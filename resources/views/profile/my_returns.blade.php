@extends('layouts.profile_user')

@section('title', 'Yêu cầu trả hàng')

@section('main-content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6" id="main-content">
        <div id="return-list" class="return-list">
            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <div class="text-2xl font-bold">Yêu cầu trả hàng của tôi</div>
                <a href="{{ route('my-orders.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600 transition-colors duration-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    Quay lại đơn hàng của tôi
                </a>
            </div>

            <div class="flex justify-between items-center mb-6 text-sm text-gray-500">
                <div id="return-tabs" class="flex w-full space-x-2">
                    <a href="{{ route('my-returns', ['trang_thai' => 'all']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'all' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Tất cả
                    </a>
                    <a href="{{ route('my-returns', ['trang_thai' => 'pending']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'pending' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Chờ xử lý
                    </a>
                    <a href="{{ route('my-returns', ['trang_thai' => 'approved']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'approved' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Đã chấp nhận
                    </a>
                    <a href="{{ route('my-returns', ['trang_thai' => 'rejected']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'rejected' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Đã từ chối
                    </a>
                    <a href="{{ route('my-returns', ['trang_thai' => 'completed']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'completed' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Hoàn tất
                    </a>
                    <a href="{{ route('my-returns', ['trang_thai' => 'cancelled']) }}"
                        class="nav-item flex-1 py-2 text-center {{ $selected_status == 'cancelled' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-500' }}">
                        Đã hủy
                    </a>
                </div>
            </div>

            <div id="returns-container">
                @forelse ($returns as $return)
                    <div class="border rounded-lg mb-6 return-item overflow-hidden" data-status="{{ $return->trang_thai }}">
                        <div class="flex items-center px-4 py-0 bg-gray-50 dark:bg-gray-700 border-b">
                            <div class="flex-1 flex flex-row items-center space-x-2">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">
                                    #{{ $return->ma_tra_hang }}
                                </span>
                                <span class="text-sm text-gray-500">|</span>
                                <span class="text-sm text-gray-500">
                                    Ngày yêu cầu: {{ $return->ngay_yeu_cau->format('d/m/Y H:i:s') }}
                                </span>
                                <span class="text-sm text-gray-500">|</span>
                                <span class="text-sm text-gray-500">
                                    Đơn hàng: #{{ $return->order->ma_don_hang }}
                                </span>
                            </div>
                            <div class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                @php
                                    $statusClass = '';
                                    $displayText = '';
                                    $statusIcon = '';
                                    switch ($return->trang_thai) {
                                        case 'pending':
                                            $statusClass = 'bg-yellow-200 text-yellow-800';
                                            $displayText = 'Chờ xử lý';
                                            $statusIcon = 'fa-solid fa-file-alt';
                                            break;
                                        case 'approved':
                                            $statusClass = 'bg-blue-200 text-blue-800';
                                            $displayText = 'Đã chấp nhận';
                                            $statusIcon = 'fa-solid fa-check-circle';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'bg-red-200 text-red-800';
                                            $displayText = 'Đã từ chối';
                                            $statusIcon = 'fa-solid fa-circle-xmark';
                                            break;
                                        case 'completed':
                                            $statusClass = 'bg-green-200 text-green-800';
                                            $displayText = 'Hoàn tất';
                                            $statusIcon = 'fa-solid fa-circle-check';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'bg-gray-200 text-gray-800';
                                            $displayText = 'Đã hủy';
                                            $statusIcon = 'fa-solid fa-ban';
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
                                @foreach ($return->returnDetails as $detail)
                                    <div class="flex items-center space-x-4 mb-2">
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                                @if ($detail->orderDetail->product && $detail->orderDetail->product->hinh_anh)
                                                    <img src="{{ asset('storage/' . $detail->orderDetail->product->hinh_anh) }}"
                                                        alt="{{ $detail->orderDetail->product->ten_san_pham }}"
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
                                                {{ $detail->orderDetail->product ? $detail->orderDetail->product->ten_san_pham : 'Sản phẩm không tồn tại' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Số lượng trả: {{ $detail->so_luong }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-end p-4">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Tổng tiền hoàn</p>
                                    <p class="text-lg font-bold text-red-500">
                                        {{ number_format($return->tong_tien_hoan, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end items-center p-4 bg-gray-50 dark:bg-gray-700 border-t">
                            <div class="flex space-x-2">
                                @if ($return->trang_thai == 'pending')
                                    <button
                                        class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-gray-500 hover:bg-gray-600 cancel-return"
                                        data-return-id="{{ $return->id }}">
                                        Hủy yêu cầu
                                    </button>
                                @endif
                                <button
                                    class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-red-500 hover:bg-red-600 view-details"
                                    data-return-id="{{ $return->id }}">
                                    Xem chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-12">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-box-open text-gray-400 mb-4" style="font-size: 5rem;"></i>
                            <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Không có yêu cầu trả hàng nào trong trạng thái này</span>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="flex justify-end">
                {{ $returns->appends(['trang_thai' => $selected_status])->links('vendor.pagination.tailwind') }}
            </div>
        </div>

        <!-- Template chi tiết yêu cầu trả hàng ẩn ban đầu -->
        <div id="return-detail" class="hidden">
            <div class="flex justify-between items-center pb-4 border-b dark:border-gray-700">
                <div>
                    <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Chi tiết yêu cầu trả hàng #<span id="detail-ma-tra-hang"></span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Yêu cầu lúc: <span id="detail-return-date"></span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Đơn hàng #<span id="detail-order-id"></span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1" id="detail-return-reason-container">
                        Lý do trả hàng: <span id="detail-return-reason"></span>
                    </div>
                    <div class="text-sm text-red-500 dark:text-red-500 mt-1" id="detail-admin-note-container">
                        Ghi chú admin: <span id="detail-admin-note"></span>
                    </div>
                    <div class="text-sm text-red-500 dark:text-red-500 mt-1" id="detail-refunded-date-container">
                        Ngày hoàn tiền: <span id="detail-refunded-date"></span>
                    </div>
                </div>
                <span id="detail-return-status"
                    class="bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-300 text-sm font-medium px-2.5 py-0.5 rounded-full">
                    Hoàn tất
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 border-b pb-6">
                <div class="col-span-1 md:col-span-2">
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Trạng thái yêu cầu</div>
                    <div id="return-status-timeline" class="relative flex justify-between items-center mb-6">
                        <!-- Timeline sẽ được cập nhật động dựa trên trạng thái -->
                    </div>

                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-8 mb-4">Danh sách sản phẩm trả hàng</div>
                    <div id="detail-products" class="space-y-4"></div>
                </div>

                <div class="col-span-1">
                    <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Thông tin hoàn tiền</h4>
                        <p id="detail-refund-method" class="text-sm text-gray-700 dark:text-gray-200"></p>
                        <p id="detail-bank-details" class="text-sm text-gray-500 dark:text-gray-400"></p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 border rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Tổng cộng</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200">
                                <span>Tổng tiền hoàn:</span>
                                <span id="detail-total"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="#" id="back-to-list"
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-300">
                    Quay lại
                </a>
                <div id="detail-actions" class="flex space-x-2"></div>
            </div>
        </div>

        <!-- Loading spinner -->
        <div id="loading-spinner" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const returnList = document.getElementById('return-list');
            const returnDetail = document.getElementById('return-detail');
            const loadingSpinner = document.getElementById('loading-spinner');
            const backButton = document.getElementById('back-to-list');

            // Xử lý sự kiện bấm nút "Xem chi tiết"
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const returnId = this.getAttribute('data-return-id');
                    loadingSpinner.classList.remove('hidden');

                    // Gọi AJAX để lấy chi tiết yêu cầu trả hàng
                    fetch(`/my-returns/${returnId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        loadingSpinner.classList.add('hidden');
                        if (!response.ok) {
                            return response.json().then(error => {
                                throw new Error(error.error || 'Yêu cầu trả hàng không tồn tại');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('detail-ma-tra-hang').textContent = data.ma_tra_hang;
                        document.getElementById('detail-order-id').textContent = data.order.ma_don_hang;
                        document.getElementById('detail-return-date').textContent = new Date(
                            data.ngay_yeu_cau).toLocaleDateString('vi-VN', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                        document.getElementById('detail-return-reason').textContent = data.ly_do_tra_hang || 'Không có';
                        document.getElementById('detail-return-reason-container').classList.toggle('hidden', !data.ly_do_tra_hang);
                        document.getElementById('detail-admin-note').textContent = data.ghi_chu_admin || 'Không có';
                        document.getElementById('detail-admin-note-container').classList.toggle('hidden', !data.ghi_chu_admin);
                        document.getElementById('detail-refunded-date').textContent = data.ngay_hoan_tien ? new Date(
                            data.ngay_hoan_tien).toLocaleDateString('vi-VN', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        }) : 'Chưa hoàn tiền';
                        document.getElementById('detail-refunded-date-container').classList.toggle('hidden', !data.ngay_hoan_tien);
                        document.getElementById('detail-return-status').innerHTML = `
                            <i class="${getStatusIcon(data.trang_thai)}"></i>
                            <span>${getStatusText(data.trang_thai)}</span>
                        `;
                        document.getElementById('detail-return-status').className = getStatusClass(data.trang_thai);

                        // Cập nhật timeline trạng thái yêu cầu trả hàng
                        updateReturnStatusTimeline(data.trang_thai);

                        // Cập nhật danh sách sản phẩm trả hàng
                        const productsContainer = document.getElementById('detail-products');
                        productsContainer.innerHTML = '';
                        data.returnDetails.forEach(detail => {
                            const productDiv = document.createElement('div');
                            productDiv.className = 'flex items-center justify-between py-2 dark:border-gray-700';
                            productDiv.innerHTML = `
                                <div class="flex items-center">
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex-shrink-0">
                                        ${detail.orderDetail.product.hinh_anh ? `<img src="/storage/${detail.orderDetail.product.hinh_anh}" alt="${detail.orderDetail.product.ten_san_pham}" class="w-full h-full object-cover">` : 'No image'}
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">${detail.orderDetail.product.ten_san_pham}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Số lượng: ${detail.so_luong}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">${numberFormat(detail.gia_tra)}</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-400">x ${detail.so_luong}</p>
                                </div>
                            `;
                            productsContainer.appendChild(productDiv);
                        });

                        // Cập nhật thông tin hoàn tiền
                        document.getElementById('detail-refund-method').textContent = `Phương thức: ${getRefundMethodText(data.phuong_thuc_hoan_tien)}`;
                        document.getElementById('detail-bank-details').textContent = data.thong_tin_ngan_hang ? `Thông tin ngân hàng: ${data.thong_tin_ngan_hang}` : '';
                        document.getElementById('detail-total').textContent = numberFormat(data.tong_tien_hoan);

                        // Cập nhật nút hành động (hủy yêu cầu)
                        const actionsContainer = document.getElementById('detail-actions');
                        actionsContainer.innerHTML = '';
                        if (data.trang_thai === 'pending') {
                            const cancelButton = document.createElement('button');
                            cancelButton.className = 'px-4 py-2 text-sm font-semibold rounded-lg text-white bg-gray-500 hover:bg-gray-600 cancel-return';
                            cancelButton.setAttribute('data-return-id', data.id);
                            cancelButton.textContent = 'Hủy yêu cầu';
                            actionsContainer.appendChild(cancelButton);
                        }

                        // Ẩn danh sách yêu cầu trả hàng và hiển thị chi tiết
                        returnList.classList.add('hidden');
                        returnDetail.classList.remove('hidden');
                    })
                    .catch(error => {
                        loadingSpinner.classList.add('hidden');
                        console.error('Lỗi:', error.message);
                        alert(`Không thể tải chi tiết yêu cầu trả hàng: ${error.message}. Vui lòng thử lại.`);
                    });
                });
            });

            // Xử lý sự kiện nút "Hủy yêu cầu"
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('cancel-return')) {
                    const returnId = e.target.getAttribute('data-return-id');
                    if (confirm('Bạn có chắc chắn muốn hủy yêu cầu trả hàng này?')) {
                        loadingSpinner.classList.remove('hidden');
                        fetch(`/my-returns/${returnId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => {
                            loadingSpinner.classList.add('hidden');
                            if (!response.ok) {
                                return response.json().then(error => {
                                    throw new Error(error.error || 'Không thể hủy yêu cầu trả hàng');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            alert(data.message);
                            window.location.reload(); // Tải lại trang để cập nhật danh sách
                        })
                        .catch(error => {
                            loadingSpinner.classList.add('hidden');
                            console.error('Lỗi:', error.message);
                            alert(`Không thể hủy yêu cầu trả hàng: ${error.message}. Vui lòng thử lại.`);
                        });
                    }
                }
            });

            // Xử lý sự kiện nút "Quay lại"
            backButton.addEventListener('click', function(e) {
                e.preventDefault();
                returnDetail.classList.add('hidden');
                returnList.classList.remove('hidden');
            });

            // Hàm định dạng trạng thái
            function getStatusIcon(status) {
                switch (status) {
                    case 'pending':
                        return 'fa-solid fa-file-alt';
                    case 'approved':
                        return 'fa-solid fa-check-circle';
                    case 'rejected':
                        return 'fa-solid fa-circle-xmark';
                    case 'completed':
                        return 'fa-solid fa-circle-check';
                    case 'cancelled':
                        return 'fa-solid fa-ban';
                    default:
                        return 'fa-solid fa-question-circle';
                }
            }

            function getStatusText(status) {
                switch (status) {
                    case 'pending':
                        return 'Chờ xử lý';
                    case 'approved':
                        return 'Đã chấp nhận';
                    case 'rejected':
                        return 'Đã từ chối';
                    case 'completed':
                        return 'Hoàn tất';
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
                    case 'approved':
                        return 'bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'rejected':
                        return 'bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'completed':
                        return 'bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    case 'cancelled':
                        return 'bg-gray-200 text-gray-800 dark:bg-gray-900 dark:text-gray-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                    default:
                        return 'bg-gray-200 text-gray-800 dark:bg-gray-900 dark:text-gray-300 text-sm font-medium px-2.5 py-0.5 rounded-full';
                }
            }

            // Hàm định dạng phương thức hoàn tiền
            function getRefundMethodText(method) {
                switch (method) {
                    case 'bank_transfer':
                        return 'Chuyển khoản ngân hàng';
                    case 'cod':
                        return 'Thanh toán khi nhận hàng';
                    case 'online_payment':
                        return 'Thanh toán trực tuyến';
                    default:
                        return 'Không xác định';
                }
            }

            // Hàm cập nhật timeline trạng thái yêu cầu trả hàng
            function updateReturnStatusTimeline(status) {
                const statuses = ['pending', 'approved', 'completed'];
                const statusLabels = {
                    pending: 'Chờ xử lý',
                    approved: 'Đã chấp nhận',
                    completed: 'Hoàn tất',
                    rejected: 'Đã từ chối',
                    cancelled: 'Đã hủy'
                };
                const statusIcons = {
                    pending: 'fa-solid fa-file-alt',
                    approved: 'fa-solid fa-check-circle',
                    completed: 'fa-solid fa-circle-check',
                    rejected: 'fa-solid fa-circle-xmark',
                    cancelled: 'fa-solid fa-ban'
                };
                const timelineContainer = document.getElementById('return-status-timeline');
                timelineContainer.innerHTML = '';

                if (status === 'rejected' || status === 'cancelled') {
                    const statusDiv = document.createElement('div');
                    statusDiv.className = 'flex flex-col items-center';
                    statusDiv.innerHTML = `
                        <div class="w-8 h-8 flex items-center justify-center rounded-full ${status === 'rejected' ? 'bg-red-500' : 'bg-gray-500'} text-white">
                            <i class="${statusIcons[status]}"></i>
                        </div>
                        <span class="mt-2 text-xs text-center text-gray-600 dark:text-gray-300">${statusLabels[status]}</span>
                    `;
                    timelineContainer.appendChild(statusDiv);
                } else {
                    const currentIndex = statuses.indexOf(status);
                    statuses.forEach((s, index) => {
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

                        if (index < statuses.length - 1) {
                            const connector = document.createElement('div');
                            connector.className = `flex-1 border-t-2 ${currentIndex > index ? 'border-green-500' : 'border-gray-300'} mx-1`;
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