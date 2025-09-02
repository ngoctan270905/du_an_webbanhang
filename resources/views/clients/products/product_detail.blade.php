@extends('layouts.master')

@section('title', $product->ten_san_pham)

@section('content')
    <style>
        /* CSS để ẩn thanh cuộn cho các trình duyệt cụ thể */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Dành cho Firefox */
        .scrollbar-none {
            scrollbar-width: none;
        }

        /* CSS cho rút gọn mô tả với hiệu ứng làm mờ */
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
            /* Giả sử line-height là 1.5em, điều chỉnh nếu cần */
        }

        .line-clamp-4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2em;
            /* Chiều cao vùng làm mờ */
            background: linear-gradient(to bottom, transparent, white);
            pointer-events: none;
        }

        /* Centered button */
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
    </style>

    <div class="container mx-auto py-4 md:py-10 px-8 md:px-36">
        @if (session('success'))
            <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif
        <div class="md:flex md:space-x-8">
            <!-- Phần hình ảnh và nút hành động -->
            <div class="md:w-2/5 lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
                    <div class="mb-4">
                        <img src="{{ Storage::url($product->hinh_anh) }}" alt="{{ $product->ten_san_pham }}"
                            class="w-full rounded-lg">
                    </div>
                    <div class="flex space-x-4 mb-4">
                        <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="w-full bg-white text-red-500 border border-red-500 py-3 rounded-lg font-semibold hover:bg-red-50">
                                Thêm vào giỏ hàng
                            </button>
                        </form>
                        <form action="" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-600">
                                Mua ngay
                            </button>
                        </form>
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
                                Chính sách khách sỉ: Ưu đãi khi mua số lượng lớn
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần thông tin sản phẩm -->
            <div class="md:w-3/5 lg:w-2/3 mt-8 md:mt-0 md:h-[85vh] md:overflow-y-auto md:sticky md:top-4 scrollbar-hide">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 mb-5">
                    <p class="text-4xl font-bold">{{ $product->ten_san_pham }}</p>

                    <div class="mt-5 text-lg">
                        <!-- Hàng 1: Nhà cung cấp - Tác giả -->
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <p>
                                Nhà cung cấp: <strong>{{ $product->publisher }}</strong>
                            </p>
                            <p>
                                Tác giả: <strong>{{ $product->author }}</strong>
                            </p>
                        </div>

                        <!-- Hàng 2: Nhà xuất bản - Hình thức bìa -->
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <p>
                                Nhà xuất bản: <strong>{{ $product->publisher }}</strong>
                            </p>
                            <p>
                                Hình thức bìa: <strong>Bìa mềm</strong>
                            </p>
                        </div>

                        <!-- Rating + Đã bán -->
                        <div class="flex items-center mt-4">
                            <span class="text-yellow-400">
                                @for ($i = 0; $i < 5; $i++)
                                    ★
                                @endfor
                            </span>
                            <span class="ml-1 text-lg text-gray-500">({{ $reviews->count() }} đánh giá)</span>
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
                            <button class="px-4 py-2 text-lg text-gray-600 hover:bg-gray-100 rounded-l-lg"
                                onclick="updateQuantity(-1)">-</button>
                            <input type="text" id="quantity" name="quantity" value="1"
                                class="w-12 text-lg text-center border-x border-gray-300 outline-none" readonly>
                            <button class="px-4 py-2 text-lg text-gray-600 hover:bg-gray-100 rounded-r-lg"
                                onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Thông tin chi tiết -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 mb-4">
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

                <!-- Mô tả sản phẩm -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 mb-4">
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

        <!-- Đánh giá sản phẩm -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow-md border border-gray-300">
            <div class="text-xl font-semibold mb-4">Đánh giá sản phẩm</div>

            <!-- Hiển thị thông báo thành công -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form gửi đánh giá -->
            <div class="mb-6">
                <div class="text-lg font-medium mb-3">Gửi đánh giá của bạn</div>

                @auth
                    <form action="{{ route('client.reviews.store', ['id' => $product->id]) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        <input type="hidden" name="id_san_pham" value="{{ $product->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Điểm đánh giá</label>
                            <div class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer"
                                        id="rating-{{ $i }}" required>
                                    <label for="rating-{{ $i }}"
                                        class="text-2xl cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300">
                                        ★
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="noi_dung" class="block text-sm font-medium text-gray-700 mb-1">Nhận xét</label>
                            <textarea name="noi_dung" id="noi_dung" rows="4"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..." required></textarea>
                            @error('noi_dung')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Gửi đánh giá
                        </button>
                    </form>
                @else
                    <p class="text-gray-500">Vui lòng <a href="{{ route('login') }}"
                            class="text-blue-600 hover:underline">đăng nhập</a> để gửi đánh giá.</p>
                @endauth
            </div>

            <!-- Danh sách đánh giá -->
            <div>
                <div class="text-lg font-medium mb-3">Các đánh giá từ khách hàng</div>
                @if ($reviews->isEmpty())
                    <p class="text-gray-500">Chưa có đánh giá nào cho sản phẩm này.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($reviews as $review)
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
                                        @endfor
                                    </div>
                                    <span
                                        class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="font-medium text-gray-800">{{ $review->user_name }}</p>
                                <p class="text-gray-600 mt-1">{!! nl2br(e($review->noi_dung)) !!}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript cho chức năng số lượng và mô tả -->
    <script>
        // Cập nhật số lượng
        function updateQuantity(change) {
            let input = document.getElementById('quantity');
            let value = parseInt(input.value);
            if (value + change >= 1 && value + change <= {{ $product->so_luong }}) {
                input.value = value + change;
            }
        }

        // Rút gọn/mở rộng mô tả
        document.addEventListener('DOMContentLoaded', function() {
            let description = document.getElementById('description');
            let toggleButton = document.getElementById('toggleDescription');

            // Kiểm tra chiều cao nội dung để quyết định hiển thị nút
            let lineHeight = parseInt(window.getComputedStyle(description).lineHeight);
            let maxHeight = lineHeight * 4; // 4 dòng
            if (description.scrollHeight > maxHeight) {
                toggleButton.classList.remove('hidden'); // Hiển thị nút nếu nội dung dài
            }

            toggleButton.addEventListener('click', function() {
                let isTruncated = description.classList.toggle('line-clamp-4');
                this.textContent = isTruncated ? 'Xem thêm' : 'Rút gọn';
            });
        });
    </script>


    <!-- Thay thế phần Modal cũ bằng Modal mới -->
    <!-- Modal thông báo -->
    <div id="cartModal" 
     class="fixed top-6 right-6 z-50 hidden animate-slideIn">
    <div class="relative bg-white rounded-2xl shadow-2xl p-5 w-80 border border-gray-100">
        <!-- Nút đóng -->
        <button id="closeModal" 
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Icon + Nội dung -->
        <div class="flex items-start space-x-3">
            <!-- Icon thành công -->
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Nội dung -->
            <div class="flex-1">
                <p class="text-base font-semibold text-gray-800">
                    Đã thêm vào giỏ hàng!
                </p>
                <p class="text-sm text-gray-500">Bạn có thể tiếp tục mua sắm hoặc kiểm tra giỏ hàng.</p>

                <!-- Nút xem giỏ -->
                <a href="{{ route('cart.show') }}" 
                   class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
                    Xem giỏ hàng →
                </a>
            </div>
        </div>
    </div>
</div>


    <!-- Cập nhật JavaScript cho modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cartModal');
            const closeBtn = document.getElementById('closeModal');
            const addToCartForm = document.getElementById('addToCartForm');
            let timeoutId;

            // Hàm hiển thị modal với animation
            function showModal() {
                modal.classList.remove('hidden');
                modal.style.animation = 'slideIn 0.3s ease-out';

                // Tự động ẩn sau 3 giây
                timeoutId = setTimeout(() => {
                    hideModal();
                }, 3000);
            }

            // Hàm ẩn modal với animation
            function hideModal() {
                modal.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 280);

                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
            }

            // Xử lý submit form
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(response => response.text())
                        .then(() => {
                            showModal();
                        });
                });
            }

            // Xử lý nút đóng
            if (closeBtn) {
                closeBtn.addEventListener('click', hideModal);
            }
        });
    </script>

    <!-- Thêm CSS cho animation -->
    <style>
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
    </style>
@endsection
