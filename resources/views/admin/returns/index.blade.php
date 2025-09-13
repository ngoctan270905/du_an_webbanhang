@extends('layouts.admin')

@section('title', 'Quản lý yêu cầu trả hàng')

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="space-y-4">
            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Danh sách yêu cầu trả hàng</h3>
                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600 transition-colors duration-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        Quay lại danh sách đơn hàng
                    </a>
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

                    <form action="{{ route('admin.returns.index') }}" method="GET"
                        class="rounded-lg border border-gray-200 p-3">
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                            <input type="text" name="search"
                                class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Tìm kiếm theo mã trả hàng" value="{{ request('search') }}">
                            <select name="status"
                                class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã chấp
                                    nhận
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn tất
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy
                                </option>
                            </select>
                            <div class="flex items-center space-x-2">
                                <button type="submit"
                                    class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Tìm kiếm
                                </button>
                                <button type="button" onclick="window.location='{{ route('admin.returns.index') }}'"
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
                                        Mã trả hàng</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Mã đơn hàng</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Khách hàng</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Sản phẩm</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Số lượng</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Tổng tiền hoàn</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Phương thức hoàn</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Trạng thái</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Ngày yêu cầu</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-center text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Ngày hoàn tiền</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-900">
                                        Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($returns as $return)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-indigo-900">
                                            {{ $return->ma_tra_hang }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                            {{ $return->order->ma_don_hang }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                            {{ $return->user->name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                            @foreach ($return->returnDetails as $detail)
                                                {{ $detail->orderDetail->product->ten_san_pham }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-900">
                                            @foreach ($return->returnDetails as $detail)
                                                {{ $detail->so_luong }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">
                                            {{ number_format($return->tong_tien_hoan, 0, ',', '.') }}đ
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                            @php
                                                $phuongThuc = '';
                                                switch ($return->phuong_thuc_hoan_tien) {
                                                    case 'cod':
                                                        $phuongThuc = 'Tiền mặt khi nhận hàng';
                                                        break;
                                                    case 'bank_transfer':
                                                        $phuongThuc = 'Chuyển khoản ngân hàng';
                                                        break;
                                                    case 'online_payment':
                                                        $phuongThuc = 'Thanh toán trực tuyến';
                                                        break;
                                                    default:
                                                        $phuongThuc = 'Không xác định';
                                                        break;
                                                }
                                            @endphp
                                            {{ $phuongThuc }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                            @php
                                                $statusClass = '';
                                                $displayText = '';
                                                $statusIcon = '';
                                                switch ($return->trang_thai) {
                                                    case 'pending':
                                                        $statusClass = 'bg-yellow-200 text-yellow-800';
                                                        $displayText = 'Chờ xử lý';
                                                        $statusIcon = 'fa-solid fa-hourglass-half';
                                                        break;
                                                    case 'approved':
                                                        $statusClass = 'bg-green-200 text-green-800';
                                                        $displayText = 'Đã chấp nhận';
                                                        $statusIcon = 'fa-solid fa-circle-check';
                                                        break;
                                                    case 'rejected':
                                                        $statusClass = 'bg-red-200 text-red-800';
                                                        $displayText = 'Đã từ chối';
                                                        $statusIcon = 'fa-solid fa-circle-xmark';
                                                        break;
                                                    case 'completed':
                                                        $statusClass = 'bg-blue-200 text-blue-800';
                                                        $displayText = 'Hoàn tất';
                                                        $statusIcon = 'fa-solid fa-check-double';
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
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500 text-center">
                                            {{ $return->ngay_yeu_cau->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500 text-center">
                                            {{ $return->ngay_hoan_tien ? $return->ngay_hoan_tien->format('d/m/Y H:i') : 'Chưa hoàn tiền' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                @if (in_array($return->trang_thai, ['pending', 'approved']))
                                                    <button type="button"
                                                        class="edit-status-btn rounded-lg bg-yellow-500 p-1.5 text-white transition-colors duration-200 hover:bg-yellow-600"
                                                        title="Cập nhật trạng thái" data-id="{{ $return->id }}"
                                                        data-status="{{ $return->trang_thai }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L15.232 5.232z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.returns.show', $return->id) }}"
                                                    class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600"
                                                    title="Xem chi tiết yêu cầu trả hàng">
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
                                            <td colspan="12"
                                                class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">
                                                Không có yêu cầu trả hàng nào
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end">
                            {{ $returns->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal cập nhật trạng thái yêu cầu trả hàng -->
        <div id="editReturnStatusModal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur transition-opacity duration-300">
            <div id="modalContent"
                class="rounded-2xl bg-white dark:bg-gray-800 p-8 w-full max-w-lg mx-4 drop-shadow-2xl transition-all duration-300 transform opacity-0 scale-95 border border-gray-200 dark:border-gray-700">

                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Cập nhật trạng thái
                    </h3>
                    <button id="closeModalButton"
                        class="text-gray-500 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <form id="updateReturnStatusForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="return_status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Trạng thái mới
                        </label>
                        <div class="relative">
                            <select id="return_status" name="trang_thai" required
                                class="block w-full rounded-xl border border-gray-300 dark:border-gray-600 py-2.5 px-4 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 appearance-none">
                                <option value="pending">Chờ xử lý</option>
                                <option value="approved">Chấp nhận</option>
                                <option value="rejected">Từ chối</option>
                                <option value="completed">Hoàn tất</option>
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

                    </div>

                    <div id="rejectReasonContainer" class="mb-6 hidden">
                        <label for="ghi_chu_admin" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Ghi chú admin
                        </label>
                        <textarea id="ghi_chu_admin" name="ghi_chu_admin" rows="4"
                            class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 py-2.5 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"
                            placeholder="Nhập ghi chú (bắt buộc khi từ chối)"></textarea>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end space-x-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <button type="button" id="cancelButton"
                            class="px-5 py-2.5 rounded-xl bg-gray-300 text-gray-700 hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition-colors">
                            Hủy
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 transition-colors">
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
            const modal = document.getElementById('editReturnStatusModal');
            const modalContent = document.getElementById('modalContent');
            const form = document.getElementById('updateReturnStatusForm');
            const closeModalButton = document.getElementById('closeModalButton');
            const cancelButton = document.getElementById('cancelButton');
            const statusSelect = document.getElementById('return_status');
            const rejectReasonContainer = document.getElementById('rejectReasonContainer');
            const rejectReasonInput = document.getElementById('ghi_chu_admin');

            function updateFormOptions(currentStatus) {
                const validTransitions = {
                    'pending': ['approved', 'rejected', 'cancelled'],
                    'approved': ['completed', 'cancelled'],
                    'rejected': [],
                    'completed': [],
                    'cancelled': []
                };
                const options = statusSelect.querySelectorAll('option');

                options.forEach(option => {
                    const optionValue = option.value;
                    if (validTransitions[currentStatus].includes(optionValue) || optionValue ===
                        currentStatus) {
                        option.disabled = false;
                    } else {
                        option.disabled = true;
                    }
                });

                if (['rejected', 'cancelled'].includes(statusSelect.value)) {
                    rejectReasonContainer.classList.remove('hidden');
                    rejectReasonInput.required = true;
                } else {
                    rejectReasonContainer.classList.add('hidden');
                    rejectReasonInput.required = false;
                    rejectReasonInput.value = '';
                }
            }

            statusSelect.addEventListener('change', () => {
                if (['rejected', 'cancelled'].includes(statusSelect.value)) {
                    rejectReasonContainer.classList.remove('hidden');
                    rejectReasonInput.required = true;
                } else {
                    rejectReasonContainer.classList.add('hidden');
                    rejectReasonInput.required = false;
                    rejectReasonInput.value = '';
                }
            });

            function openModal(returnId, currentStatus) {
                const updateUrl = `/admin/returns/${returnId}/update-status`;
                form.setAttribute('action', updateUrl);

                // Cập nhật các lựa chọn trạng thái
                statusSelect.value = currentStatus;
                updateFormOptions(currentStatus);

                // Hiển thị modal
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
                    const returnId = this.getAttribute('data-id');
                    const currentStatus = this.getAttribute('data-status');
                    openModal(returnId, currentStatus);
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
