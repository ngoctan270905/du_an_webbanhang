<style>
    .sidebar {
        transition: transform 0.3s ease;
        width: 230px;
    }

    .sidebar-item:hover {
        background: linear-gradient(to right, #6b7280, #9ca3af);
        color: white;
    }

    .sidebar-item:hover svg {
        color: white;
    }

    .logo {
        font-family: 'Arial', sans-serif;
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(45deg, #ffffff, #d1d5db);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 10px rgba(255, 255, 255, 0.5);
        letter-spacing: 2px;
        position: relative;
        display: inline-block;
        transition: transform 0.3s ease, text-shadow 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
        text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.4), 0 0 15px rgba(255, 255, 255, 0.7);
    }

    .logo::before {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, #6b7280, #ffffff);
        transition: transform 0.3s ease;
    }

    .logo:hover::before {
        transform: scaleX(1.2);
    }

    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* CSS để ẩn thanh cuộn */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<aside id="sidebar" class="sidebar bg-gradient-to-b from-gray-700 to-gray-900 text-white shadow-2xl flex flex-col p-4 fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0">
    <div class="logo-container mb-6 relative">
        <h1 class="logo">RyoPhone</h1>
        <button id="close-sidebar" class="md:hidden absolute top-0 right-0 text-white hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <nav class="flex-1 overflow-y-auto hide-scrollbar">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.products.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14 10a2 2 0 012 2v2a2 2 0 01-2 2h-4a2 2 0 01-2-2v-2a2 2 0 012-2h4z"></path>
                    </svg>
                    <span>Quản lý sản phẩm</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
                    </svg>
                    <span>Quản lý danh mục</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index')}}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V6a2 2 0 00-2-2H4zm10 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V6a2 2 0 00-2-2h-2zM4 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H4zm10 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
                    </svg>
                    <span>Quản lý đơn hàng</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Quản lý người dùng</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.banners.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.banners.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.banners.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v10H5V5zm6.5 1a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0 4a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    </svg>
                    <span>Quản lý banner</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posts.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.posts.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5zM4 17h12"></path>
                    </svg>
                    <span>Quản lý bài viết</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contacts.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.contacts.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2-1v10h12V4H4zm1 1h10"></path>
                    </svg>
                    <span>Quản lý liên hệ</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reviews.index') }}"
                   class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg transition-all duration-300 {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-600' : 'hover:bg-gray-600' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.reviews.*') ? 'text-white' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.638-.921 1.938 0l2.536 7.788 8.165 1.187a1 1 0 01.554 1.705l-5.91 5.764 1.396 8.14a1 1 0 01-1.451 1.054L10 18.23l-7.294 3.834a1 1 0 01-1.451-1.054l1.396-8.14-5.91-5.764a1 1 0 01.554-1.705l8.165-1.187z"></path>
                    </svg>
                    <span>Quản lý đánh giá</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-auto">
        <hr class="border-gray-600 my-3">
        <a href="#" class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg hover:bg-gray-600 transition-all duration-300">
            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM4.09 4.09A7.965 7.965 0 0110 2a8 8 0 015.91 2.09l-1.42 1.42A6.002 6.002 0 0010 4a6 6 0 00-4.49 2.14L4.09 4.09z"></path>
            </svg>
            <span>Cài đặt</span>
        </a>
        <a href="#" class="sidebar-item flex items-center space-x-2 p-2 text-sm rounded-lg text-red-300 hover:bg-red-500 hover:text-white transition-all duration-300 mt-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>
