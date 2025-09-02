<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1a202c;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, #2c3e50 0%, #8B5CF6 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: none;
        }

        header a.logo {
            font-size: 2rem;
            font-weight: 700;
            color: #FFD700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: transform 0.3s ease;
        }

        header a.logo:hover {
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        header nav a {
            color: #F3F4F6;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: uppercase;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        header nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #FFD700;
        }

        header .flex.items-center>div>button,
        header .flex.items-center>button {
            color: #F3F4F6;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        header .flex.items-center>div>button:hover,
        header .flex.items-center>button:hover {
            color: #FFD700;
            transform: scale(1.1);
        }

        /* Dropdown Menu Styles */
        .user-menu-dropdown,
        .notification-dropdown,
        .cart-dropdown {
            transform-origin: top right;
            transition: transform 0.2s ease-out, opacity 0.2s ease-out;
        }

        .user-menu-dropdown.hidden,
        .notification-dropdown.hidden,
        .cart-dropdown.hidden {
            transform: scale(0.95);
            opacity: 0;
            display: none;
        }

        .user-menu-dropdown.show,
        .notification-dropdown.show,
        .cart-dropdown.show {
            transform: scale(1);
            opacity: 1;
            display: block;
        }

        /* Hide Scrollbar */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Hero Section */
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=2938&auto=format&fit=crop');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(44, 62, 80, 0.7) 0%, rgba(139, 92, 246, 0.5) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 2rem 1rem;
            animation: fadeInUp 1s ease-out;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 1.5rem;
        }

        .hero-content p {
            font-size: 1.25rem;
            font-weight: 300;
            max-width: 36rem;
            margin: 0 auto 2rem;
        }

        .hero-content a {
            background: #FFD700;
            color: #1a202c;
            padding: 0.75rem 2rem;
            border-radius: 0.375rem;
            text-transform: uppercase;
            font-weight: 600;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .hero-content a:hover {
            background: #F59E0B;
            transform: scale(1.05);
        }

        /* Featured Books Section */
        .featured-books {
            padding: 4rem 1rem 2rem;
            background: #F9FAFB;
        }

        .featured-books h2 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #2c3e50;
            animation: fadeInUp 0.8s ease-out;
        }

        .featured-books p {
            text-align: center;
            color: #6B7280;
        }

        .product-card {
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
            border: 1px solid transparent;
            animation: fadeInUp 0.8s ease-out;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 1px solid #8B5CF6;
        }

        .product-card img {
            height: 14rem;
            object-fit: cover;
            width: 100%;
        }

        .product-card .card-content {
            text-align: center;
        }

        .product-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .product-card p.author {
            color: #6B7280;
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .product-card p.price {
            font-size: 1rem;
            font-weight: 700;
            color: #8B5CF6;
        }

        /* News Section */
        .news-section {
            padding: 4rem 1rem;
            background: #f9fafb;
        }

        .news-section .container {
            max-width: 1200px;
            margin: auto;
        }

        .news-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .news-section p.subtitle {
            text-align: center;
            color: #6B7280;
            margin-bottom: 2.5rem;
        }

        .news-card {
            background: #fff;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .news-card img {
            width: 100%;
            height: 12rem;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-card:hover img {
            transform: scale(1.05);
        }

        .news-card-content {
            padding: 1.5rem;
        }

        .news-card-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .news-card-content p {
            font-size: 0.95rem;
            color: #6B7280;
            line-height: 1.6;
        }

        .news-card-content .news-meta {
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #9CA3AF;
        }

        .news-card-content .read-more {
            color: #8B5CF6;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .news-card-content .read-more:hover {
            color: #6D28D9;
        }

        /* Footer Styles */
        footer {
            background: #1a202c;
            color: #D1D5DB;
            padding: 3rem 5.5rem 2rem;
            border-top: 2px solid #8B5CF6;
        }

        footer h3 {
            color: #FFD700;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        footer h4 {
            color: #fff;
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }

        footer ul li a {
            color: #D1D5DB;
            transition: color 0.3s ease;
        }

        footer ul li a:hover {
            color: #FFD700;
        }

        footer .border-t {
            border-color: #374151;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (min-width: 768px) {
            .hero-content h1 {
                font-size: 4rem;
            }

            .news-section .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>

<body>
    <header class="fixed top-0 left-0 right-0 z-50 py-3 px-8 flex items-center justify-between">
        <a href="{{ route('home') }}" class="logo">BOOKSTORE</a>
        <nav class="hidden md:flex flex-1 justify-center space-x-8">
            <a href="#" class="transition-colors">VĂN HỌC</a>
            <a href="#" class="transition-colors">KINH TẾ</a>
            <a href="#" class="transition-colors">THIẾU NHI</a>
            <a href="#" class="transition-colors">KHOA HỌC</a>
            <a href="#" class="transition-colors">SÁCH MỚI</a>
        </nav>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button id="notification-button"
                    class="relative flex items-center justify-center w-10 h-10 focus:outline-none">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">5</span>
                </button>
                <div id="notification-dropdown"
                    class="notification-dropdown hidden absolute right-0 mt-2 w-80 bg-gray-700 text-white rounded-md shadow-lg overflow-hidden z-20">
                    <div class="p-4 border-b border-gray-600">
                        <h4 class="text-lg font-bold">Thông báo mới</h4>
                    </div>
                    <div class="max-h-80 overflow-y-auto hide-scrollbar"></div>
                    <div class="p-2 text-center border-t border-gray-600">
                        <a href="#" class="text-sm font-medium text-blue-300 hover:text-blue-100">Xem tất cả</a>
                    </div>
                </div>
            </div>

            <div class="relative">
                @auth
                    <button id="user-menu-button"
                        class="relative flex items-center justify-center w-10 h-10 transition-colors focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                    <div id="user-menu-dropdown"
                        class="user-menu-dropdown hidden absolute right-0 mt-2 w-52 bg-gray-700 text-white rounded-md shadow-lg py-1 focus:outline-none z-10">
                        <a class="block mt-1 px-4 py-2 text-sm hover:bg-gray-600">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                        </a>
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2V7a5 5 0 00-5-5zM9 16.5a.5.5 0 001 0V15a1 1 0 00-2 0v1.5zm0-2.5a.5.5 0 001 0v-1a.5.5 0 00-1 0v1z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                    <span>Truy cập trang quản trị</span>
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-600">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.121 17.804A11.956 11.956 0 0112 15c2.981 0 5.76-1.077 7.91-2.996L19.5 14.5m-7.5-12a9 9 0 100 18 9 9 0 000-18zm0 14a5 5 0 110-10 5 5 0 010 10z" />
                                </svg>
                                <span>Xem hồ sơ của tôi</span>
                            </div>
                        </a>
                        <div class="border-t border-gray-600 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-300 hover:bg-red-700 hover:text-white">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Đăng xuất</span>
                                </div>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-white hover:text-yellow-400 transition-colors">Đăng nhập</a>
                    <a class="text-sm font-medium text-white hover:text-yellow-400 transition-colors">/</a>
                    <a href="{{ route('register') }}"
                        class="text-sm font-medium text-white hover:text-yellow-400 transition-colors">Đăng ký</a>
                @endauth
            </div>

            <div class="relative">
                <button id="cart-button" class="relative flex items-center justify-center w-10 h-10 transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">3</span>
                </button>
                <div id="cart-dropdown"
                    class="cart-dropdown hidden absolute right-0 mt-2 w-80 bg-gray-700 text-white rounded-md shadow-lg overflow-hidden z-20">
                    <div class="p-4 border-b border-gray-600">
                        <h4 class="text-lg font-bold">Giỏ hàng</h4>
                    </div>
                    <div class="max-h-80 overflow-y-auto hide-scrollbar">
                        <!-- Cart items will be populated here -->
                    </div>
                    <div class="p-4 border-t border-gray-600">
                        <div class="flex justify-between text-sm font-medium">
                            <span>Tổng cộng:</span>
                            <span id="cart-total">0 VNĐ</span>
                        </div>
                        <a href=""
                            class="block mt-2 text-center bg-yellow-400 text-gray-900 font-bold py-2 px-4 rounded-md hover:bg-yellow-500 transition-colors">
                            Xem giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-14">
        @yield('content')
    </main>

    <footer>
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="space-y-4">
                    <h3 class="text-3xl font-bold text-yellow-400 font-serif tracking-wide">BOOKSTORE</h3>
                    <p class="text-sm leading-relaxed">
                        Chuyên cung cấp các sản phẩm sách chất lượng cao, mang đến trải nghiệm đọc tuyệt vời cho khách
                        hàng.
                    </p>
                    <p class="text-sm">Địa chỉ: 123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh</p>
                    <p class="text-sm">Giờ làm việc: 8:00 - 20:00 (Thứ 2 - Chủ Nhật)</p>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.774-1.63 1.574V12h2.77l-.44 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12c0 5.244 3.824 9.588 8.841 9.948v-6.963H7.747v-2.985h2.994V8.586c0-2.96 1.81-4.57 4.437-4.57 1.258 0 2.339.222 2.654.321v3.01h-1.789c-1.408 0-1.681.668-1.681 1.643V12h3.344l-.546 2.985h-2.798v6.963C20.176 21.588 24 17.244 24 12c0-5.523-4.477-10-10-10z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2c2.716 0 3.056.01 4.122.06c1.066.05 1.792.203 2.427.478a4.989 4.989 0 011.772 1.153 4.99 4.99 0 011.153 1.772c.275.635.428 1.36.478 2.427.05 1.066.06 1.406.06 4.122s-.01 3.056-.06 4.122c-.05 1.066-.203 1.792-.478 2.427a4.99 4.99 0 01-1.153 1.772 4.99 4.99 0 01-1.772 1.153c-.635.275-1.36.428-2.427.478-1.066.05-1.406.06-4.122.06s-3.056-.01-4.122-.06c-1.066-.05-1.792-.203-2.427-.478a4.99 4.99 0 01-1.772-1.153 4.99 4.99 0 01-1.153-1.772c-.275-.635-.428-1.36-.478-2.427-.05-1.066-.06-1.406-.06-4.122s.01-3.056.06-4.122c.05-1.066.203-1.792.478-2.427a4.99 4.99 0 011.153-1.772 4.99 4.99 0 011.772-1.153c.635-.275 1.36-.428 2.427-.478C8.944 2.01 9.284 2 12 2zm0 4a6 6 0 100 12 6 6 0 000-12zm0 2a4 4 0 110 8 4 4 0 010-8zm-4 4.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Liên kết nhanh</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition-colors">Trang
                                chủ</a></li>
                        <li><a href="{{ route('product.index') }}" class="hover:text-yellow-400 transition-colors">Sản
                                phẩm</a></li>
                        <li><a href="{{ route('posts.list') }}" class="hover:text-yellow-400 transition-colors">Bài
                                viết</a></li>
                        <li><a href="{{ route('contact.form') }}"
                                class="hover:text-yellow-400 transition-colors">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Chính sách bảo hành</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Hướng dẫn mua hàng</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Hỗ trợ khách hàng</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Câu hỏi thường gặp</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Chính sách đổi trả</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Hướng dẫn đặt hàng</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Hệ thống cửa hàng</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Liên hệ & Nhận tin</h4>
                    <p class="text-sm">Địa chỉ: 123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh</p>
                    <p class="text-sm mt-2">Điện thoại: +84 123 456 789</p>
                    <p class="text-sm mt-2">Email: support@bookstore.vn</p>
                    <div class="mt-6">
                        <p class="text-sm mb-2">Đăng ký để nhận thông tin ưu đãi:</p>
                        <form action="#" method="post" class="flex">
                            @csrf
                            <input type="email" name="email" placeholder="Nhập email của bạn"
                                class="flex-1 py-2 px-4 rounded-l-md focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-gray-700 text-white placeholder-gray-400">
                            <button type="submit"
                                class="bg-yellow-400 text-gray-900 font-bold py-2 px-4 rounded-r-md hover:bg-yellow-500 transition-colors">
                                Gửi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-xs text-gray-500">
                <p>&copy; 2025 BOOKSTORE. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notification-button');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const userMenuBtn = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            const cartBtn = document.getElementById('cart-button');
            const cartDropdown = document.getElementById('cart-dropdown');
            const notificationList = document.querySelector('#notification-dropdown .max-h-80');
            const cartList = document.querySelector('#cart-dropdown .max-h-80');
            const cartTotal = document.getElementById('cart-total');
            const modal = document.getElementById('notification-modal');
            const closeModalBtn = document.getElementById('close-modal-button');
            const modalTitle = document.getElementById('modal-title');
            const modalContent = document.getElementById('modal-content');

            // Sample notification data
            const notifications = [{
                    id: 1,
                    title: 'Đơn hàng mới #S12345 đã được tạo.',
                    time: '5 phút trước',
                    detail: 'Chi tiết: Đơn hàng S12345 bao gồm sách "Nhà giả kim" và "Đắc nhân tâm".'
                },
                {
                    id: 2,
                    title: 'Sách "Nhà giả kim" vừa được thêm vào giỏ hàng.',
                    time: '15 phút trước',
                    detail: 'Chi tiết: Sản phẩm "Nhà giả kim" đã được thêm vào giỏ hàng của bạn.'
                },
                {
                    id: 3,
                    title: 'Khách hàng mới: Trần Văn C đã đăng ký.',
                    time: '1 giờ trước',
                    detail: 'Chi tiết: Khách hàng mới Trần Văn C đã hoàn tất đăng ký tài khoản.'
                },
                {
                    id: 4,
                    title: 'Đơn hàng #S12344 đã được giao thành công.',
                    time: '2 giờ trước',
                    detail: 'Chi tiết: Đơn hàng S12344 đã được giao đến địa chỉ của khách hàng và hoàn tất.'
                },
                {
                    id: 5,
                    title: 'Bạn có một tin nhắn mới từ bộ phận hỗ trợ.',
                    time: '3 giờ trước',
                    detail: 'Chi tiết: Một tin nhắn mới đã đến từ bộ phận hỗ trợ khách hàng.'
                }
            ];

            // Sample cart data
            const cartItems = [
                {
                    id: 1,
                    name: 'Nhà giả kim',
                    price: 120000,
                    quantity: 1,
                    image: 'https://via.placeholder.com/50'
                },
                {
                    id: 2,
                    name: 'Đắc nhân tâm',
                    price: 150000,
                    quantity: 2,
                    image: 'https://via.placeholder.com/50'
                },
                {
                    id: 3,
                    name: 'Dám bị ghét',
                    price: 100000,
                    quantity: 1,
                    image: 'https://via.placeholder.com/50'
                }
            ];

            // Function to render notifications
            function renderNotifications() {
                notificationList.innerHTML = '';
                if (notifications.length === 0) {
                    notificationList.innerHTML =
                        `<p class="p-4 text-center text-gray-400">Không có thông báo mới.</p>`;
                    return;
                }
                notifications.forEach(notif => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('block', 'p-4', 'hover:bg-gray-600', 'border-b', 'border-gray-600',
                        'last:border-b-0');
                    item.innerHTML = `
                <p class="text-sm font-medium">${notif.title}</p>
                <p class="text-xs text-gray-300 mt-1">${notif.time}</p>
            `;
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        showModal(notif);
                    });
                    notificationList.appendChild(item);
                });
            }

            // Function to render cart items
            function renderCartItems() {
                cartList.innerHTML = '';
                if (cartItems.length === 0) {
                    cartList.innerHTML =
                        `<p class="p-4 text-center text-gray-400">Giỏ hàng trống.</p>`;
                    return;
                }
                let total = 0;
                cartItems.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    const cartItem = document.createElement('div');
                    cartItem.classList.add('flex', 'items-center', 'p-4', 'border-b', 'border-gray-600', 'last:border-b-0');
                    cartItem.innerHTML = `
                        <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded-md mr-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium">${item.name}</p>
                            <p class="text-xs text-gray-300">${item.quantity} x ${item.price.toLocaleString('vi-VN')} VNĐ</p>
                        </div>
                        <button class="text-red-400 hover:text-red-300 text-sm" onclick="removeCartItem(${item.id})">
                            Xóa
                        </button>
                    `;
                    cartList.appendChild(cartItem);
                });
                cartTotal.textContent = `${total.toLocaleString('vi-VN')} VNĐ`;
            }

            // Function to remove cart item (placeholder)
            function removeCartItem(itemId) {
                const index = cartItems.findIndex(item => item.id === itemId);
                if (index !== -1) {
                    cartItems.splice(index, 1);
                    renderCartItems();
                }
            }

            // Expose removeCartItem to global scope
            window.removeCartItem = removeCartItem;

            // Function to show the modal with content
            function showModal(notifData) {
                if (modal && modalTitle && modalContent) {
                    modalTitle.textContent = notifData.title;
                    modalContent.innerHTML =
                        `<p>${notifData.detail}</p><p class="mt-2 text-sm text-gray-400">Thời gian: ${notifData.time}</p>`;
                    modal.classList.remove('hidden');
                }
            }

            // Function to hide the modal
            function hideModal() {
                if (modal) {
                    modal.classList.add('hidden');
                }
            }

            // Event listener to close the modal
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', hideModal);
            }

            // Close modal when clicking outside
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        hideModal();
                    }
                });
            }

            // Function to close other dropdowns
            function closeOtherDropdown(currentDropdown) {
                const dropdowns = [notificationDropdown, userMenuDropdown, cartDropdown];
                dropdowns.forEach(dropdown => {
                    if (dropdown && dropdown !== currentDropdown && dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Dropdown menu functionality
            function setupDropdown(button, dropdown) {
                if (button && dropdown) {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                        closeOtherDropdown(dropdown);
                        dropdown.classList.toggle('hidden');
                        dropdown.classList.toggle('show');
                    });

                    document.addEventListener('click', (e) => {
                        if (!dropdown.contains(e.target) && !button.contains(e.target) && dropdown.classList
                            .contains('show')) {
                            dropdown.classList.remove('show');
                            dropdown.classList.add('hidden');
                        }
                    });
                }
            }

            // Initial function calls
            renderNotifications();
            renderCartItems();
            setupDropdown(notificationBtn, notificationDropdown);
            setupDropdown(userMenuBtn, userMenuDropdown);
            setupDropdown(cartBtn, cartDropdown);
        });
    </script>
</body>

</html>