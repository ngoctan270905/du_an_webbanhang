@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Thông tin chi tiết sản phẩm</h3>
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Quay lại
                </a>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/3 flex-shrink-0">
                    <img src="{{ $product->hinh_anh ? asset('storage/' . $product->hinh_anh) : asset('images/no-image.png') }}"
                        alt="{{ $product->ten_san_pham }}"
                        class="w-full h-full object-cover rounded-xl shadow-lg border border-gray-200">
                </div>

                <div class="flex-grow space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="text-3xl font-extrabold text-gray-900">{{ $product->ten_san_pham }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Mã sản phẩm: <span
                                class="font-semibold text-gray-700">{{ $product->ma_san_pham }}</span></p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Danh mục:</span>
                            <p class="text-base text-gray-800 font-semibold">
                                {{ $product->category->ten_danh_muc ?? 'Không rõ' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Giá:</span>
                            <p class="text-lg font-bold text-red-600">
                                {{ number_format($product->gia, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Giá khuyến mãi:</span>
                            <p class="text-lg font-bold text-green-600">
                                {{ $product->gia_khuyen_mai ? number_format($product->gia_khuyen_mai, 0, ',', '.') . ' VNĐ' : 'Không có' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Số lượng:</span>
                            <p class="text-lg text-gray-800">{{ $product->so_luong }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Tác giả:</span>
                            <p class="text-base text-gray-800">{{ $product->author ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Nhà xuất bản:</span>
                            <p class="text-base text-gray-800">{{ $product->publisher ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Năm xuất bản:</span>
                            <p class="text-base text-gray-800">{{ $product->published_year ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Ngày nhập:</span>
                            <p class="text-base text-gray-800">{{ date('d/m/Y', strtotime($product->ngay_nhap)) }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Trạng thái:</span>
                            <span
                                class="inline-flex rounded-full px-2 py-1 text-xs font-semibold
                                {{ $product->trang_thai ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->trang_thai ? 'Còn hàng' : 'Hết hàng' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">
                <h5 class="text-xl font-bold text-gray-800 mb-2">Mô tả sản phẩm</h5>
                <div class="text-gray-700 leading-relaxed prose max-w-none">
                    <p>{{ $product->mo_ta ?? 'Không có mô tả chi tiết cho sản phẩm này.' }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 mt-8 border-t border-gray-200 pt-6">
                <a href="{{ route('admin.products.edit', $product->id) }}"
                    class="inline-flex items-center rounded-lg bg-yellow-500 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    Chỉnh sửa
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Quay lại
                </a>
            </div>
        </div>

    </div>
@endsection