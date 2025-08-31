@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-10 flex items-center justify-center p-3 sm:p-4 lg:p-6">
        <div class="w-full max-w-xl rounded-2xl bg-white p-8 shadow-2xl">
            <div class="mb-8 text-center">
                <h3 class="text-3xl font-bold text-indigo-900">Chỉnh Sửa Người Dùng</h3>
                <p class="mt-2 text-gray-500">Cập nhật thông tin chi tiết của người dùng.</p>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="name" class="mb-2 block text-sm font-medium text-indigo-900">Tên</label>
                    <input type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="mb-2 block text-sm font-medium text-indigo-900">Email</label>
                    <input type="email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6 flex flex-col gap-6 sm:flex-row">
                    <div class="w-full">
                        <label for="password" class="mb-2 block text-sm font-medium text-indigo-900">Mật khẩu (để trống nếu
                            không đổi)</label>
                        <div class="relative">
                            <input type="password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                id="password" name="password">
                            <button type="button" class="absolute inset-y-0 right-0 top-0 flex items-center pr-3"
                                onclick="togglePasswordVisibility('password', 'password-icon')">
                                <svg id="password-icon" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-indigo-900">Xác nhận
                            mật khẩu</label>
                        <div class="relative">
                            <input type="password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="password_confirmation" name="password_confirmation">
                            <button type="button" class="absolute inset-y-0 right-0 top-0 flex items-center pr-3"
                                onclick="togglePasswordVisibility('password_confirmation', 'confirm-password-icon')">
                                <svg id="confirm-password-icon" class="h-5 w-5 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="role" class="mb-2 block text-sm font-medium text-indigo-900">Vai trò</label>
                    <div class="relative">
                        <select
                            class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                            id="role" name="role" required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                    @error('role')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-8 flex flex-col justify-end gap-3 sm:flex-row">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full transform rounded-lg bg-gray-300 px-6 py-3 text-center text-sm font-semibold text-gray-800 shadow-md transition-all duration-300 hover:scale-105 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto">
                        Quay lại
                    </a>
                    <button type="submit"
                        class="w-full transform rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>

    </div>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.024 10.024 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7c1.764 0 3.42 0.514 4.875 1.488M12 9a3 3 0 110 6 3 3 0 010-6z" />';
            } else {
                input.type = 'password';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>
@endsection
