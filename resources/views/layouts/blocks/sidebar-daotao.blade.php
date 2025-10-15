<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('dao-tao.dashboard') }}"><img src="{{ asset('assets/images/logo/logo.png') }}"
                            alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Đào Tạo</li>

                <li class="sidebar-item {{ request()->is('dao-tao/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Chức năng Đào Tạo</li>

                {{-- Sinh viên --}}
                <li class="sidebar-item {{ request()->is('dao-tao/sinh-vien*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.sinh-vien.index') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Sinh viên</span>
                    </a>
                </li>

                {{-- Giảng viên --}}
                <li class="sidebar-item {{ request()->is('dao-tao/giang-vien*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.giang-vien.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Giảng viên</span>
                    </a>
                </li>
                         {{-- Lớp học phần --}}
                <li class="sidebar-item {{ request()->is('dao-tao/lop-hoc-phan*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.lop-hoc-phan.index') }}" class='sidebar-link'>
                        <i class="bi bi-book-half"></i>
                        <span>Lớp học phần</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-journal-text"></i>
                        <span>Quản lý Chương trình</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar-check"></i>
                        <span>Lịch học</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Báo cáo</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
