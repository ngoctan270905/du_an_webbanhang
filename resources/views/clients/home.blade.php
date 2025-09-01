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
            <h2 class="text-center text-3xl font-bold mb-4">Sách nổi bật</h2>
            <p class="text-center text-lg mb-8">Những tác phẩm bán chạy và được yêu thích nhất.</p>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($featuredBooks as $book)
                    <a href="{{ route('product.detail', $book->id) }}"
                        class="product-card flex flex-col bg-white shadow-lg rounded-lg p-4 hover:shadow-xl transition-shadow">

                        <!-- Khối ảnh -->
                        <div class="w-full h-64 flex items-center justify-center">
                            <img src="{{ Storage::url($book->hinh_anh) }}" alt="{{ $book->ten_san_pham }}"
                                class="max-h-64 object-contain">
                        </div>

                        <!-- Khối nội dung -->
                        <div class="card-content flex flex-col flex-grow justify-between text-center">
                            <div>
                                <h3 class="text-lg font-semibold line-clamp-2 min-h-[3.5rem]">
                                    {{ $book->ten_san_pham }}
                                </h3>
                                <p class="author text-gray-900 min-h-[1.5rem]">
                                    {{ $book->author }}
                                </p>
                            </div>
                            <div class="price">
                                @if ($book->gia_khuyen_mai)
                                    <span class="text-red-500 font-bold">
                                        {{ number_format($book->gia_khuyen_mai, 0, ',', '.') }}đ
                                    </span>
                                    <span class="text-gray-500 line-through ml-2">
                                        {{ number_format($book->gia, 0, ',', '.') }}đ
                                    </span>
                                @else
                                    <span class="text-red-500 font-bold">
                                        {{ number_format($book->gia, 0, ',', '.') }}đ
                                    </span>
                                @endif
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    <section class="new-releases">
        <div class="container mx-auto px-20">
            <h2>Sách mới phát hành</h2>
            <p>Khám phá những cuốn sách mới nhất vừa được xuất bản.</p>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <a href="#" class="new-release-card">
                    <img src="https://images.unsplash.com/photo-1516979187457-6376cc01a66d?q=80&w=2670&auto=format&fit=crop"
                        alt="Sách mới">
                    <div class="card-content">
                        <h3>Hành trình vũ trụ</h3>
                        <p class="author">Neil deGrasse Tyson</p>
                        <p class="price">220.000đ</p>
                    </div>
                </a>
                <a href="#" class="new-release-card">
                    <img src="https://images.unsplash.com/photo-1516321165247-7b367e0168b0?q=80&w=2670&auto=format&fit=crop"
                        alt="Sách mới">
                    <div class="card-content">
                        <h3>Ánh sáng vô hình</h3>
                        <p class="author">Anthony Doerr</p>
                        <p class="price">180.000đ</p>
                    </div>
                </a>
                <a href="#" class="new-release-card">
                    <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2670&auto=format&fit=crop"
                        alt="Sách mới">
                    <div class="card-content">
                        <h3>Tâm lý học đám đông</h3>
                        <p class="author">Gustave Le Bon</p>
                        <p class="price">130.000đ</p>
                    </div>
                </a>
                <a href="#" class="new-release-card">
                    <img src="https://images.unsplash.com/photo-1516655855035-d7c18c20826e?q=80&w=2670&auto=format&fit=crop"
                        alt="Sách mới">
                    <div class="card-content">
                        <h3>Cây cam ngọt của tôi</h3>
                        <p class="author">José Mauro de Vasconcelos</p>
                        <p class="price">110.000đ</p>
                    </div>
                </a>
                <a href="#" class="new-release-card">
                    <img src="https://images.unsplash.com/photo-1519408299519-3b26aa4a8a35?q=80&w=2670&auto=format&fit=crop"
                        alt="Sách mới">
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
                    <img src="https://images.unsplash.com/photo-1507919914441-2a1d2f2d9e03?q=80&w=2835&auto=format&fit=crop"
                        alt="Tin tức 1">
                    <div class="news-card-content">
                        <h3>TOP 10 cuốn sách quản lý tài chính cá nhân bán chạy nhất 2024</h3>
                        <p>Khám phá danh sách các cuốn sách giúp bạn làm chủ tài chính, từ việc tiết kiệm đến đầu tư hiệu
                            quả.</p>
                        <div class="news-meta">
                            <span>Thứ Hai, 1 tháng 9, 2025</span>
                            <span class="read-more">Đọc thêm</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="news-card">
                    <img src="https://images.unsplash.com/photo-1582049191062-81c002167d5e?q=80&w=2670&auto=format&fit=crop"
                        alt="Tin tức 2">
                    <div class="news-card-content">
                        <h3>Diễn đàn sách online: \'Văn học Việt Nam đương đại và những hướng đi mới\'</h3>
                        <p>Tổng hợp những chia sẻ từ các nhà văn, nhà phê bình hàng đầu về tương lai của văn học nước nhà.
                        </p>
                        <div class="news-meta">
                            <span>Thứ Sáu, 29 tháng 8, 2025</span>
                            <span class="read-more">Đọc thêm</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="news-card">
                    <img src="https://images.unsplash.com/photo-1627916962058-00507202b8d9?q=80&w=2670&auto=format&fit=crop"
                        alt="Tin tức 3">
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
