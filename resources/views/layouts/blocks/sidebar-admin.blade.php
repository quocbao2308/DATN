<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center">
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
                <li class="sidebar-title">Menu Admin</li>

                <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Quản lý Hệ thống</li>

                <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Quản lý Người dùng</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('admin/roles*') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}" class='sidebar-link'>
                        <i class="bi bi-shield-check"></i>
                        <span>Quản lý Vai trò</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                    <a href="{{ route('admin.permissions.index') }}" class='sidebar-link'>
                        <i class="bi bi-key-fill"></i>
                        <span>Quản lý Quyền</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('admin/notifications*') ? 'active' : '' }}">
                    <a href="{{ route('admin.notifications.index') }}" class='sidebar-link'>
                        <i class="bi bi-bell-fill"></i>
                        <span>Quản lý Thông báo</span>
                    </a>
                </li>

                <li
                    class="sidebar-item has-sub {{ request()->is('admin/khoa*') || request()->is('admin/nganh*') || request()->is('admin/chuyen-nganh*') || request()->is('admin/trinh-do*') || request()->is('admin/trang-thai*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-building"></i>
                        <span>Quản lý Danh mục</span>
                    </a>
                    <ul
                        class="submenu {{ request()->is('admin/khoa*') || request()->is('admin/nganh*') || request()->is('admin/chuyen-nganh*') || request()->is('admin/trinh-do*') || request()->is('admin/trang-thai*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->is('admin/khoa*') ? 'active' : '' }}">
                            <a href="{{ route('admin.khoa.index') }}">Khoa</a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/nganh*') ? 'active' : '' }}">
                            <a href="{{ route('admin.nganh.index') }}">Ngành</a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/chuyen-nganh*') ? 'active' : '' }}">
                            <a href="{{ route('admin.chuyen-nganh.index') }}">Chuyên ngành</a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/trinh-do*') ? 'active' : '' }}">
                            <a href="{{ route('admin.trinh-do.index') }}">Trình độ</a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/trang-thai*') ? 'active' : '' }}">
                            <a href="{{ route('admin.trang-thai-hoc-tap.index') }}">Trạng thái học tập</a>
                        </li>
                    </ul>
                </li>

                <li
                    class="sidebar-item has-sub {{ request()->is('admin/khoa-hoc*') || request()->is('admin/hoc-ky*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar3"></i>
                        <span>Quản lý Thời gian</span>
                    </a>
                    <ul
                        class="submenu {{ request()->is('admin/khoa-hoc*') || request()->is('admin/hoc-ky*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->is('admin/khoa-hoc*') ? 'active' : '' }}">
                            <a href="{{ route('admin.khoa-hoc.index') }}">Khóa học</a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/hoc-ky*') ? 'active' : '' }}">
                            <a href="{{ route('admin.hoc-ky.index') }}">Học kỳ</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('admin/phong-hoc*') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-door-open"></i>
                        <span>Quản lý Phòng học</span>
                    </a>

                    <ul class="submenu {{ request()->is('admin/phong-hoc*') ? 'submenu-open' : '' }}">
                        <li class="submenu-item {{ request()->is('admin/phong-hoc') ? 'active' : '' }}">
                            <a href="{{ route('admin.phong-hoc.index') }}">
                                Danh sách phòng
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->is('admin/phong-hoc/create') ? 'active' : '' }}">
                            <a href="{{ route('admin.phong-hoc.create') }}">
                                Thêm phòng học
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Test Thông báo -->
                <li class="sidebar-item {{ request()->is('admin/test-notifications*') ? 'active' : '' }}">
                    <a href="{{ route('admin.test-notifications.index') }}" class='sidebar-link'>
                        <i class="bi bi-bug"></i>
                        <span>🧪 Test Thông báo</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>
