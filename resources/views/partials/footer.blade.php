<footer>
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="space-y-4">
                    <h3 class="text-3xl font-bold text-yellow-400 font-serif tracking-wide">BOOKSTORE</h3>
                    <p class="text-sm leading-relaxed">
                        Chuyên cung cấp các sản phẩm sách chất lượng cao, mang đến trải nghiệm đọc tuyệt vời cho khách
                        hàng.
                    </p>
                    <p class="text-sm">Địa chỉ: 123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh</p>
                    <p class="text-sm">Giờ làm việc: 8:00 - 20:00 (Thứ 2 - Chủ Nhật)</p>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.774-1.63 1.574V12h2.77l-.44 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12c0 5.244 3.824 9.588 8.841 9.948v-6.963H7.747v-2.985h2.994V8.586c0-2.96 1.81-4.57 4.437-4.57 1.258 0 2.339.222 2.654.321v3.01h-1.789c-1.408 0-1.681.668-1.681 1.643V12h3.344l-.546 2.985h-2.798v6.963C20.176 21.588 24 17.244 24 12c0-5.523-4.477-10-10-10z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2c2.716 0 3.056.01 4.122.06c1.066.05 1.792.203 2.427.478a4.989 4.989 0 011.772 1.153 4.99 4.99 0 011.153 1.772c.275.635.428 1.36.478 2.427.05 1.066.06 1.406.06 4.122s-.01 3.056-.06 4.122c-.05 1.066-.203 1.792-.478 2.427a4.99 4.99 0 01-1.153 1.772 4.99 4.99 0 01-1.772 1.153c-.635.275-1.36.428-2.427.478-1.066.05-1.406.06-4.122.06s-3.056-.01-4.122-.06c-1.066-.05-1.792-.203-2.427-.478a4.99 4.99 0 01-1.772-1.153 4.99 4.99 0 01-1.153-1.772c-.275-.635-.428-1.36-.478-2.427-.05-1.066-.06-1.406-.06-4.122s.01-3.056.06-4.122c.05-1.066.203-1.792.478-2.427a4.99 4.99 0 011.153-1.772 4.99 4.99 0 011.772-1.153c.635-.275 1.36-.428 2.427-.478C8.944 2.01 9.284 2 12 2zm0 4a6 6 0 100 12 6 6 0 000-12zm0 2a4 4 0 110 8 4 4 0 010-8zm-4 4.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Liên kết nhanh</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition-colors">Trang
                                chủ</a></li>
                        <li><a href="{{ route('product.index') }}" class="hover:text-yellow-400 transition-colors">Sản
                                phẩm</a></li>
                        <li><a href="{{ route('posts.list') }}" class="hover:text-yellow-400 transition-colors">Bài
                                viết</a></li>
                        <li><a href="{{ route('contact.form') }}"
                                class="hover:text-yellow-400 transition-colors">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Chính sách bảo hành</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Hướng dẫn mua hàng</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Hỗ trợ khách hàng</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Câu hỏi thường gặp</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Chính sách đổi trả</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Hướng dẫn đặt hàng</a>
                        </li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Hệ thống cửa hàng</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Liên hệ & Nhận tin</h4>
                    <p class="text-sm">Địa chỉ: 123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh</p>
                    <p class="text-sm mt-2">Điện thoại: +84 123 456 789</p>
                    <p class="text-sm mt-2">Email: support@bookstore.vn</p>
                    <div class="mt-6">
                        <p class="text-sm mb-2">Đăng ký để nhận thông tin ưu đãi:</p>
                        <form action="#" method="post" class="flex">
                            @csrf
                            <input type="email" name="email" placeholder="Nhập email của bạn"
                                class="flex-1 py-2 px-4 rounded-l-md focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-gray-700 text-white placeholder-gray-400">
                            <button type="submit"
                                class="bg-yellow-400 text-gray-900 font-bold py-2 px-4 rounded-r-md hover:bg-yellow-500 transition-colors">
                                Gửi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-xs text-gray-500">
                <p>&copy; 2025 BOOKSTORE. All Rights Reserved.</p>
            </div>
        </div>
    </footer>