@extends('layouts.master')

@section('title', 'Thanh toán')

@section('content')
    <style>
        /* Modal styling từ giỏ hàng */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.hidden {
            display: none;
        }

        .modal-overlay.closing {
            opacity: 0;
        }

        .modal-confirm {
            animation: fadeIn 0.3s ease-out;
        }

        .modal-confirm.closing {
            animation: fadeOut 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        /* Loading style */
        .loading::after {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Select styling */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="gray" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 0.75rem center/16px 16px;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-800 rounded-xl">
                <div class="text-4xl font-extrabold text-center mb-10 text-blue-800 tracking-tight">
                    <i class="fas fa-credit-card text-4xl mr-3 text-blue-600 align-middle"></i>
                    Thanh Toán Đơn Hàng
                </div>

                <form id="order-form" action="{{ route('order.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="phi_ship" id="shipping-cost-hidden" value="30000">

                    <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
                        <div class="lg:w-2/3 space-y-8">
                            <div class="bg-white p-8 rounded-xl shadow-lg">
                                <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                                    <i class="fas fa-shopping-cart text-2xl mr-3 text-blue-500 align-middle"></i>
                                    Đơn Hàng Của Bạn
                                </div>
                                <ul class="divide-y divide-gray-200">
                                    @forelse ($cartItems as $item)
                                        <li class="py-5 flex items-center gap-4 group" data-id="{{ $item->id_san_pham }}">
                                            <div class="relative w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                                <img src="{{ Storage::url($item->product->hinh_anh) }}"
                                                    alt="{{ $item->product->ten_san_pham }}"
                                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                            </div>
                                            <div class="flex-grow">
                                                <p class="font-semibold text-lg text-gray-900">
                                                    {{ $item->product->ten_san_pham }}
                                                </p>
                                                <p class="text-sm text-gray-500">Tác giả: {{ $item->product->author }}</p>
                                                <p class="text-sm text-gray-500 mt-1">Số lượng: <span
                                                        class="font-medium text-gray-700">{{ $item->so_luong }}</span></p>
                                            </div>
                                            <span class="font-bold text-lg text-blue-600 price-col text-right">
                                                {{ number_format($item->product->gia_khuyen_mai ?? $item->product->gia, 0, ',', '.') }}đ
                                                <br>
                                                <span class="text-sm font-bold">x {{ $item->so_luong }}</span>
                                            </span>
                                        </li>
                                    @empty
                                        <li class="py-5 text-center text-gray-500">Giỏ hàng của bạn đang trống!</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-lg">
                                <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                                    <i class="fas fa-map-marker-alt text-2xl mr-3 text-blue-500 align-middle"></i>
                                    Địa Chỉ Giao Hàng & Liên Hệ
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="fullName" class="block text-gray-700 font-medium mb-2 text-sm">Họ và Tên
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="fullName" name="ho_ten"
                                            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                            value="{{ old('ho_ten', $user->name) }}" required>
                                        @error('ho_ten')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-gray-700 font-medium mb-2 text-sm">Số điện
                                            thoại
                                            <span class="text-red-500">*</span></label>
                                        <input type="tel" id="phone" name="so_dien_thoai"
                                            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                            value="{{ old('so_dien_thoai', $user->so_dien_thoai) }}" required>
                                        @error('so_dien_thoai')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="province_code"
                                            class="block text-gray-700 font-medium mb-2 text-sm">Tỉnh/Thành
                                            phố
                                            <span class="text-red-500">*</span></label>
                                        <select id="province_code" name="province_code"
                                            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                            required>
                                            <option value="">Chọn tỉnh/thành phố</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->code }}"
                                                    {{ old('province_code') == $province->code ? 'selected' : '' }}>
                                                    {{ $province->name_with_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('province_code')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="district_code"
                                            class="block text-gray-700 font-medium mb-2 text-sm">Quận/Huyện
                                            <span class="text-red-500">*</span></label>
                                        <select id="district_code" name="district_code"
                                            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                            required>
                                            <option value="">Chọn quận/huyện</option>
                                        </select>
                                        @error('district_code')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="ward_code"
                                            class="block text-gray-700 font-medium mb-2 text-sm">Phường/Xã
                                            <span class="text-red-500">*</span></label>
                                        <select id="ward_code" name="ward_code"
                                            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                            required>
                                            <option value="">Chọn phường/xã</option>
                                        </select>
                                        @error('ward_code')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-gray-700 font-medium mb-2 text-sm">Địa chỉ
                                            cụ
                                            thể
                                            (Số nhà, tên đường)
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="address" name="dia_chi_giao_hang"
                                            placeholder="Ví dụ: 123 Đường Láng"
                                            class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                            value="{{ old('dia_chi_giao_hang') }}" required>
                                        @error('dia_chi_giao_hang')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-lg">
                                <div class="text-2xl font-bold mb-6 flex items-center text-blue-700">
                                    <i class="fas fa-truck text-2xl mr-3 text-blue-500 align-middle"></i>
                                    Chọn Hình Thức Vận Chuyển
                                </div>
                                <div class="flex flex-col gap-4">
                                    <label
                                        class="radio-option flex items-center justify-between p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                                <input type="radio" name="hinh_thuc_van_chuyen" value="standard"
                                                    checked class="absolute opacity-1 w-full h-full cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white hidden"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-700">Giao hàng tiêu chuẩn (2-5 ngày)</span>
                                        </div>
                                        <span class="font-bold text-gray-900"
                                            id="shipping-cost-display-standard">30.000đ</span>
                                    </label>
                                    <label
                                        class="radio-option flex items-center justify-between p-5 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition duration-200 ease-in-out has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                                <input type="radio" name="hinh_thuc_van_chuyen" value="express"
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
                                        <span class="font-bold text-gray-900"
                                            id="shipping-cost-display-express">50.000đ</span>
                                    </label>
                                </div>
                                @error('hinh_thuc_van_chuyen')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-white p-8 rounded-xl shadow-lg">
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
                                        class="radio-option flex items-center justify-between gap-4 p-5 border border-gray-200 rounded-lg opacity-50 cursor-not-allowed">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                                <input type="radio" name="phuong_thuc_thanh_toan" value="bank_transfer"
                                                    class="absolute opacity-1 w-full h-full cursor-not-allowed" disabled>
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
                                        </div>
                                        <span class="text-red-500 text-sm font-medium flex items-center">Đang bảo
                                            trì</span>
                                    </label>
                                    <label
                                        class="radio-option flex items-center justify-between gap-4 p-5 border border-gray-200 rounded-lg opacity-50 cursor-not-allowed">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="relative w-5 h-5 border border-gray-400 rounded-full flex items-center justify-center radio-indicator">
                                                <input type="radio" name="phuong_thuc_thanh_toan"
                                                    value="online_payment"
                                                    class="absolute opacity-1 w-full h-full cursor-not-allowed" disabled>
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
                                        </div>
                                        <span class="text-red-500 text-sm font-medium flex items-center">Đang bảo
                                            trì</span>
                                    </label>
                                </div>
                                @error('phuong_thuc_thanh_toan')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="lg:w-1/3">
                            <div class="bg-white p-8 rounded-xl shadow-lg sticky top-28">
                                <div class="text-2xl font-bold mb-6 text-blue-700">
                                    <i class="fas fa-file-invoice-dollar text-2xl mr-3 text-blue-500 align-middle"></i>
                                    Tổng Kết Đơn Hàng
                                </div>
                                <div class="space-y-4 text-gray-700">
                                    <div class="flex justify-between items-center text-base">
                                        <span>Tạm tính</span>
                                        <span class="font-bold text-gray-900"
                                            id="subtotal">{{ number_format($total, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-base">
                                        <span>Phí vận chuyển</span>
                                        <span class="font-bold text-gray-900" id="shipping-cost">30.000đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-base">
                                        <span>Giảm giá</span>
                                        <span class="font-bold text-gray-900" id="coupon-discount">0đ</span>
                                    </div>
                                    <div
                                        class="flex justify-between items-center font-extrabold text-xl border-t border-blue-200 pt-6 mt-6">
                                        <span>Tổng cộng</span>
                                        <span class="text-blue-600"
                                            id="total-price">{{ number_format($total + 30000, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                                <button type="button" id="submit-order-btn"
                                    class="w-full mt-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-extrabold text-lg rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-800 transition duration-200 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                                    <i class="fas fa-check-circle text-xl mr-3 align-middle"></i>
                                    Xác Nhận Thanh Toán
                                </button>
                                <p class="text-center text-xs text-gray-500 mt-4">Bằng cách nhấp vào "Xác Nhận Thanh Toán",
                                    bạn đồng ý với các Điều Khoản Dịch Vụ.</p>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Modal thông báo thay đổi -->
                <div id="confirmChangesModal" class="modal-overlay hidden">
                    <div class="modal-confirm bg-white rounded-lg shadow-xl p-6 w-96 max-w-full">
                        <div class="text-lg font-semibold text-gray-800 mb-4">Có thay đổi trong giỏ hàng</div>
                        <p id="changesMessage" class="text-gray-600 mb-6"></p>
                        <ul id="changesList" class="list-disc pl-5 mb-6"></ul>
                        <div class="flex justify-end space-x-4">
                            <button id="confirmChanges"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                Xác nhận cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitOrderBtn = document.getElementById('submit-order-btn');
            const orderForm = document.getElementById('order-form');
            const confirmChangesModal = document.getElementById('confirmChangesModal');
            const confirmChangesBtn = document.getElementById('confirmChanges');
            const changesMessage = document.getElementById('changesMessage');
            const changesList = document.getElementById('changesList');
            const shippingRadios = document.querySelectorAll('input[name="hinh_thuc_van_chuyen"]');
            const shippingCostDisplay = document.getElementById('shipping-cost');
            const totalPriceDisplay = document.getElementById('total-price');
            const couponDiscountDisplay = document.getElementById('coupon-discount');
            const shippingCostHidden = document.getElementById('shipping-cost-hidden');
            const applyCouponBtn = document.getElementById('apply-coupon-btn');
            const couponCodeInput = document.getElementById('coupon_code');
            const baseTotal = {{ $total }};
            let discount = 0;

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(amount).replace('₫', 'đ');
            }

            // Hàm debounce
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            function formatCurrencyVND(number) {
                return number.toLocaleString('vi-VN') + 'đ'; // liền luôn, không khoảng trắng
            }

            // trong event listener:
            shippingRadios.forEach((radio) => {
                radio.addEventListener('change', () => {
                    let shippingCost = radio.value === 'standard' ? 30000 : 50000;
                    shippingCostDisplay.textContent = formatCurrencyVND(shippingCost);
                    totalPriceDisplay.textContent = formatCurrencyVND(baseTotal + shippingCost -
                        discount);
                    shippingCostHidden.value = shippingCost;
                });
            });


            // Tải danh sách quận/huyện khi chọn tỉnh
            document.getElementById('province_code').addEventListener('change', function() {
                const provinceCode = this.value;
                const districtSelect = document.getElementById('district_code');
                const wardSelect = document.getElementById('ward_code');
                districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

                if (provinceCode) {
                    fetch('/api/districts/' + provinceCode, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district.code;
                                option.text = district.name_with_type;
                                districtSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading districts:', error);
                            alert('Không thể tải danh sách quận/huyện!');
                        });
                }
            });

            // Tải danh sách phường/xã khi chọn quận/huyện
            document.getElementById('district_code').addEventListener('change', function() {
                const districtCode = this.value;
                const wardSelect = document.getElementById('ward_code');
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

                if (districtCode) {
                    fetch('/api/wards/' + districtCode, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(ward => {
                                const option = document.createElement('option');
                                option.value = ward.code;
                                option.text = ward.name_with_type;
                                wardSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading wards:', error);
                            alert('Không thể tải danh sách phường/xã!');
                        });
                }
            });

            // Đóng modal
            function closeConfirmModal() {
                confirmChangesModal.classList.add('closing');
                const modalContent = confirmChangesModal.querySelector('.modal-confirm');
                if (modalContent) modalContent.classList.add('closing');
                setTimeout(() => {
                    confirmChangesModal.classList.add('hidden');
                    confirmChangesModal.classList.remove('closing');
                    if (modalContent) modalContent.classList.remove('closing');
                }, 280);
            }

            // Hàm xử lý bấm nút thanh toán
            const handleSubmitOrder = debounce(function() {
                // Disable nút và thêm loading
                submitOrderBtn.disabled = true;
                submitOrderBtn.classList.add('loading');
                submitOrderBtn.innerHTML =
                    '<i class="fas fa-spinner text-xl mr-3 align-middle"></i> Đang xử lý...';

                // Gọi AJAX validate cart
                fetch('{{ route('cart.validate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        // Bật lại nút
                        submitOrderBtn.disabled = false;
                        submitOrderBtn.classList.remove('loading');
                        submitOrderBtn.innerHTML =
                            '<i class="fas fa-check-circle text-xl mr-3 align-middle"></i> Xác Nhận Thanh Toán Ngay';

                        if (!data.success) {
                            alert(data.error || 'Có lỗi khi kiểm tra giỏ hàng, vui lòng thử lại!');
                            return;
                        }

                        if (data.has_changes) {
                            // Hiển thị modal thay đổi
                            changesMessage.textContent = data.message ||
                                'Giỏ hàng của bạn có một số thay đổi.';
                            changesList.innerHTML = data.changes ? data.changes.map(change =>
                                `<li>${change.message}</li>`).join('') : '';
                            confirmChangesModal.classList.remove('hidden');
                            confirmChangesBtn.dataset.updatedItems = JSON.stringify(data
                                .updated_items || []);
                        } else {
                            // Không có thay đổi, submit form
                            orderForm.submit();
                        }
                    })
                    .catch(error => {
                        console.error('Error validating cart:', error);
                        alert('Có lỗi xảy ra: ' + error.message + '. Vui lòng thử lại!');
                        submitOrderBtn.disabled = false;
                        submitOrderBtn.classList.remove('loading');
                        submitOrderBtn.innerHTML =
                            '<i class="fas fa-check-circle text-xl mr-3 align-middle"></i> Xác Nhận Thanh Toán Ngay';
                    });
            }, 1000); // Debounce 1 giây

            // Gắn sự kiện click với disable ngay lập tức
            submitOrderBtn.addEventListener('click', function() {
                if (!submitOrderBtn.disabled) {
                    submitOrderBtn.disabled = true; // Disable ngay khi nhấp
                    submitOrderBtn.classList.add('loading');
                    submitOrderBtn.innerHTML =
                        '<i class="fas fa-spinner text-xl mr-3 align-middle"></i> Đang xử lý...';
                    handleSubmitOrder(); // Gọi hàm debounce
                }
            });

            // Xử lý bấm xác nhận cập nhật
            confirmChangesBtn.addEventListener('click', function() {
                const updatedItems = JSON.parse(this.dataset.updatedItems || '[]');
                fetch('{{ route('cart.apply_changes') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            updated_items: updatedItems
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.reload(); // Reload trang thanh toán
                        } else {
                            alert(data.error || 'Có lỗi khi cập nhật giỏ hàng, vui lòng thử lại!');
                        }
                    })
                    .catch(error => {
                        console.error('Error applying changes:', error);
                        alert('Có lỗi xảy ra: ' + error.message + '. Vui lòng thử lại!');
                    });
                closeConfirmModal();
            });
        });
    </script>
@endsection
