<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('dao-tao.dashboard') }}" class="d-flex align-items-center">
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
                {{-- Môn học --}}
                <li class="sidebar-item {{ request()->is('dao-tao/mon-hoc*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.mon-hoc.index') }}" class='sidebar-link'>
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span>Môn học</span>
                    </a>
                </li>


                {{-- Quản lý Điểm --}}
                <li class="sidebar-item {{ request()->is('dao-tao/grades*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.grades.index') }}" class='sidebar-link'>
                        <i class="bi bi-card-checklist"></i>
                        <span>Quản lý Điểm</span>
                    </a>
                </li>
<!-- Ghí chsu quản lý đểm  -->

                {{-- Chương trình khung --}}
                <li class="sidebar-item {{ request()->is('dao-tao/chuong-trinh-khung*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.chuong-trinh-khung.index') }}" class='sidebar-link'>
                        <i class="bi bi-journal-text"></i>
                        <span>Chương trình khung</span>
                    </a>
                </li>

                {{-- Lớp học phần --}}
                <li class="sidebar-item {{ request()->is('dao-tao/lop-hoc-phan*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.lop-hoc-phan.index') }}" class='sidebar-link'>
                        <i class="bi bi-book-half"></i>
                        <span>Lớp học phần</span>
                    </a>
                </li>
                
                <li
                    class="sidebar-item has-sub {{ request()->is('dao-tao/khoa*') || request()->is('dao-tao/nganh*') || request()->is('dao-tao/chuyen-nganh*') || request()->is('dao-tao/trinh-do*') || request()->is('dao-tao/trang-thai*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-building"></i>
                        <span>Quản lý Danh mục</span>
                    </a>
                    <ul
                        class="submenu {{ request()->is('dao-tao/khoa*') || request()->is('dao-tao/nganh*') || request()->is('dao-tao/chuyen-nganh*') || request()->is('dao-tao/trinh-do*') || request()->is('dao-tao/trang-thai*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->is('dao-tao/khoa*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.khoa.index') }}">Khoa</a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/nganh*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.nganh.index') }}">Ngành</a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/chuyen-nganh*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.chuyen-nganh.index') }}">Chuyên ngành</a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/trinh-do*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.trinh-do.index') }}">Trình độ</a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/trang-thai*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.trang-thai-hoc-tap.index') }}">Trạng thái học tập</a>
                        </li>
                    </ul>
                </li>

                <li
                    class="sidebar-item has-sub {{ request()->is('dao-tao/khoa-hoc*') || request()->is('dao-tao/hoc-ky*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar3"></i>
                        <span>Quản lý Thời gian</span>
                    </a>
                    <ul
                        class="submenu {{ request()->is('dao-tao/khoa-hoc*') || request()->is('dao-tao/hoc-ky*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->is('dao-tao/khoa-hoc*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.khoa-hoc.index') }}">Khóa học</a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/hoc-ky*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.hoc-ky.index') }}">Học kỳ</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('dao-tao/phong-hoc*') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-door-open"></i>
                        <span>Quản lý Phòng học</span>
                    </a>

                    <ul class="submenu {{ request()->is('dao-tao/phong-hoc*') ? 'submenu-open' : '' }}">
                        <li class="submenu-item {{ request()->is('dao-tao/phong-hoc') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.phong-hoc.index') }}">
                                Danh sách phòng
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/phong-hoc/create') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.phong-hoc.create') }}">
                                Thêm phòng học
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="sidebar-item has-sub {{ request()->is('dao-tao/lich-hoc*') || request()->is('dao-tao/lich-thi*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar-check"></i>
                        <span>Quản lý Lịch</span>
                    </a>

                    <ul
                        class="submenu {{ request()->is('dao-tao/lich-hoc*') || request()->is('dao-tao/lich-thi*') ? 'active' : '' }}">

                        <li class="submenu-item {{ request()->is('dao-tao/lich-hoc*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.lich-hoc.index') }}">Lịch học</a>
                        </li>
                        <li class="submenu-item {{ request()->is('dao-tao/lich-thi*') ? 'active' : '' }}">
                            <a href="{{ route('dao-tao.lich-thi.index') }}">Lịch thi</a>
                        </li>
                    </ul>
                </li>

                {{-- Điểm danh --}}
                <li class="sidebar-item {{ request()->is('dao-tao/diem-danh*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.diem-danh.index') }}" class='sidebar-link'>
                        <i class="bi bi-check2-square"></i>
                        <span>Điểm danh</span>
                    </a>
                </li>

                {{-- Học phí --}}
                <li class="sidebar-item {{ request()->is('dao-tao/hoc-phi*') ? 'active' : '' }}">
                    <a href="{{ route('dao-tao.hoc-phi.index') }}" class='sidebar-link'>
                        <i class="bi bi-cash-coin"></i>
                        <span>Học phí</span>
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
