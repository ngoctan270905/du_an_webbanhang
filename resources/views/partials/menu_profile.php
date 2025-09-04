<aside class="col-lg-3">
    <div class="offcanvas-lg offcanvas-start pe-lg-0 pe-xl-4" id="accountSidebar">

        <div class="d-flex align-items-center">
            <div class="position-relative">
               
                <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-0 border"
                    style="transform: translate(30%, 30%); cursor: pointer;" data-bs-toggle="modal"
                    data-bs-target="#chooseAvatarModal">
                    <i class="bi bi-camera-fill text-muted fs-10 "></i>
                </div>
            </div>
        </div>

       
    </div>
    <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
        <nav class="list-group list-group-borderless">
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="">
                <i class="ci-shopping-bag fs-base opacity-75 me-2"></i>
                Đơn hàng của tôi
                <!-- <span class="badge bg-primary rounded-pill ms-auto">1</span> -->
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="">
                <i class="ci-heart fs-base opacity-75 me-2"></i>
                Danh sách yêu thích
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center" href="account-payment.html">
                <i class="ci-credit-card fs-base opacity-75 me-2"></i>
                Phương thức thanh toán
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="">
                <i class="ci-star fs-base opacity-75 me-2"></i>
                Đánh giá của tôi
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="">
                <i class="ci-star fs-base opacity-75 me-2"></i>
                Lịch sử điểm thưởng
            </a>
        </nav>
        <h6 class="pt-4 ps-2 ms-1">Manage account</h6>
        <nav class="list-group list-group-borderless">
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="{{ route('profile.edit') }}">
                <i class="ci-user fs-base opacity-75 me-2"></i>
                Thông tin cá nhân
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="{{ route('addresses.index') }}">
                <i class="ci-map-pin fs-base opacity-75 me-2"></i>
                Địa chỉ
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="account-notifications.html">
                <i class="ci-bell fs-base opacity-75 mt-1 me-2"></i>
                Thông báo
            </a>
        </nav>
        <h6 class="pt-4 ps-2 ms-1">Dịch vụ khách hàng</h6>
        <nav class="list-group list-group-borderless">
            <a class="list-group-item list-group-item-action d-flex align-items-center" href="help-topics-v1.html">
                <i class="ci-help-circle fs-base opacity-75 me-2"></i>
                Trung tâm trợ giúp
            </a>
            <a class="list-group-item list-group-item-action d-flex align-items-center"
                href="terms-and-conditions.html">
                <i class="ci-info fs-base opacity-75 me-2"></i>
                Điều khoản và điều kiện
            </a>
        </nav>
        <nav class="list-group list-group-borderless pt-3">
            <a href="#" class="list-group-item list-group-item-action"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ci-log-out fs-base opacity-75 me-2"></i>
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
    </div>
</aside>
