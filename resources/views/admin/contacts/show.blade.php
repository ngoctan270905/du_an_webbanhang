@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl p-6 lg:p-8">
                <div class="mb-8 flex items-center justify-between">
                    <h3 class="text-3xl font-bold text-indigo-900">Chi tiết liên hệ</h3>
                   <a href="{{ route('admin.contacts.index') }}"
                        class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors">
                        Quay lại
                    </a>
                </div>

                <div class="space-y-8">
                    <!-- Contact Details Section -->
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">
                        <h4 class="text-xl font-bold text-indigo-900 mb-4">Thông tin khách hàng</h4>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Họ tên</h4>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $contact->ho_ten }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Số điện thoại</h4>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $contact->so_dien_thoai }}</p>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Nội dung</h4>
                                <div class="mt-2 rounded-lg bg-white p-4 text-gray-700 shadow-sm border border-gray-100">
                                    <p>{{ $contact->noi_dung }}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Ngày gửi</h4>
                                <p class="mt-1 text-sm text-gray-500">{{ $contact->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reply History Section -->
                    <div class="rounded-2xl bg-white p-6 shadow-md border border-gray-200">
                        <h4 class="mb-6 text-xl font-bold text-indigo-900">Lịch sử trả lời</h4>
                        {{-- <div class="space-y-6">
                            @forelse ($contact->replies as $reply)
                                <div class="flex flex-col items-end">
                                    <div class="bg-indigo-50 p-4 rounded-xl shadow-md max-w-lg">
                                        <p class="font-medium text-indigo-900">Admin</p>
                                        <p class="text-sm text-gray-700 mt-1">{{ $reply->content }}</p>
                                        <p class="text-xs text-gray-500 mt-2 text-right">{{ $reply->created_at->format('H:i:s d/m/Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl bg-gray-50 p-4 text-center text-sm text-gray-500 border border-gray-200">
                                    Chưa có trả lời nào.
                                </div>
                            @endforelse
                        </div> --}}
                    </div>

                    <!-- Reply Section -->
                    <div class="rounded-2xl bg-white p-6 shadow-md border border-gray-200">
                        <h4 class="mb-4 text-xl font-bold text-indigo-900">Gửi trả lời</h4>
                        <form action="" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="reply_content" class="block text-sm font-medium text-indigo-900">Nội dung trả lời</label>
                                <textarea name="reply_content" id="reply_content" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('reply_content') border-red-500 @enderror"
                                    placeholder="Nhập nội dung trả lời tại đây..." required>{{ old('reply_content') }}</textarea>
                                @error('reply_content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center space-x-2 rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -rotate-45" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22.0001 2.0001L3.0001 10.0001L10.0001 13.0001L13.0001 20.0001L22.0001 2.0001Z"></path>
                                    </svg>
                                    <span>Gửi trả lời</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
