@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="space-y-6">
        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800">Chi tiết đánh giá</h3>
                <a href="{{ url()->previous() }}"
                    class="rounded-lg bg-gray-500 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>

            @if (session('success'))
                <div class="relative mb-4 rounded-lg bg-green-100 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 p-5">
                    <h4 class="mb-4 text-lg font-semibold text-gray-700">Thông tin chung</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <label class="w-1/3 font-semibold text-gray-600">ID:</label>
                            <p class="w-2/3 text-gray-800">{{ $review->id }}</p>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 font-semibold text-gray-600">Khách hàng:</label>
                            <p class="w-2/3 text-gray-800">{{ $review->user->name }}</p>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 font-semibold text-gray-600">Sản phẩm:</label>
                            <p class="w-2/3 text-gray-800">{{ $review->product->ten_san_pham }}</p>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 font-semibold text-gray-600">Ngày đánh giá:</label>
                            <p class="w-2/3 text-gray-800">{{ $review->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 p-5">
                    <h4 class="mb-4 text-lg font-semibold text-gray-700">Nội dung đánh giá</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1 font-semibold text-gray-600">Đánh giá (sao):</label>
                            <div class="flex items-center text-xl text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.696h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.721c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.696l1.07-3.292z" />
                                    </svg>
                                @endfor
                                <span class="ml-2 text-base font-semibold text-gray-700">({{ $review->rating }}/5)</span>
                            </div>
                        </div>
                        <div>
                            <label class="mb-1 font-semibold text-gray-600">Nội dung:</label>
                            <p class="rounded-md bg-gray-50 p-3 text-sm italic text-gray-700">{{ $review->noi_dung }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
            <h3 class="mb-4 text-2xl font-bold text-gray-800">Phản hồi của bạn</h3>

            @if (session('reply_success'))
                <div class="relative mb-4 rounded-lg bg-green-100 p-3 text-sm text-green-700">
                    {{ session('reply_success') }}
                </div>
            @endif

            @if ($review->admin_reply)
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm font-semibold text-blue-600">Quản trị viên đã trả lời:</p>
                    <p class="mt-1 text-gray-700">{{ $review->admin_reply }}</p>
                    <p class="mt-2 text-xs text-gray-500">
                        Ngày trả lời: {{ $review->reply_at->format('d/m/Y H:i:s') }}
                    </p>
                    <form action="" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-md bg-red-500 px-3 py-1.5 text-xs font-medium text-white transition-colors duration-200 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa phản hồi này?')">
                            Xóa phản hồi
                        </button>
                    </form>
                </div>
            @else
                <form action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="admin_reply" class="mb-2 block font-semibold text-gray-700">Nội dung phản hồi:</label>
                        <textarea id="admin_reply" name="admin_reply" rows="4"
                            class="w-full rounded-lg border border-gray-300 p-3 text-gray-700 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nhập nội dung phản hồi tại đây...">{{ old('admin_reply') }}</textarea>
                        @error('admin_reply')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Gửi phản hồi
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection