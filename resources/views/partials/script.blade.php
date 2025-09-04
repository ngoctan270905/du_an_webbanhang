<script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notification-button');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const userMenuBtn = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            const notificationList = document.querySelector('#notification-dropdown .max-h-80');
            const modal = document.getElementById('notification-modal');
            const closeModalBtn = document.getElementById('close-modal-button');
            const modalTitle = document.getElementById('modal-title');
            const modalContent = document.getElementById('modal-content');

            // Sample notification data
            const notifications = [{
                    id: 1,
                    title: 'Đơn hàng mới #S12345 đã được tạo.',
                    time: '5 phút trước',
                    detail: 'Chi tiết: Đơn hàng S12345 bao gồm sách "Nhà giả kim" và "Đắc nhân tâm".'
                },
                {
                    id: 2,
                    title: 'Sách "Nhà giả kim" vừa được thêm vào giỏ hàng.',
                    time: '15 phút trước',
                    detail: 'Chi tiết: Sản phẩm "Nhà giả kim" đã được thêm vào giỏ hàng của bạn.'
                },
                {
                    id: 3,
                    title: 'Khách hàng mới: Trần Văn C đã đăng ký.',
                    time: '1 giờ trước',
                    detail: 'Chi tiết: Khách hàng mới Trần Văn C đã hoàn tất đăng ký tài khoản.'
                },
                {
                    id: 4,
                    title: 'Đơn hàng #S12344 đã được giao thành công.',
                    time: '2 giờ trước',
                    detail: 'Chi tiết: Đơn hàng S12344 đã được giao đến địa chỉ của khách hàng và hoàn tất.'
                },
                {
                    id: 5,
                    title: 'Bạn có một tin nhắn mới từ bộ phận hỗ trợ.',
                    time: '3 giờ trước',
                    detail: 'Chi tiết: Một tin nhắn mới đã đến từ bộ phận hỗ trợ khách hàng.'
                }
            ];

            // Function to render notifications
            function renderNotifications() {
                notificationList.innerHTML = '';
                if (notifications.length === 0) {
                    notificationList.innerHTML =
                        `<p class="p-4 text-center text-gray-400">Không có thông báo mới.</p>`;
                    return;
                }
                notifications.forEach(notif => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('block', 'p-4', 'hover:bg-gray-600', 'border-b', 'border-gray-600',
                        'last:border-b-0');
                    item.innerHTML = `
                <p class="text-sm font-medium">${notif.title}</p>
                <p class="text-xs text-gray-300 mt-1">${notif.time}</p>
            `;
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        showModal(notif);
                    });
                    notificationList.appendChild(item);
                });
            }

            // Function to show the modal with content
            function showModal(notifData) {
                if (modal && modalTitle && modalContent) {
                    modalTitle.textContent = notifData.title;
                    modalContent.innerHTML =
                        `<p>${notifData.detail}</p><p class="mt-2 text-sm text-gray-400">Thời gian: ${notifData.time}</p>`;
                    modal.classList.remove('hidden');
                }
            }

            // Function to hide the modal
            function hideModal() {
                if (modal) {
                    modal.classList.add('hidden');
                }
            }

            // Event listener to close the modal
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', hideModal);
            }

            // Close modal when clicking outside
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        hideModal();
                    }
                });
            }

            // Function to close other dropdowns
            function closeOtherDropdown(currentDropdown) {
                const dropdowns = [notificationDropdown, userMenuDropdown];
                dropdowns.forEach(dropdown => {
                    if (dropdown && dropdown !== currentDropdown && dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Dropdown menu functionality
            function setupDropdown(button, dropdown) {
                if (button && dropdown) {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
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

            // Initial function calls
            renderNotifications();
            setupDropdown(notificationBtn, notificationDropdown);
            setupDropdown(userMenuBtn, userMenuDropdown);
        });
    </script>