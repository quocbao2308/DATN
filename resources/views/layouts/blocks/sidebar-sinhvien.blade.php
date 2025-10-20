<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('sinh-vien.dashboard') }}" class="d-flex align-items-center">
                        <h4 class="mb-0 text-primary fw-bold">S-MIS</h4>
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Sinh Viên</li>

                <li class="sidebar-item {{ request()->is('sinh-vien/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('sinh-vien.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Thông tin học tập</li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar-week"></i>
                        <span>Thời khóa biểu</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-clipboard-check"></i>
                        <span>Kết quả học tập</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-book"></i>
                        <span>Đăng ký môn học</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cash-coin"></i>
                        <span>Học phí</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
