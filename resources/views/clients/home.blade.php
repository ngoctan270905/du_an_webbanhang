@extends('layouts.master')

@section('title', 'Trang Chủ')

@section('content')
   <section class="hero-bg">
            <div class="hero-content">
                <h1>KHO TÀNG TRI THỨC</h1>
                <p>Khám phá những câu chuyện, kiến thức và cảm hứng từ hàng triệu cuốn sách.</p>
                <a href="#">KHÁM PHÁ NGAY</a>
            </div>
        </section>

        <section class="featured-books">
            <div class="container mx-auto px-20">
                <h2>Sách nổi bật</h2>
                <p>Những tác phẩm bán chạy và được yêu thích nhất.</p>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <a href="#" class="product-card">
                        <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=2757&auto=format&fit=crop" alt="Sách Trinh thám">
                        <div class="card-content">
                            <h3>Đắc nhân tâm</h3>
                            <p class="author">Dale Carnegie</p>
                            <p class="price">120.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="product-card">
                        <img src="https://images.unsplash.com/photo-1544947953-b3a1a9807567?q=80&w=2670&auto=format&fit=crop" alt="Sách kinh tế">
                        <div class="card-content">
                            <h3>Cha giàu cha nghèo</h3>
                            <p class="author">Robert T. Kiyosaki</p>
                            <p class="price">150.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="product-card">
                        <img src="https://images.unsplash.com/photo-1509192934062-81734265492d?q=80&w=2670&auto=format&fit=crop" alt="Sách văn học">
                        <div class="card-content">
                            <h3>Nhà giả kim</h3>
                            <p class="author">Paulo Coelho</p>
                            <p class="price">95.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="product-card">
                        <img src="https://images.unsplash.com/photo-1521747116042-5a810fda9664?q=80&w=2670&auto=format&fit=crop" alt="Sách khoa học">
                        <div class="card-content">
                            <h3>Sapiens: Lược sử loài người</h3>
                            <p class="author">Yuval Noah Harari</p>
                            <p class="price">280.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="product-card">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca3b5b526d?q=80&w=2670&auto=format&fit=crop" alt="Sách tự truyện">
                        <div class="card-content">
                            <h3>Trở thành chính mình</h3>
                            <p class="author">Michelle Obama</p>
                            <p class="price">200.000đ</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="new-releases">
            <div class="container mx-auto px-20">
                <h2>Sách mới phát hành</h2>
                <p>Khám phá những cuốn sách mới nhất vừa được xuất bản.</p>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <a href="#" class="new-release-card">
                        <img src="https://images.unsplash.com/photo-1516979187457-6376cc01a66d?q=80&w=2670&auto=format&fit=crop" alt="Sách mới">
                        <div class="card-content">
                            <h3>Hành trình vũ trụ</h3>
                            <p class="author">Neil deGrasse Tyson</p>
                            <p class="price">220.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="new-release-card">
                        <img src="https://images.unsplash.com/photo-1516321165247-7b367e0168b0?q=80&w=2670&auto=format&fit=crop" alt="Sách mới">
                        <div class="card-content">
                            <h3>Ánh sáng vô hình</h3>
                            <p class="author">Anthony Doerr</p>
                            <p class="price">180.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="new-release-card">
                        <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2670&auto=format&fit=crop" alt="Sách mới">
                        <div class="card-content">
                            <h3>Tâm lý học đám đông</h3>
                            <p class="author">Gustave Le Bon</p>
                            <p class="price">130.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="new-release-card">
                        <img src="https://images.unsplash.com/photo-1516655855035-d7c18c20826e?q=80&w=2670&auto=format&fit=crop" alt="Sách mới">
                        <div class="card-content">
                            <h3>Cây cam ngọt của tôi</h3>
                            <p class="author">José Mauro de Vasconcelos</p>
                            <p class="price">110.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="new-release-card">
                        <img src="https://images.unsplash.com/photo-1519408299519-3b26aa4a8a35?q=80&w=2670&auto=format&fit=crop" alt="Sách mới">
                        <div class="card-content">
                            <h3>Đi tìm lẽ sống</h3>
                            <p class="author">Viktor E. Frankl</p>
                            <p class="price">140.000đ</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="news-section">
            <div class="container mx-auto px-4">
                <h2>Tin tức nổi bật</h2>
                <p class="subtitle">Cập nhật các sự kiện, tin tức mới nhất từ cộng đồng sách.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <a href="#" class="news-card">
                        <img src="https://images.unsplash.com/photo-1507919914441-2a1d2f2d9e03?q=80&w=2835&auto=format&fit=crop" alt="Tin tức 1">
                        <div class="news-card-content">
                            <h3>TOP 10 cuốn sách quản lý tài chính cá nhân bán chạy nhất 2024</h3>
                            <p>Khám phá danh sách các cuốn sách giúp bạn làm chủ tài chính, từ việc tiết kiệm đến đầu tư hiệu quả.</p>
                            <div class="news-meta">
                                <span>Thứ Hai, 1 tháng 9, 2025</span>
                                <span class="read-more">Đọc thêm</span>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="news-card">
                        <img src="https://images.unsplash.com/photo-1582049191062-81c002167d5e?q=80&w=2670&auto=format&fit=crop" alt="Tin tức 2">
                        <div class="news-card-content">
                            <h3>Diễn đàn sách online: \'Văn học Việt Nam đương đại và những hướng đi mới\'</h3>
                            <p>Tổng hợp những chia sẻ từ các nhà văn, nhà phê bình hàng đầu về tương lai của văn học nước nhà.</p>
                            <div class="news-meta">
                                <span>Thứ Sáu, 29 tháng 8, 2025</span>
                                <span class="read-more">Đọc thêm</span>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="news-card">
                        <img src="https://images.unsplash.com/photo-1627916962058-00507202b8d9?q=80&w=2670&auto=format&fit=crop" alt="Tin tức 3">
                        <div class="news-card-content">
                            <h3>Sự kiện ra mắt sách \'Thành phố không ngủ\' của tác giả Nguyễn Nhật Ánh</h3>
                            <p>Thông tin chi tiết về buổi ký tặng sách và giao lưu với tác giả nổi tiếng tại Hà Nội.</p>
                            <div class="news-meta">
                                <span>Chủ Nhật, 24 tháng 8, 2025</span>
                                <span class="read-more">Đọc thêm</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
@endsection
