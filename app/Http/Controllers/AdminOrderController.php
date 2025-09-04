<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderDetails.product', 'payment'])->latest();

        // Tìm kiếm theo mã đơn hàng
        if ($request->has('search') && $request->search) {
            $query->where('ma_don_hang', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status) {
            $query->where('trang_thai', $request->status);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails.product', 'payment'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            // 1. Xác thực dữ liệu đầu vào
            $request->validate([
                'trang_thai' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            ], [
                'trang_thai.required' => 'Trạng thái đơn hàng là bắt buộc.',
                'trang_thai.in' => 'Trạng thái đơn hàng không hợp lệ.',
            ]);

            // 2. Hoàn tồn kho nếu trạng thái thay đổi thành 'cancelled'
            if ($request->trang_thai === 'cancelled' && $order->trang_thai !== 'cancelled') {
                DB::transaction(function () use ($order, $request) {
                    foreach ($order->orderDetails as $detail) {
                        $product = $detail->product;
                        $product->so_luong += $detail->so_luong;
                        $product->save();
                    }
                    $order->trang_thai = $request->trang_thai;
                    $order->save();
                });
            } else {
                // 3. Cập nhật trạng thái đơn hàng
                $order->trang_thai = $request->trang_thai;
                $order->save();
            }

            // 4. Cập nhật trạng thái thanh toán tương ứng
            if ($order->payment) {
                if ($request->trang_thai === 'cancelled') {
                    $order->payment->trang_thai = 'failed';
                    $order->payment->save();
                } elseif ($request->trang_thai === 'delivered') {
                    $order->payment->trang_thai = 'completed';
                    $order->payment->save();
                }
            }

            // 5. Chuyển hướng người dùng với thông báo thành công
            return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Chuyển hướng với lỗi nếu xác thực thất bại
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Chuyển hướng với lỗi nếu có ngoại lệ khác
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
