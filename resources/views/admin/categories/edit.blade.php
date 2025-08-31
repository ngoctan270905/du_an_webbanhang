@extends('layouts.admin')

@section('content')
<div class="container flex items-center justify-center mt-10 mx-auto p-3 sm:p-4 lg:p-6">
    <div class="max-w-xl w-full bg-white p-8 rounded-xl shadow-2xl">
        <div class="mb-8 text-center">
            <h3 class="text-3xl font-bold text-indigo-900">Chỉnh Sửa Danh Mục</h3>
            <p class="text-gray-500 mt-2">Cập nhật thông tin chi tiết cho danh mục.</p>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="ten_danh_muc" class="block text-indigo-900 text-sm font-medium mb-2">Tên Danh Mục</label>
                <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ten_danh_muc') border-red-500 @enderror"
                    id="ten_danh_muc" name="ten_danh_muc"
                    value="{{ old('ten_danh_muc', $category->ten_danh_muc) }}"
                    placeholder="Ví dụ: Thời trang nam">
                @error('ten_danh_muc')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="trang_thai" class="block text-indigo-900 text-sm font-medium mb-2">Trạng Thái</label>
                <div class="relative">
                    <select
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none @error('trang_thai') border-red-500 @enderror"
                        id="trang_thai" name="trang_thai" required>
                        <option value="1" {{ old('trang_thai', $category->trang_thai) == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('trang_thai', $category->trang_thai) == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                @error('trang_thai')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8">
                <a href="{{ route('admin.categories.index') }}"
                    class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors">
                    Quay lại
                </a>
                <button type="submit"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection