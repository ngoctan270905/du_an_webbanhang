@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto rounded-xl bg-white p-6 shadow-2xl sm:p-8">
            <div class="mb-6 text-center">
                <h1 class="text-4xl font-extrabold text-indigo-900">{{ $post->tieu_de }}</h1>
                <p class="mt-2 text-sm text-gray-500">Được tạo: {{ $post->created_at->format('d/m/Y H:i:s') }} | Cập nhật: {{ $post->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>

            <div class="relative w-full overflow-hidden rounded-lg mb-8 shadow-md">
                <img src="{{ asset('storage/' . $post->hinh_anh) }}" alt="{{ $post->tieu_de }}" class="w-full h-80 object-cover">
            </div>

            <div class="space-y-6">
                <!-- Nội dung bài viết -->
                <div class="prose max-w-none rounded-lg border border-gray-300 bg-gray-50 p-6 shadow-inner text-gray-800">
                    <h2 class="text-xl font-bold text-indigo-900 mb-4">Nội dung</h2>
                    {!! $post->noi_dung !!}
                </div>

                <!-- Chi tiết khác -->
                <div class="rounded-lg bg-gray-50 p-6 shadow-inner border border-gray-300">
                    <h2 class="text-xl font-bold text-indigo-900 mb-4">Chi tiết</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-indigo-900">ID:</p>
                            <p class="text-base text-gray-700 font-semibold">{{ $post->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-indigo-900">Trạng thái:</p>
                            @if($post->trang_thai)
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                    Hoạt động
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                    Không hoạt động
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse items-center justify-end space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                <a href="{{ route('admin.posts.index') }}"
                    class="w-full rounded-lg bg-gray-300 px-6 py-2.5 text-center text-sm font-semibold text-gray-800 transition-colors duration-200 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto">
                    Quay lại
                </a>
                <a href="{{ route('admin.posts.edit', $post->id) }}"
                    class="w-full rounded-lg bg-blue-600 px-6 py-2.5 text-center text-sm font-semibold text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                    Chỉnh sửa
                </a>
            </div>
        </div>
    </div>
@endsection
