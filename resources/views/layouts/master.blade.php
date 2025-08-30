<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="header-custom">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="row align-items-center py-2">
                    <div class="col-md-6">
                        <span class="text-light fs-6"><i class="fas fa-phone-alt me-2"></i>+84 123 456 789</span>
                    </div>
                    <div class="col-md-6 text-end">
                        @auth
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-gradient dropdown-toggle px-4 py-2" type="button" id="userMenu"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="userMenu">
                                    @if (Auth::user()->quyen === 'admin')
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i
                                                    class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn btn-outline-light btn-sm me-2 px-4 py-2 hover-effect">Đăng nhập</a>
                            <a href="{{ route('register') }}"
                                class="btn btn-gradient btn-sm px-4 py-2 hover-effect">Đăng ký</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="main-header">
            <div class="container">
                <div class="row align-items-center py-3">
                    <!-- Logo -->
                    <div class="col-md-3">
                        <a href="/" class="logo-text">
                            <span class="highlight">PhoneStore</span>
                        </a>
                    </div>
                    <!-- Navigation -->
                    <div class="col-md-9">
                        <nav class="navbar navbar-expand-lg shimmering-nav">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                                <ul class="navbar-nav gap-3" >
                                    <li class="nav-item">
                                        <a class="nav-link text-white fw-semibold px-4 py-2 rounded-pill hover-nav"
                                            href="/">Trang chủ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white fw-semibold px-4 py-2 rounded-pill hover-nav"
                                            href="{{ route('product.index') }}">Sản phẩm</a>
                                    </li>
                                    <li class="nav-itemnext">
                                        <a class="nav-link text-white fw-semibold px-4 py-2 rounded-pill hover-nav"
                                            href="{{ route('posts.list') }}">Bài viết</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white fw-semibold px-4 py-2 rounded-pill hover-nav"
                                            href="{{ route('contact.form') }}">Liên hệ</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- CSS tùy chỉnh -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Header */
        .header-custom {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1000;
        }

        /* Top Bar */
        .top-bar {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Header */
        .main-header {
            padding: 10px 0;
        }

        .logo-text {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo-text .highlight {
            color: #f1c40f;
            text-shadow: 0 0 10px rgba(241, 196, 15, 0.5);
        }

        .logo-text:hover {
            transform: scale(1.05);
        }

        /* Navigation */
        .shimmering-nav {
            background: linear-gradient(90deg, #bdc3c7, #7f8c8d, #bdc3c7);
            background-size: 200% 100%;
            animation: shimmer 3s infinite linear;
            border-radius: 50px;
            padding: 10px 20px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(241, 196, 15, 0.2);
            color: #fff !important;
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.3);
        }

        /* Buttons */
        .btn-gradient {
            background: linear-gradient(45deg, #f1c40f, #e67e22);
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-outline-light {
            border-color: #fff;
            color: #fff;
        }

        .btn-outline-light:hover {
            background: #fff;
            color: #2c3e50;
        }

        .hover-effect {
            transition: all 0.3s ease;
        }

        .hover-effect:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(241, 196, 15, 0.3);
        }

        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            background: #fff;
        }

        .dropdown-item:hover {
            background: #f1c40f;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .shimmering-nav {
                border-radius: 10px;
                margin-top: 10px;
            }
            .navbar-nav {
                padding: 1rem;
            }
            .nav-link {
                text-align: center;
            }
        }
        .footer-custom {
        background: linear-gradient(135deg, #2c3e50, #34495e); /* Gradient giống header-custom */
        position: relative;
        color: #fff;
    }

    .footer-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, #bdc3c7, #7f8c8d, #bdc3c7); /* Hiệu ứng xám lóng lánh giống shimmering-nav */
        background-size: 200% 100%;
        animation: shimmer 3s infinite linear;
        opacity: 0.3; /* Làm mờ hiệu ứng để không quá chói */
        z-index: 0;
    }

    .footer-custom > * {
        position: relative;
        z-index: 1;
    }

    .footer-title {
        color: #f1c40f;
        font-weight: 600;
        margin-bottom: 20px;
        position: relative;
        font-size: 1.25rem;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #f1c40f;
        border-radius: 3px;
    }

    .footer-link {
        color: #d1d1d1;
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .footer-link:hover {
        color: #f1c40f;
        transform: translateX(5px);
    }

    .social-link {
        color: #d1d1d1;
        font-size: 1.2rem;
        margin: 0 10px;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        color: #f1c40f;
        transform: scale(1.2);
    }

    .border-light {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .text-light {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-custom .col-md-4 {
            text-align: center;
        }

        .footer-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-link {
            display: inline-block;
        }

        .social-icons {
            justify-content: center;
        }
    }
       

    </style>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

     <!-- Footer -->
<footer class="footer-custom py-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Về Ngọc Tấn</h5>
                <p class="text-light">Chuyên cung cấp các sản phẩm công nghệ hiện đại, chất lượng cao, mang đến trải nghiệm tuyệt vời cho khách hàng.</p>
                <p class="text-light">Địa chỉ: 123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh</p>
                <p class="text-light">Giờ làm việc: 8:00 - 20:00 (Thứ 2 - Chủ Nhật)</p>
            </div>
            <!-- Quick Links -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="footer-link">Trang chủ</a></li>
                    <li><a href="{{ route('product.index') }}" class="footer-link">Sản phẩm</a></li>
                    <li><a href="#" class="footer-link">Bài viết</a></li>
                    <li><a href="#" class="footer-link">Liên hệ</a></li>
                    <li><a href="#" class="footer-link">Chính sách bảo hành</a></li>
                    <li><a href="#" class="footer-link">Hướng dẫn mua hàng</a></li>
                </ul>
            </div>
            <!-- Contact Info -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Liên hệ</h5>
                <p class="text-light"><i class="fas fa-phone-alt me-2"></i>+84 123 456 789</p>
                <p class="text-light"><i class="fas fa-envelope me-2"></i>support@ngoctan.com</p>
                <p class="text-light"><i class="fas fa-map-marker-alt me-2"></i>123 Đường Công Nghệ, Quận 1, TP. HCM</p>
                <div class="social-icons mt-3">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <hr class="border-light">
        <div class="text-center">
            <p class="text-light mb-0">© 2025 Ngọc Tấn. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- CSS tùy chỉnh cho Footer -->
<style>
    
</style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>