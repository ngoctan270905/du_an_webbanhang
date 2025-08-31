@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-10 flex items-center justify-center p-3 sm:p-4 lg:p-6">
<div class="w-full max-w-xl rounded-xl bg-white p-8 shadow-2xl">
<div class="mb-8 text-center">
<h3 class="text-3xl font-bold text-indigo-900">Thêm Mới Banner</h3>
<p class="mt-2 text-gray-500">Điền thông tin chi tiết để thêm banner mới.</p>
</div>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="mb-6">
                <label for="tieu_de" class="mb-2 block text-sm font-medium text-indigo-900">Tiêu đề</label>
                <input type="text" id="tieu_de" name="tieu_de" value="{{ old('tieu_de') }}" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tieu_de') border-red-500 @enderror"
                    placeholder="Ví dụ: Giảm giá đặc biệt mùa hè">
                @error('tieu_de')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="hinh_anh" class="mb-2 block text-sm font-medium text-indigo-900">Hình ảnh</label>
                <label for="hinh_anh"
                    class="relative flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-300 px-4 py-3 text-gray-700 shadow-sm transition-colors duration-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span class="ml-2">Chọn tệp ảnh</span>
                    <input type="file" id="hinh_anh" name="hinh_anh" required
                        class="sr-only @error('hinh_anh') border-red-500 @enderror">
                </label>
                <p class="mt-1 text-xs text-gray-500">Chỉ chấp nhận file ảnh (jpeg, png, jpg, gif) và kích thước tối đa 2MB</p>
                @error('hinh_anh')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image preview -->
            <div id="image-preview" class="mb-6 hidden">
                <label class="mb-2 block text-sm font-medium text-indigo-900">Xem trước hình ảnh</label>
                <img id="preview-image-tag" src="" alt="Image Preview"
                    class="h-48 w-full rounded-lg border border-gray-200 object-cover shadow-sm">
            </div>

            <div class="mb-6">
                <label for="trang_thai" class="mb-2 block text-sm font-medium text-indigo-900">Trạng thái</label>
                <div class="relative">
                    <select id="trang_thai" name="trang_thai" required
                        class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('trang_thai') border-red-500 @enderror">
                        <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                @error('trang_thai')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex flex-col justify-end gap-3 pt-4 sm:flex-row">
                <a href="{{ route('admin.banners.index') }}"
                    class="w-full rounded-lg bg-gray-300 px-6 py-3 text-center font-semibold text-gray-800 transition-colors hover:bg-gray-400 sm:w-auto">
                    Quay lại
                </a>
                <button type="submit"
                    class="w-full rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-blue-700 sm:w-auto">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('hinh_anh').addEventListener('change', function() {
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image-tag');
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            previewImage.src = '';
        }
    });
</script>

@endsection