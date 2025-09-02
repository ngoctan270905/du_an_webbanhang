@extends('layouts.master')

@section('title', 'Giỏ hàng')

@section('content')
    <style>
        /* Animation for modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        /* Faded overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
            transition: opacity 0.3s ease;
        }

        /* Class to hide modal with JavaScript */
        .modal-overlay.hidden {
            display: none;
        }

        /* Confirmation modal */
        .modal-confirm {
            animation: fadeIn 0.3s ease-out;
        }

        .modal-confirm.closing {
            animation: fadeOut 0.3s ease-out;
        }

        /* Responsive table */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d1d5db;
        }

        .cart-table th,
        .cart-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #d1d5db;
        }

        .cart-table th {
            font-weight: 600;
            color: #1f2937;
        }

        .cart-table td {
            vertical-align: middle;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .cart-table thead {
                display: none;
            }

            .cart-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                padding: 1rem;
            }

            .cart-table td {
                display: block;
                text-align: right;
                position: relative;
                padding-left: 50%;
            }

            .cart-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                font-weight: 600;
                color: #1f2937;
            }

            .cart-table td.product-col {
                display: flex;
                align-items: center;
                text-align: left;
                padding-left: 1rem;
            }

            .cart-table td.product-col:before {
                display: none;
            }
        }
    </style>

    <div class="container mx-auto px-4 py-8 md:px-8 lg:px-16">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Giỏ hàng của bạn</h1>

        @if (count($cart) > 0)
            <div class="flex flex-col lg:flex-row lg:space-x-8">
                <div class="lg:w-2/3 bg-white rounded-lg shadow-md p-6 mb-6 lg:mb-0 border border-gray-300">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th class="w-1/3">Sản phẩm</th>
                                <th class="w-1/6 text-center">Số lượng</th>
                                <th class="w-1/6 text-right">Giá tiền</th>
                                <th class="w-1/6 text-right">Tổng tiền</th>
                                <th class="w-1/6 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $isValidCart = true;
                                $total = 0;
                                $totalItems = 0;
                            @endphp
                            @foreach ($cart as $details)
                                @php
                                    $subtotal = $details['price'] * $details['quantity'];
                                    $total += $subtotal;
                                    $totalItems += $details['quantity'];
                                    if ($details['quantity'] <= 0 || $details['quantity'] > $details['stock']) {
                                        $isValidCart = false;
                                    }
                                @endphp
                                <tr data-id="{{ $details['id'] }}">
                                    <td data-label="Sản phẩm" class="product-col">
                                        <div class="flex items-center">
                                            <img src="{{ Storage::url($details['image']) }}" alt="{{ $details['name'] }}"
                                                class="w-16 h-16 object-cover rounded">
                                            <span class="ml-4 text-gray-800 font-medium">{{ $details['name'] }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Số lượng" class="text-center">
                                        <div
                                            class="flex items-center justify-center border border-gray-300 rounded-lg w-fit mx-auto">
                                            <button
                                                class="px-3 py-1 text-lg text-gray-600 hover:bg-gray-100 rounded-l-lg decrement-btn"
                                                data-product-id="{{ $details['id'] }}"
                                                data-stock="{{ $details['stock'] }}">-</button>
                                            <input type="text"
                                                class="w-12 text-center border-x border-gray-300 outline-none text-gray-800 quantity-input"
                                                value="{{ $details['quantity'] }}" readonly
                                                data-product-id="{{ $details['id'] }}">
                                            <button
                                                class="px-3 py-1 text-lg text-gray-600 hover:bg-gray-100 rounded-r-lg increment-btn"
                                                data-product-id="{{ $details['id'] }}"
                                                data-stock="{{ $details['stock'] }}">+</button>
                                        </div>
                                    </td>
                                    <td data-label="Giá tiền" class="text-right">
                                        <span
                                            class="text-gray-600 price-col">{{ number_format($details['price'], 0, ',', '.') }}đ</span>
                                    </td>
                                    <td data-label="Tổng tiền" class="text-right">
                                        <span class="text-gray-800 font-medium subtotal-col">
                                            {{ number_format($subtotal, 0, ',', '.') }}đ
                                        </span>
                                    </td>
                                    <td data-label="Thao tác" class="text-center">
                                        <button onclick="showConfirmDelete('{{ $details['id'] }}')"
                                            class="border border-red-500 text-red-500 px-3 py-1 rounded-lg hover:bg-red-50 transition">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="lg:w-1/3 bg-white rounded-lg shadow-md p-6 border border-gray-300">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Thông tin gói sản phẩm</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng số sản phẩm:</span>
                            <span class="text-gray-800 font-medium total-items-display">{{ $totalItems }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính:</span>
                            <span
                                class="text-gray-800 font-medium total-amount-display">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí vận chuyển:</span>
                            <span class="text-gray-800 font-medium">0đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Giảm giá:</span>
                            <span class="text-gray-800 font-medium">0đ</span>
                        </div>
                        <div class="flex justify-between border-t pt-3">
                            <span class="text-gray-600 font-semibold">Thành tiền:</span>
                            <span id="cart-total" class="text-lg font-bold text-gray-800">
                                {{ number_format($total, 0, ',', '.') }}đ
                            </span>
                        </div>
                    </div>
                    <button id="checkout-button"
                        class="w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-600 transition mt-4 {{ $isValidCart ? '' : 'opacity-50 cursor-not-allowed' }}"
                        @if (!$isValidCart) disabled @endif>
                        Tiến hành đặt hàng
                    </button>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('product.index') }}"
                    class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                    Tiếp tục mua sắm
                </a>
                <button onclick="showConfirmClear()"
                    class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition">
                    Xóa hết giỏ hàng
                </button>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 mb-4">Giỏ hàng của bạn đang trống</p>
                <a href="{{ route('product.index') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600">
                    Tiếp tục mua sắm
                </a>
            </div>
        @endif

        {{-- Modal for success/error messages --}}
        <div id="cartModal" class="fixed top-6 right-6 z-50 hidden">
            <div class="relative bg-white rounded-2xl shadow-2xl p-5 w-80 border border-gray-100">
                <button id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div id="modalIcon" class="flex items-center justify-center w-10 h-10 rounded-full">
                            {{-- Icon will be dynamically updated --}}
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div id="modalContent" class="flex-1">
                        {{-- Content will be dynamically updated --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirmation modal for single item deletion --}}
        <div id="confirmDeleteModal" class="modal-overlay hidden">
            <div class="modal-confirm bg-white rounded-lg shadow-xl p-6 w-96 max-w-full">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Xác nhận xóa</h3>
                <p class="text-gray-600 mb-6">Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?</p>
                <div class="flex justify-end space-x-4">
                    <button id="cancelDelete"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Hủy
                    </button>
                    <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>

        {{-- Confirmation modal for clearing all items --}}
        <div id="confirmClearModal" class="modal-overlay hidden">
            <div class="modal-confirm bg-white rounded-lg shadow-xl p-6 w-96 max-w-full">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Xác nhận xóa</h3>
                <p class="text-gray-600 mb-6">Bạn có muốn xóa tất cả sản phẩm trong giỏ hàng không?</p>
                <div class="flex justify-end space-x-4">
                    <button id="cancelClear"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Hủy
                    </button>
                    <button id="confirmClear"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cartModal');
            const closeModalBtn = document.getElementById('closeModal');
            const modalContent = document.getElementById('modalContent');
            const modalIcon = document.getElementById('modalIcon');
            const confirmDeleteModal = document.getElementById('confirmDeleteModal');
            const confirmClearModal = document.getElementById('confirmClearModal');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            const cancelClearBtn = document.getElementById('cancelClear');
            const confirmClearBtn = document.getElementById('confirmClear');
            const totalItemsDisplay = document.querySelector('.total-items-display');
            const totalAmountDisplay = document.querySelector('.total-amount-display');
            const cartTotalElement = document.getElementById('cart-total');
            const checkoutButton = document.getElementById('checkout-button');
            let productIdToDelete = null;
            let timeoutId;

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(amount);
            }

            function showModal(message, isSuccess = true) {
                clearTimeout(timeoutId); // Clear any existing timeout
                modalContent.innerHTML = `
                    <p class="text-base font-semibold text-gray-800">${isSuccess ? 'Thành công' : 'Lỗi'}</p>
                    <p class="text-sm text-gray-500">${message}</p>
                    ${isSuccess ? '<a href="{{ route('cart.show') }}" class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">Xem giỏ hàng →</a>' : ''}
                `;

                modalIcon.className =
                    `flex items-center justify-center w-10 h-10 rounded-full ${isSuccess ? 'bg-green-100' : 'bg-red-100'}`;
                const iconSvg = modalIcon.querySelector('svg');
                iconSvg.className = `h-6 w-6 ${isSuccess ? 'text-green-500' : 'text-red-500'}`;
                iconSvg.innerHTML = isSuccess ?
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';

                modal.classList.remove('hidden');
                modal.style.animation = 'fadeIn 0.3s ease-out';
                timeoutId = setTimeout(hideModal, 3000);
            }

            function hideModal() {
                modal.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.style.animation = '';
                }, 280);
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', hideModal);
            }

            window.showConfirmDelete = function(productId) {
                productIdToDelete = productId;
                confirmDeleteModal.classList.remove('hidden');
            };

            window.showConfirmClear = function() {
                confirmClearModal.classList.remove('hidden');
            };

            function closeConfirmModal(modal) {
                modal.classList.add('closing');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('closing');
                }, 280);
            }

            if (cancelDeleteBtn) {
                cancelDeleteBtn.addEventListener('click', () => closeConfirmModal(confirmDeleteModal));
            }

            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', () => {
                    if (productIdToDelete) {
                        removeFromCart(productIdToDelete);
                    }
                    closeConfirmModal(confirmDeleteModal);
                });
            }

            if (cancelClearBtn) {
                cancelClearBtn.addEventListener('click', () => closeConfirmModal(confirmClearModal));
            }

            if (confirmClearBtn) {
                confirmClearBtn.addEventListener('click', () => {
                    fetch('{{ route('cart.clear') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                showModal(data.error, false);
                            }
                        })
                        .catch(() => {
                            showModal('Có lỗi xảy ra, vui lòng thử lại!', false);
                        });
                    closeConfirmModal(confirmClearModal);
                });
            }

            function updateSummary() {
                let newTotal = 0;
                let newTotalItems = 0;
                let isCartValid = true;

                document.querySelectorAll('.cart-table tbody tr').forEach(row => {
                    const quantityInput = row.querySelector('.quantity-input');
                    const priceElement = row.querySelector('.price-col');
                    const subtotalElement = row.querySelector('.subtotal-col');

                    const quantity = parseInt(quantityInput.value);
                    const priceText = priceElement.textContent.replace(/\D/g, ''); // Remove non-digits
                    const price = parseInt(priceText);
                    const stock = parseInt(quantityInput.dataset.stock);

                    if (quantity <= 0 || quantity > stock) {
                        isCartValid = false;
                    }

                    const subtotal = quantity * price;
                    newTotal += subtotal;
                    newTotalItems += quantity;
                    subtotalElement.textContent = formatCurrency(subtotal);
                });

                totalItemsDisplay.textContent = newTotalItems;
                totalAmountDisplay.textContent = formatCurrency(newTotal);
                cartTotalElement.textContent = formatCurrency(newTotal);

                // Update checkout button state
                if (isCartValid) {
                    checkoutButton.disabled = false;
                    checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    checkoutButton.disabled = true;
                    checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            document.querySelectorAll('.increment-btn, .decrement-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const stock = parseInt(this.dataset.stock);
                    const quantityInput = document.querySelector(
                        `.quantity-input[data-product-id="${productId}"]`);
                    let currentQuantity = parseInt(quantityInput.value);
                    let newQuantity = this.classList.contains('increment-btn') ? currentQuantity +
                        1 : currentQuantity - 1;

                    if (newQuantity < 1) {
                        showModal('Số lượng phải lớn hơn 0!', false);
                        return;
                    }
                    if (newQuantity > stock) {
                        showModal(`Số lượng vượt quá tồn kho. Sản phẩm này chỉ còn ${stock} quyển.`,
                            false);
                        return;
                    }

                    fetch('{{ route('cart.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: newQuantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                quantityInput.value = newQuantity;
                                updateSummary();
                                showModal(data.message, true);
                            } else {
                                showModal(data.error, false);
                            }
                        })
                        .catch(() => {
                            showModal('Có lỗi xảy ra, vui lòng thử lại!', false);
                        });
                });
            });

            function removeFromCart(productId) {
                fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const rowToRemove = document.querySelector(`tr[data-id="${productId}"]`);
                            if (rowToRemove) {
                                rowToRemove.remove();
                                updateSummary();
                            }
                            if (!document.querySelector('.cart-table tbody tr')) {
                                window.location.reload();
                            } else {
                                showModal(data.message, true);
                            }
                        } else {
                            showModal(data.error, false);
                        }
                    })
                    .catch(() => {
                        showModal('Có lỗi xảy ra, vui lòng thử lại!', false);
                    });
            }

            // Initial summary update
            updateSummary();
        });
    </script>
@endsection
