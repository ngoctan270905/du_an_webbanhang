<style>
    .user-menu-dropdown,
    .notification-dropdown {
        transform-origin: top right;
        transition: transform 0.2s ease-out, opacity 0.2s ease-out;
    }

    .user-menu-dropdown.hidden,
    .notification-dropdown.hidden {
        transform: scale(0.95);
        opacity: 0;
        display: none;
    }

    .user-menu-dropdown.show,
    .notification-dropdown.show {
        transform: scale(1);
        opacity: 1;
        display: block;
    }

    /* CSS để ẩn thanh cuộn */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<header class="bg-white shadow-md p-4 flex items-center justify-between z-10 sticky top-0">
    <button id="toggle-sidebar"
        class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 md:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <div class="flex items-center space-x-4 ml-auto">
        <div class="relative">
            <button id="notification-button" class="relative text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                    </path>
                </svg>
                <span
                    class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">10</span>
            </button>
            <div id="notification-dropdown"
                class="notification-dropdown hidden absolute right-0 mt-2 w-80 bg-gray-700 text-white rounded-md shadow-lg overflow-hidden z-20">
                <div class="p-4 border-b border-gray-600">
                    <h4 class="text-lg font-bold">Thông báo mới</h4>
                </div>
                <div class="max-h-80 overflow-y-auto hide-scrollbar">
                    <!-- Danh sách thông báo sẽ được render bằng JavaScript -->
                </div>
                <div class="p-2 text-center border-t border-gray-600">
                    <a href="#" class="text-sm font-medium text-blue-300 hover:text-blue-100">Xem tất cả</a>
                </div>
            </div>
        </div>
        <div class="relative">
            <button id="user-menu-button"
                class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                <img class="h-8 w-8 rounded-full object-cover"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="User avatar">
                <span class="hidden md:block">John Doe</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="user-menu-dropdown"
                class="user-menu-dropdown hidden absolute right-0 mt-2 w-48 bg-gray-700 text-white rounded-md shadow-lg py-1 focus:outline-none z-10">
                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-600">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Hồ sơ cá nhân</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-600">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2V7a5 5 0 00-5-5zM9 16.5a.5.5 0 001 0V15a1 1 0 00-2 0v1.5zm0-2.5a.5.5 0 001 0v-1a.5.5 0 00-1 0v1z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                        <span>Đổi mật khẩu</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-red-300 hover:bg-red-700 hover:text-white">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span>Đăng xuất</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBtn = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const userMenuBtn = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');
        const notificationList = document.querySelector('#notification-dropdown .max-h-80');

        // Dữ liệu mẫu thông báo
        const notifications = [{
                id: 1,
                title: 'Đơn hàng mới #12345 đã được tạo.',
                time: '5 phút trước'
            },
            {
                id: 2,
                title: 'Sản phẩm "iPhone 15 Pro Max" vừa được thêm vào.',
                time: '15 phút trước'
            },
            {
                id: 3,
                title: 'Khách hàng mới: Nguyễn Văn A đã đăng ký tài khoản.',
                time: '1 giờ trước'
            },
            {
                id: 4,
                title: 'Đơn hàng #12344 đã được giao thành công.',
                time: '2 giờ trước'
            },
            {
                id: 5,
                title: 'Báo cáo doanh thu tháng 8 đã sẵn sàng.',
                time: '3 giờ trước6 giờ trước'
            },
            {
                id: 6,
                title: 'Sản phẩm "Samsung Galaxy Z Fold5" còn dưới 5 sản phẩm.',
                time: 'Hôm qua'
            },
            {
                id: 7,
                title: 'Có 2 đánh giá mới cho sản phẩm "MacBook Air M3".',
                time: 'Hôm qua'
            },
            {
                id: 8,
                title: 'Hệ thống đã cập nhật thành công.',
                time: '2 ngày trước'
            },
            {
                id: 9,
                title: 'Khách hàng yêu cầu hỗ trợ về đơn hàng #12343.',
                time: '3 ngày trước'
            },
            {
                id: 10,
                title: 'Mã giảm giá mới "SALE20" đã được kích hoạt.',
                time: '4 ngày trước'
            }
        ];

        // Hàm render thông báo
        function renderNotifications() {
            notificationList.innerHTML = ''; // Xóa nội dung cũ
            notifications.forEach(notif => {
                const item = document.createElement('a');
                item.href = '#';
                item.classList.add('block', 'p-4', 'hover:bg-gray-600', 'border-b', 'border-gray-600',
                    'last:border-b-0');
                item.innerHTML = `
                <p class="text-sm font-medium">${notif.title}</p>
                <p class="text-xs text-gray-300 mt-1">${notif.time}</p>
            `;
                notificationList.appendChild(item);
            });
        }

        // Gọi hàm render khi tải trang
        renderNotifications();

        // Hàm đóng dropdown khác
        function closeOtherDropdown(currentDropdown) {
            const dropdowns = [notificationDropdown, userMenuDropdown];
            dropdowns.forEach(dropdown => {
                if (dropdown !== currentDropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    dropdown.classList.add('hidden');
                }
            });
        }

        // Chức năng dropdown menu
        function setupDropdown(button, dropdown) {
            if (button && dropdown) {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Đóng dropdown khác trước khi toggle dropdown hiện tại
                    closeOtherDropdown(dropdown);
                    dropdown.classList.toggle('hidden');
                    dropdown.classList.toggle('show');
                });

                document.addEventListener('click', (e) => {
                    if (!dropdown.contains(e.target) && !button.contains(e.target) && dropdown.classList
                        .contains('show')) {
                        dropdown.classList.remove('show');
                        dropdown.classList.add('hidden');
                    }
                });
            }
        }

        setupDropdown(notificationBtn, notificationDropdown);
        setupDropdown(userMenuBtn, userMenuDropdown);
    });
</script>
