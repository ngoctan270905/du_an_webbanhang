@extends('layouts.master')

@section('title', $product->ten_san_pham)

@section('content')
    <style>
        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: auto;
            max-height: 450px;
            object-fit: contain;
        }

        .product-details {
            padding: 1rem;
        }

        .product-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .rating-stars {
            color: #f1c40f;
            font-size: 1rem;
        }

        .rating-count {
            font-size: 0.9rem;
            color: #666;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e63946;
            margin-bottom: 1rem;
        }

        .product-specs {
            font-size: 1rem;
            color: #555;
            margin-bottom: 1rem;
        }

        .spec-label {
            font-weight: 600;
            color: #333;
        }

        .color-options {
            margin-bottom: 1.5rem;
        }

        .color-options label {
            font-size: 0.9rem;
            margin-right: 0.5rem;
            color: #333;
        }

        .color-options select {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .quantity-selector button {
            width: 35px;
            height: 35px;
            border: 1px solid #ddd;
            background: #f5f5f5;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .quantity-selector input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.5rem;
            font-size: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-add-to-cart,
        .btn-buy-now {
            padding: 0.75rem 2rem;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-to-cart {
            background: #fff;
            color: #e63946;
            border: 1px solid #e63946;
        }

        .btn-add-to-cart:hover {
            background: #e63946;
            color: #fff;
        }

        .btn-buy-now {
            background: #e63946;
            color: #fff;
        }

        .btn-buy-now:hover {
            background: #d00000;
        }

        /* Section chung */
        .section {
            margin-top: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            width: 50px;
            height: 3px;
            background: #e63946;
            position: absolute;
            bottom: -5px;
            left: 0;
        }

        /* Đánh giá sản phẩm */
        .review-card {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #e63946;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .review-user {
            font-weight: 600;
            color: #333;
        }

        .review-date {
            font-size: 0.9rem;
            color: #666;
        }

        /* Sản phẩm cùng danh mục */
        .related-products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
        }

        .related-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .related-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .related-body {
            padding: 1rem;
            text-align: center;
        }

        .related-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .related-price {
            font-size: 0.9rem;
            color: #e63946;
            font-weight: 500;
        }
    </style>

    <div class="product-container">
        <!-- Main Product -->
        <div class="product-grid">
            <!-- Product Image -->
            <div class="product-image-wrapper">
                <img src="{{ asset('storage/' . $product->hinh_anh) }}" class="product-image"
                    alt="{{ $product->ten_san_pham }}">
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h1 class="product-title">{{ $product->ten_san_pham }}</h1>

                <!-- Rating -->
                <div class="product-rating">
                    <span class="rating-stars">★★★★★</span>
                    <span class="rating-count">({{ $reviews->count() }} đánh giá)</span>
                </div>

                <!-- Price -->
                <p class="product-price">{{ number_format($product->gia, 0, ',', '.') }} VNĐ</p>

                <!-- Specs -->
                <div class="product-specs">
                    <p><span class="spec-label">Mô tả:</span> {{ $product->mo_ta }}</p>
                    <p><span class="spec-label">Số lượng còn lại:</span> {{ $product->so_luong }}</p>
                </div>

                <!-- Color Options (if applicable) -->
                <div class="color-options">
                    <label for="color">Màu sắc:</label>
                    <select id="color" name="color">
                        <option value="black">Đen</option>
                        <option value="brown">Nâu</option>
                        <option value="cream">Kem</option>
                    </select>
                </div>

                <!-- Quantity Selector -->
                <div class="quantity-selector">
                    <button type="button" onclick="this.nextElementSibling.value--">-</button>
                    <input type="number" value="1" min="1" max="{{ $product->so_luong }}">
                    <button type="button" onclick="this.previousElementSibling.value++">+</button>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <form action="" method="POST">
                        @csrf
                        <button type="submit" class="btn-add-to-cart">Thêm vào giỏ hàng</button>
                    </form>
                    <form action="" method="POST">
                        @csrf
                        <button type="submit" class="btn-buy-now">Mua ngay</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sản phẩm cùng danh mục -->
        <div class="mt-5">
            <h4 class="mb-4 fw-bold text-uppercase text-center">Sản phẩm cùng danh mục</h4>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3">
                @foreach ($relatedProducts as $related)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 text-center related-card">
                            <div class="ratio ratio-1x1">
                                <img src="{{ asset('storage/' . $related->hinh_anh) }}" class="card-img-top rounded-top"
                                    alt="{{ $related->ten_san_pham }}" style="object-fit: contain; padding: 10px;">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="text-truncate fw-semibold">{{ $related->ten_san_pham }}</h6>
                                <p class="text-success fw-bold small mb-2">{{ number_format($related->gia, 0, ',', '.') }}
                                    VNĐ</p>
                                <a href="{{ route('product.detail', $related->id) }}"
                                    class="btn btn-primary btn-sm w-100 mt-auto rounded-pill">Xem Chi Tiết</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- Đánh giá sản phẩm -->
        <div class="section">
            <h2 class="section-title">Đánh Giá Sản Phẩm</h2>
            @if ($reviews->count())
                @foreach ($reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-user">{{ $review->user->name ?? 'Khách' }}</span>
                            <span class="review-date">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="mb-1">Rating: <span class="rating-stars">★ {{ $review->rating }}/5</span></p>
                        <p>{{ $review->noi_dung }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
            @endif
        </div>
        @auth
            <form action="{{ route('client.reviews.store', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="rating">Đánh giá (1 đến 5 sao):</label>
                    <select name="rating" id="rating" class="form-control" required>
                        <option value="">-- Chọn số sao --</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} sao</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="noi_dung">Nội dung đánh giá:</label>
                    <textarea name="noi_dung" id="noi_dung" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Gửi đánh giá</button>
            </form>
        @else
            <div class="mt-4 alert alert-warning">
                Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá sản phẩm.
            </div>
        @endauth

    </div>
@endsection
