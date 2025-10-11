<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<!-- Top header: user info only -->
<div class="top-header d-flex align-items-center justify-content-end px-3 py-2 bg-white shadow-sm mb-3">
    <div class="d-flex align-items-center">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                @php
                    $currentUser = Auth::user();
                    $userAvatar = null;

                    // Tìm ảnh đại diện từ bảng tương ứng
                    if ($currentUser) {
                        $admin = DB::table('admin')->where('email', $currentUser->email)->first();
                        if ($admin && $admin->anh_dai_dien) {
                            $userAvatar = $admin->anh_dai_dien;
                        } else {
                            $daoTao = DB::table('dao_tao')->where('email', $currentUser->email)->first();
                            if ($daoTao && $daoTao->anh_dai_dien) {
                                $userAvatar = $daoTao->anh_dai_dien;
                            } else {
                                $giangVien = DB::table('giang_vien')->where('email', $currentUser->email)->first();
                                if ($giangVien && $giangVien->anh_dai_dien) {
                                    $userAvatar = $giangVien->anh_dai_dien;
                                } else {
                                    $sinhVien = DB::table('sinh_vien')->where('email', $currentUser->email)->first();
                                    if ($sinhVien && $sinhVien->anh_dai_dien) {
                                        $userAvatar = $sinhVien->anh_dai_dien;
                                    }
                                }
                            }
                        }
                    }
                @endphp

                @if ($userAvatar)
                    <img src="{{ asset('storage/' . $userAvatar) }}" alt="user" width="36" height="36"
                        class="rounded-circle me-2" style="object-fit: cover;">
                @else
                    <div class="rounded-circle me-2 d-inline-flex align-items-center justify-content-center"
                        style="width: 36px; height: 36px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 14px; font-weight: bold;">
                        {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                    </div>
                @endif
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
