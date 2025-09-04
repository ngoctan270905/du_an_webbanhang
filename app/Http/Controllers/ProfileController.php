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
}
