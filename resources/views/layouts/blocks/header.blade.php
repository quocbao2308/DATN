<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<!-- Top header: notifications & user info -->
<div class="top-header d-flex align-items-center justify-content-end px-3 py-2 bg-white shadow-sm mb-3">
    <div class="d-flex align-items-center gap-3">
        <!-- Notifications Dropdown -->
        <div class="dropdown">
            <a href="#" class="position-relative text-decoration-none" id="notificationDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-4 text-dark"></i>
                @php
                    $unreadCount = \App\Models\HeThong\ThongBao::where('tai_khoan_id', Auth::id())
                        ->where('da_doc', false)
                        ->count();
                @endphp
                @if ($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.65rem;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown"
                style="width: 350px; max-height: 400px; overflow-y: auto;">
                <li class="dropdown-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Thông báo</span>
                    @if ($unreadCount > 0)
                        <a href="#" class="text-primary text-decoration-none small"
                            onclick="event.preventDefault(); markAllAsRead();">
                            Đánh dấu đã đọc tất cả
                        </a>
                    @endif
                </li>
                <li>
                    <hr class="dropdown-divider my-1">
                </li>
                @php
                    $notifications = \App\Models\HeThong\ThongBao::where('tai_khoan_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
                @endphp
                @forelse($notifications as $notification)
                    <li>
                        <a class="dropdown-item {{ !$notification->da_doc ? 'bg-light' : '' }} py-2"
                            href="{{ $notification->lien_ket ?? '#' }}" onclick="markAsRead({{ $notification->id }})">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i
                                        class="bi {{ $notification->icon }} text-{{ $notification->loai == 'diem' ? 'success' : ($notification->loai == 'lich_hoc' ? 'info' : 'primary') }} fs-5"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="fw-semibold">{{ $notification->tieu_de }}</div>
                                    <small class="text-muted">{{ Str::limit($notification->noi_dung, 60) }}</small>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @if (!$notification->da_doc)
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-primary rounded-circle"
                                            style="width: 8px; height: 8px; padding: 0;"></span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-0">
                    </li>
                @empty
                    <li class="text-center py-4">
                        <i class="bi bi-bell-slash fs-1 text-muted"></i>
                        <p class="text-muted mb-0 mt-2">Không có thông báo mới</p>
                    </li>
                @endforelse
                @if ($notifications->count() > 0)
                    <li class="text-center py-2">
                        <a href="{{ route('notifications.index') }}" class="text-primary text-decoration-none small">
                            Xem tất cả thông báo
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <!-- User Dropdown -->
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

<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(() => {
            location.reload();
        });
    }
</script>
