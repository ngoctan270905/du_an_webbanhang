@extends('layouts.master')

@section('title', 'Danh Mục Sách')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-center mb-6">Tất Cả Sách</h1>
            <p class="text-center text-lg mb-8 text-gray-600">Khám phá toàn bộ bộ sưu tập sách của chúng tôi.</p>

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <label for="category-filter" class="text-gray-700 font-medium">Danh mục:</label>
                    <select id="category-filter" name="category_id"
                        class="border rounded-lg px-4 py-2.5 focus:ring-red-500 focus:border-red-500">
                        <option value="all"
                            {{ request('category_id') === 'all' || !request('category_id') ? 'selected' : '' }}>Tất cả
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->ten_danh_muc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-4">
                    <label for="sort-by" class="text-gray-700 font-medium">Sắp xếp theo:</label>
                    <select id="sort-by" name="sort_by"
                        class="border rounded-lg px-4 py-2.5 focus:ring-red-500 focus:border-red-500">
                        <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ $sortBy === 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                        <option value="price_desc" {{ $sortBy === 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp
                        </option>
                        <option value="best_selling" {{ $sortBy === 'best_selling' ? 'selected' : '' }}>Bán chạy nhất
                        </option>
                    </select>
                </div>
            </div>

            @if ($products->isEmpty())
                <p class="text-gray-500 text-center">Không tìm thấy sách nào phù hợp.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ route('product.detail', $product->id) }}"
                            class="product-card flex flex-col bg-white shadow-lg rounded-lg p-4 hover:shadow-xl transition-shadow">
                            <div class="w-full h-64 flex items-center justify-center">
                                <img src="{{ $product->hinh_anh ? asset('storage/' . $product->hinh_anh) : 'https://via.placeholder.com/300x450' }}"
                                    alt="{{ $product->ten_san_pham }}" class="max-h-64 object-contain">
                            </div>
                            <div class="card-content flex flex-col flex-grow justify-between text-center">
                                <div>
                                    <h3 class="text-lg font-semibold line-clamp-2 min-h-[3.5rem]">
                                        {{ $product->ten_san_pham }}</h3>
                                    <p class="author text-gray-900 min-h-[1.5rem]">{{ $product->author ?? 'Không rõ' }}</p>
                                </div>
                                <div class="price">
                                    @if ($product->gia_khuyen_mai)
                                        <span class="text-red-500 font-bold">
                                            {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}đ
                                        </span>
                                        <span class="text-gray-500 line-through ml-2">
                                            {{ number_format($product->gia, 0, ',', '.') }}đ
                                        </span>
                                    @else
                                        <span class="text-red-500 font-bold">
                                            {{ number_format($product->gia, 0, ',', '.') }}đ
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Phân trang -->
                <div class="flex justify-center mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('category-filter');
            const sortByFilter = document.getElementById('sort-by');

            function updateFilters() {
                const params = new URLSearchParams(window.location.search);
                params.set('category_id', categoryFilter.value);
                params.set('sort_by', sortByFilter.value);
                window.location.href = '{{ route('products.list') }}?' + params.toString();
            }

            categoryFilter.addEventListener('change', updateFilters);
            sortByFilter.addEventListener('change', updateFilters);
        });
    </script>
@endsection

