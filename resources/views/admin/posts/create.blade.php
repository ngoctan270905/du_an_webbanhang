@extends('layouts.admin')

@section('content')
    <div class="container mx-auto flex items-center justify-center py-8">
        <div class="w-full max-w-xl rounded-xl bg-white p-6 shadow-2xl transition-all duration-300 hover:shadow-3xl sm:p-8">
            <div class="mb-8 text-center">
                <h3 class="text-3xl font-bold text-indigo-900">Thêm mới bài viết</h3>
                <p class="mt-2 text-gray-500">Điền thông tin chi tiết để thêm bài viết mới.</p>
            </div>

            @if (session('error'))
                <div class="relative mb-6 rounded-lg bg-red-100 p-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="tieu_de" class="mb-1 block text-sm font-medium text-indigo-900">Tiêu đề</label>
                    <input type="text" id="tieu_de" name="tieu_de" value="{{ old('tieu_de') }}" required
                        class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-sm transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-inner @error('tieu_de') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Ví dụ: Lợi ích của lập trình">
                    @error('tieu_de')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="noi_dung" class="mb-1 block text-sm font-medium text-indigo-900">Nội dung</label>
                    <textarea id="noi_dung" name="noi_dung" rows="6"
                        class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-sm transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-inner @error('noi_dung') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Nhập nội dung bài viết...">{!! old('noi_dung') !!}</textarea>
                    @error('noi_dung')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hinh_anh" class="mb-1 block text-sm font-medium text-indigo-900">Hình ảnh</label>
                    <input type="file" id="hinh_anh" name="hinh_anh"
                        class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 shadow-inner transition-colors duration-200 focus:outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 @error('hinh_anh') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('hinh_anh')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <div id="image-preview-container" class="mt-4 hidden overflow-hidden rounded-lg border border-dashed border-gray-300 bg-gray-100 p-2 text-center transition-all duration-300">
                        <img id="image-preview" src="#" alt="Image Preview" class="mx-auto block h-48 w-full rounded-lg object-contain" style="display: none;">
                        <p id="placeholder-text" class="text-gray-400">Xem trước hình ảnh</p>
                    </div>
                </div>

                <div>
                    <label for="trang_thai" class="mb-1 block text-sm font-medium text-indigo-900">Trạng thái</label>
                    <select id="trang_thai" name="trang_thai" required
                        class="w-full appearance-none rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-sm transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 shadow-inner @error('trang_thai') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="1" {{ old('trang_thai', 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('trang_thai') == 0 ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @error('trang_thai')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse items-center justify-end space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                    <a href="{{ route('admin.posts.index') }}"
                        class="w-full rounded-lg bg-gray-300 px-6 py-2.5 text-center text-sm font-semibold text-gray-800 transition-colors duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto">
                        Quay lại
                    </a>
                    <button type="submit"
                        class="w-full rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                        Thêm mới
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('hinh_anh');
            const imagePreview = document.getElementById('image-preview');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const placeholderText = document.getElementById('placeholder-text');

            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        placeholderText.style.display = 'none';
                        imagePreviewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    placeholderText.style.display = 'block';
                    imagePreviewContainer.style.display = 'none';
                }
            });
        });
    </script>
@endsection
