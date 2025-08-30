@extends('layouts.master')

@section('title', 'Danh Sách Sản Phẩm')

@section('content')
<style>
    @media (min-width: 1400px) {
        .col-xxl-2-4 {
            flex: 0 0 auto;
            width: 20%;
        }
    }

    .product-image-wrapper {
        height: 250px;
        overflow: hidden;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .card:hover .product-image-wrapper img {
        transform: scale(1.05);
    }
</style>

<div class="container my-5">
    <h2 class="text-center mb-5 fw-bold text-uppercase" style="color: #2c3e50;">Danh Sách Sản Phẩm</h2>

    <!-- Bộ lọc tìm kiếm -->
    <form method="GET" action="{{ route('product.index') }}">
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Tìm sản phẩm..." value="{{ request()->search }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-control">
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>{{ $category->ten_danh_muc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu" value="{{ request()->min_price }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa" value="{{ request()->max_price }}">
            </div>
            <div class="col-md-2">
                <select name="sort_by" class="form-control">
                    <option value="asc" {{ request()->sort_by == 'asc' ? 'selected' : '' }}>Giá từ thấp đến cao</option>
                    <option value="desc" {{ request()->sort_by == 'desc' ? 'selected' : '' }}>Giá từ cao đến thấp</option>
                </select>
            </div>
        </div>

        <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary">Áp Dụng Bộ Lọc</button>
        </div>
    </form>

    <!-- Danh sách sản phẩm -->
    <div class="row g-4 justify-content-center">
        @foreach ($products as $product)
            <div class="col-xxl-2-4 col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden transition-hover">
                    <div class="product-image-wrapper">
                        <img src="{{ asset('storage/' . $product->hinh_anh) }}" class="card-img-top" alt="{{ $product->ten_san_pham }}">
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title text-center text-truncate fw-semibold mb-2" style="color: #34495e; font-size: 1.1rem;">
                            {{ $product->ten_san_pham }}
                        </h5>
                        <p class="card-text text-center text-success fw-bold mb-3" style="font-size: 1rem;">
                            {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                        </p>
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm w-100 mt-auto rounded-pill">Xem Chi Tiết</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-end mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
