import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const toggleSidebarBtn = document.getElementById('toggle-sidebar');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    // Chức năng toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
        mainContent.classList.toggle('md:ml-[230px]');
    }

    if (toggleSidebarBtn && sidebar && mainContent) {
        toggleSidebarBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSidebar();
        });
    }

    if (closeSidebarBtn && sidebar && mainContent) {
        closeSidebarBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSidebar();
        });
    }

    // Xử lý responsive
    function handleResize() {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            mainContent.classList.add('md:ml-[230px]');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            mainContent.classList.remove('md:ml-[230px]');
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Gọi ngay khi tải trang
});
