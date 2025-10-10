<header class="mb-3" style="padding-bottom: 4rem;">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>


<!-- Top header: search, notifications, avatar (added) -->
<div class="top-header d-flex align-items-center justify-content-between px-3 py-2 bg-white shadow-sm mb-3">
    <div class="d-flex align-items-center">

        <form class="d-none d-sm-flex align-items-center" style="min-width:320px;">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search or type command...">
            </div>
        </form>
    </div>

    <div class="d-flex align-items-center">
        <button class="btn btn-link text-decoration-none text-muted me-2 d-none d-md-inline" title="Toggle dark mode">
            <i class="bi bi-moon"></i>
        </button>
        <button class="btn btn-link position-relative text-muted me-2" title="Notifications">
            <i class="bi bi-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </button>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/images/faces/1.jpg') }}" alt="user" width="36" height="36"
                    class="rounded-circle me-2">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <div class="dropdown-item-text">
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2"></i>Hồ sơ cá nhân
                    </a></li>
                <li><a class="dropdown-item" href="#">
                        <i class="bi bi-gear me-2"></i>Cài đặt
                    </a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
