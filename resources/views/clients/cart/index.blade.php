
@extends('layouts.master')

@section('title', 'Giỏ hàng')

@section('content')
    <style>
        /* Animation for max quantity and stock limit modals */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        /* Animation for confirmation modals */
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

        /* Modal styling for max quantity and stock limit */
        .modal-slide {
            animation: slideIn 0.3s ease-out;
        }

        .modal-slide.closing {
            animation: slideOut 0.3s ease-out;
        }

        /* Modal styling for confirmation */
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
            z-index: 1000;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.hidden {
            display: none;
        }

        .modal-overlay.closing {
            opacity: 0;
        }

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

        /* Disabled button style */
        .increment-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Input quantity style */
        .quantity-input {
            text-align: center;
            border: none;
            outline: none;
            width: 3rem;
        }

        .quantity-input:focus {
            outline: none;
            box-shadow: none;
        }

        /* Ẩn mũi tên tăng/giảm trong Chrome, Safari, Edge */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Ẩn trong Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Loading style */
        .loading::after {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
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

    <div class="container mx-auto px-4 py-12 md:px-8 lg:px-16">
        <div class="text-3xl font-bold mb-4 text-gray-800">Giỏ hàng của bạn</div>

        @if (count($cart) > 0)
            <div class="flex flex-col lg:flex-row lg:space-x-8">
                <div class="lg:w-2/3 bg-white rounded-lg shadow-md p-6 mb-6 lg:mb-0">
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
                                        <div class="flex items-center justify-center border border-gray-300 rounded-lg w-fit mx-auto">
                                            <button class="px-3 py-1 text-lg text-gray-600 hover:bg-gray-100 rounded-l-lg decrement-btn"
                                                data-product-id="{{ $details['id'] }}"
                                                data-stock="{{ $details['stock'] }}">-</button>
                                            <input type="number"
                                                class="quantity-input w-12 text-center border-x border-gray-300 text-gray-800"
                                                value="{{ $details['quantity'] }}" data-product-id="{{ $details['id'] }}"
                                                data-stock="{{ $details['stock'] }}" min="1">
                                            <button class="px-3 py-1 text-lg text-gray-600 hover:bg-gray-100 rounded-r-lg increment-btn"
                                                data-product-id="{{ $details['id'] }}" data-stock="{{ $details['stock'] }}"
                                                {{ $details['quantity'] >= $details['stock'] ? 'disabled' : '' }}>+</button>
                                        </div>
                                    </td>
                                    <td data-label="Giá tiền" class="text-right">
                                        <span class="text-gray-600 price-col">{{ number_format($details['price'], 0, ',', '.') }}đ</span>
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

                <div class="lg:w-1/3 bg-white rounded-lg shadow-md p-6">
                    <div class="text-xl font-semibold mb-4 text-gray-800">Thông tin gói sản phẩm</div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng số sản phẩm:</span>
                            <span class="text-gray-800 font-medium total-items-display">{{ $totalItems }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính:</span>
                            <span class="text-gray-800 font-medium total-amount-display">{{ number_format($total, 0, ',', '.') }}đ</span>
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
                <a href="{{ url()->previous() }}"
                    class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                    Quay lại
                </a>
                <button onclick="showConfirmClear()"
                    class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition">
                    Xóa hết giỏ hàng
                </button>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600 mb-10">Giỏ hàng của bạn đang trống</p>
                <a href="{{ route('product.index') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600">
                    Tiếp tục mua sắm
                </a>
            </div>
        @endif

        {{-- Modal for max quantity reached (used for increment button) --}}
        <div id="maxQuantityModal" class="fixed top-6 right-6 z-50 hidden modal-slide">
            <div class="relative bg-white rounded-2xl shadow-2xl p-5 w-80 border border-gray-100">
                <button id="closeMaxQuantity" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-semibold text-gray-800">Thông báo</p>
                        <p class="text-sm text-gray-500">Bạn đã chọn đến số lượng tối đa có sẵn trong kho.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal for stock limit exceeded (used for manual input) --}}
        <div id="stockLimitModal" class="fixed top-6 right-6 z-50 hidden modal-slide">
            <div class="relative bg-white rounded-2xl shadow-2xl p-5 w-80 border border-gray-100">
                <button id="closeStockLimit" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-semibold text-gray-800">Thông báo</p>
                        <p id="stockLimitMessage" class="text-sm text-gray-500">Sản phẩm này chỉ còn <span id="stockLimitValue"></span> quyển.</p>
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

        {{-- Modal for cart changes --}}
        <div id="confirmChangesModal" class="modal-overlay hidden">
            <div class="modal-confirm bg-white rounded-lg shadow-xl p-6 w-96 max-w-full">
                <div class="text-lg font-semibold text-gray-800 mb-4">Có thay đổi trong giỏ hàng</div>
                <p id="changesMessage" class="text-gray-600 mb-6"></p>
                <ul id="changesList" class="list-disc pl-5 mb-6"></ul>
                <div class="flex justify-end space-x-4">
                    <button id="confirmChanges"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        Xác nhận cập nhật
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const maxQuantityModal = document.getElementById('maxQuantityModal');
        const closeMaxQuantityBtn = document.getElementById('closeMaxQuantity');
        const stockLimitModal = document.getElementById('stockLimitModal');
        const closeStockLimitBtn = document.getElementById('closeStockLimit');
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const confirmClearModal = document.getElementById('confirmClearModal');
        const confirmChangesModal = document.getElementById('confirmChangesModal');
        const cancelDeleteBtn = document.getElementById('cancelDelete');
        const confirmDeleteBtn = document.getElementById('confirmDelete');
        const cancelClearBtn = document.getElementById('cancelClear');
        const confirmClearBtn = document.getElementById('confirmClear');
        const confirmChangesBtn = document.getElementById('confirmChanges');
        const totalItemsDisplay = document.querySelector('.total-items-display');
        const totalAmountDisplay = document.querySelector('.total-amount-display');
        const cartTotalElement = document.getElementById('cart-total');
        const checkoutButton = document.getElementById('checkout-button');
        let productIdToDelete = null;
        let autoCloseTimeout = null;

        // Kiểm tra DOM elements
        if (!cartTotalElement) console.error('cartTotalElement (#cart-total) not found in DOM');
        if (!totalAmountDisplay) console.error('totalAmountDisplay (.total-amount-display) not found in DOM');
        if (!totalItemsDisplay) console.error('totalItemsDisplay (.total-items-display) not found in DOM');
        if (!confirmChangesModal) console.error('confirmChangesModal (#confirmChangesModal) not found in DOM');
        if (!confirmChangesBtn) console.error('confirmChangesBtn (#confirmChanges) not found in DOM');
        if (!stockLimitModal) console.error('stockLimitModal (#stockLimitModal) not found in DOM');
        if (!closeStockLimitBtn) console.error('closeStockLimitBtn (#closeStockLimit) not found in DOM');

        // Hàm debounce
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount).replace('₫', 'đ');
        }

        function showMaxQuantityModal() {
            console.log('Showing max quantity modal');
            if (maxQuantityModal) {
                maxQuantityModal.classList.remove('hidden');
                maxQuantityModal.classList.add('modal-slide');
                if (autoCloseTimeout) clearTimeout(autoCloseTimeout);
                autoCloseTimeout = setTimeout(closeMaxQuantityModal, 2000);
            } else {
                console.error('Cannot show modal: maxQuantityModal is null');
            }
        }

        function closeMaxQuantityModal() {
            console.log('Closing max quantity modal');
            if (maxQuantityModal) {
                maxQuantityModal.classList.add('closing');
                setTimeout(() => {
                    maxQuantityModal.classList.add('hidden');
                    maxQuantityModal.classList.remove('closing', 'modal-slide');
                }, 280);
                if (autoCloseTimeout) {
                    clearTimeout(autoCloseTimeout);
                    autoCloseTimeout = null;
                }
            }
        }

        function showStockLimitModal(stock) {
            console.log('Showing stock limit modal with stock:', stock);
            if (stockLimitModal) {
                const stockLimitValue = document.getElementById('stockLimitValue');
                if (stockLimitValue) {
                    stockLimitValue.textContent = stock;
                }
                stockLimitModal.classList.remove('hidden');
                stockLimitModal.classList.add('modal-slide');
                if (autoCloseTimeout) clearTimeout(autoCloseTimeout);
                autoCloseTimeout = setTimeout(closeStockLimitModal, 2000);
            } else {
                console.error('Cannot show modal: stockLimitModal is null');
            }
        }

        function closeStockLimitModal() {
            console.log('Closing stock limit modal');
            if (stockLimitModal) {
                stockLimitModal.classList.add('closing');
                setTimeout(() => {
                    stockLimitModal.classList.add('hidden');
                    stockLimitModal.classList.remove('closing', 'modal-slide');
                }, 280);
                if (autoCloseTimeout) {
                    clearTimeout(autoCloseTimeout);
                    autoCloseTimeout = null;
                }
            }
        }

        function closeConfirmModal(modal) {
            if (modal) {
                const modalContent = modal.querySelector('.modal-confirm');
                modal.classList.add('closing');
                if (modalContent) modalContent.classList.add('closing');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('closing');
                    if (modalContent) modalContent.classList.remove('closing');
                }, 280);
            }
        }

        if (closeMaxQuantityBtn) {
            closeMaxQuantityBtn.addEventListener('click', closeMaxQuantityModal);
        }

        if (closeStockLimitBtn) {
            closeStockLimitBtn.addEventListener('click', closeStockLimitModal);
        }

        window.showConfirmDelete = function(productId) {
            productIdToDelete = productId;
            if (confirmDeleteModal) {
                confirmDeleteModal.classList.remove('hidden');
            } else {
                console.error('Cannot show confirm delete modal: confirmDeleteModal is null');
            }
        };

        window.showConfirmClear = function() {
            if (confirmClearModal) {
                confirmClearModal.classList.remove('hidden');
            } else {
                console.error('Cannot show confirm clear modal: confirmClearModal is null');
            }
        };

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
                            alert(data.error || 'Có lỗi khi xóa giỏ hàng, vui lòng thử lại!');
                        }
                    })
                    .catch(error => {
                        console.error('Error clearing cart:', error);
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    });
                closeConfirmModal(confirmClearModal);
            });
        }

        if (confirmChangesBtn) {
            confirmChangesBtn.addEventListener('click', () => {
                const updatedItems = JSON.parse(confirmChangesBtn.dataset.updatedItems || '[]');
                console.log('Sending apply changes request with data:', updatedItems);

                fetch('{{ route('cart.apply_changes') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            updated_items: updatedItems
                        })
                    })
                    .then(response => {
                        console.log('Apply changes response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Apply changes response data:', data);
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.error || 'Có lỗi khi cập nhật giỏ hàng, vui lòng thử lại!');
                        }
                    })
                    .catch(error => {
                        console.error('Error applying changes:', error);
                        alert('Có lỗi xảy ra: ' + error.message + '. Vui lòng thử lại!');
                    });
                closeConfirmModal(confirmChangesModal);
            });
        }

        function updateSummary() {
            let newTotal = 0;
            let newTotalItems = 0;
            let isCartValid = true;

            const rows = Array.from(document.querySelectorAll('.cart-table tbody tr'));
            rows.forEach(row => {
                const quantityInput = row.querySelector('.quantity-input');
                const priceElement = row.querySelector('.price-col');
                const subtotalElement = row.querySelector('.subtotal-col');
                const incrementBtn = row.querySelector('.increment-btn');

                const quantity = parseInt(quantityInput.value) || 0;
                const priceText = priceElement.textContent.replace(/\D/g, '');
                const price = parseInt(priceText) || 0;
                const stock = parseInt(quantityInput.dataset.stock) || 0;

                console.log(`Row: ${row.dataset.id}, Quantity: ${quantity}, Stock: ${stock}, Price: ${price}`);

                if (quantity <= 0 || quantity > stock) {
                    isCartValid = false;
                }

                if (quantity >= stock) {
                    incrementBtn.disabled = true;
                } else {
                    incrementBtn.disabled = false;
                }

                const subtotal = quantity * price;
                newTotal += subtotal;
                newTotalItems += quantity;
                subtotalElement.textContent = formatCurrency(subtotal);
            });

            totalItemsDisplay.textContent = newTotalItems;
            totalAmountDisplay.textContent = formatCurrency(newTotal);
            cartTotalElement.textContent = formatCurrency(newTotal);

            console.log('updateSummary - Total Items:', newTotalItems, 'Total Amount:', formatCurrency(newTotal));

            if (isCartValid) {
                checkoutButton.disabled = false;
                checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                checkoutButton.disabled = true;
                checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        const updateCart = debounce(function(productId, newQuantity, incrementBtn, quantityInput) {
            console.log(`Updating cart: Product ID ${productId}, Quantity ${newQuantity}`);
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
                .then(response => {
                    console.log('Update cart response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Update cart response data:', data);
                    if (data.success) {
                        quantityInput.value = newQuantity;
                        if (newQuantity >= parseInt(quantityInput.dataset.stock)) {
                            showMaxQuantityModal();
                            incrementBtn.disabled = true;
                        } else {
                            incrementBtn.disabled = false;
                        }

                        const row = quantityInput.closest('tr');
                        const priceElement = row.querySelector('.price-col');
                        const subtotalElement = row.querySelector('.subtotal-col');
                        const priceText = priceElement.textContent.replace(/\D/g, '');
                        const price = parseInt(priceText) || 0;
                        const subtotal = price * newQuantity;
                        subtotalElement.textContent = formatCurrency(subtotal);

                        const rows = Array.from(document.querySelectorAll('.cart-table tbody tr'));
                        totalItemsDisplay.textContent = rows.length > 0 ? rows.reduce((sum, row) => {
                            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
                            return sum + quantity;
                        }, 0) : 0;

                        const cartTotalValue = parseInt(data.cart_total) || 0;
                        console.log('Parsed cart_total:', cartTotalValue);
                        if (isNaN(cartTotalValue)) {
                            console.error('Invalid cart_total value:', data.cart_total);
                            throw new Error('Giá trị cart_total không hợp lệ');
                        }
                        totalAmountDisplay.textContent = formatCurrency(cartTotalValue);
                        cartTotalElement.textContent = formatCurrency(cartTotalValue);
                        console.log('Updated cartTotalElement:', cartTotalElement.textContent);

                        // Kiểm tra thay đổi giỏ hàng sau khi cập nhật
                        console.log('Calling validateCart after update');
                        fetch('{{ route('cart.validate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => {
                            console.log('Validate cart response status:', response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Validate cart response data:', JSON.stringify(data, null, 2));
                            if (!data.success) {
                                console.error('Validate cart failed:', data.error);
                                alert(data.error || 'Có lỗi khi kiểm tra giỏ hàng, vui lòng thử lại!');
                                return;
                            }

                            if (data.has_changes) {
                                console.log('Changes detected, showing confirmChangesModal');
                                const changesMessage = document.getElementById('changesMessage');
                                const changesList = document.getElementById('changesList');
                                if (changesMessage && changesList && confirmChangesModal && confirmChangesBtn) {
                                    changesMessage.textContent = data.message || 'Giỏ hàng của bạn có một số thay đổi.';
                                    changesList.innerHTML = data.changes ? data.changes.map(change => `<li>${change.message}</li>`).join('') : '';
                                    confirmChangesBtn.dataset.updatedItems = JSON.stringify(data.updated_items || []);
                                    confirmChangesModal.classList.remove('hidden');
                                    console.log('confirmChangesModal should be visible now');
                                } else {
                                    console.error('Modal elements missing:', {
                                        changesMessage: !!changesMessage,
                                        changesList: !!changesList,
                                        confirmChangesModal: !!confirmChangesModal,
                                        confirmChangesBtn: !!confirmChangesBtn
                                    });
                                    alert('Lỗi giao diện: Không tìm thấy modal xác nhận thay đổi!');
                                }
                            } else {
                                console.log('No changes detected in cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error validating cart after update:', error);
                            alert('Có lỗi xảy ra khi kiểm tra giỏ hàng: ' + error.message + '. Vui lòng thử lại!');
                        });

                        updateSummary();
                    } else {
                        console.error('Server error:', data.error);
                        alert(data.error || 'Lỗi từ server, vui lòng thử lại!');
                        quantityInput.value = quantityInput.dataset.previousQuantity || 1;
                        updateSummary();
                    }
                })
                .catch(error => {
                    console.error('AJAX error:', error.message);
                    alert('Có lỗi xảy ra: ' + error.message + '. Vui lòng thử lại!');
                    quantityInput.value = quantityInput.dataset.previousQuantity || 1;
                    updateSummary();
                });
        }, 500);

        document.querySelectorAll('.increment-btn, .decrement-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const stock = parseInt(this.dataset.stock);
                const quantityInput = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                let currentQuantity = parseInt(quantityInput.value);
                let newQuantity = this.classList.contains('increment-btn') ? currentQuantity + 1 : currentQuantity - 1;

                console.log('Stock:', stock, 'Current Quantity:', currentQuantity, 'New Quantity:', newQuantity);

                if (newQuantity < 1) {
                    alert('Số lượng phải lớn hơn 0!');
                    return;
                }

                if (newQuantity > stock) {
                    showMaxQuantityModal();
                    quantityInput.value = currentQuantity;
                    return;
                }

                quantityInput.dataset.previousQuantity = currentQuantity;
                updateCart(productId, newQuantity, this, quantityInput);
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.dataset.previousQuantity = this.value;
            });

            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                const stock = parseInt(this.dataset.stock);
                const incrementBtn = this.closest('td').querySelector('.increment-btn');
                let newQuantity = parseInt(this.value);

                console.log('Input change: Product ID:', productId, 'New Quantity:', newQuantity, 'Stock:', stock);

                if (isNaN(newQuantity) || newQuantity < 1) {
                    alert('Số lượng phải lớn hơn 0!');
                    this.value = this.dataset.previousQuantity || 1;
                    updateSummary();
                    return;
                }

                if (newQuantity > stock) {
                    showStockLimitModal(stock);
                    this.value = this.dataset.previousQuantity || 1;
                    updateSummary();
                    return;
                }

                updateCart(productId, newQuantity, incrementBtn, this);
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
                .then(response => {
                    console.log('Remove cart response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Remove cart response data:', data);
                    if (data.success) {
                        const rowToRemove = document.querySelector(`tr[data-id="${productId}"]`);
                        if (rowToRemove) {
                            rowToRemove.remove();
                            const cartTotalValue = parseInt(data.cart_total) || 0;
                            totalAmountDisplay.textContent = formatCurrency(cartTotalValue);
                            cartTotalElement.textContent = formatCurrency(cartTotalValue);
                            console.log('removeFromCart - Updated cartTotalElement:', cartTotalElement.textContent);
                            updateSummary();
                        }
                        if (!document.querySelector('.cart-table tbody tr')) {
                            window.location.reload();
                        }
                    } else {
                        alert(data.error || 'Có lỗi khi xóa sản phẩm, vui lòng thử lại!');
                    }
                })
                .catch(error => {
                    console.error('Error removing from cart:', error);
                    alert('Có lỗi xảy ra: ' + error.message + '. Vui lòng thử lại!');
                });
        }

        const handleCheckout = debounce(function() {
            console.log('Sending validate cart request');
            fetch('{{ route('cart.validate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    console.log('Validate cart response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    checkoutButton.disabled = false;
                    checkoutButton.classList.remove('loading');
                    checkoutButton.innerHTML = 'Tiến hành đặt hàng';

                    console.log('Validate cart response data:', JSON.stringify(data, null, 2));
                    if (!data.success) {
                        alert(data.error || 'Có lỗi khi kiểm tra giỏ hàng, vui lòng thử lại!');
                        return;
                    }

                    if (data.has_changes) {
                        console.log('Changes detected in checkout, showing confirmChangesModal');
                        const changesMessage = document.getElementById('changesMessage');
                        const changesList = document.getElementById('changesList');
                        if (changesMessage && changesList && confirmChangesModal && confirmChangesBtn) {
                            changesMessage.textContent = data.message || 'Giỏ hàng của bạn có một số thay đổi.';
                            changesList.innerHTML = data.changes ? data.changes.map(change => `<li>${change.message}</li>`).join('') : '';
                            confirmChangesBtn.dataset.updatedItems = JSON.stringify(data.updated_items || []);
                            confirmChangesModal.classList.remove('hidden');
                            console.log('confirmChangesModal should be visible now');
                        } else {
                            console.error('Modal elements missing:', {
                                changesMessage: !!changesMessage,
                                changesList: !!changesList,
                                confirmChangesModal: !!confirmChangesModal,
                                confirmChangesBtn: !!confirmChangesBtn
                            });
                            alert('Lỗi giao diện: Không tìm thấy modal xác nhận thay đổi!');
                        }
                    } else {
                        console.log('No changes detected in cart, redirecting to checkout');
                        window.location.href = '{{ route('order.checkout') }}';
                    }
                })
                .catch(error => {
                    console.error('Error validating cart:', error);
                    alert('Có lỗi xảy ra: ' + error.message + '. Vui lòng thử lại!');
                    checkoutButton.disabled = false;
                    checkoutButton.classList.remove('loading');
                    checkoutButton.innerHTML = 'Tiến hành đặt hàng';
                });
        }, 1000);

        if (checkoutButton) {
            checkoutButton.addEventListener('click', function() {
                if (this.disabled) return;
                this.disabled = true;
                this.classList.add('loading');
                this.innerHTML = '<i class="fas fa-spinner text-xl mr-3 align-middle"></i> Đang xử lý...';
                handleCheckout();
            });
        }

        updateSummary();
    });
</script>
@endsection