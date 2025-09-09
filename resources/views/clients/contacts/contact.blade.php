@extends('layouts.master')

@section('title', 'Liên hệ')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-2xl font-bold mb-5 text-gray-800">Liên hệ với chúng tôi</div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-5 text-base" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form id="contactForm" action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="ho_ten" class="block text-base font-medium text-gray-700">Họ tên</label>
                <input type="text" id="ho_ten" name="ho_ten" value="{{ old('ho_ten', $ho_ten ?? '') }}"
                       class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base p-2 @error('ho_ten') border-red-500 @enderror">
                @error('ho_ten')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-base font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}"
                       class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base p-2 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="so_dien_thoai" class="block text-base font-medium text-gray-700">Số điện thoại</label>
                <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="{{ old('so_dien_thoai') }}"
                       class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base p-2 @error('so_dien_thoai') border-red-500 @enderror">
                @error('so_dien_thoai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="noi_dung" class="block text-base font-medium text-gray-700">Nội dung</label>
                <textarea id="noi_dung" name="noi_dung" rows="4"
                          class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base p-2 @error('noi_dung') border-red-500 @enderror"
                          >{{ old('noi_dung') }}</textarea>
                @error('noi_dung')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" id="submitButton"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="buttonText">Gửi liên hệ</span>
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 ml-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function() {
            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const loadingIcon = document.getElementById('loadingIcon');

            submitButton.disabled = true;
            buttonText.textContent = 'Đang gửi...';
            loadingIcon.classList.remove('hidden');
        });
    </script>
@endsection