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

            // Tạo payment (nếu không cod)
            if ($request->phuong_thuc_thanh_toan != 'cod') {
                Payment::create([
                    'id_don_hang' => $order->id,
                    'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
                    'so_tien' => $total,
                    'trang_thai' => 'pending',
                    'ma_giao_dich' => Str::random(20),
                ]);
            }

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
}