@extends('layouts.profile_user')

@section('title', 'Thông tin cá nhân')

@section('main-content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center pb-4 border-b dark:border-gray-700">
            <div>
                <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Chi tiết đơn hàng #DH987654321
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Đặt hàng ngày 20/07/2025
                </div>
            </div>

            <span
                class="bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-300 text-sm font-medium px-2.5 py-0.5 rounded-full">
                Giao thành công
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 border-b pb-6">
            <div class="col-span-1 md:col-span-2">
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Trạng thái đơn hàng</div>
                <div class="relative flex justify-between items-center mb-6">
                    <div class=" flex flex-col items-center">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">Chờ xác nhận</span>
                    </div>
                    <div class="flex-1 border-t-2 border-green-500 mx-1"></div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">Đang xử lý</span>
                    </div>
                    <div class="flex-1 border-t-2 border-green-500 mx-1"></div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">Đang giao</span>
                    </div>
                    <div class="flex-1 border-t-2 border-green-500 mx-1"></div>
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">Thành công</span>
                    </div>
                </div>

                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-8 mb-4">Danh sách sản phẩm</div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex-shrink-0">
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900 dark:text-gray-100">iPhone 15 Pro Max 256GB</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Màu: Titan Tự nhiên</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">SL: 1</p>
                            </div>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">30.490.000 VNĐ</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex-shrink-0">
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900 dark:text-gray-100">Ốp lưng Silicon MagSafe</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Màu: Xanh Dương</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">SL: 1</p>
                            </div>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">1.250.000 VNĐ</span>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Địa chỉ giao hàng</h4>
                    <p class="text-gray-700 dark:text-gray-200 font-medium">Trần Văn An</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Số 123, Đường ABC, Phường Cống Vị, Quận Ba Đình,
                        Hà Nội</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">SĐT: 0987654321</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Thông tin thanh toán</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-200">Phương thức: Thanh toán khi nhận hàng (COD)</p>
                    <p class="text-sm text-gray-700 dark:text-gray-200">Tình trạng: <span
                            class="font-medium text-green-600">Đã thanh toán</span></p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Tổng cộng</h4>
                    <div class="space-y-1">
                        <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                            <span>Tạm tính:</span>
                            <span>31.740.000 VNĐ</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                            <span>Phí vận chuyển:</span>
                            <span>25.000 VNĐ</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                            <span>Giảm giá:</span>
                            <span class="text-red-500">- 0 VNĐ</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-4 mt-4 border-t dark:border-gray-600">
                        <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Tổng:</span>
                        <span class="text-lg font-bold text-red-500">31.765.000 VNĐ</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <!-- Nút quay lại -->
            <a
                class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300">
                Quay lại
            </a>

            <!-- Các nút bên phải -->
            <div class="flex space-x-4">
                <button
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-red-500 border border-red-500 hover:bg-red-50">
                    Yêu cầu trả hàng
                </button>
                <button class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-red-500 hover:bg-red-600">
                    Viết đánh giá
                </button>
            </div>
        </div>

    </div>
@endsection
