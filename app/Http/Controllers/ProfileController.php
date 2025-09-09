<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $status = $request->input('trang_thai', 'all'); // Lấy trạng thái từ query string, mặc định là 'all'

        $query = Order::with(['orderDetails.product'])
            ->where('id_nguoi_dung', $user->id)
            ->whereNull('deleted_at')
            ->latest();

        // Thêm điều kiện lọc nếu trạng thái không phải 'all'
        if ($status !== 'all') {
            $query->where('trang_thai', $status);
        }

        $orders = $query->paginate(3);

        return view('profile.my_orders', [
            'user' => $user,
            'orders' => $orders,
            'selected_status' => $status, // Truyền trạng thái đã chọn vào view
        ]);
    }


    public function showOrders(Request $request, $id = null)
    {
        $user = $request->user();

        if ($id) {
            // Lấy chi tiết đơn hàng dựa trên ma_don_hang
            $order = Order::where('ma_don_hang', $id)
                ->where('id_nguoi_dung', $user->id)
                ->with([
                    'orderDetails.product',
                    'payment',
                    'province' => function ($query) {
                        $query->select('code', 'name');
                    },
                    'district' => function ($query) {
                        $query->select('code', 'name');
                    },
                    'ward' => function ($query) {
                        $query->select('code', 'name');
                    }
                ])
                ->first();

            if (!$order) {
                return response()->json(['error' => 'Đơn hàng không tồn tại hoặc không thuộc về bạn'], 404);
            }

            // Lấy trạng thái thanh toán từ bảng payments
            $tinh_trang_thanh_toan = $order->payment ? $this->getPaymentStatusText($order->payment->trang_thai) : 'Không xác định';

            return response()->json([
                'ma_don_hang' => $order->ma_don_hang,
                'ngay_dat_hang' => $order->ngay_dat_hang,
                'trang_thai' => $order->trang_thai,
                'ngay_huy' => $order->ngay_huy,
                'tong_tien' => $order->tong_tien,
                'tong_tien_hang' => $order->tong_tien_hang,
                'phi_van_chuyen' => $order->phi_ship,
                'giam_gia' => 0, // Giá trị mặc định vì không có cột trong DB
                'ten_nguoi_nhan' => $order->ho_ten_khach_hang ?? 'Không xác định',
                'dia_chi' => $order->dia_chi_giao_hang ?? 'Không xác định',
                'so_dien_thoai' => $order->so_dien_thoai ?? 'Không xác định',
                'province_name' => $order->province ? $order->province->name : 'Không xác định',
                'district_name' => $order->district ? $order->district->name : 'Không xác định',
                'ward_name' => $order->ward ? $order->ward->name : 'Không xác định',
                'phuong_thuc_thanh_toan' => $order->phuong_thuc_thanh_toan,
                'tinh_trang_thanh_toan' => $tinh_trang_thanh_toan,
                'da_nhan_hang' => $order->da_nhan_hang,
                'orderDetails' => $order->orderDetails->map(function ($detail) {
                    return [
                        'product_id' => $detail->id_san_pham,
                        'ten_san_pham' => $detail->product ? $detail->product->ten_san_pham : 'Sản phẩm không tồn tại',
                        'so_luong' => $detail->so_luong,
                        'gia' => $detail->gia,
                        'hinh_anh' => $detail->product && $detail->product->hinh_anh ? asset('storage/' . $detail->product->hinh_anh) : null,
                    ];
                }),
            ]);
        }

        // Lấy danh sách đơn hàng nếu không có id
        $trang_thai = $request->query('trang_thai', 'all');
        $query = Order::where('id_nguoi_dung', $user->id)->with('orderDetails.product');

        if ($trang_thai !== 'all') {
            $query->where('trang_thai', $trang_thai);
        }

        $orders = $query->paginate(10);

        return view('profile.show_orders', [
            'user' => $user,
            'orders' => $orders,
            'selected_status' => $trang_thai,
        ]);
    }

    /**
     * Hàm chuyển đổi trạng thái thanh toán sang text hiển thị
     */
    private function getPaymentStatusText($status)
    {
        switch ($status) {
            case 'pending':
                return 'Chưa thanh toán';
            case 'completed':
                return 'Đã thanh toán';
            case 'failed':
                return 'Thanh toán thất bại';
            default:
                return 'Không xác định';
        }
    }
}
