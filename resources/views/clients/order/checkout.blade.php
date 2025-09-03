@extends('layouts.master')

@section('title', 'Thanh toán')

@section('content')

    <div
        class="container mx-auto p-4 md:p-8 lg:p-12 bg-gradient-to-br from-blue-50 to-indigo-100 font-sans antialiased text-gray-800">
        <div class="text-4xl font-extrabold text-center mb-10 text-blue-800 tracking-tight">
            <i class="fas fa-credit-card text-4xl mr-3 text-blue-600 align-middle"></i>
            Thanh Toán Đơn Hàng
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
            <div class="lg:w-2/3 space-y-8">
                <div class="bg-white p-8 rounded-xl shadow-lg border border-blue-100">
                    <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                        <i class="fas fa-shopping-cart text-2xl mr-3 text-blue-500 align-middle"></i>
                        Đơn Hàng Của Bạn
                    </div>
                    <ul class="divide-y divide-gray-200">
                        @forelse ($cartItems as $item)
                            <li class="py-5 flex items-center gap-4 group">
                                <div class="relative w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ Storage::url($item->product->hinh_anh) }}"
                                        alt="{{ $item->product->ten_san_pham }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                                </div>
                                <div class="flex-grow">
                                    <p class="font-semibold text-lg text-gray-900">{{ $item->product->ten_san_pham }}</p>
                                    <p class="text-sm text-gray-500">Tác giả: {{ $item->product->author }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Số lượng: <span
                                            class="font-medium text-gray-700">{{ $item->so_luong }}</span></p>
                                </div>
                                <span
                                    class="font-bold text-lg text-blue-600">{{ number_format($item->product->gia_khuyen_mai ?? $item->product->gia, 0, ',', '.') }}đ</span>
                            </li>
                        @empty
                            <li class="py-5 text-center text-gray-500">Giỏ hàng của bạn đang trống!</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg border border-blue-100">
                    <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                        <i class="fas fa-map-marker-alt text-2xl mr-3 text-blue-500 align-middle"></i>
                        Địa Chỉ Giao Hàng & Liên Hệ
                    </div>
                    <form id="order-form" action="{{ route('order.create') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="fullName" class="block text-gray-700 font-medium mb-2 text-sm">Họ và Tên <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="fullName" name="ho_ten"
                                    class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                    value="{{ old('ho_ten', $user->name) }}" required>
                                @error('ho_ten')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-gray-700 font-medium mb-2 text-sm">Số điện thoại
                                    <span class="text-red-500">*</span></label>
                                <input type="tel" id="phone" name="so_dien_thoai"
                                    class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                    value="{{ old('so_dien_thoai', $user->so_dien_thoai) }}" required>
                                @error('so_dien_thoai')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="address" class="block text-gray-700 font-medium mb-2 text-sm">Địa chỉ cụ thể <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="address" name="dia_chi_giao_hang"
                                class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                value="{{ old('dia_chi_giao_hang', $user->dia_chi) }}" required>
                            @error('dia_chi_giao_hang')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg border border-blue-100">
                    <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                        <i class="fas fa-truck text-2xl mr-3 text-blue-500 align-middle"></i>
                        Chọn Phương Thức Vận Chuyển
                    </div>
                    <div class="flex flex-col gap-4">
                        <label
                            class="radio-option flex items-center justify-between p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                            <div class="flex items-center gap-4">
                                <div
                                    class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                    <input type="radio" name="shippingMethod" value="standard" checked
                                        class="absolute opacity-1 w-full h-full cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white hidden"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Giao hàng tiêu chuẩn (2-5 ngày)</span>
                            </div>
                            <span class="font-bold text-gray-900" id="shipping-cost-display-standard">30.000đ</span>
                        </label>
                        <label
                            class="radio-option flex items-center justify-between p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                            <div class="flex items-center gap-4">
                                <div
                                    class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                    <input type="radio" name="shippingMethod" value="express"
                                        class="absolute opacity-1 w-full h-full cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white hidden"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Giao hàng nhanh (1-2 ngày)</span>
                            </div>
                            <span class="font-bold text-gray-900" id="shipping-cost-display-express">50.000đ</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg border border-blue-100">
                    <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                        <i class="fas fa-money-check-alt text-2xl mr-3 text-blue-500 align-middle"></i>
                        Chọn Phương Thức Thanh Toán
                    </div>
                    <div class="flex flex-col gap-4">
                        <label
                            class="radio-option flex items-center gap-4 p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                            <div
                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                <input type="radio" name="phuong_thuc_thanh_toan" value="cod" checked
                                    class="absolute opacity-1 w-full h-full cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white hidden"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700 flex items-center">
                                <i class="fas fa-home text-xl mr-2 text-green-600 align-middle"></i>
                                Thanh toán khi nhận hàng (COD)
                            </span>
                        </label>
                        <label
                            class="radio-option flex items-center gap-4 p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                            <div
                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                <input type="radio" name="phuong_thuc_thanh_toan" value="bank"
                                    class="absolute opacity-1 w-full h-full cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white hidden"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700 flex items-center">
                                <i class="fas fa-university text-xl mr-2 text-purple-600 align-middle"></i>
                                Chuyển khoản ngân hàng
                            </span>
                        </label>
                        <label
                            class="radio-option flex items-center gap-4 p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                            <div
                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                <input type="radio" name="phuong_thuc_thanh_toan" value="momo"
                                    class="absolute opacity-1 w-full h-full cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white hidden"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700 flex items-center">
                                <i class="fas fa-mobile-alt text-xl mr-2 text-pink-600 align-middle"></i>
                                Ví điện tử MoMo
                            </span>
                        </label>
                    </div>
                    @error('phuong_thuc_thanh_toan')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    </form>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white p-8 rounded-xl shadow-lg border border-blue-100 sticky top-12">
                    <div class="text-2xl font-bold mb-6 text-blue-700">
                        <i class="fas fa-file-invoice-dollar text-2xl mr-3 text-blue-500 align-middle"></i>
                        Tổng Kết Đơn Hàng
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <div class="flex justify-between items-center text-lg">
                            <span>Tạm tính</span>
                            <span class="font-bold text-gray-900">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span>Phí vận chuyển</span>
                            <span class="font-bold text-gray-900" id="shipping-cost">30.000đ</span>
                        </div>
                        <div
                            class="flex justify-between items-center font-extrabold text-2xl border-t border-blue-200 pt-6 mt-6">
                            <span>Tổng cộng</span>
                            <span class="text-blue-600"
                                id="total-price">{{ number_format($total + 30000, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                    <button type="submit" form="order-form"
                        class="w-full mt-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-extrabold text-lg rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-800 transition duration-200 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                        <i class="fas fa-check-circle text-xl mr-3 align-middle"></i>
                        Xác Nhận Thanh Toán Ngay
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-4">Bằng cách nhấp vào "Xác Nhận Thanh Toán Ngay", bạn
                        đồng ý với các Điều Khoản Dịch Vụ.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="shippingMethod"]').forEach((radio) => {
            radio.addEventListener('change', () => {
                const shippingCostDisplay = document.getElementById('shipping-cost');
                const totalPriceDisplay = document.getElementById('total-price');
                const baseTotal = {{ $total }};
                let shippingCost = radio.value === 'standard' ? 30000 : 50000;

                shippingCostDisplay.textContent = shippingCost.toLocaleString('vi-VN') + 'đ';
                totalPriceDisplay.textContent = (baseTotal + shippingCost).toLocaleString('vi-VN') + 'đ';
            });
        });
    </script>
@endsection
