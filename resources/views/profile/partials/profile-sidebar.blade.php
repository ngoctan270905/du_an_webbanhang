<aside class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
    <div class="flex flex-col items-center mb-6">
        <div class="relative">
            <div
                class="w-16 h-16 rounded-full border-4 border-indigo-500 dark:border-indigo-400 bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-4xl font-bold text-indigo-600 dark:text-indigo-300">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>
        <div class="mt-4 text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
    </div>

    <nav class="space-y-1">
        <a href="{{ route('my-orders.index') }}"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->routeIs('my-orders.index') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-shopping-bag mr-3 text-indigo-500"></i> Đơn hàng của tôi
            </a>
        <a href="#"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('danh-sach-yeu-thich') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-heart mr-3 text-indigo-500"></i> Danh sách yêu thích
            </a>
        <a href="account-payment.html"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('account-payment.html') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-credit-card mr-3 text-indigo-500"></i> Phương thức thanh toán
            </a>
        <a href="#"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('danh-gia') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-star mr-3 text-indigo-500"></i> Đánh giá của tôi
            </a>
        <a href="#"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('lich-su-diem-thuong') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-star mr-3 text-indigo-500"></i> Lịch sử điểm thưởng
            </a>

        <a href="{{ route('profile.edit') }}"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-user mr-3 text-indigo-500"></i> Thông tin cá nhân
            </a>
        <a href="#"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('dia-chi-cua-toi') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-map-pin mr-3 text-indigo-500"></i> Địa chỉ của tôi
            </a>
        <a href="account-notifications.html"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('account-notifications.html') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-bell mr-3 text-indigo-500"></i> Thông báo
            </a>

        <a href="help-topics-v1.html"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('help-topics-v1.html') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-help-circle mr-3 text-indigo-500"></i> Trung tâm trợ giúp
            </a>
        <a href="terms-and-conditions.html"
            class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded-lg transition {{ request()->is('terms-and-conditions.html') ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
            <i class="ci-info mr-3 text-indigo-500"></i> Điều khoản và điều kiện
            </a>

        <a href="#"
            class="flex items-center px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 rounded-lg transition"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="ci-log-out mr-3"></i> Đăng xuất
            </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
            </form>
    </nav>
</aside>
