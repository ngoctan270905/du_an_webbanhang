@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-3 sm:p-4 lg:p-6">
    <div class="space-y-4">
        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Sửa sản phẩm</h3>
            </div>

            <div class="space-y-4">
                @if ($errors->any())
                    <div class="relative rounded-lg bg-red-100 p-3 text-sm text-red-700">
                        <ul class="mb-0 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Danh mục -->
                        <div class="mb-3">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
                            <select name="category_id" class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->ten_danh_muc }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mã sản phẩm -->
                        <div class="mb-3">
                            <label for="ma_san_pham" class="block text-sm font-medium text-gray-700">Mã sản phẩm</label>
                            <input type="text" name="ma_san_pham" id="ma_san_pham"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('ma_san_pham') border-red-500 @enderror"
                                   value="{{ old('ma_san_pham', $product->ma_san_pham) }}">
                            @error('ma_san_pham')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tên sản phẩm -->
                        <div class="mb-3">
                            <label for="ten_san_pham" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                            <input type="text" name="ten_san_pham"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('ten_san_pham') border-red-500 @enderror"
                                   value="{{ old('ten_san_pham', $product->ten_san_pham) }}">
                            @error('ten_san_pham')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hình ảnh -->
                        <div class="mb-3">
                            <label for="hinh_anh" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                            <input type="file" name="hinh_anh"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('hinh_anh') border-red-500 @enderror">
                            @error('hinh_anh')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            @if ($product->hinh_anh)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $product->hinh_anh) }}" class="h-10 w-10 rounded-full object-cover">
                                </div>
                            @endif
                        </div>

                        <!-- Giá -->
                        <div class="mb-3">
                            <label for="gia" class="block text-sm font-medium text-gray-700">Giá (VND)</label>
                            <input type="number" name="gia"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('gia') border-red-500 @enderror"
                                   value="{{ old('gia', $product->gia) }}">
                            @error('gia')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Giá khuyến mãi -->
                        <div class="mb-3">
                            <label for="gia_khuyen_mai" class="block text-sm font-medium text-gray-700">Giá khuyến mãi (VND)</label>
                            <input type="number" name="gia_khuyen_mai"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('gia_khuyen_mai') border-red-500 @enderror"
                                   value="{{ old('gia_khuyen_mai', $product->gia_khuyen_mai) }}">
                            @error('gia_khuyen_mai')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Số lượng -->
                        <div class="mb-3">
                            <label for="so_luong" class="block text-sm font-medium text-gray-700">Số lượng</label>
                            <input type="number" name="so_luong"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('so_luong') border-red-500 @enderror"
                                   value="{{ old('so_luong', $product->so_luong) }}">
                            @error('so_luong')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ngày nhập -->
                        <div class="mb-3">
                            <label for="ngay_nhap" class="block text-sm font-medium text-gray-700">Ngày nhập</label>
                            <input type="date" name="ngay_nhap"
                                   class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('ngay_nhap') border-red-500 @enderror"
                                   value="{{ old('ngay_nhap', $product->ngay_nhap) }}">
                            @error('ngay_nhap')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-3 md:col-span-2">
                            <label for="mo_ta" class="block text-sm font-medium text-gray-700">Mô tả</label>
                            <textarea name="mo_ta"
                                      class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('mo_ta') border-red-500 @enderror"
                                      rows="4">{{ old('mo_ta', $product->mo_ta) }}</textarea>
                            @error('mo_ta')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-3">
                            <label for="trang_thai" class="block text-sm font-medium text-gray-700">Trạng thái</label>
                            <select name="trang_thai"
                                    class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('trang_thai') border-red-500 @enderror">
                                <option value="1" {{ old('trang_thai', $product->trang_thai) == 1 ? 'selected' : '' }}>Còn hàng</option>
                                <option value="0" {{ old('trang_thai', $product->trang_thai) == 0 ? 'selected' : '' }}>Hết hàng</option>
                            </select>
                            @error('trang_thai')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="flex items-center space-x-2 mt-4">
                        <button type="submit"
                                class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                           class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection