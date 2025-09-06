<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showCheckout()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('id_nguoi_dung', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Giỏ hàng trống!');
        }

        $total = $cartItems->sum(function ($item) {
            $price = $item->product->gia_khuyen_mai ?? $item->product->gia;
            return $price * $item->so_luong;
        });

        return view('clients.order.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'user' => $user,
        ]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => ['required', 'string', 'regex:#^(03|05|07|08|09)[0-9]{8}$#'],
            'dia_chi_giao_hang' => 'required|string|max:500',
            'phuong_thuc_thanh_toan' => 'required|in:cod,bank_transfer,online_payment',
            'phi_van_chuyen' => 'required|integer|min:0',
            'coupon_code' => 'nullable|string',
        ]);

        $user = Auth::user();
        $cartItems = CartItem::where('id_nguoi_dung', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Giỏ hàng trống!');
        }

        return DB::transaction(function () use ($request, $user, $cartItems) {
            $total = 0;
            foreach ($cartItems as $item) {
                $product = $item->product;
                $currentPrice = $product->gia_khuyen_mai ?? $item->product->gia;

                if ($item->so_luong > $product->so_luong) {
                    throw new \Exception("Sản phẩm {$product->ten_san_pham} chỉ còn {$product->so_luong} quyển!");
                }

                $subtotal = $currentPrice * $item->so_luong;
                $total += $subtotal;
            }

            // Áp coupon nếu có
            $coupon = null;
            if ($request->coupon_code) {
                $coupon = Coupon::where('ma_giam_gia', $request->coupon_code)->where('trang_thai', 1)->first();
                if ($coupon) {
                    if ($coupon->loai_giam_gia == 'percent') {
                        $total -= $total * ($coupon->gia_tri / 100);
                    } else {
                        $total -= $coupon->gia_tri;
                    }
                }
            }

            // Thêm phí vận chuyển
            $total += $request->phi_van_chuyen;

            // Tạo mã đơn hàng unique
            do {
                $maDonHang = 'DH' . now()->format('YmdHis') . rand(1000, 9999);
            } while (Order::where('ma_don_hang', $maDonHang)->exists());

            // Tạo địa chỉ đầy đủ
            $diaChiDayDu = $request->ho_ten . ' - ' . $request->so_dien_thoai . ' - ' . $request->dia_chi_giao_hang;

            // Tạo order
            $order = Order::create([
                'ma_don_hang' => $maDonHang,
                'id_nguoi_dung' => $user->id,
                'tong_tien' => $total,
                'trang_thai' => 'pending',
                'dia_chi_giao_hang' => $diaChiDayDu,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
                'ngay_dat_hang' => now(),
            ]);

            // Tạo order_details và trừ stock
            foreach ($cartItems as $item) {
                $product = $item->product;
                $currentPrice = $product->gia_khuyen_mai ?? $product->gia;

                OrderDetail::create([
                    'id_don_hang' => $order->id,
                    'id_san_pham' => $item->id_san_pham,
                    'so_luong' => $item->so_luong,
                    'gia' => $currentPrice,
                ]);

                $product->so_luong -= $item->so_luong;
                $product->save();
            }

            // Tạo payment với trạng thái pending
            Payment::create([
                'id_don_hang' => $order->id,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
                'so_tien' => $total,
                'trang_thai' => 'pending',
                'ma_giao_dich' => Str::random(20),
            ]);


            // Xóa giỏ hàng
            CartItem::where('id_nguoi_dung', $user->id)->delete();

            return redirect()->route('order.success', $order->id);
        });
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        return view('clients.order.success', ['order' => $order]);
    }

    public function cancel(Request $request, $ma_don_hang)
    {
        $user = Auth::user();
        $order = Order::where('ma_don_hang', $ma_don_hang)
            ->where('id_nguoi_dung', $user->id)
            ->with('orderDetails.product')
            ->first();

        if (!$order) {
            return response()->json([
                'error' => 'Đơn hàng không tồn tại hoặc bạn không có quyền hủy.'
            ], 403);
        }

        if (!in_array($order->trang_thai, ['pending', 'processing'])) {
            return response()->json([
                'error' => 'Đơn hàng không thể hủy vì đã ở trạng thái ' . $order->trang_thai . '.'
            ], 400);
        }

        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'other_reason' => 'required_if:cancel_reason,Khác|string|max:500|nullable',
        ]);

        $reason = $request->cancel_reason === 'Khác' ? $request->other_reason : $request->cancel_reason;

        return DB::transaction(function () use ($order, $reason) {
            // Cập nhật trạng thái đơn hàng
            $order->trang_thai = 'cancelled';
            $order->ly_do_huy = $reason;
            $order->ngay_huy = now();
            $order->save();

            // Trả lại số lượng tồn kho
            foreach ($order->orderDetails as $detail) {
                $product = Product::find($detail->id_san_pham);
                if ($product) {
                    $product->so_luong += $detail->so_luong;
                    $product->save();
                }
            }

            return response()->json([
                'message' => 'Đơn hàng đã được hủy thành công.',
                'order' => [
                    'ma_don_hang' => $order->ma_don_hang,
                    'trang_thai' => $order->trang_thai,
                    'ly_do_huy' => $order->ly_do_huy,
                    'ngay_huy' => $order->ngay_huy->format('d/m/Y H:i:s'),
                ]
            ]);
        }, 5); // Retry transaction tối đa 5 lần nếu gặp deadlock
    }
}
