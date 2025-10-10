<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('giang-vien.dashboard') }}"><img src="{{ asset('assets/images/logo/logo.png') }}"
                            alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Giảng Viên</li>

                <li class="sidebar-item {{ request()->is('giang-vien/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('giang-vien.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Chức năng Giảng dạy</li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-journal-bookmark"></i>
                        <span>Lớp học phần</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-check2-square"></i>
                        <span>Điểm danh</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-pencil-square"></i>
                        <span>Nhập điểm</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar3"></i>
                        <span>Lịch giảng dạy</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
