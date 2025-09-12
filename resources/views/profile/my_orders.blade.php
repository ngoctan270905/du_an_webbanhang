@extends('layouts.profile_user')

@section('title', 'Thông tin cá nhân')

@section('main-content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6" id="main-content">
        <div id="order-list" class="order-list">
            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <div class="text-2xl font-bold">Đơn hàng của tôi</div>
            </div>

            <div class="flex justify-between items-center mb-6 text-sm text-gray-500">
                <div id="order-tabs" class="flex w-full space-x-2">
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'all']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'all' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Tất cả
                    </a>
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'pending']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'pending' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Chờ xác nhận
                    </a>
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'processing']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'processing' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Đang xử lý
                    </a>
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'shipped']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'shipped' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Đang giao
                    </a>
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'delivered']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'delivered' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Hoàn tất
                    </a>
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'cancelled']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'cancelled' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Đã hủy
                    </a>
                    <a href="{{ route('my-orders.index', ['trang_thai' => 'returns']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'returns' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Trả hàng
                    </a>
                </div>
            </div>

            <div id="orders-container">
                @forelse ($orders as $order)
                    <div class="border rounded-lg mb-6 order-item overflow-hidden" data-status="{{ $order->trang_thai }}">
                        <div class="flex items-center px-4 py-0 bg-gray-50 dark:bg-gray-700 border-b">
                            <div class="flex-1 flex flex-row items-center space-x-2">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">
                                    Đơn hàng #{{ $order->ma_don_hang }}
                                </span>
                                <span class="text-sm text-gray-500">|</span>
                                <span class="text-sm text-gray-500">
                                    Ngày đặt: {{ $order->ngay_dat_hang->format('d/m/Y H:i:s') }}
                                </span>
                            </div>
                            <div class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                @php
                                    $statusClass = '';
                                    $displayText = '';
                                    $statusIcon = '';
                                    switch ($order->trang_thai) {
                                        case 'pending':
                                            $statusClass = 'bg-yellow-200 text-yellow-800';
                                            $displayText = 'Chờ xác nhận';
                                            $statusIcon = 'fa-solid fa-file-alt';
                                            break;
                                        case 'processing':
                                            $statusClass = 'bg-blue-200 text-blue-800';
                                            $displayText = 'Đang xử lý';
                                            $statusIcon = 'fa-solid fa-cogs';
                                            break;
                                        case 'shipped':
                                            $statusClass = 'bg-indigo-200 text-indigo-800';
                                            $displayText = 'Đang giao hàng';
                                            $statusIcon = 'fa-solid fa-truck';
                                            break;
                                        case 'delivered':
                                            $statusClass = 'bg-green-200 text-green-800';
                                            $displayText = 'Giao thành công';
                                            $statusIcon = 'fa-solid fa-circle-check';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'bg-red-200 text-red-800';
                                            $displayText = 'Đã hủy';
                                            $statusIcon = 'fa-solid fa-circle-xmark';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-200 text-gray-800';
                                            $displayText = 'Không rõ';
                                            $statusIcon = 'fa-solid fa-question-circle';
                                            break;
                                    }
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">
                                    <i class="{{ $statusIcon }}"></i>
                                    <span>{{ $displayText }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-1 p-4">
                                @foreach ($order->orderDetails as $detail)
                                    <div class="flex items-center space-x-4 mb-2">
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                                @if ($detail->product && $detail->product->hinh_anh)
                                                    <img src="{{ asset('storage/' . $detail->product->hinh_anh) }}"
                                                        alt="{{ $detail->product->ten_san_pham }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                                        No image
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                                                {{ $detail->product ? $detail->product->ten_san_pham : 'Sản phẩm không tồn tại' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Số lượng: {{ $detail->so_luong }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-end p-4">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Tổng tiền</p>
                                    <p class="text-lg font-bold text-red-500">
                                        {{ number_format($order->tong_tien, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end items-center p-4 bg-gray-50 dark:bg-gray-700 border-t">
                            <div class="flex space-x-2">
                                @if ($order->trang_thai == 'delivered' && $order->da_nhan_hang == 0)
                                    <button
                                        class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-green-500 hover:bg-green-600 confirm-received"
                                        data-order-id="{{ $order->ma_don_hang }}">
                                        Đã nhận được hàng
                                    </button>
                                @endif
                                <button
                                    class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-red-500 hover:bg-red-600 view-details"
                                    data-order-id="{{ $order->ma_don_hang }}">
                                    Xem chi tiết
                                </button>
                                @if ($order->trang_thai == 'delivered' && $order->da_nhan_hang == 1)
                                    <button
                                        class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-blue-500 hover:bg-blue-600 write-review"
                                        data-order-id="{{ $order->ma_don_hang }}">
                                        Viết đánh giá
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-12">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-box-open text-gray-400 mb-4" style="font-size: 5rem;"></i>
                            <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Không có đơn hàng nào trong
                                trạng thái này</span>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="flex justify-end">
                {{ $orders->appends(['trang_thai' => $selected_status])->links('vendor.pagination.tailwind') }}
            </div>
        </div>

        <!-- Template chi tiết đơn hàng ẩn ban đầu -->
        <div id="order-detail" class="hidden">
            <div class="flex justify-between items-center pb-4 border-b dark:border-gray-700">
                <div>
                    <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Chi tiết đơn hàng #<span id="detail-order-id"></span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Đặt hàng lúc <span id="detail-order-date"></span>
                    </div>
                    <div id="detail-cancel-date" class="hidden text-sm text-red-500 dark:text-red-400 mt-1">
                        Bạn đã hủy đơn hàng vào lúc <span id="cancel-date"></span>
                    </div>
                </div>
                <span id="detail-order-status"
                    class="bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-300 text-sm font-medium px-2.5 py-0.5 rounded-full">
                    Giao thành công
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 border-b pb-6">
                <div class="col-span-1 md:col-span-2">
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Trạng thái đơn hàng</div>
                    <div id="order-status-timeline" class="relative flex justify-between items-center mb-6">
                        <!-- Timeline sẽ được cập nhật động dựa trên trạng thái -->
                    </div>

                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-8 mb-4">Danh sách sản phẩm</div>
                    <div id="detail-products" class="space-y-4"></div>
                </div>

                <div class="col-span-1">
                    <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Địa chỉ giao hàng</h4>
                        <p id="detail-address-name" class="text-gray-700 dark:text-gray-200 font-bold"></p>
                        <p id="detail-full-address" class="text-sm text-gray-500 dark:text-gray-400"></p>
                        <p id="detail-phone" class="text-sm text-gray-500 dark:text-gray-400"></p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Thông tin thanh toán</h4>
                        <p id="detail-payment-method" class="text-sm text-gray-700 dark:text-gray-200"></p>
                        <p id="detail-payment-status" class="text-sm text-gray-700 dark:text-gray-200"></p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Tổng cộng</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                                <span>Tạm tính:</span>
                                <span id="detail-subtotal"></span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                                <span>Phí vận chuyển:</span>
                                <span id="detail-shipping"></span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                                <span>Giảm giá:</span>
                                <span id="detail-discount" class="text-red-500"></span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-4 mt-4 border-t dark:border-gray-600">
                            <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Tổng:</span>
                            <span id="detail-total" class="text-lg font-bold text-red-500"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="#" id="back-to-list"
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300">
                    Quay lại
                </a>
                <div class="flex space-x-4" id="order-actions">
                    <!-- Các nút sẽ được thêm động bằng JavaScript -->
                </div>
            </div>
        </div>

        <!-- Loading spinner -->
        <div id="loading-spinner" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500"></div>
        </div>

        <!-- Modal hủy đơn hàng -->
        <div id="cancel-order-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hủy đơn hàng</div>
                <form id="cancel-order-form">
                    <div class="mb-4">
                        <label for="cancel-reason"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lý do hủy đơn hàng
                        </label>
                        <div class="relative">
                            <select id="cancel-reason" name="cancel_reason"
                                class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-200 appearance-none">
                                <option value="">Chọn lý do</option>
                                <option value="Đặt nhầm sản phẩm, số lượng">Đặt nhầm sản phẩm, số lượng</option>
                                <option value="Muốn thay đổi sản phẩm khác">Muốn thay đổi sản phẩm khác</option>
                                <option value="Sản phẩm không đúng như mô tả">Sản phẩm không đúng như mô tả</option>
                                <option value="Thay đổi địa chỉ giao hàng">Thay đổi địa chỉ giao hàng</option>
                                <option value="Không còn nhu cầu mua nữa">Không còn nhu cầu mua nữa</option>
                                <option value="Khác">Khác</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
                                <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div id="cancel-error" class="hidden text-red-500 text-sm mt-2"></div>
                    </div>
                    <div id="other-reason-container" class="mb-4 hidden">
                        <label for="other-reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Vui lòng nhập lý do khác
                        </label>
                        <textarea id="other-reason" name="other_reason" rows="4"
                            class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-200"
                            placeholder="Nhập lý do cụ thể..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="close-cancel-modal"
                            class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                            Đóng
                        </button>
                        <button type="submit" id="submit-cancel-order"
                            class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-red-500 hover:bg-red-600">
                            Hủy đơn hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal chọn sản phẩm để đánh giá -->
        <div id="select-product-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Chọn sản phẩm để đánh giá</div>
                <div id="product-list" class="space-y-4 max-h-96 overflow-y-auto">
                    <!-- Danh sách sản phẩm sẽ được thêm động bằng JavaScript -->
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button id="close-select-product-modal"
                        class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Đóng
                    </button>
                    <button id="confirm-select-product"
                        class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal chọn sản phẩm để trả hàng -->
        <div id="select-return-product-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Chọn sản phẩm để trả hàng</div>
                <div id="return-product-list" class="space-y-4 max-h-96 overflow-y-auto">
                    <!-- Danh sách sản phẩm sẽ được thêm động bằng JavaScript -->
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button id="close-select-return-product-modal"
                        class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Đóng
                    </button>
                    <button id="confirm-select-return-product"
                        class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal yêu cầu trả hàng -->
        <div id="return-request-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg">
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Yêu cầu trả hàng</div>
                <form id="return-request-form" data-order-id="">
                    <!-- Phần hiển thị sản phẩm đã chọn -->
                    <div id="selected-product" class="mb-4 flex items-center space-x-4 hidden">
                        <img id="selected-product-image" src="" alt=""
                            class="w-16 h-16 rounded object-cover">
                        <span id="selected-product-name"
                            class="text-sm font-medium text-gray-900 dark:text-gray-200"></span>
                    </div>

                    <div class="mb-4">
                        <label for="return-reason"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lý do trả hàng
                        </label>
                        <div class="relative">
                            <select id="return-reason" name="return_reason"
                                class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-200 appearance-none">
                                <option value="">Chọn lý do</option>
                                <option value="Sản phẩm lỗi hoặc hư hỏng">Sản phẩm lỗi hoặc hư hỏng</option>
                                <option value="Sản phẩm không đúng như mô tả">Sản phẩm không đúng như mô tả</option>
                                <option value="Đặt nhầm sản phẩm">Đặt nhầm sản phẩm</option>
                                <option value="Không còn nhu cầu">Không còn nhu cầu</option>
                                <option value="Khác">Khác</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
                                <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div id="return-error" class="hidden text-red-500 text-sm mt-2"></div>
                    </div>

                    <div id="other-return-reason-container" class="mb-4 hidden">
                        <label for="other-return-reason"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Vui lòng nhập lý do khác
                        </label>
                        <textarea id="other-return-reason" name="other_return_reason" rows="4"
                            class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-200"
                            placeholder="Nhập lý do cụ thể..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="refund-method"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phương thức hoàn tiền
                        </label>
                        <div class="relative">
                            <select id="refund-method" name="refund_method"
                                class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-200 appearance-none">
                                <option value="">Chọn phương thức</option>
                                <option value="bank_transfer">Hoàn tiền về tài khoản ngân hàng</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
                                <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div id="bank-details-container" class="mb-4 mt-4 hidden">
                            <label for="bank-details"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Thông tin tài khoản ngân hàng
                            </label>
                            <input type="text" id="bank-details" name="bank_details"
                                class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-200"
                                placeholder="VD: MBBANK: STK 0123456">
                        </div>
                        <div id="refund-method-error" class="hidden text-red-500 text-sm mt-2"></div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" id="close-return-modal"
                            class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                            Đóng
                        </button>
                        <button type="submit" id="submit-return-request"
                            class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-blue-500 hover:bg-blue-600">
                            Gửi yêu cầu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderList = document.getElementById('order-list');
            const orderDetail = document.getElementById('order-detail');
            const loadingSpinner = document.getElementById('loading-spinner');
            const backButton = document.getElementById('back-to-list');
            const orderActions = document.getElementById('order-actions');
            const cancelOrderModal = document.getElementById('cancel-order-modal');
            const closeCancelModal = document.getElementById('close-cancel-modal');
            const cancelOrderForm = document.getElementById('cancel-order-form');
            const cancelReasonSelect = document.getElementById('cancel-reason');
            const otherReasonContainer = document.getElementById('other-reason-container');
            const errorContainer = document.getElementById('cancel-error') || document.createElement('div');
            const selectProductModal = document.getElementById('select-product-modal');
            const closeSelectProductModal = document.getElementById('close-select-product-modal');
            const confirmSelectProduct = document.getElementById('confirm-select-product');
            const productList = document.getElementById('product-list');
            const selectReturnProductModal = document.getElementById('select-return-product-modal');
            const closeSelectReturnProductModal = document.getElementById('close-select-return-product-modal');
            const confirmSelectReturnProduct = document.getElementById('confirm-select-return-product');
            const returnProductList = document.getElementById('return-product-list');
            const returnRequestModal = document.getElementById('return-request-modal');
            const closeReturnModal = document.getElementById('close-return-modal');
            const returnRequestForm = document.getElementById('return-request-form');
            const returnReasonSelect = document.getElementById('return-reason');
            const otherReturnReasonContainer = document.getElementById('other-return-reason-container');
            const returnError = document.getElementById('return-error');
            const refundMethodError = document.getElementById('refund-method-error');
            const refundMethodSelect = document.getElementById('refund-method');
            const bankDetailsContainer = document.getElementById('bank-details-container');

            // Xử lý hiển thị textarea khi chọn "Khác" trong dropdown lý do trả hàng
            returnReasonSelect.addEventListener('change', function() {
                if (this.value === 'Khác') {
                    otherReturnReasonContainer.classList.remove('hidden');
                } else {
                    otherReturnReasonContainer.classList.add('hidden');
                }
                returnError.classList.add('hidden');
            });

            // Xử lý hiển thị ô nhập thông tin ngân hàng
            refundMethodSelect.addEventListener('change', function() {
                if (this.value === 'bank_transfer') {
                    bankDetailsContainer.classList.remove('hidden');
                } else {
                    bankDetailsContainer.classList.add('hidden');
                }
                refundMethodError.classList.add('hidden');
            });

            // Xử lý đóng modal trả hàng
            closeReturnModal.addEventListener('click', function() {
                returnRequestModal.classList.add('hidden');
                returnRequestForm.reset();
                otherReturnReasonContainer.classList.add('hidden');
                returnError.classList.add('hidden');
                refundMethodError.classList.add('hidden');
                bankDetailsContainer.classList.add('hidden');
                document.getElementById('selected-product').classList.add('hidden');
            });

            // Đóng modal trả hàng khi click bên ngoài
            returnRequestModal.addEventListener('click', function(e) {
                if (e.target === returnRequestModal) {
                    returnRequestModal.classList.add('hidden');
                    returnRequestForm.reset();
                    otherReturnReasonContainer.classList.add('hidden');
                    returnError.classList.add('hidden');
                    refundMethodError.classList.add('hidden');
                    bankDetailsContainer.classList.add('hidden');
                    document.getElementById('selected-product').classList.add('hidden');
                }
            });

            // Xử lý đóng modal chọn sản phẩm trả hàng
            closeSelectReturnProductModal.addEventListener('click', function() {
                selectReturnProductModal.classList.add('hidden');
                returnProductList.innerHTML = '';
                confirmSelectReturnProduct.disabled = true;
            });

            // Đóng modal chọn sản phẩm trả hàng khi click bên ngoài
            selectReturnProductModal.addEventListener('click', function(e) {
                if (e.target === selectReturnProductModal) {
                    selectReturnProductModal.classList.add('hidden');
                    returnProductList.innerHTML = '';
                    confirmSelectReturnProduct.disabled = true;
                }
            });

            // Xử lý sự kiện bấm nút "Yêu cầu trả hàng"
            orderActions.addEventListener('click', function(e) {
                if (e.target.classList.contains('return-request')) {
                    const orderId = e.target.getAttribute('data-order-id');
                    selectReturnProductModal.classList.remove('hidden');
                    returnProductList.innerHTML = ''; // Xóa danh sách cũ

                    // Dữ liệu giả để test
                    const mockProducts = [{
                            product_id: 1,
                            ten_san_pham: 'Sản phẩm mẫu 1',
                            hinh_anh: '/images/sample-product1.jpg'
                        },
                        {
                            product_id: 2,
                            ten_san_pham: 'Sản phẩm mẫu 2',
                            hinh_anh: '/images/sample-product2.jpg'
                        }
                    ];

                    mockProducts.forEach(detail => {
                        const productDiv = document.createElement('div');
                        productDiv.className =
                            'flex items-center space-x-4 p-2 border rounded-lg cursor-pointer hover:bg-gray-100';
                        productDiv.innerHTML = `
                    <input type="radio" name="selected_return_product" value="${detail.product_id}" class="product-radio" data-name="${detail.ten_san_pham}" data-image="${detail.hinh_anh}">
                    <img src="${detail.hinh_anh}" alt="${detail.ten_san_pham}" class="w-12 h-12 rounded object-cover">
                    <span class="text-sm">${detail.ten_san_pham}</span>
                `;
                        returnProductList.appendChild(productDiv);
                    });

                    // Kích hoạt nút "Xác nhận" khi chọn sản phẩm
                    const radios = returnProductList.querySelectorAll('.product-radio');
                    radios.forEach(radio => {
                        radio.addEventListener('change', () => {
                            confirmSelectReturnProduct.disabled = false;
                            confirmSelectReturnProduct.setAttribute('data-product-id', radio
                                .value);
                            confirmSelectReturnProduct.setAttribute('data-product-name',
                                radio.getAttribute('data-name'));
                            confirmSelectReturnProduct.setAttribute('data-product-image',
                                radio.getAttribute('data-image'));
                            confirmSelectReturnProduct.setAttribute('data-order-id',
                                orderId);
                        });
                    });
                }
            });

            // Xử lý xác nhận chọn sản phẩm trả hàng
            confirmSelectReturnProduct.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productImage = this.getAttribute('data-product-image');
                const orderId = this.getAttribute('data-order-id');

                if (productId) {
                    // Đóng modal chọn sản phẩm
                    selectReturnProductModal.classList.add('hidden');
                    returnProductList.innerHTML = '';
                    confirmSelectReturnProduct.disabled = true;

                    // Mở modal yêu cầu trả hàng và hiển thị thông tin sản phẩm
                    returnRequestModal.classList.remove('hidden');
                    returnRequestForm.setAttribute('data-order-id', orderId);
                    document.getElementById('selected-product').classList.remove('hidden');
                    document.getElementById('selected-product-name').textContent = productName;
                    document.getElementById('selected-product-image').src = productImage;
                    document.getElementById('selected-product-image').alt = productName;
                }
            });

            // Xử lý sự kiện bấm nút "Đã nhận được hàng"
            document.querySelectorAll('.confirm-received').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    loadingSpinner.classList.remove('hidden');

                    fetch(`/my-orders/${orderId}/confirm-received`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => {
                            loadingSpinner.classList.add('hidden');
                            if (!response.ok) {
                                return response.json().then(error => {
                                    throw new Error(error.error ||
                                        'Có lỗi khi xác nhận nhận hàng.');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            alert(data.message);
                            window.location.reload(); // Tải lại trang để cập nhật giao diện
                        })
                        .catch(error => {
                            loadingSpinner.classList.add('hidden');
                            alert(`Lỗi: ${error.message}`);
                        });
                });
            });

            // Xử lý sự kiện bấm nút "Viết đánh giá"
            document.querySelectorAll('.write-review').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    loadingSpinner.classList.remove('hidden');

                    // Gọi API để lấy danh sách sản phẩm trong đơn hàng
                    fetch(`/my-orders/${orderId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            loadingSpinner.classList.add('hidden');
                            if (!response.ok) {
                                return response.json().then(error => {
                                    throw new Error(error.error ||
                                        'Không thể tải danh sách sản phẩm.');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            productList.innerHTML = ''; // Xóa danh sách cũ
                            data.orderDetails.forEach(detail => {
                                const productDiv = document.createElement('div');
                                productDiv.className =
                                    'flex items-center space-x-4 p-2 border rounded-lg cursor-pointer hover:bg-gray-100';

                                // Xử lý URL ảnh
                                let imageUrl = detail.hinh_anh ?
                                    (detail.hinh_anh.startsWith('http') ? detail
                                        .hinh_anh : '/storage/' + detail.hinh_anh) :
                                    '/images/no-image.png';

                                productDiv.innerHTML = `
        <input type="radio" name="selected_product" value="${detail.product_id}" class="product-radio">
        <img src="${imageUrl}" alt="${detail.ten_san_pham}" class="w-12 h-12 rounded object-cover">
        <span class="text-sm">${detail.ten_san_pham}</span>
    `;

                                productList.appendChild(productDiv);
                            });


                            // Hiển thị modal
                            selectProductModal.classList.remove('hidden');

                            // Kích hoạt nút "Xác nhận" khi chọn sản phẩm
                            const radios = productList.querySelectorAll('.product-radio');
                            radios.forEach(radio => {
                                radio.addEventListener('change', () => {
                                    confirmSelectProduct.disabled = false;
                                    confirmSelectProduct.setAttribute(
                                        'data-product-id', radio.value);
                                });
                            });
                        })
                        .catch(error => {
                            loadingSpinner.classList.add('hidden');
                            alert(`Lỗi: ${error.message}`);
                        });
                });
            });

            // Đóng modal chọn sản phẩm
            closeSelectProductModal.addEventListener('click', () => {
                selectProductModal.classList.add('hidden');
                productList.innerHTML = '';
                confirmSelectProduct.disabled = true;
            });

            // Xử lý xác nhận chọn sản phẩm
            confirmSelectProduct.addEventListener('click', () => {
                const productId = confirmSelectProduct.getAttribute('data-product-id');
                if (productId) {
                    // Chuyển hướng đến trang chi tiết sản phẩm với tham số để mở modal đánh giá
                    window.location.href = `/san-pham/${productId}?openReview=true`;
                }
            });

            // Đóng modal khi click bên ngoài
            selectProductModal.addEventListener('click', (e) => {
                if (e.target === selectProductModal) {
                    selectProductModal.classList.add('hidden');
                    productList.innerHTML = '';
                    confirmSelectProduct.disabled = true;
                }
            });

            // Thêm errorContainer nếu chưa có
            if (!document.getElementById('cancel-error')) {
                errorContainer.id = 'cancel-error';
                errorContainer.className = 'hidden text-red-500 text-sm mt-2';
                cancelOrderForm.querySelector('.mb-4').appendChild(errorContainer);
            }

            // Xử lý sự kiện khi bấm nút "Xem chi tiết"
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    loadingSpinner.classList.remove('hidden');

                    // Gọi AJAX để lấy chi tiết đơn hàng
                    fetch(`{{ url('/my-orders') }}/${orderId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => {
                            loadingSpinner.classList.add('hidden');
                            if (!response.ok) {
                                return response.json().then(error => {
                                    throw new Error(error.error ||
                                        'Đơn hàng không tồn tại');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            document.getElementById('detail-order-id').textContent = data
                                .ma_don_hang;
                            document.getElementById('detail-order-date').textContent = new Date(
                                data.ngay_dat_hang).toLocaleDateString('vi-VN', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            });
                            if (data.trang_thai === 'cancelled' && data.ngay_huy) {
                                document.getElementById('cancel-date').textContent = new Date(
                                    data.ngay_huy).toLocaleDateString('vi-VN', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });
                                document.getElementById('detail-cancel-date').classList.remove(
                                    'hidden');
                            } else {
                                document.getElementById('detail-cancel-date').classList.add(
                                    'hidden');
                            }
                            document.getElementById('detail-order-status').innerHTML = `
    <i class="${getStatusIcon(data.trang_thai)}"></i>
    <span>${getStatusText(data.trang_thai)}</span>
`;
                            document.getElementById('detail-order-status').className =
                                getStatusClass(data.trang_thai);

                            // Cập nhật timeline trạng thái đơn hàng
                            updateOrderStatusTimeline(data.trang_thai);

                            // Cập nhật danh sách sản phẩm
                            const productsContainer = document.getElementById(
                                'detail-products');
                            productsContainer.innerHTML =
                                ''; // Xóa nội dung cũ trước khi render lại
                            data.orderDetails.forEach(detail => {
                                const productDiv = document.createElement('div');
                                productDiv.className =
                                    'flex items-center justify-between py-2 dark:border-gray-700';
                                productDiv.innerHTML = `
        <div class="flex items-center">
            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex-shrink-0">
                ${detail.hinh_anh ? `<img src="${detail.hinh_anh}" alt="${detail.ten_san_pham}" class="w-full h-full object-cover">` : 'No image'}
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900 dark:text-gray-100">${detail.ten_san_pham}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Số lượng: ${detail.so_luong}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="font-semibold text-gray-900 dark:text-gray-100">${numberFormat(detail.gia)}</p>
            <p class="text-sm font-semibold text-gray-900 dark:text-gray-400">x ${detail.so_luong}</p>
        </div>
    `;
                                productsContainer.appendChild(productDiv);
                            });

                            // Cập nhật thông tin địa chỉ và thanh toán
                            document.getElementById('detail-address-name').textContent = data
                                .ten_nguoi_nhan;
                            document.getElementById('detail-full-address').textContent = [
                                data.dia_chi,
                                data.ward_name,
                                data.district_name,
                                data.province_name
                            ].filter(Boolean).join(', ');
                            document.getElementById('detail-phone').textContent =
                                `SĐT: ${data.so_dien_thoai}`;
                            document.getElementById('detail-payment-method').textContent =
                                `Phương thức: ${getPaymentMethodText(data.phuong_thuc_thanh_toan)}`;
                            document.getElementById('detail-payment-status').innerHTML =
                                `Tình trạng: <span class="font-medium ${getPaymentStatusClass(data.tinh_trang_thanh_toan)}">${data.tinh_trang_thanh_toan}</span>`;
                            document.getElementById('detail-subtotal').textContent =
                                numberFormat(data.tong_tien_hang);
                            document.getElementById('detail-shipping').textContent =
                                numberFormat(data.phi_van_chuyen);
                            document.getElementById('detail-discount').textContent =
                                numberFormat(data.giam_gia);
                            document.getElementById('detail-total').textContent = numberFormat(
                                data.tong_tien);

                            // Xóa các nút cũ trong #order-actions
                            orderActions.innerHTML = '';

                            // Thêm nút Hủy đơn hàng nếu trạng thái là pending hoặc processing
                            if (['pending', 'processing'].includes(data.trang_thai)) {
                                const cancelButton = document.createElement('button');
                                cancelButton.className =
                                    'px-4 py-2 text-sm font-semibold rounded-lg text-red-500 border border-red-500 hover:bg-red-50 cancel-order';
                                cancelButton.setAttribute('data-order-id', data.ma_don_hang);
                                cancelButton.textContent = 'Hủy đơn hàng';
                                orderActions.appendChild(cancelButton);
                            }

                            // Thêm nút Yêu cầu trả hàng và Viết đánh giá nếu trạng thái là delivered
                            if (data.trang_thai === 'delivered') {
                                const returnButton = document.createElement('button');
                                returnButton.className =
                                    'px-4 py-2 text-sm font-semibold rounded-lg text-red-500 border border-red-500 hover:bg-red-50 return-request';
                                returnButton.setAttribute('data-order-id', data.ma_don_hang);
                                returnButton.textContent = 'Yêu cầu trả hàng';
                                orderActions.appendChild(returnButton);
                            }
                            // Ẩn danh sách đơn hàng và hiển thị chi tiết đơn hàng
                            orderList.classList.add('hidden');
                            orderDetail.classList.remove('hidden');
                        })
                        .catch(error => {
                            loadingSpinner.classList.add('hidden');
                            console.error('Lỗi:', error.message);
                            alert(
                                `Không thể tải chi tiết đơn hàng: ${error.message}. Vui lòng thử lại.`
                            );
                        });
                });
            });

            // Xử lý sự kiện nút "Quay lại"
            backButton.addEventListener('click', function(e) {
                e.preventDefault();
                orderDetail.classList.add('hidden');
                orderList.classList.remove('hidden');
            });

            // Xử lý sự kiện bấm nút "Hủy đơn hàng"
            orderActions.addEventListener('click', function(e) {
                if (e.target.classList.contains('cancel-order')) {
                    const orderId = e.target.getAttribute('data-order-id');
                    cancelOrderModal.classList.remove('hidden');
                    cancelOrderForm.setAttribute('data-order-id', orderId);
                    errorContainer.classList.add('hidden'); // Ẩn thông báo lỗi khi mở modal
                }
            });

            // Xử lý hiển thị textarea khi chọn "Khác" trong dropdown
            cancelReasonSelect.addEventListener('change', function() {
                if (this.value === 'Khác') {
                    otherReasonContainer.classList.remove('hidden');
                } else {
                    otherReasonContainer.classList.add('hidden');
                }
                errorContainer.classList.add('hidden'); // Ẩn thông báo lỗi khi thay đổi lý do
            });

            // Xử lý đóng modal
            closeCancelModal.addEventListener('click', function() {
                cancelOrderModal.classList.add('hidden');
                cancelOrderForm.reset();
                otherReasonContainer.classList.add('hidden');
                errorContainer.classList.add('hidden');
            });

            // Xử lý submit form hủy đơn hàng
            cancelOrderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const orderId = this.getAttribute('data-order-id');
                const reason = cancelReasonSelect.value;
                const otherReason = document.getElementById('other-reason').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                // Validation phía client
                if (!reason) {
                    errorContainer.textContent = 'Vui lòng chọn lý do hủy đơn hàng.';
                    errorContainer.classList.remove('hidden');
                    return;
                }

                if (reason === 'Khác' && !otherReason.trim()) {
                    errorContainer.textContent = 'Vui lòng nhập lý do cụ thể.';
                    errorContainer.classList.remove('hidden');
                    return;
                }

                loadingSpinner.classList.remove('hidden');

                // Gửi AJAX đến backend
                fetch(`{{ url('/my-orders') }}/${orderId}/cancel`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            cancel_reason: reason,
                            other_reason: reason === 'Khác' ? otherReason : null
                        })
                    })
                    .then(response => {
                        loadingSpinner.classList.add('hidden');
                        if (!response.ok) {
                            return response.json().then(error => {
                                throw new Error(error.error ||
                                    'Có lỗi xảy ra khi hủy đơn hàng.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        cancelOrderModal.classList.add('hidden');
                        cancelOrderForm.reset();
                        otherReasonContainer.classList.add('hidden');
                        errorContainer.classList.add('hidden');
                        alert(data.message);
                        // Reload trang để cập nhật danh sách đơn hàng
                        window.location.reload();
                    })
                    .catch(error => {
                        loadingSpinner.classList.add('hidden');
                        errorContainer.textContent = error.message;
                        errorContainer.classList.remove('hidden');
                    });
            });

            // Hàm định dạng trạng thái
            function getStatusIcon(status) {
                switch (status) {
                    case 'pending':
                        return 'fa-solid fa-file-alt';
                    case 'processing':
                        return 'fa-solid fa-cogs';
                    case 'shipped':
                        return 'fa-solid fa-truck';
                    case 'delivered':
                        return 'fa-solid fa-circle-check';
                    case 'cancelled':
                        return 'fa-solid fa-circle-xmark';
                    default:
                        return 'fa-solid fa-question-circle';
                }
            }

            function getStatusText(status) {
                switch (status) {
                    case 'pending':
                        return 'Chờ xác nhận';
                    case 'processing':
                        return 'Đang xử lý';
                    case 'shipped':
                        return 'Đang giao hàng';
                    case 'delivered':
                        return 'Giao thành công';
                    case 'cancelled':
                        return 'Đã hủy';
                    default:
                        return 'Không rõ';
                }
            }

            function getStatusClass(status) {
                switch (status) {
                    case 'pending':
                        return 'bg-yellow-200 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'processing':
                        return 'bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'shipped':
                        return 'bg-indigo-200 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'delivered':
                        return 'bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'cancelled':
                        return 'bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    default:
                        return 'bg-gray-200 text-gray-800 dark:bg-gray-900 dark:text-gray-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                }
            }

            // Hàm định dạng phương thức thanh toán
            function getPaymentMethodText(method) {
                switch (method) {
                    case 'cod':
                        return 'Thanh toán khi nhận hàng';
                    case 'bank_transfer':
                        return 'Chuyển khoản ngân hàng';
                    case 'online_payment':
                        return 'Thanh toán trực tuyến';
                    default:
                        return 'Không xác định';
                }
            }

            // Hàm định dạng trạng thái thanh toán
            function getPaymentStatusClass(status) {
                switch (status) {
                    case 'Chưa thanh toán':
                        return 'text-yellow-600';
                    case 'Đã thanh toán':
                        return 'text-green-600';
                    case 'Thanh toán thất bại':
                        return 'text-red-600';
                    default:
                        return 'text-gray-600';
                }
            }

            // Hàm cập nhật timeline trạng thái đơn hàng
            function updateOrderStatusTimeline(status) {
                const statuses = ['pending', 'processing', 'shipped', 'delivered'];
                const statusLabels = {
                    pending: 'Chờ xác nhận',
                    processing: 'Đang xử lý',
                    shipped: 'Đang giao',
                    delivered: 'Thành công',
                    cancelled: 'Đã hủy'
                };
                const statusIcons = {
                    pending: 'fa-solid fa-file-alt',
                    processing: 'fa-solid fa-cogs',
                    shipped: 'fa-solid fa-truck',
                    delivered: 'fa-solid fa-circle-check',
                    cancelled: 'fa-solid fa-circle-xmark'
                };
                const timelineContainer = document.getElementById('order-status-timeline');
                timelineContainer.innerHTML = '';

                if (status === 'cancelled') {
                    // Nếu trạng thái là 'cancelled', chỉ hiển thị trạng thái "Đã hủy" màu đỏ
                    const statusDiv = document.createElement('div');
                    statusDiv.className = 'flex flex-col items-center';
                    statusDiv.innerHTML = `
            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white">
                <i class="${statusIcons['cancelled']}"></i>
            </div>
            <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">${statusLabels['cancelled']}</span>
        `;
                    timelineContainer.appendChild(statusDiv);
                } else {
                    // Hiển thị các trạng thái khác
                    const currentIndex = statuses.indexOf(status);
                    statuses.forEach((s, index) => {
                        // Ô được đánh dấu là active nếu nó là trạng thái hiện tại hoặc trước đó
                        const isActive = index <= currentIndex;
                        const statusDiv = document.createElement('div');
                        statusDiv.className = 'flex flex-col items-center';
                        statusDiv.innerHTML = `
                <div class="w-8 h-8 flex items-center justify-center rounded-full ${isActive ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500'}">
                    <i class="${statusIcons[s]}"></i>
                </div>
                <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">${statusLabels[s]}</span>
            `;
                        timelineContainer.appendChild(statusDiv);

                        // Luôn thêm đường nối nếu không phải trạng thái cuối
                        if (index < statuses.length - 1) {
                            const connector = document.createElement('div');
                            // Đường nối chỉ có màu xanh nếu trạng thái hiện tại vượt qua trạng thái hiện tại
                            connector.className =
                                `flex-1 border-t-2 ${currentIndex > index ? 'border-green-500' : 'border-gray-300'} mx-1`;
                            timelineContainer.appendChild(connector);
                        }
                    });
                }
            }

            // Hàm định dạng số tiền
            function numberFormat(number) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(number);
            }
        });
    </script>
@endsection
