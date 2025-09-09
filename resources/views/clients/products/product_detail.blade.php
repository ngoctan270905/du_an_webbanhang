@extends('layouts.master')

@section('title', $product->ten_san_pham)

@section('content')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            scrollbar-width: none;
        }

        .description-container {
            position: relative;
        }

        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            position: relative;
            max-height: calc(1.5em * 4);
        }

        .line-clamp-4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2em;
            background: linear-gradient(to bottom, transparent, white);
            pointer-events: none;
        }

        .toggle-button {
            display: flex;
            justify-content: center;
            margin-top: 0.5rem;
        }

        .toggle-button button {
            background: none;
            border: none;
            color: #2563eb;
            font-size: 1.125rem;
            cursor: pointer;
            text-decoration: underline;
        }

        .toggle-button button:hover {
            color: #1e40af;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        #authModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        #authModal .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        #authModal .modal-content p {
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
            color: #333;
        }

        #authModal .modal-content .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            margin: 0 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
        }

        #authModal .modal-content .btn-login {
            background: #2563eb;
            color: white;
        }

        #authModal .modal-content .btn-login:hover {
            background: #1e40af;
        }

        #authModal .modal-content .btn-register {
            background: #e5e7eb;
            color: #333;
        }

        #authModal .modal-content .btn-register:hover {
            background: #d1d5db;
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .disabled-button {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:space-x-8">
                <div class="md:w-2/5 lg:w-1/3">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <img src="{{ Storage::url($product->hinh_anh) }}" alt="{{ $product->ten_san_pham }}"
                                class="w-full rounded-lg">
                        </div>
                        <div class="flex space-x-4 mb-4">
                            @auth
                                <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" id="form_quantity" name="quantity" value="1">
                                    <button type="submit" id="addToCartButton"
                                        class="w-full bg-white text-red-500 border-2 border-red-500 py-3 rounded-lg font-semibold hover:bg-red-50">
                                        Thêm vào giỏ hàng
                                    </button>
                                </form>
                                <form id="buyNowForm" action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" id="buyNowButton"
                                        class="w-full bg-red-500 text-white border-2 border-red-500 py-3 rounded-lg font-semibold hover:bg-red-600">
                                        Mua ngay
                                    </button>
                                </form>
                            @else
                                <button onclick="showAuthModal()"
                                    class="flex-1 bg-white text-red-500 border-2 border-red-500 py-3 rounded-lg font-semibold hover:bg-red-50">
                                    Thêm vào giỏ hàng
                                </button>
                                <button onclick="showAuthModal()"
                                    class="flex-1 bg-red-500 text-white border-2 border-red-500 py-3 rounded-lg font-semibold hover:bg-red-600">
                                    Mua ngay
                                </button>
                            @endauth
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-base font-semibold mb-2">Chính sách ưu đãi</p>
                            <div class="space-y-2 text-sm text-gray-700">
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.293a1 1 0 00-1.414-1.414L8 9.586 6.707 8.293a1 1 0 00-1.414 1.414L8 12.414l3.293-3.293z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                    Thời gian giao hàng: Giao nhanh và uy tín
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.293a1 1 0 00-1.414-1.414L8 9.586 6.707 8.293a1 1 0 00-1.414 1.414L8 12.414l3.293-3.293z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                    Chính sách đổi trả: Đổi trả miễn phí toàn quốc
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.293a1 1 0 00-1.414-1.414L8 9.586 6.707 8.293a1 1 0 00-1.414 1.414L8 12.414l3.293-3.293z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                    Chính sách ưu đãi: Ưu đãi khi mua số lượng lớn
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="md:w-3/5 lg:w-2/3 mt-8 md:mt-0 md:h-[85vh] md:overflow-y-auto md:sticky md:top-4 scrollbar-hide">
                    <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                        <p class="text-4xl font-bold">{{ $product->ten_san_pham }}</p>

                        <div class="mt-5 text-lg">
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <p>Nhà cung cấp: <strong>{{ $product->publisher }}</strong></p>
                                <p>Tác giả: <strong>{{ $product->author }}</strong></p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <p>Nhà xuất bản: <strong>{{ $product->publisher }}</strong></p>
                                <p>Hình thức bìa: <strong>Bìa mềm</strong></p>
                            </div>
                            <div class="flex items-center mt-4">
                                <span class="text-yellow-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        ★
                                    @endfor
                                </span>
                                <span class="ml-1 text-lg text-gray-500">({{ $allReviews->count() }} đánh giá)</span>
                                <span class="mx-2 text-gray-300">|</span>
                                <span class="text-lg text-gray-500">Đã bán {{ rand(100, 1500) }}</span>
                            </div>
                        </div>

                        <div class="flex items-baseline mt-4">
                            <span
                                class="text-4xl font-bold text-red-500">{{ number_format($product->gia_khuyen_mai ?? $product->gia, 0, ',', '.') }}đ</span>
                            @if ($product->gia_khuyen_mai && $product->gia_khuyen_mai < $product->gia)
                                <span
                                    class="ml-2 line-through text-gray-500 text-lg">{{ number_format($product->gia, 0, ',', '.') }}đ</span>
                                <span class="ml-2 text-red-500 font-bold text-lg">
                                    -{{ number_format((($product->gia - $product->gia_khuyen_mai) / $product->gia) * 100, 0) }}%
                                </span>
                            @endif
                        </div>

                        <div class="mt-6">
                            <p class="font-semibold text-lg">Số lượng</p>
                            <div class="flex items-center border border-gray-300 rounded-lg w-fit mt-2">
                                <button id="decreaseButton"
                                    class="px-4 py-2 text-lg text-gray-600 hover:bg-gray-100 rounded-l-lg"
                                    onclick="updateQuantity(-1)">-</button>
                                <input type="text" id="quantity" name="quantity" value="1"
                                    class="w-12 text-lg text-center border-x border-gray-300 outline-none" readonly>
                                <button id="increaseButton"
                                    class="px-4 py-2 text-lg text-gray-600 hover:bg-gray-100 rounded-r-lg {{ $product->so_luong <= 1 ? 'disabled-button' : '' }}"
                                    onclick="updateQuantity(1)" {{ $product->so_luong <= 1 ? 'disabled' : '' }}>+</button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                        <div class="font-semibold text-lg mb-2">Thông tin chi tiết</div>
                        <div class="divide-y divide-gray-300 text-base">
                            <div class="grid grid-cols-2 py-2">
                                <p>Mã hàng</p>
                                <p class="font-medium">{{ $product->ma_san_pham }}</p>
                            </div>
                            <div class="grid grid-cols-2 py-2">
                                <p>Tên Nhà Cung Cấp</p>
                                <p class="font-medium">{{ $product->publisher }}</p>
                            </div>
                            <div class="grid grid-cols-2 py-2">
                                <p>Tác giả</p>
                                <p class="font-medium">{{ $product->author }}</p>
                            </div>
                            <div class="grid grid-cols-2 py-2">
                                <p>NXB</p>
                                <p class="font-medium">{{ $product->publisher }}</p>
                            </div>
                            <div class="grid grid-cols-2 py-2">
                                <p>Năm XB</p>
                                <p class="font-medium">{{ $product->published_year }}</p>
                            </div>
                            <div class="grid grid-cols-2 py-2">
                                <p>Số lượng tồn</p>
                                <p class="font-medium">{{ $product->so_luong }}</p>
                            </div>
                            <div class="grid grid-cols-2 py-2">
                                <p>Ngày nhập</p>
                                <p class="font-medium">{{ $product->ngay_nhap }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                        <div class="font-semibold text-lg mb-2">Mô tả sản phẩm</div>
                        <div class="description-container">
                            <p id="description" class="mt-2 text-base text-gray-600 line-clamp-4">
                                {!! nl2br(e($product->mo_ta)) !!}
                            </p>
                        </div>
                        <div class="toggle-button">
                            <button id="toggleDescription" class="hidden">Xem thêm</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white p-6 rounded-lg shadow-md" id="reviews-section">
                <div class="flex justify-between items-center mb-6">
                    <div class="text-xl font-semibold text-gray-800">Đánh giá & Nhận xét</div>
                    <button id="open-review-modal"
                        class="bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Viết đánh giá
                    </button>
                </div>

                <!-- Thống kê đánh giá -->
                <div class="flex flex-col md:flex-row items-center md:items-center justify-between">
                    <div class="flex flex-col items-center flex-shrink-0 md:mr-10 mb-6 md:mb-0 w-full md:w-4/12">
                        <div class="text-5xl font-bold text-gray-800">
                            @php
                                $averageRating = $allReviews->avg('rating');
                                $totalReviews = $allReviews->count();
                                echo $averageRating ? number_format($averageRating, 1) : '0.0';
                            @endphp / 5
                        </div>
                        <div class="flex justify-center md:justify-start text-yellow-400 my-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 fill-current {{ $i <= round($averageRating) ? '' : 'text-gray-300' }}"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21z" />
                                </svg>
                            @endfor
                        </div>
                        <div class="text-sm text-gray-500">({{ $totalReviews }} đánh giá)</div>
                    </div>

                    <div class="flex-grow w-full md:w-6/12">
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $ratingCount = $allReviews->where('rating', $i)->count();
                                $percentage = $totalReviews > 0 ? ($ratingCount / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="flex items-center mb-2">
                                <span class="w-8 text-right text-gray-600 mr-2 flex-shrink-0">{{ $i }}<span
                                        class="text-xs text-yellow-400 ml-1">★</span></span>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-400 h-2.5 rounded-full" style="width: {{ $percentage }}%;">
                                    </div>
                                </div>
                                <span
                                    class="w-10 text-right text-gray-600 ml-2 text-sm flex-shrink-0">{{ $ratingCount }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="border-t border-gray-200 mt-6 pt-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-700">{{ $totalReviews }} Đánh giá</span>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('product.detail', $product->id) }}?filter=all"
                            class="px-3 py-1.5 rounded-lg border text-sm font-medium transition
                  {{ $filter === 'all'
                      ? 'bg-blue-600 text-white border-blue-600'
                      : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                            Tất cả
                        </a>

                        <a href="{{ route('product.detail', $product->id) }}?filter=5"
                            class="px-3 py-1.5 rounded-lg border text-sm font-medium flex items-center space-x-1 transition
                  {{ $filter === '5'
                      ? 'bg-blue-600 text-white border-blue-600'
                      : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                            <span>5</span>
                            <svg class="w-3.5 h-3.5 fill-current text-yellow-400" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21 16.54 13.97 22 9.24
                                 14.81 8.63 12 2 9.19 8.63
                                 2 9.24 7.46 13.97 5.82 21z" />
                            </svg>
                        </a>
                    </div>
                </div>


                <div class="my-6 border-t border-gray-200"></div>

                <!-- Danh sách đánh giá -->
                @if ($reviews->isEmpty())
                    <p class="text-gray-500 text-center">Chưa có đánh giá nào cho sản phẩm này.</p>
                @else
                    <div class="space-y-8">
                        @foreach ($reviews as $review)
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white text-base font-semibold">
                                    {{ substr($review->user->name ?? 'N', 0, 1) }}
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-center mb-1">
                                        <span
                                            class="font-semibold text-gray-800 mr-2">{{ $review->user->name ?? 'Ẩn danh' }}</span>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 fill-current {{ $i <= $review->rating ? '' : 'text-gray-300' }}"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27L18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-3">{{ $review->noi_dung }}</p>
                                    <div class="flex space-x-2 mb-3">
                                        @if ($review->image)
                                            <img src="{{ asset('storage/' . $review->image) }}" alt="Review Image"
                                                class="w-20 h-20 rounded-md object-cover">
                                        @endif
                                    </div>

                                    <div class="flex items-center text-sm text-gray-500">
                                        <span>{{ \Carbon\Carbon::parse($review->created_at)->locale('vi')->diffForHumans() }}</span>
                                        <span class="mx-2">•</span>
                                        <button class="flex items-center text-blue-600 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <div class="border-t border-gray-100"></div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Phân trang -->
                    <div class="pagination mt-12">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>

            <!-- Phần sản phẩm liên quan -->
            <section class="related-products mt-16 mb-4">
                <div class="container mx-auto">
                    <div class="text-center text-3xl font-bold mb-4">Sản phẩm liên quan</div>
                    <p class="text-center text-lg mb-8">Những sản phẩm tương tự bạn có thể quan tâm.</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <a href="{{ route('product.detail', $relatedProduct->id) }}"
                                class="product-card flex flex-col bg-white shadow-lg rounded-lg p-4 hover:shadow-xl transition-shadow">
                                <div class="w-full h-64 flex items-center justify-center">
                                    <img src="{{ Storage::url($relatedProduct->hinh_anh) }}"
                                        alt="{{ $relatedProduct->ten_san_pham }}" class="max-h-64 object-contain">
                                </div>
                                <div class="card-content flex flex-col flex-grow justify-between text-center">
                                    <div>
                                        <div class="text-lg font-semibold line-clamp-2 min-h-[3.5rem]">
                                            {{ $relatedProduct->ten_san_pham }}
                                        </div>
                                        <p class="author text-gray-900 min-h-[1.5rem]">
                                            {{ $relatedProduct->author }}
                                        </p>
                                    </div>
                                    <div class="price">
                                        @if ($relatedProduct->gia_khuyen_mai)
                                            <span class="text-red-500 font-bold">
                                                {{ number_format($relatedProduct->gia_khuyen_mai, 0, ',', '.') }}đ
                                            </span>
                                            <span class="text-gray-500 line-through ml-2">
                                                {{ number_format($relatedProduct->gia, 0, ',', '.') }}đ
                                            </span>
                                        @else
                                            <span class="text-red-500 font-bold">
                                                {{ number_format($relatedProduct->gia, 0, ',', '.') }}đ
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>


        </div>
    </div>

    <div id="cartModal" class="fixed top-6 right-6 z-50 hidden animate-slideIn">
        <div class="relative bg-white rounded-2xl shadow-2xl p-5 w-80 border border-gray-100">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div id="modalIcon" class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
                <div id="modalContent" class="flex-1">
                    <p class="text-base font-semibold text-gray-800">Đã thêm vào giỏ hàng!</p>
                    <p class="text-sm text-gray-500">Bạn có thể tiếp tục mua sắm hoặc kiểm tra giỏ hàng.</p>
                    <a href="{{ route('cart.show') }}"
                        class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
                        Xem giỏ hàng →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="reviewSuccessModal" class="fixed top-6 right-6 z-50 hidden animate-slideIn">
        <div class="relative bg-white rounded-2xl shadow-2xl p-5 w-80 border border-gray-100">
            <button id="closeReviewSuccessModal"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div id="reviewModalIcon"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
                <div id="reviewModalContent" class="flex-1">
                    <p class="text-base font-semibold text-gray-800">Đánh giá thành công!</p>
                    <p class="text-sm text-gray-500"></p>
                </div>
            </div>
        </div>
    </div>

    <div id="authModal" style="display: none;">
        <div class="modal-content">
            <p>Vui lòng đăng nhập hoặc đăng ký để mua hàng</p>
            <div>
                <a href="{{ route('login') }}" class="btn btn-login">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-register">Đăng ký</a>
            </div>
        </div>
    </div>

    <div id="review-modal"
        class="fixed inset-x-0 top-16 bottom-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-md p-4 shadow-xl w-full max-w-sm mx-auto">
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <div class="text-lg font-semibold text-gray-800">Viết đánh giá</div>
                <button id="close-review-modal" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="pt-3">
                <form action="{{ route('client.reviews.store', $product->id) }}" data-product-id="{{ $product->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium text-sm">Đánh giá của bạn</label>
                        <div class="flex flex-col">
                            <div class="flex text-2xl text-gray-300 mb-1" id="rating-stars">
                                <span class="cursor-pointer hover:text-yellow-400 transition-colors duration-200 star"
                                    data-value="1">★</span>
                                <span class="cursor-pointer hover:text-yellow-400 transition-colors duration-200 star"
                                    data-value="2">★</span>
                                <span class="cursor-pointer hover:text-yellow-400 transition-colors duration-200 star"
                                    data-value="3">★</span>
                                <span class="cursor-pointer hover:text-yellow-400 transition-colors duration-200 star"
                                    data-value="4">★</span>
                                <span class="cursor-pointer hover:text-yellow-400 transition-colors duration-200 star"
                                    data-value="5">★</span>
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', 0) }}">
                            @error('rating')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="review-comment" class="block text-gray-700 font-medium mb-1 text-sm">Bình luận</label>
                        <textarea id="review-comment" name="noi_dung"
                            class="w-full h-24 p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none placeholder-gray-400"
                            placeholder="Hãy chia sẻ cảm nhận của bạn về sản phẩm...">{{ old('noi_dung') }}</textarea>
                        @error('noi_dung')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1 text-sm">Thêm hình ảnh/video</label>
                        <div class="border border-dashed border-gray-300 rounded-md p-3 text-center text-gray-500 cursor-pointer hover:border-blue-500 transition-colors duration-200"
                            id="image-upload-area">
                            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/gif"
                                class="hidden" id="image-upload">
                            <p class="mt-1 text-xs">Tải lên một file</p>
                            <p class="text-xs">PNG, JPG, GIF up to 10MB</p>
                            <p id="file-name" class="mt-1 text-xs text-gray-700"></p>
                            <div id="image-preview" class="mt-2 flex justify-center"></div>
                        </div>
                        @error('image')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200 w-full">
                            Gửi đánh giá
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Define reviewForm in global scope to be accessible to resetReviewForm
        const reviewForm = document.querySelector('#review-modal form');

        // Cập nhật số lượng
        function updateQuantity(change) {
            let input = document.getElementById('quantity');
            let formInput = document.getElementById('form_quantity');
            let value = parseInt(input.value);
            let maxStock = {{ $product->so_luong }};
            let increaseButton = document.getElementById('increaseButton');

            if (value + change >= 1 && value + change <= maxStock) {
                input.value = value + change;
                formInput.value = value + change;
                // Cập nhật trạng thái nút tăng
                if (value + change >= maxStock) {
                    increaseButton.classList.add('disabled-button');
                    increaseButton.disabled = true;
                } else {
                    increaseButton.classList.remove('disabled-button');
                    increaseButton.disabled = false;
                }
            }
        }

        // Hiển thị modal thông báo đánh giá thành công
        function showReviewSuccessModal(message, isSuccess = true) {
            const modal = document.getElementById('reviewSuccessModal');
            const modalContent = document.getElementById('reviewModalContent');
            const modalIcon = document.getElementById('reviewModalIcon');

            modalContent.innerHTML = `
        <p class="text-base font-semibold text-gray-800">${isSuccess ? 'Đánh giá thành công!' : 'Lỗi'}</p>
        <p class="text-sm text-gray-500">${message}</p>
     `;
            modalIcon.classList.remove(isSuccess ? 'bg-red-100' : 'bg-green-100');
            modalIcon.classList.add(isSuccess ? 'bg-green-100' : 'bg-red-100');
            modalIcon.querySelector('svg').classList.remove(isSuccess ? 'text-red-500' : 'text-green-500');
            modalIcon.querySelector('svg').innerHTML = isSuccess ?
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            modalIcon.querySelector('svg').classList.add(isSuccess ? 'text-green-500' : 'text-red-500');

            modal.classList.remove('hidden');
            modal.style.animation = 'slideIn 0.3s ease-out';
            let timeoutId = setTimeout(() => hideReviewSuccessModal(), 5000);
        }

        // Ẩn modal đánh giá thành công
        function hideReviewSuccessModal() {
            const modal = document.getElementById('reviewSuccessModal');
            modal.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 280);
        }

        // Hiển thị modal đăng nhập/đăng ký
        function showAuthModal() {
            const authModal = document.getElementById('authModal');
            authModal.style.display = 'flex';
        }

        // Ẩn modal đăng nhập/đăng ký
        function hideAuthModal() {
            const authModal = document.getElementById('authModal');
            authModal.style.display = 'none';
        }

        // Hàm reset form đánh giá
        function resetReviewForm() {
            const ratingInput = document.getElementById('rating-value');
            const commentInput = document.getElementById('review-comment');
            const imageInput = document.getElementById('image-upload');
            const imagePreview = document.getElementById('image-preview');
            const fileNameDisplay = document.getElementById('file-name');
            const starRatings = document.querySelectorAll('#rating-stars .star');

            // Reset rating
            ratingInput.value = 0;
            starRatings.forEach(star => {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            });

            // Reset nội dung bình luận
            commentInput.value = '';

            // Reset hình ảnh
            imageInput.value = '';
            imagePreview.innerHTML = '';
            fileNameDisplay.textContent = '';

            // Xóa thông báo lỗi validate
            if (reviewForm) {
                reviewForm.querySelectorAll('.text-red-500').forEach(error => error.remove());
            }
        }

        // Xử lý modal
        document.addEventListener('DOMContentLoaded', function() {
            let description = document.getElementById('description');
            let toggleButton = document.getElementById('toggleDescription');
            const modal = document.getElementById('cartModal');
            const closeBtn = document.getElementById('closeModal');
            const addToCartForm = document.getElementById('addToCartForm');
            const buyNowForm = document.getElementById('buyNowForm');
            const addToCartButton = document.getElementById('addToCartButton');
            const buyNowButton = document.getElementById('buyNowButton');
            const openReviewModalBtn = document.getElementById('open-review-modal');
            const closeReviewModalBtn = document.getElementById('close-review-modal');
            const reviewModal = document.getElementById('review-modal');
            const starRatings = document.querySelectorAll('#rating-stars .star');
            const ratingInput = document.getElementById('rating-value');
            let currentRating = {{ old('rating', 0) }};
            const imageUploadArea = document.getElementById('image-upload-area');
            const imageUploadInput = document.getElementById('image-upload');
            const fileNameDisplay = document.getElementById('file-name');
            const imagePreview = document.getElementById('image-preview');
            let timeoutId;

           if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn chặn làm mới trang
        const submitButton = reviewForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.classList.add('loading', 'disabled-button');
        submitButton.innerHTML = ''; // Hiển thị icon xoay tròn

        // Xóa các thông báo lỗi cũ
        reviewForm.querySelectorAll('.text-red-500').forEach(error => error.remove());

        fetch(reviewForm.action, {
            method: 'POST',
            body: new FormData(reviewForm),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            submitButton.disabled = false;
            submitButton.classList.remove('loading', 'disabled-button');
            submitButton.innerHTML = 'Gửi đánh giá';

            if (data.success) {
                // Đóng modal và hiển thị thông báo thành công
                reviewModal.classList.add('hidden');
                showReviewSuccessModal('Đánh giá của bạn đã được gửi thành công!', true);
                
                // Xóa tham số openReview và chuyển hướng
                const productId = reviewForm.getAttribute('data-product-id');
                setTimeout(() => {
                    window.location.href = `/san-pham/${productId}`; // Chuyển hướng đến URL sạch
                }, 1000);
            } else {
                // Hiển thị lỗi validate trong modal
                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const inputField = reviewForm.querySelector(`[name="${field}"]`);
                        if (inputField) {
                            const errorSpan = document.createElement('span');
                            errorSpan.className = 'text-red-500 text-xs';
                            errorSpan.textContent = messages[0];
                            inputField.parentElement.appendChild(errorSpan);
                        }
                    }
                }
                reviewModal.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Lỗi khi gửi đánh giá:', error);
            submitButton.disabled = false;
            submitButton.classList.remove('loading', 'disabled-button');
            submitButton.innerHTML = 'Gửi đánh giá';
            showReviewSuccessModal('Có lỗi xảy ra, vui lòng thử lại!', false);
        });
    });
}

            if (openReviewModalBtn) {
                openReviewModalBtn.addEventListener('click', () => {
                    reviewModal.classList.remove('hidden');
                    resetReviewForm(); // Reset form khi mở modal
                });
            }

            if (closeReviewModalBtn) {
                closeReviewModalBtn.addEventListener('click', () => {
                    reviewModal.classList.add('hidden');
                    resetReviewForm(); // Reset form khi đóng modal
                });
            }

            if (reviewModal) {
                reviewModal.addEventListener('click', (e) => {
                    if (e.target === reviewModal) {
                        reviewModal.classList.add('hidden');
                        resetReviewForm(); // Reset form khi click ra ngoài
                    }
                });
            }

            // Xử lý đánh giá ngôi sao
            starRatings.forEach((star, index) => {
                star.addEventListener('mouseover', () => {
                    resetStars();
                    highlightStars(index + 1);
                });

                star.addEventListener('click', () => {
                    currentRating = index + 1;
                    ratingInput.value = currentRating;
                    highlightStars(currentRating);
                    console.log(`Người dùng đã chọn ${currentRating} sao.`);
                });

                star.addEventListener('mouseout', () => {
                    resetStars();
                    highlightStars(currentRating);
                });
            });

            function highlightStars(count) {
                for (let i = 0; i < count; i++) {
                    starRatings[i].classList.remove('text-gray-300');
                    starRatings[i].classList.add('text-yellow-400');
                }
            }

            function resetStars() {
                starRatings.forEach(star => {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                });
            }

            // Xử lý click khu vực tải ảnh
            if (imageUploadArea && imageUploadInput) {
                imageUploadArea.addEventListener('click', () => {
                    imageUploadInput.click();
                });

                // Xử lý khi chọn file
                imageUploadInput.addEventListener('change', function() {
                    imagePreview.innerHTML = ''; // Xóa preview cũ
                    fileNameDisplay.textContent = ''; // Xóa tên file cũ

                    const file = this.files[0];
                    if (file) {
                        fileNameDisplay.textContent = file.name;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-32 h-32 rounded-md object-cover';
                            imagePreview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // LOGIC CŨ
            // Kiểm tra số lượng tồn kho để vô hiệu hóa nút tăng ban đầu
            let maxStock = {{ $product->so_luong }};
            let quantityInput = document.getElementById('quantity');
            let increaseButton = document.getElementById('increaseButton');
            if (parseInt(quantityInput.value) >= maxStock) {
                increaseButton.classList.add('disabled-button');
                increaseButton.disabled = true;
            }

            // Rút gọn/mở rộng mô tả
            let lineHeight = parseFloat(window.getComputedStyle(description).lineHeight);
            let maxHeight = lineHeight * 4;
            if (description.scrollHeight > maxHeight) {
                toggleButton.classList.remove('hidden');
            }

            toggleButton.addEventListener('click', function() {
                let isTruncated = description.classList.toggle('line-clamp-4');
                this.textContent = isTruncated ? 'Xem thêm' : 'Rút gọn';
            });

            // Xử lý modal thông báo giỏ hàng
            function showModal(message, isSuccess = true) {
                const modalContent = document.getElementById('modalContent');
                const modalIcon = document.getElementById('modalIcon');

                modalContent.innerHTML = `
            <p class="text-base font-semibold text-gray-800">${isSuccess ? 'Đã thêm vào giỏ hàng!' : 'Lỗi'}</p>
            <p class="text-sm text-gray-500">${message}</p>
            <a href="{{ route('cart.show') }}" class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">Xem giỏ hàng →</a>
        `;
                modalIcon.classList.remove(isSuccess ? 'bg-red-100' : 'bg-green-100');
                modalIcon.classList.add(isSuccess ? 'bg-green-100' : 'bg-red-100');
                modalIcon.querySelector('svg').classList.remove(isSuccess ? 'text-red-500' : 'text-green-500');
                modalIcon.querySelector('svg').innerHTML = isSuccess ?
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                modalIcon.querySelector('svg').classList.add(isSuccess ? 'text-green-500' : 'text-red-500');

                modal.classList.remove('hidden');
                modal.style.animation = 'slideIn 0.3s ease-out';
                timeoutId = setTimeout(hideModal, 5000);
            }

            function hideModal() {
                modal.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 280);
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
            }

            // Xử lý submit form thêm vào giỏ hàng
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    addToCartButton.disabled = true;
                    addToCartButton.classList.add('loading', 'disabled-button');
                    addToCartButton.innerHTML = ''; // Xóa nội dung để hiển thị icon xoay tròn
                    fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(response => response.json())
                        .then(data => {
                            addToCartButton.disabled = false;
                            addToCartButton.classList.remove('loading', 'disabled-button');
                            addToCartButton.innerHTML = 'Thêm vào giỏ hàng'; // Khôi phục text
                            if (data.success) {
                                showModal(data.message, true);
                            } else {
                                if (data.error.includes('đăng nhập hoặc đăng ký')) {
                                    showAuthModal();
                                } else {
                                    showModal(data.error, false);
                                }
                            }
                        })
                        .catch(() => {
                            addToCartButton.disabled = false;
                            addToCartButton.classList.remove('loading', 'disabled-button');
                            addToCartButton.innerHTML = 'Thêm vào giỏ hàng'; // Khôi phục text
                            showModal('Có lỗi xảy ra, vui lòng thử lại!', false);
                        });
                });
            }

            // Xử lý submit form mua ngay
            if (buyNowForm) {
                buyNowForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    buyNowButton.disabled = true;
                    buyNowButton.classList.add('loading', 'disabled-button');
                    buyNowButton.innerHTML = '';
                    fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(response => response.json())
                        .then(data => {
                            buyNowButton.disabled = false;
                            buyNowButton.classList.remove('loading', 'disabled-button');
                            buyNowButton.innerHTML = 'Mua ngay';
                            if (data.success) {
                                window.location.href = "{{ route('cart.show') }}";
                            } else {
                                if (data.error.includes('đăng nhập hoặc đăng ký')) {
                                    showAuthModal();
                                } else {
                                    showModal(data.error, false);
                                }
                            }
                        })
                        .catch(() => {
                            buyNowButton.disabled = false;
                            buyNowButton.classList.remove('loading', 'disabled-button');
                            buyNowButton.innerHTML = 'Mua ngay';
                            showModal('Có lỗi xảy ra, vui lòng thử lại!', false);
                        });
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', hideModal);
            }

            // Xử lý đóng modal đánh giá thành công
            const closeReviewSuccessModalBtn = document.getElementById('closeReviewSuccessModal');
            if (closeReviewSuccessModalBtn) {
                closeReviewSuccessModalBtn.addEventListener('click', hideReviewSuccessModal);
            }

            document.getElementById('authModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    hideAuthModal();
                }
            });
            // Kiểm tra tham số openReview trong URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('openReview') === 'true') {
                const reviewModal = document.getElementById('review-modal');
                if (reviewModal) {
                    reviewModal.classList.remove('hidden');
                    resetReviewForm(); // Reset form khi mở modal
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);

            // Nếu URL có tham số page hoặc filter thì cuộn xuống reviews
            if (urlParams.has('page') || urlParams.has('filter')) {
                const reviewsSection = document.getElementById('reviews-section');
                if (reviewsSection) {
                    reviewsSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    </script>

@endsection
