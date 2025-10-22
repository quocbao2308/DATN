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
