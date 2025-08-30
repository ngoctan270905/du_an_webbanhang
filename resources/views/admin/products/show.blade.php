@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-3 sm:p-4 lg:p-6">
    <div class="space-y-4">
        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Thông tin chi tiết sản phẩm</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Image Section -->
                <div class="md:col-span-1">
                    <img src="{{ $product->hinh_anh ? asset('storage/' . $product->hinh_anh) : asset('images/no-image.png') }}"
                         alt="{{ $product->ten_san_pham }}"
                         class="w-full h-48 object-cover rounded-lg shadow-sm">
                </div>

                <!-- Details Section -->
                <div class="md:col-span-2">
                    <div class="space-y-3">
                        <h4 class="text-lg font-medium text-gray-900">{{ $product->ten_san_pham }}</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Mã sản phẩm:</span>
                                <span class="text-sm text-gray-800">{{ $product->ma_san_pham }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Danh mục:</span>
                                <span class="text-sm text-gray-800">{{ $product->category->ten_danh_muc }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Giá:</span>
                                <span class="text-sm text-gray-800">{{ number_format($product->gia, 0, ',', '.') }} VND</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Giá khuyến mãi:</span>
                                <span class="text-sm text-gray-800">
                                    {{ $product->gia_khuyen_mai ? number_format($product->gia_khuyen_mai, 0, ',', '.') . ' VND' : 'Không có' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Số lượng:</span>
                                <span class="text-sm text-gray-800">{{ $product->so_luong }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Ngày nhập:</span>
                                <span class="text-sm text-gray-800">{{ date('d/m/Y', strtotime($product->ngay_nhap)) }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Trạng thái:</span>
                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $product->trang_thai ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->trang_thai ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Mô tả:</span>
                            <p class="text-sm text-gray-800">{{ $product->mo_ta ?? 'Không có mô tả' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-2 mt-4">
                <a href="{{ route('admin.products.edit', $product->id) }}"
                   class="rounded-lg bg-yellow-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Chỉnh sửa
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</div>
@endsection