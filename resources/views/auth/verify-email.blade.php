<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="w-full max-w-xl p-10 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl space-y-8">

            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-gray-100">Xác Minh Email</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Cảm ơn bạn đã đăng ký! Vui lòng kiểm tra email của bạn để xác minh tài khoản.
                </p>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Nếu bạn không nhận được email, chúng tôi sẽ vui lòng gửi lại cho bạn.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 dark:bg-green-700 p-4 rounded-xl text-center text-green-700 dark:text-green-100 transition-all duration-300 transform scale-100 opacity-100">
                    <p class="font-bold">Một liên kết xác minh mới đã được gửi đến email của bạn.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="space-y-6">
                @csrf
                <button type="submit" class="w-full px-6 py-3 text-lg font-bold text-white rounded-full bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                    Gửi lại Email Xác minh
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>