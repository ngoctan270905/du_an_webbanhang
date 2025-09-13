@extends('layouts.admin')

@section('title', 'Chi tiết yêu cầu trả hàng #' . $return->ma_tra_hang)

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Chi tiết yêu cầu trả hàng: {{ $return->ma_tra_hang }}</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Yêu cầu lúc: {{ $return->ngay_yeu_cau ? $return->ngay_yeu_cau->format('d/m/Y, H:i') : 'Chưa ghi nhận' }}
                    </p>
                    @if ($return->trang_thai === 'cancelled' && $return->ghi_chu_admin)
                        <p class="text-sm text-red-600 font-medium mt-1">
                            Yêu cầu bị hủy: {{ $return->ghi_chu_admin }}
                        </p>
                    @endif
                    @if ($return->trang_thai === 'rejected' && $return->ghi_chu_admin)
                        <p class="text-sm text-red-600 font-medium mt-1">
                            Yêu cầu bị từ chối: {{ $return->ghi_chu_admin }}
                        </p>
                    @endif
                </div>
                <a href="{{ route('admin.returns.index') }}"
                    class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Quay lại
                </a>
            </div>

            {{-- Stepper Section --}}
            <div class="mb-8 p-4 rounded-lg border border-gray-200 shadow-sm">
                @php
                    $statusMap = [
                        'pending' => ['label' => 'Chờ xử lý', 'icon' => 'fa-solid fa-hourglass-half'],
                        'approved' => ['label' => 'Đã chấp nhận', 'icon' => 'fa-solid fa-circle-check'],
                        'completed' => ['label' => 'Hoàn tất', 'icon' => 'fa-solid fa-check-double'],
                    ];
                    $currentStatus = $return->trang_thai;
                    $isCancelledOrRejected = in_array($currentStatus, ['cancelled', 'rejected']);
                    $completedSteps = $isCancelledOrRejected
                        ? []
                        : array_keys(
                            array_slice($statusMap, 0, array_search($currentStatus, array_keys($statusMap)), true),
                        );
                @endphp

                @if ($isCancelledOrRejected)
                    {{-- Cancelled or Rejected Status --}}
                    <div class="flex items-center justify-center">
                        <div class="stepper-item failed">
                            <div class="stepper-icon">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <span class="stepper-label text-red-600">
                                {{ $currentStatus === 'cancelled' ? 'Đã hủy' : 'Đã từ chối' }}
                            </span>
                        </div>
                    </div>
                @else
                    {{-- Standard Stepper --}}
                    <div class="stepper">
                        @foreach ($statusMap as $statusKey => $status)
                            @php
                                $isCompleted = in_array($statusKey, $completedSteps);
                                $isCurrent = $statusKey === $currentStatus;
                            @endphp
                            <div class="stepper-item {{ $isCompleted ? 'completed' : ($isCurrent ? 'current' : '') }}">
                                <div class="stepper-icon">
                                    <i class="{{ $status['icon'] }}"></i>
                                </div>
                                <span class="stepper-label">{{ $status['label'] }}</span>
                            </div>
                            @if (!$loop->last)
                                <div class="stepper-connector {{ $isCompleted ? 'completed' : '' }}"></div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Cấu trúc 2 cột --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                {{-- Cột trái: 2 khung, chiếm 2/5 chiều rộng --}}
                <div class="md:col-span-2 space-y-6">
                    {{-- Khung 1: Thông tin khách hàng --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Thông tin khách hàng</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-gray-500 w-40">Tên khách hàng:</p>
                                <p class="text-base font-semibold text-gray-900">{{ $return->user->name }}</p>
                            </div>
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-gray-500 w-40">Email:</p>
                                <p class="text-base font-semibold text-gray-900">{{ $return->user->email }}</p>
                            </div>
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-gray-500 w-40">Số điện thoại:</p>
                                <p class="text-base font-semibold text-gray-900">
                                    {{ $return->order->so_dien_thoai ?? 'Chưa cập nhật' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Khung 2: Lý do trả hàng --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Lý do trả hàng</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Lý do:</p>
                                <p class="mt-1 text-base text-gray-700">{{ $return->ly_do_tra_hang }}</p>
                            </div>
                            @if ($return->ghi_chu_admin)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Ghi chú admin:</p>
                                    <p class="mt-1 text-base text-gray-700">{{ $return->ghi_chu_admin }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Cột phải: 2 khung, chiếm 3/5 chiều rộng --}}
                <div class="md:col-span-3 space-y-6">
                    {{-- Khung 1: Tổng quan yêu cầu trả hàng --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Tổng quan yêu cầu</h3>
                        <div class="grid grid-cols-2 gap-y-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Mã đơn hàng</span>
                                <a href="{{ route('admin.orders.show', $return->order->id) }}"
                                   class="font-semibold text-indigo-600 hover:text-indigo-800 mt-1">
                                    {{ $return->order->ma_don_hang }}
                                </a>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Trạng thái</span>
                                @php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch ($return->trang_thai) {
                                        case 'pending':
                                            $statusClass = 'text-yellow-800';
                                            $statusText = 'Chờ xử lý';
                                            break;
                                        case 'approved':
                                            $statusClass = 'text-green-800';
                                            $statusText = 'Đã chấp nhận';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'text-red-800';
                                            $statusText = 'Đã từ chối';
                                            break;
                                        case 'completed':
                                            $statusClass = 'text-blue-800';
                                            $statusText = 'Hoàn tất';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'text-gray-800';
                                            $statusText = 'Đã hủy bởi người dùng';
                                            break;
                                        default:
                                            $statusClass = 'text-gray-800';
                                            $statusText = 'Không rõ';
                                            break;
                                    }
                                @endphp
                                <span class="rounded-full font-semibold {{ $statusClass }} mt-1 inline-block">
                                    {{ $statusText }}
                                </span>
                            </div>
                            <div class="flex flex-col mt-4">
                                <span class="text-sm text-gray-500">Phương thức hoàn tiền</span>
                                <span class="font-semibold text-gray-900 mt-1">
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
                                </span>
                            </div>
                            <div class="flex flex-col mt-4">
                                <span class="text-sm text-gray-500">Ngày hoàn tiền</span>
                                <span class="font-semibold text-gray-900 mt-1">
                                    {{ $return->ngay_hoan_tien ? $return->ngay_hoan_tien->format('d/m/Y H:i') : 'Chưa hoàn tiền' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Khung 2: Sản phẩm trả hàng --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Sản phẩm trả hàng</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Sản phẩm
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Số lượng
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Giá hoàn
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Thành tiền
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($return->returnDetails as $detail)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded object-cover"
                                                            src="{{ Storage::url($detail->orderDetail->product->hinh_anh) }}"
                                                            alt="{{ $detail->orderDetail->product->ten_san_pham }}">
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $detail->orderDetail->product->ten_san_pham }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            SKU: {{ $detail->orderDetail->product->ma_san_pham }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                    {{ $detail->so_luong }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-500">
                                                    {{ number_format($detail->gia_tra, 0, ',', '.') }}đ
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                                    {{ number_format($detail->gia_tra * $detail->so_luong, 0, ',', '.') }}đ
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                                Tổng tiền hoàn:
                                            </td>
                                            <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">
                                                {{ number_format($return->tong_tien_hoan, 0, ',', '.') }}đ
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('admin.returns.index') }}"
                        class="rounded-lg bg-gray-200 border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Đóng
                    </a>
                    @if (in_array($return->trang_thai, ['pending', 'approved']))
                        <button type="button"
                            class="edit-status-btn rounded-lg bg-yellow-500 px-6 py-2.5 text-sm font-semibold text-white transition-colors duration-200 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            title="Cập nhật trạng thái" data-id="{{ $return->id }}"
                            data-status="{{ $return->trang_thai }}">
                            Cập nhật trạng thái
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal cập nhật trạng thái yêu cầu trả hàng --}}
        <div id="editReturnStatusModal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur transition-opacity duration-300">
            <div id="modalContent"
                class="rounded-2xl bg-white p-8 w-full max-w-md mx-4 drop-shadow-2xl transition-all duration-300 transform opacity-0 scale-95 border border-gray-200">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Cập nhật trạng thái yêu cầu trả hàng</h3>
                    <button id="closeModalButton"
                        class="text-gray- завершен
500 hover:text-gray-900 transition-colors duration-200 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="updateReturnStatusForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="return_status" class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái mới</label>
                        <select id="return_status" name="trang_thai" required
                            class="mt-1 block w-full rounded-xl border border-gray-300 py-2.5 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base transition-colors duration-200">
                            <option value="pending">Chờ xử lý</option>
                            <option value="approved">Chấp nhận</option>
                            <option value="rejected">Từ chối</option>
                            <option value="completed">Hoàn tất</option>
                            <option value="cancelled">Hủy</option>
                        </select>
                    </div>

                    <div id="rejectReasonContainer" class="mb-6 hidden">
                        <label for="ghi_chu_admin" class="block text-sm font-semibold text-gray-700 mb-2">Ghi chú admin</label>
                        <textarea id="ghi_chu_admin" name="ghi_chu_admin"
                            class="mt-1 block w-full rounded-xl border border-gray-300 py-2.5 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-base transition-colors duration-200"
                            placeholder="Nhập ghi chú (bắt buộc khi từ chối hoặc hủy)"></textarea>
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
    </div>

    <style>
        /* Horizontal Stepper for Return Status */
        .stepper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .stepper-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 110px;
            position: relative;
        }

        .stepper-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            border: 2px solid;
            transition: all 0.3s ease;
        }

        .stepper-label {
            margin-top: 8px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .stepper-connector {
            flex: 1;
            height: 2px;
            margin-top: 17px;
            transition: all 0.3s ease;
        }

        /* Default state */
        .stepper-item .stepper-icon {
            background-color: #f3f4f6;
            border-color: #e5e7eb;
            color: #6b7280;
        }

        .stepper-item .stepper-label {
            color: #6b7280;
        }

        .stepper-connector {
            background-color: #e5e7eb;
        }

        /* Completed state */
        .stepper-item.completed .stepper-icon {
            background-color: #dcfce7;
            border-color: #16a34a;
            color: #16a34a;
        }

        .stepper-item.completed .stepper-label {
            color: #1f2937;
        }

        .stepper-connector.completed {
            background-color: #16a34a;
        }

        /* Current state */
        .stepper-item.current .stepper-icon {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: #ffffff;
            transform: scale(1.1);
        }

        .stepper-item.current .stepper-label {
            color: #4f46e5;
            font-weight: 600;
        }

        /* Failed/Cancelled/Rejected state */
        .stepper-item.failed .stepper-icon {
            background-color: #fee2e2;
            border-color: #ef4444;
            color: #ef4444;
        }

        .stepper-item.failed .stepper-label {
            color: #ef4444;
            font-weight: 600;
        }
    </style>
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
                if (validTransitions[currentStatus].includes(optionValue) || optionValue === currentStatus) {
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