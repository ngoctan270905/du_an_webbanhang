@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="space-y-4">
            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Danh sách đơn hàng</h3>
                </div>

                <div class="space-y-4">
                    @if (session('success'))
                        <div class="relative rounded-lg bg-green-100 p-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="relative rounded-lg bg-red-100 p-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.orders.index') }}" method="GET"
                        class="rounded-lg border border-gray-200 p-3">
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                            <input type="text" name="search"
                                class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Tìm kiếm theo mã đơn hàng" value="{{ request('search') }}">
                            <select name="status"
                                class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử
                                    lí</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang giao
                                </option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Giao
                                    thành công
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy
                                </option>
                            </select>
                            <div class="flex items-center space-x-2">
                                <button type="submit"
                                    class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Tìm kiếm
                                </button>
                                <button type="button" onclick="window.location='{{ route('admin.orders.index') }}'"
                                    class="w-1/2 rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Làm mới
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="w-full min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="whitespace-nowrap px-3 py-5 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Mã đơn</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Khách hàng</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Tổng tiền</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Trạng thái giao hàng</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Trạng thái thanh toán</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Ngày đặt</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-indigo-900">
                                            {{ $order->ma_don_hang }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                            {{ $order->user->name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">
                                            {{ number_format($order->tong_tien, 0, ',', '.') }}đ
                                        </td>
                                        {{-- Trạng thái giao hàng --}}
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                            @php
                                                $statusClass = '';
                                                $displayText = '';
                                                $statusIcon = ''; // Thêm biến này
                                                switch ($order->trang_thai) {
                                                    case 'pending':
                                                        $statusClass = 'bg-yellow-200 text-yellow-800';
                                                        $displayText = 'Chờ xác nhận';
                                                        $statusIcon = 'fa-solid fa-file-alt'; // Icon cho "Chờ xác nhận"
                                                        break;
                                                    case 'processing':
                                                        $statusClass = 'bg-blue-200 text-blue-800';
                                                        $displayText = 'Đang xử lý';
                                                        $statusIcon = 'fa-solid fa-cogs'; // Icon cho "Đang xử lý"
                                                        break;
                                                    case 'shipped':
                                                        $statusClass = 'bg-indigo-200 text-indigo-800';
                                                        $displayText = 'Đang giao hàng';
                                                        $statusIcon = 'fa-solid fa-truck'; // Icon cho "Đang giao hàng"
                                                        break;
                                                    case 'delivered':
                                                        $statusClass = 'bg-green-200 text-green-800';
                                                        $displayText = 'Giao thành công';
                                                        $statusIcon = 'fa-solid fa-circle-check'; // Icon cho "Giao thành công"
                                                        break;
                                                    case 'cancelled':
                                                        $statusClass = 'bg-red-200 text-red-800';
                                                        $displayText = 'Đã hủy';
                                                        $statusIcon = 'fa-solid fa-circle-xmark'; // Icon cho "Đã hủy"
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-gray-200 text-gray-800';
                                                        $displayText = 'Không rõ';
                                                        $statusIcon = 'fa-solid fa-question-circle'; // Icon mặc định
                                                        break;
                                                }
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">
                                                <i class="{{ $statusIcon }}"></i> {{-- Thêm icon vào đây --}}
                                                <span>{{ $displayText }}</span>
                                            </span>
                                        </td>
                                        {{-- Trạng thái thanh toán --}}
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                            @if ($order->payment)
                                                @php
                                                    $paymentStatus = $order->payment->trang_thai;
                                                    $paymentClass = '';
                                                    $displayText = '';
                                                    $paymentIcon = ''; // Thêm biến này để lưu class icon
                                                    switch ($paymentStatus) {
                                                        case 'pending':
                                                            $paymentClass = 'bg-yellow-200 text-yellow-800';
                                                            $displayText = 'Chưa thanh toán';
                                                            $paymentIcon = 'fa-solid fa-hourglass-half'; // Icon cho "Chưa thanh toán"
                                                            break;
                                                        case 'completed':
                                                            $paymentClass = 'bg-green-200 text-green-800';
                                                            $displayText = 'Đã thanh toán';
                                                            $paymentIcon = 'fa-solid fa-circle-check'; // Icon cho "Đã thanh toán"
                                                            break;
                                                        case 'failed':
                                                            $paymentClass = 'bg-red-200 text-red-800';
                                                            $displayText = 'Thất bại';
                                                            $paymentIcon = 'fa-solid fa-circle-xmark'; // Icon cho "Thất bại"
                                                            break;
                                                        default:
                                                            $paymentClass = 'bg-gray-200 text-gray-800';
                                                            $displayText = 'Không rõ';
                                                            $paymentIcon = 'fa-solid fa-question-circle'; // Icon mặc định
                                                            break;
                                                    }
                                                @endphp
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $paymentClass }}">
                                                    <i class="{{ $paymentIcon }}"></i> {{-- Thêm icon vào đây --}}
                                                    <span>{{ $displayText }}</span>
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-800">
                                                    <i class="fa-solid fa-info-circle"></i> {{-- Icon cho trạng thái không có thông tin --}}
                                                    <span>Chưa có thông tin</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500 text-center">
                                            {{ $order->ngay_dat_hang->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                {{-- Nút sửa --}}
                                                <button type="button"
                                                    class="edit-status-btn rounded-lg bg-yellow-500 p-1.5 text-white transition-colors duration-200 hover:bg-yellow-600"
                                                    title="Sửa đơn hàng" data-id="{{ $order->id }}"
                                                    data-status="{{ $order->trang_thai }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L15.232 5.232z" />
                                                    </svg>
                                                </button>
                                                {{-- Nút xem chi tiết --}}
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600"
                                                    title="Xem chi tiết">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M2 12s5-8 10-8 10 8 10 8-5 8-10 8-10-8-10-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">
                                            Không có đơn hàng nào
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        {{ $orders->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editStatusModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur transition-opacity duration-300">
        <div id="modalContent"
            class="rounded-2xl bg-white p-8 w-full max-w-md mx-4 drop-shadow-2xl transition-all duration-300 transform opacity-0 scale-95 border border-gray-200">
            <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Cập nhật trạng thái đơn hàng</h3>
                <button id="closeModalButton"
                    class="text-gray-500 hover:text-gray-900 transition-colors duration-200 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="updateStatusForm" method="POST" action="">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="order_status" class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái
                        mới</label>
                    <select id="order_status" name="trang_thai" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 py-2.5 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base transition-colors duration-200">
                        <option value="pending">Chờ xác nhận</option>
                        <option value="processing">Đang xử lý</option>
                        <option value="shipped">Đang giao hàng</option>
                        <option value="delivered">Giao thành công</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelButton"
                        class="rounded-xl border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Hủy
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-status-btn');
        const modal = document.getElementById('editStatusModal');
        const modalContent = document.getElementById('modalContent');
        const form = document.getElementById('updateStatusForm');
        const closeModalButton = document.getElementById('closeModalButton');
        const cancelButton = document.getElementById('cancelButton');
        const statusSelect = document.getElementById('order_status');

        // Định nghĩa các bước trạng thái
        const statusSteps = {
            'pending': 1,
            'processing': 2,
            'shipped': 3,
            'delivered': 4,
            'cancelled': 5
        };

        // Hàm cập nhật các lựa chọn trạng thái
        function updateStatusOptions(currentStatus) {
            const currentStep = statusSteps[currentStatus];
            const options = statusSelect.querySelectorAll('option');

            options.forEach(option => {
                const optionValue = option.value;
                const optionStep = statusSteps[optionValue];

                // Nếu đơn hàng đã hoàn thành hoặc bị hủy, không cho phép thay đổi
                if (currentStatus === 'delivered' || currentStatus === 'cancelled') {
                    option.disabled = true;
                }
                // Logic chính: chỉ cho phép chọn trạng thái tiếp theo hoặc trạng thái "Đã hủy"
                else if (optionStep && (optionStep === currentStep + 1 || optionValue ===
                        'cancelled')) {
                    option.disabled = false;
                } else {
                    option.disabled = true;
                }
            });

            // Chọn trạng thái hiện tại
            statusSelect.value = currentStatus;
        }

        function openModal(orderId, currentStatus) {
            const updateUrl = `/admin/orders/${orderId}/update-status`;
            form.setAttribute('action', updateUrl);

            // Gọi hàm cập nhật các lựa chọn khi modal được mở
            updateStatusOptions(currentStatus);

            // Hiển thị modal và thêm hiệu ứng
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            setTimeout(() => {
                modalContent.classList.add('opacity-100', 'scale-100');
                modalContent.classList.remove('opacity-0', 'scale-95');
                modal.classList.add('opacity-100');
            }, 10);
        }

        function closeModal() {
            modal.classList.remove('opacity-100');
            modalContent.classList.add('opacity-0', 'scale-95');
            modalContent.classList.remove('opacity-100', 'scale-100');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const orderId = this.getAttribute('data-id');
                const currentStatus = this.getAttribute('data-status');
                openModal(orderId, currentStatus);
            });
        });

        closeModalButton.addEventListener('click', closeModal);
        cancelButton.addEventListener('click', closeModal);

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    });
</script>
