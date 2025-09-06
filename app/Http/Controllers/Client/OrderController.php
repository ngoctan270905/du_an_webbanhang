<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderDetail;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
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

        $provinces = Province::all();

        return view('clients.order.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'user' => $user,
            'provinces' => $provinces,
        ]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => ['required', 'string', 'regex:#^(03|05|07|08|09)[0-9]{8}$#'],
            'province_code' => 'required|string|exists:provinces,code',
            'district_code' => 'required|string|exists:districts,code',
            'ward_code' => 'required|string|exists:wards,code',
            'dia_chi_giao_hang' => 'required|string|max:500',
            'phuong_thuc_thanh_toan' => 'required|in:cod,bank_transfer,online_payment',
            'hinh_thuc_van_chuyen' => 'required|in:standard,express',
            'phi_ship' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string',
        ], [
            'ho_ten.required' => 'Họ tên không được để trống.',
            'ho_ten.max' => 'Họ tên không được dài quá 255 ký tự.',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng (VD: 03xxxxxxx).',
            'province_code.required' => 'Bạn phải chọn tỉnh/thành.',
            'province_code.exists' => 'Tỉnh/thành không hợp lệ.',
            'district_code.required' => 'Bạn phải chọn quận/huyện.',
            'district_code.exists' => 'Quận/huyện không hợp lệ.',
            'ward_code.required' => 'Bạn phải chọn xã/phường.',
            'ward_code.exists' => 'Xã/phường không hợp lệ.',
            'dia_chi_giao_hang.required' => 'Địa chỉ giao hàng không được để trống.',
            'phuong_thuc_thanh_toan.required' => 'Bạn phải chọn phương thức thanh toán.',
            'phuong_thuc_thanh_toan.in' => 'Phương thức thanh toán không hợp lệ.',
            'hinh_thuc_van_chuyen.required' => 'Bạn phải chọn hình thức vận chuyển.',
            'hinh_thuc_van_chuyen.in' => 'Hình thức vận chuyển không hợp lệ.',
            'phi_ship.required' => 'Phí vận chuyển không được để trống.',
            'phi_ship.numeric' => 'Phí vận chuyển phải là số.',
            'phi_ship.min' => 'Phí vận chuyển phải lớn hơn hoặc bằng 0.',
        ]);

        $user = Auth::user();
        $cartItems = CartItem::where('id_nguoi_dung', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Giỏ hàng trống!');
        }

        return DB::transaction(function () use ($request, $user, $cartItems) {
            $tongTienHang = 0;
            foreach ($cartItems as $item) {
                $product = $item->product;
                $currentPrice = $product->gia_khuyen_mai ?? $item->product->gia;

                if ($item->so_luong > $product->so_luong) {
                    throw new \Exception("Sản phẩm {$product->ten_san_pham} chỉ còn {$product->so_luong} quyển!");
                }

                $subtotal = $currentPrice * $item->so_luong;
                $tongTienHang += $subtotal;
            }

            // Áp coupon nếu có
            $total = $tongTienHang;
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

            // Thêm phí ship
            $total += $request->phi_ship;

            // Tạo mã đơn hàng unique theo ngày
            $prefix = 'DH';
            $datePart = now()->format('ymd'); // vd: 250906

            // Lấy đơn hàng gần nhất trong ngày
            $lastOrder = Order::whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->first();

            // Tính số thứ tự, nếu chưa có đơn nào hôm nay thì là 1
            $sequence = $lastOrder ? (int) substr($lastOrder->ma_don_hang, -3) + 1 : 1;

            // Đệm số thứ tự 3 chữ số
            $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

            // Ghép thành mã đơn hàng
            $maDonHang = "$prefix-$datePart-$sequence";


            // Tạo order
            $order = Order::create([
                'ma_don_hang' => $maDonHang,
                'id_nguoi_dung' => $user->id,
                'ho_ten_khach_hang' => $request->ho_ten,
                'so_dien_thoai' => $request->so_dien_thoai,
                'tong_tien' => $total,
                'tong_tien_hang' => $tongTienHang,
                'phi_ship' => $request->phi_ship,
                'hinh_thuc_van_chuyen' => $request->hinh_thuc_van_chuyen,
                'da_nhan_hang' => false,
                'trang_thai' => 'pending',
                'dia_chi_giao_hang' => $request->dia_chi_giao_hang,
                'province_code' => $request->province_code,
                'district_code' => $request->district_code,
                'ward_code' => $request->ward_code,
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
