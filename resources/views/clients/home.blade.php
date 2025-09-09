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

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <section class="featured-books">
                <div class="container mx-auto">
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

            <!-- Latest Books Section (mirrors Featured Books) -->
            <section class="featured-books">
                <div class="container mx-auto">
                    <h2 class="text-center text-3xl font-bold mb-4">Sách mới phát hành</h2>
                    <p class="text-center text-lg mb-8">Khám phá những cuốn sách mới nhất vừa được xuất bản.</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @foreach ($latestBooks as $book)
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


            <section class="news-section">
                <div class="container mx-auto">
                    <h2>Tin tức nổi bật</h2>
                    <p class="subtitle">Cập nhật các sự kiện, tin tức mới nhất từ cộng đồng sách.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($posts as $post)
                            <a href="#" class="news-card">
                                <img src="{{ Storage::url($post->hinh_anh) }}" alt="{{ $post->tieu_de }}">

                                <div class="news-card-content">
                                    <h3>{{ $post->tieu_de }}</h3>
                                    <p>{{ \Str::limit(strip_tags($post->noi_dung), 100) }}</p>
                                    <div class="news-meta">
                                        <span>{{ $post->created_at->format('l, d \t\h\á\n\g m, Y') }}</span>
                                        <span class="read-more">Đọc thêm</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>





@endsection
