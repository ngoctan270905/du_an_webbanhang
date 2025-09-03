@extends('layouts.master')

@section('title', 'Thanh toán')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Thông tin thanh toán</h1>
        <form action="{{ route('order.create') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label>Địa chỉ giao hàng (bao gồm họ tên, số điện thoại, địa chỉ):</label>
                <textarea name="dia_chi_giao_hang" class="w-full border p-2" required>{{ old('dia_chi_giao_hang', Auth::user()->dia_chi) }}</textarea>
            </div>
            <div class="mb-4">
                <label>Phương thức thanh toán:</label>
                <select name="phuong_thuc_thanh_toan" class="w-full border p-2" required>
                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                    <option value="online_payment">Thanh toán trực tuyến</option>
                </select>
            </div>
            <div class="mb-4">
                <label>Mã giảm giá (nếu có):</label>
                <input type="text" name="coupon_code" class="w-full border p-2">
            </div>
            <div class="mb-4">
                <h2>Tổng tiền: {{ number_format($total, 0, ',', '.') }}đ</h2>
            </div>
            <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded">Xác nhận đặt hàng</button>
        </form>
    </div>
@endsection