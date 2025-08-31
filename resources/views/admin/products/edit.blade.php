@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen py-12">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    {{-- Tiêu đề chính --}}
                    <h1 class="text-3xl font-bold text-indigo-900">Sửa sản phẩm</h1>
                    <p class="mt-1 text-sm text-gray-600">Cập nhật thông tin chi tiết cho sản phẩm.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.products.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Quay lại
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Lưu thay đổi
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-xl">
                        <h2 class="text-xl font-semibold text-indigo-900 mb-5">Thông tin cơ bản</h2>
                        <div class="space-y-6">
                            <div>
                                <label for="ten_san_pham" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                                <input type="text" name="ten_san_pham" id="ten_san_pham"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm
                                            bg-gray-50 text-gray-900 placeholder-gray-400
                                            focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                            sm:text-sm h-12 px-4 @error('ten_san_pham') border-red-500 @enderror"
                                    value="{{ old('ten_san_pham', $product->ten_san_pham) }}">
                                @error('ten_san_pham')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="mo_ta" class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
                                <textarea id="mo_ta" name="mo_ta" rows="8"
                                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm
                                                   bg-gray-50 text-gray-900 placeholder-gray-400
                                                   focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                                   sm:text-sm p-4 @error('mo_ta') border-red-500 @enderror">{{ old('mo_ta', $product->mo_ta) }}</textarea>
                                @error('mo_ta')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-xl">
                        <h2 class="text-xl font-semibold text-indigo-900 mb-5">Hình ảnh sản phẩm</h2>
                        
                        {{-- Thẻ img để hiển thị ảnh cũ và xem trước ảnh mới --}}
                        <img id="image-preview" src="{{ $product->hinh_anh ? asset('storage/' . $product->hinh_anh) : '' }}" 
                            class="{{ $product->hinh_anh ? '' : 'hidden' }} max-h-48 w-auto mx-auto mb-4 object-contain rounded-lg">
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg @error('hinh_anh') border-red-500 @enderror">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="hinh_anh" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                        <span>Tải ảnh lên</span>
                                        <input id="hinh_anh" name="hinh_anh" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">hoặc kéo và thả vào đây</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF lên đến 10MB</p>
                            </div>
                        </div>
                        @error('hinh_anh')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-xl">
                        <h2 class="text-xl font-semibold text-indigo-900 mb-5">Giá & Khuyến mãi</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gia" class="block text-sm font-medium text-gray-700">Giá bán (VNĐ)</label>
                                <div class="mt-1 relative rounded-lg shadow-sm">
                                    <input type="number" name="gia" id="gia"
                                        class="block w-full border-gray-300 rounded-lg
                                                bg-gray-50 text-gray-900 placeholder-gray-400
                                                focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                                sm:text-sm h-12 px-4 @error('gia') border-red-500 @enderror"
                                        value="{{ old('gia', $product->gia) }}">
                                </div>
                                @error('gia')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="gia_khuyen_mai" class="block text-sm font-medium text-gray-700">Giá khuyến mãi (VNĐ)</label>
                                <div class="mt-1 relative rounded-lg shadow-sm">
                                    <input type="number" name="gia_khuyen_mai" id="gia_khuyen_mai"
                                        class="block w-full border-gray-300 rounded-lg
                                                bg-gray-50 text-gray-900 placeholder-gray-400
                                                focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                                sm:text-sm h-12 px-4 @error('gia_khuyen_mai') border-red-500 @enderror"
                                        value="{{ old('gia_khuyen_mai', $product->gia_khuyen_mai) }}">
                                </div>
                                @error('gia_khuyen_mai')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-xl">
                        <h2 class="text-xl font-semibold text-indigo-900 mb-5">Định danh & Số lượng</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ma_san_pham" class="block text-sm font-medium text-gray-700">Mã sản phẩm (SKU)</label>
                                <input type="text" name="ma_san_pham" id="ma_san_pham"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm
                                            bg-gray-50 text-gray-900 placeholder-gray-400
                                            focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                            sm:text-sm h-12 px-4 @error('ma_san_pham') border-red-500 @enderror"
                                    value="{{ old('ma_san_pham', $product->ma_san_pham) }}">
                                @error('ma_san_pham')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="so_luong" class="block text-sm font-medium text-gray-700">Số lượng</label>
                                <input type="number" name="so_luong" id="so_luong"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm
                                            bg-gray-50 text-gray-900 placeholder-gray-400
                                            focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                            sm:text-sm h-12 px-4 @error('so_luong') border-red-500 @enderror"
                                    value="{{ old('so_luong', $product->so_luong) }}">
                                @error('so_luong')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="lg:col-span-1 space-y-8">
                    
                    <div class="bg-white p-6 rounded-xl shadow-xl">
                        <h2 class="text-xl font-semibold text-indigo-900 mb-5">Trạng thái</h2>
                        <select id="trang_thai" name="trang_thai"
                                class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm
                                        bg-gray-50 text-gray-900
                                        focus:outline-none focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                        sm:text-sm @error('trang_thai') border-red-500 @enderror">
                            <option value="1" {{ old('trang_thai', $product->trang_thai) == 1 ? 'selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ old('trang_thai', $product->trang_thai) == 0 ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                        @error('trang_thai')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-xl">
                        <h2 class="text-xl font-semibold text-indigo-900 mb-5">Phân loại</h2>
                        <div class="space-y-6">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục sản phẩm</label>
                                <select id="category_id" name="category_id"
                                        class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm
                                                bg-gray-50 text-gray-900
                                                focus:outline-none focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                                sm:text-sm @error('category_id') border-red-500 @enderror">
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
                            <div>
                                <label for="ngay_nhap" class="block text-sm font-medium text-gray-700">Ngày nhập</label>
                                <input type="date" name="ngay_nhap" id="ngay_nhap"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm
                                            bg-gray-50 text-gray-900
                                            focus:ring-teal-500 focus:border-teal-500 focus:bg-white
                                            sm:text-sm h-12 px-4 @error('ngay_nhap') border-red-500 @enderror"
                                    value="{{ old('ngay_nhap', $product->ngay_nhap) }}">
                                @error('ngay_nhap')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('hinh_anh');
        const imagePreview = document.getElementById('image-preview');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else if (!imagePreview.src || imagePreview.src.includes('data:image')) {
                // Ẩn preview nếu không có ảnh mới và ảnh cũ cũng không tồn tại
                imagePreview.classList.add('hidden');
                imagePreview.src = '#';
            }
        });
    });
</script>