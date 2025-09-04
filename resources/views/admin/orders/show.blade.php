@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->ma_don_hang)

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="space-y-4">
            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Chi tiết đơn hàng #{{ $order->ma_don_hang }}</h3>
                    <a href="{{ route('admin.orders.index') }}"
                       class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Quay lại danh sách
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p><strong>Mã đơn hàng:</strong> {{ $order->ma_don_hang }}</p>
                            <p><strong>Khách hàng:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->user->so_dien_thoai ?? 'Chưa cập nhật' }}</p>
                            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->dia_chi_giao_hang }}</p>
                        </div>
                        <div>
                            <p><strong>Tổng tiền:</strong> {{ number_format($order->tong_tien, 0, ',', '.') }}đ</p>
                            <p><strong>Phương thức thanh toán:</strong> 
                                {{ $order->phuong_thuc_thanh_toan == 'cod' ? 'COD' : ($order->phuong_thuc_thanh_toan == 'bank_transfer' ? 'Chuyển khoản' : 'Online') }}
                            </p>
                            <p><strong>Trạng thái:</strong> 
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                    {{ $order->trang_thai == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->trang_thai == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->trang_thai == 'shipped' ? 'bg-green-100 text-green-800' : 
                                       ($order->trang_thai == 'delivered' ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800'))) }}">
                                    {{ $order->trang_thai == 'pending' ? 'Chờ xử lý' : 
                                       ($order->trang_thai == 'processing' ? 'Đang xử lý' : 
                                       ($order->trang_thai == 'shipped' ? 'Đang giao' : 
                                       ($order->trang_thai == 'delivered' ? 'Đã giao' : 'Đã hủy'))) }}
                                </span>
                            </p>
                            <p><strong>Ngày đặt hàng:</strong> {{ $order->ngay_dat_hang->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="w-full min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Sản phẩm</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Số lượng</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Giá</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tổng</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($order->orderDetails as $detail)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <img src="{{ Storage::url($detail->product->hinh_anh) }}" alt="{{ $detail->product->ten_san_pham }}"
                                                     class="w-12 h-12 object-cover rounded">
                                                <span class="ml-4">{{ $detail->product->ten_san_pham }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $detail->so_luong }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ number_format($detail->gia, 0, ',', '.') }}đ</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ number_format($detail->gia * $detail->so_luong, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($order->payment)
                        <div class="rounded-lg border border-gray-200 p-3">
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Thông tin thanh toán</h4>
                            <p><strong>Phương thức:</strong> 
                                {{ $order->payment->phuong_thuc_thanh_toan == 'cod' ? 'COD' : 
                                   ($order->payment->phuong_thuc_thanh_toan == 'bank_transfer' ? 'Chuyển khoản' : 'Online') }}
                            </p>
                            <p><strong>Số tiền:</strong> {{ number_format($order->payment->so_tien, 0, ',', '.') }}đ</p>
                            <p><strong>Trạng thái:</strong> 
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                    {{ $order->payment->trang_thai == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->payment->trang_thai == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $order->payment->trang_thai == 'pending' ? 'Chờ thanh toán' : 
                                       ($order->payment->trang_thai == 'completed' ? 'Đã thanh toán' : 'Thất bại') }}
                                </span>
                            </p>
                            <p><strong>Mã giao dịch:</strong> {{ $order->payment->ma_giao_dich ?? 'N/A' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection