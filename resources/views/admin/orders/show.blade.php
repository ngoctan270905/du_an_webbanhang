@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->ma_don_hang)

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold text-gray-800">Chi tiết đơn hàng: {{ $order->ma_don_hang }}</h2>
                <a href="{{ route('admin.orders.index') }}"
                    class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Quay lại
                </a>
            </div>

            {{-- Stepper Section --}}
            {{-- Stepper Section --}}
            <div class="mb-8 p-4 rounded-lg border border-gray-200 shadow-sm">
                @php
                    $statusMap = [
                        'pending' => ['label' => 'Chờ xác nhận', 'icon' => 'fa-solid fa-file-alt'],
                        'processing' => ['label' => 'Đang xử lý', 'icon' => 'fa-solid fa-cogs'], //fa-solid fa-box-open chờ giao hàng sẽ để sau
                        'shipped' => ['label' => 'Đang giao hàng', 'icon' => 'fa-solid fa-truck'],
                        'delivered' => ['label' => 'Giao thành công', 'icon' => 'fa-solid fa-circle-check'],
                    ];
                    $currentStatus = $order->trang_thai;
                    $isCancelled = $currentStatus === 'cancelled';
                    $completedSteps = $isCancelled
                        ? []
                        : array_keys(
                            array_slice($statusMap, 0, array_search($currentStatus, array_keys($statusMap)), true),
                        );
                @endphp

                @if ($isCancelled)
                    {{-- Canceled Status --}}
                    <div class="flex items-center justify-center">
                        <div class="stepper-item failed">
                            <div class="stepper-icon">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <span class="stepper-label text-red-600">Đã hủy</span>
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
                                    {{-- Hiển thị icon riêng cho từng trạng thái --}}
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

            {{-- Cấu trúc mới: Bên trái 3 khung, bên phải 2 khung --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                {{-- Cột trái: 3 khung, chiếm 2/5 chiều rộng --}}
                <div class="md:col-span-2 space-y-6">
                    {{-- Khung 1: Thông tin khách hàng --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Thông tin khách hàng</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tên khách hàng</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Số điện thoại</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ $order->user->so_dien_thoai ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Khung 2: Địa chỉ giao hàng --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Địa chỉ giao hàng</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Địa chỉ</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->dia_chi_giao_hang }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Khung 3: Ghi chú --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Ghi chú</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nội dung ghi chú</p>
                                <p class="mt-1 text-base text-gray-700">{{ $order->ghi_chu ?? 'Không có ghi chú.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cột phải: 2 khung, chiếm 3/5 chiều rộng --}}
                <div class="md:col-span-3 space-y-6">
                    {{-- Khung 1: Tổng quan thanh toán --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Tổng quan thanh toán</h3>
                        <div class="grid grid-cols-2 gap-y-4">
                            {{-- Hàng 1 --}}
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Ngày đặt</span>
                                <span
                                    class="font-semibold text-gray-900 mt-1">{{ $order->ngay_dat_hang->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Trạng thái thanh toán</span>
                                @if ($order->payment)
                                    @php
                                        $paymentStatusClass = '';
                                        $paymentStatusText = '';
                                        switch ($order->payment->trang_thai) {
                                            case 'pending':
                                                $paymentStatusClass = 'text-yellow-800';
                                                $paymentStatusText = 'Chưa thanh toán';
                                                break;
                                            case 'completed':
                                                $paymentStatusClass = 'text-green-800';
                                                $paymentStatusText = 'Đã thanh toán';
                                                break;
                                            case 'failed':
                                                $paymentStatusClass = 'text-red-800';
                                                $paymentStatusText = 'Thất bại';
                                                break;
                                            default:
                                                $paymentStatusClass = 'text-gray-800';
                                                $paymentStatusText = 'Không rõ';
                                                break;
                                        }
                                    @endphp
                                    <span class="rounded-full font-semibold {{ $paymentStatusClass }} mt-1 inline-block">
                                        {{ $paymentStatusText }}
                                    </span>
                                @else
                                    <span
                                        class="rounded-full px-2 py-1 text-sm font-semibold bg-gray-100 text-gray-800 mt-1 inline-block">
                                        Không có thông tin
                                    </span>
                                @endif
                            </div>

                            {{-- Hàng 2 --}}
                            <div class="flex flex-col mt-4">
                                <span class="text-sm text-gray-500">Phương thức</span>
                                <span class="font-semibold text-gray-900 mt-1">
                                    @if ($order->phuong_thuc_thanh_toan == 'cod')
                                        COD
                                    @elseif ($order->phuong_thuc_thanh_toan == 'bank_transfer')
                                        Chuyển khoản
                                    @elseif ($order->phuong_thuc_thanh_toan == 'online_payment')
                                        Thanh toán Online
                                    @endif
                                </span>
                            </div>
                            <div class="flex flex-col mt-4">
                                <span class="text-sm text-gray-500">Shipper</span>
                                <span
                                    class="font-semibold text-gray-900 mt-1">{{ $order->shipper->name ?? 'Chưa gán' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Khung 2: Sản phẩm trong đơn --}}
                    <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h3 class="mb-4 text-xl font-semibold text-gray-800">Sản phẩm trong đơn</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Sản phẩm</th>
                                        {{-- Loại bỏ cột SKU --}}
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Số lượng</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Đơn giá</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($order->orderDetails as $detail)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded object-cover"
                                                            src="{{ Storage::url($detail->product->hinh_anh) }}"
                                                            alt="{{ $detail->product->ten_san_pham }}">
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $detail->product->ten_san_pham }}</div>
                                                        <div class="text-xs text-gray-500 mt-1">SKU:
                                                            {{ $detail->product->ma_san_pham }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                                                {{ $detail->so_luong }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-500">
                                                {{ number_format($detail->gia, 0, ',', '.') }}đ</td>
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                                {{ number_format($detail->gia * $detail->so_luong, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.orders.index') }}"
                    class="rounded-lg bg-gray-200 border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Đóng
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Horizontal Stepper for Order History */
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

        /* Failed/Cancelled state */
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
