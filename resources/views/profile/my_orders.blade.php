@extends('layouts.profile_user')

@section('title', 'Thông tin cá nhân')

@section('main-content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div class="text-2xl font-bold">Đơn hàng của tôi</div>
        </div>

        <div class="flex justify-between items-center mb-6 text-sm text-gray-500">
            <div id="order-tabs" class="flex w-full space-x-2">
                {{-- Dùng route() để tạo URL với tham số trạng thái --}}
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
                        {{-- Trạng thái giao hàng --}}
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
                                            (x{{ $detail->so_luong }})
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
                            @if ($order->trang_thai == 'delivered')
                                <button
                                    class="px-4 py-2 text-sm font-semibold rounded-lg text-red-500 border border-red-500 hover:bg-red-50">
                                    Mua lại
                                </button>
                            @endif
                            <button
                                class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-red-500 hover:bg-red-600">
                                Xem chi tiết
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-12">
                    <div class="flex flex-col items-center justify-center">
                        {{-- Icon Font Awesome --}}
                        <i class="fa-solid fa-box-open text-gray-400 mb-4" style="font-size: 5rem;"></i>

                        <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Không có đơn hàng nào trong
                            trạng thái này</span>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="flex justify-end">
            {{-- Đảm bảo phân trang giữ lại tham số trạng thái --}}
            {{ $orders->appends(['trang_thai' => $selected_status])->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    {{-- Xóa toàn bộ đoạn JavaScript không cần thiết --}}
@endsection
