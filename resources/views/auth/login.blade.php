<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="w-full max-w-xl p-10 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl space-y-8">

            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-gray-100">Đăng Nhập</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Chào mừng bạn đã trở lại</p>
            </div>

            <x-auth-session-status class="mb-4 text-center text-green-500" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" value="Email" class="sr-only" />
                    <x-text-input 
                        id="email" 
                        class="block w-full px-5 py-3 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        autofocus 
                        autocomplete="username" 
                        placeholder="Địa chỉ Email"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Mật khẩu" class="sr-only" />
                    <div class="relative">
                        <x-text-input 
                            id="password" 
                            class="block w-full px-5 py-3 pr-12 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Mật khẩu"
                        />
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 dark:text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.575 3.01 9.963 7.182.023.097.023.203 0 .3C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.575-3.01-9.963-7.182z" />
                                <path id="eyeClosed" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path id="eyeSlashed" stroke-linecap="round" stroke-linejoin="round" class="hidden" d="M3.98 8.44A12.015 12.015 0 0112 5.25c4.544 0 8.481 2.923 9.92 6.84a1.012 1.012 0 010 .639C20.51 16.49 16.573 19.5 12 19.5a12.015 12.015 0 01-8.02-3.19z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                
                <div class="flex items-center justify-between text-base">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="w-5 h-5 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-gray-600 dark:text-gray-400">Ghi nhớ</span>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 transition-colors duration-200" href="{{ route('password.request') }}">
                            Quên mật khẩu?
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-between space-x-4">
                     <a href="{{ route('home') }}" class="w-full text-center px-6 py-3 text-lg font-bold text-gray-800 dark:text-gray-200 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-transform duration-300 ease-in-out transform hover:scale-105">
                        Hủy bỏ
                    </a>
                    <button type="submit" class="w-full px-6 py-3 text-lg font-bold text-white rounded-full bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                        Đăng nhập
                    </button>
                   
                </div>
            </form>

            @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 transition-colors duration-200">
                        Đăng ký ngay
                    </a>
                </p>
            </div>
            @endif
        </div>
    </div>
    
    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeOpen = toggleButton.querySelector('#eyeOpen');
        const eyeClosed = toggleButton.querySelector('#eyeClosed');
        const eyeSlashed = toggleButton.querySelector('#eyeSlashed');
        
        // Cập nhật trạng thái icon ban đầu
        if (passwordInput.getAttribute('type') === 'password') {
            eyeOpen.classList.remove('hidden');
            eyeSlashed.classList.add('hidden');
        } else {
            eyeOpen.classList.add('hidden');
            eyeSlashed.classList.remove('hidden');
        }

        toggleButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                eyeOpen.classList.remove('hidden');
                eyeSlashed.classList.add('hidden');
            } else {
                eyeOpen.classList.add('hidden');
                eyeSlashed.classList.remove('hidden');
            }
        });
    </script>
</x-guest-layout>