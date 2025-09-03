@extends('layouts.master')

@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="container mx-auto px-4 py-8 text-center">
        <h1 class="text-3xl font-bold mb-4">Đặt hàng thành công!</h1>
        <p>Mã đơn hàng: {{ $order->ma_don_hang }}</p>
        <p>Tổng tiền: {{ number_format($order->tong_tien, 0, ',', '.') }}đ</p>
        <p>Chúng tôi sẽ liên hệ sớm. Cảm ơn!</p>
        <a href="{{ route('home') }}" class="bg-blue-500 text-white px-6 py-3 rounded mt-4">Về trang chủ</a>
    </div>
@endsection