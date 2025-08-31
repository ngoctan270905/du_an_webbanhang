@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="bg-indigo-900 text-white p-6">
            <h3 class="text-3xl font-bold">Chi Tiết Danh Mục</h3>
        </div>
        <div class="p-8">
            <div class="mb-8">
                <h4 class="text-2xl font-semibold text-indigo-800 mb-4">Thông Tin Cơ Bản</h4>
                <div class="bg-gray-100 rounded-lg p-6 space-y-4">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 w-32">ID:</span>
                        <span class="text-gray-900 font-bold">{{ $category->id }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 w-32">Tên danh mục:</span>
                        <span class="text-gray-900">{{ $category->ten_danh_muc }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 w-32">Trạng thái:</span>
                        @if ($category->trang_thai)
                            <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">Hoạt động</span>
                        @else
                            <span class="bg-red-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">Không hoạt động</span>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 w-32">Ngày tạo:</span>
                        <span class="text-gray-900">{{ $category->created_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 w-32">Ngày cập nhật:</span>
                        <span class="text-gray-900">{{ $category->updated_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                </div>
            </div>

            <h4 class="text-2xl font-semibold text-indigo-800 mb-4">Sản Phẩm Trong Danh Mục</h4>
            @if($category->product->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="w-full min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tên SP</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Hình ảnh</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Giá</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Trạng thái</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($category->product as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-sm font-medium text-gray-900">{{ $product->id }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-500">{{ $product->ten_san_pham }}</td>
                                    <td class="px-3 py-2">
                                        @if ($product->hinh_anh)
                                            <img src="{{ asset('storage/' . $product->hinh_anh) }}" alt="{{ $product->ten_san_pham }}" class="h-10 w-10 object-cover rounded-lg">
                                        @else
                                            <span class="text-xs text-gray-400">Không ảnh</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-500">
                                        @if ($product->gia_khuyen_mai)
                                            <div class="flex flex-col">
                                                <span class="text-red-600 font-bold">{{ number_format($product->gia_khuyen_mai) }} đ</span>
                                                <span class="text-gray-400 line-through text-xs">{{ number_format($product->gia) }} đ</span>
                                            </div>
                                        @else
                                            <span>{{ number_format($product->gia) }} đ</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-500">
                                        @if ($product->so_luong > 0)
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Còn hàng</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Hết hàng</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.products.show', $product->id) }}"
                                                class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M2 12s5-8 10-8 10 8 10 8-5 8-10 8-10-8-10-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic mt-2">Chưa có sản phẩm nào trong danh mục này.</p>
            @endif

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>
@endsection