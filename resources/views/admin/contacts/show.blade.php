@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl p-6 lg:p-8">
                <!-- Thông báo thành công -->
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

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
                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Email</h4>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $contact->email }}</p>
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
                        <div class="space-y-6">
                            @forelse ($contact->replies as $reply)
                                <div class="flex flex-col items-end">
                                    <div class="bg-indigo-50 p-4 rounded-xl shadow-md max-w-lg w-full">
                                        <p class="font-medium text-indigo-900">
                                            {{ $reply->user && $reply->user->role === 'admin' ? 'Admin' : $reply->user->name ?? 'Người dùng' }}
                                        </p>
                                        <p class="text-sm text-gray-700 mt-1">
                                            {{ $reply->content }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-2 text-right">
                                            {{ $reply->created_at->format('H:i:s d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl bg-gray-50 p-4 text-center text-sm text-gray-500 border border-gray-200">
                                    Chưa có trả lời nào.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Reply Section -->
                    @if ($contact->replies->isEmpty())
                        <div class="rounded-2xl bg-white p-6 shadow-md border border-gray-200">
                            <h4 class="mb-4 text-xl font-bold text-indigo-900">Gửi trả lời</h4>
                            <form id="replyForm" action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST" class="space-y-4">
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
                                    <button type="submit" id="submitReplyButton"
                                        class="inline-flex items-center space-x-2 rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span id="buttonText">Gửi trả lời</span>
                                        <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript để xử lý hiệu ứng loading -->
    <script>
        document.getElementById('replyForm').addEventListener('submit', function () {
            const submitButton = document.getElementById('submitReplyButton');
            const buttonText = document.getElementById('buttonText');
            const loadingIcon = document.getElementById('loadingIcon');

            submitButton.disabled = true;
            buttonText.textContent = 'Đang gửi...';
            loadingIcon.classList.remove('hidden');
        });
    </script>
@endsection