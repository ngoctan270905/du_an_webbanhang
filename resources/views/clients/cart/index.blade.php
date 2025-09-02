@extends('layouts.master')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Giỏ hàng của bạn</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-4">Sản phẩm</th>
                        <th class="text-center py-4">Số lượng</th>
                        <th class="text-right py-4">Giá</th>
                        <th class="text-right py-4">Tổng</th>
                        <th class="text-center py-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr class="border-b">
                            <td class="py-4">
                                <div class="flex items-center">
                                    <img src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}" 
                                         class="w-16 h-16 object-cover rounded">
                                    <span class="ml-4">{{ $details['name'] }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('cart.update') }}" method="POST" class="inline-flex items-center">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                           min="1" class="w-16 text-center border rounded px-2 py-1">
                                    <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">
                                        Cập nhật
                                    </button>
                                </form>
                            </td>
                            <td class="text-right">{{ number_format($details['price'], 0, ',', '.') }}đ</td>
                            <td class="text-right">
                                {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ
                            </td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-bold py-4">Tổng cộng:</td>
                        <td class="text-right font-bold py-4">{{ number_format($total, 0, ',', '.') }}đ</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('product.index') }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600">
                Tiếp tục mua sắm
            </a>
            <a href="#" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600">
                Thanh toán
            </a>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500 mb-4">Giỏ hàng của bạn đang trống</p>
            <a href="{{ route('product.index') }}" 
               class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600">
                Tiếp tục mua sắm
            </a>
        </div>
    @endif
</div>
@endsection