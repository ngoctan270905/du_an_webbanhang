@extends('layouts.master')

@section('title', 'Trang Chủ')

@section('content')
    <!-- Banner Section -->
    <div class="banner carousel slide" data-bs-ride="carousel" id="bannerCarousel">
        <div class="carousel-inner">
            @foreach ($banners as $index => $banner)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $banner->hinh_anh) }}" alt="Banner"
                        class="d-block w-100 object-fit-cover" style="max-height: 100%;">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- New Products Section -->
    <div class="container my-5">
        <h3 class="text-center mb-5 fw-bold text-uppercase" style="color: #2c3e50;">Sản Phẩm Mới Nhất</h3>
        <div class="row g-4">
            @foreach ($newProducts as $product)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden transition-hover">
                        <!-- Tối ưu hình ảnh sản phẩm -->
                        <div class="product-image-wrapper">
                            <img src="{{ asset('storage/' . $product->hinh_anh) }}" class="card-img-top object-fit-contain"
                                alt="{{ $product->ten_san_pham }}" style="height: 250px; width: 100%;">
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Tên sản phẩm -->
                            <h5 class="card-title text-center text-truncate fw-semibold mb-2"
                                style="color: #34495e; font-size: 1.1rem;">{{ $product->ten_san_pham }}</h5>
                            <!-- Giá sản phẩm -->
                            <p class="card-text text-center text-success fw-bold mb-3" style="font-size: 1rem;">
                                {{ number_format($product->gia, 0, ',', '.') }} VNĐ</p>
                            <!-- Nút Xem Chi Tiết -->
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm w-100 mt-auto rounded-pill">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- CSS tùy chỉnh -->


    <!-- Latest Posts Section -->
    <div class="container my-5">
        <h3 class="text-center mb-5 fw-bold text-uppercase" style="color: #2c3e50;">Bài Viết Mới Nhất</h3>
        <div class="row g-4">
            @foreach ($latestPosts as $post)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden transition-hover">
                        <!-- Thêm hình ảnh -->
                        @if ($post->hinh_anh)
                            <img src="{{ asset('storage/' . $post->hinh_anh) }}" class="card-img-top"
                                alt="{{ $post->tieu_de }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate fw-semibold" style="color: #34495e;">{{ $post->tieu_de }}
                            </h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($post->noi_dung, 100) }}</p>
                            <a href="#" class="btn btn-outline-primary btn-sm mt-auto rounded-pill">Đọc Tiếp</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Top Reviews Section -->
    <div class="container my-5">
        <h3 class="text-center mb-5 fw-bold text-uppercase" style="color: #2c3e50;">Đánh Giá Cao Nhất</h3>
        <div class="row g-4">
            @foreach ($topReviews as $review)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden transition-hover">
                        <div class="card-body d-flex flex-column">


                            <!-- Tên sản phẩm -->
                            <h5 class="card-title fw-semibold" style="color: #34495e;">Điện thoại:
                                {{ $review->product->ten_san_pham }}
                            </h5>

                            <!-- Tên khách hàng -->
                            <p class="card-text text-muted">Đánh giá bởi: <strong>{{ $review->user->name }}</strong></p>

                            <!-- Nội dung đánh giá -->
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($review->noi_dung, 100) }}</p>

                            <!-- Đánh giá sao -->
                            <p class="card-text">
                                <strong>Rating:</strong>
                                <span class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                </span>
                            </p>


                            <!-- Ngày đánh giá -->
                            <p class="card-text text-muted"><small>Ngày đánh giá:
                                    {{ $review->created_at->format('d/m/Y') }}</small></p>

                            <!-- Nút xem chi tiết -->
                            <a href="#" class="btn btn-outline-warning btn-sm mt-auto rounded-pill">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Thêm CSS tùy chỉnh -->
    <style>
         
        .transition-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .object-fit-cover {
            object-fit: cover;
        }
        

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            background-color: #f8f9fa;
            /* Màu nền nhẹ để làm nổi bật hình ảnh */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 250px;
            /* Đảm bảo khung đủ cao để chứa toàn bộ hình ảnh */
        }

        .card-img-top {
            object-fit: contain;
            /* Hiển thị toàn bộ hình ảnh mà không bị cắt */
            transition: transform 0.3s ease;
            /* Hiệu ứng phóng to khi hover */
            max-height: 100%;
            /* Đảm bảo hình ảnh không vượt quá khung */
            max-width: 100%;
            /* Đảm bảo hình ảnh không vượt quá khung */
        }

        .transition-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            /* Nâng card lên khi hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            /* Tăng shadow */
        }

        .transition-hover:hover .card-img-top {
            transform: scale(1.05);
            /* Phóng to hình ảnh khi hover */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 500;
            padding: 8px 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
@endsection
