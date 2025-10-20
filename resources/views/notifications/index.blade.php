@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Thông báo</h3>
                    <p class="text-subtitle text-muted">Tất cả thông báo của bạn</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Thông báo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bell me-2"></i>Danh sách thông báo
                    </h5>
                    @if ($notifications->where('da_doc', false)->count() > 0)
                        <button class="btn btn-sm btn-primary" onclick="markAllAsRead()">
                            <i class="bi bi-check-all me-1"></i>Đánh dấu đã đọc tất cả
                        </button>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($notifications as $notification)
                            <a href="{{ $notification->lien_ket ?? '#' }}"
                                class="list-group-item list-group-item-action {{ !$notification->da_doc ? 'bg-light' : '' }}"
                                onclick="markAsRead({{ $notification->id }})">
                                <div class="d-flex w-100">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle bg-{{ $notification->loai == 'diem' ? 'success' : ($notification->loai == 'lich_hoc' ? 'info' : 'primary') }} d-inline-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="bi {{ $notification->icon }} text-white fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <h6 class="mb-1 {{ !$notification->da_doc ? 'fw-bold' : '' }}">
                                                {{ $notification->tieu_de }}
                                            </h6>
                                            <div class="text-end">
                                                <small
                                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                @if (!$notification->da_doc)
                                                    <br>
                                                    <span class="badge bg-primary rounded-pill mt-1">Mới</span>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mb-1 text-muted">{{ $notification->noi_dung }}</p>
                                        <small class="text-muted">
                                            <i
                                                class="bi bi-clock me-1"></i>{{ $notification->created_at->format('d/m/Y H:i') }}
                                            <span class="mx-2">•</span>
                                            <span class="badge {{ $notification->badgeClass }}">
                                                {{ ucfirst($notification->loai ?? 'Hệ thống') }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-bell-slash fs-1 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">Không có thông báo nào</h5>
                                <p class="text-muted">Bạn chưa có thông báo nào</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if ($notifications->hasPages())
                    <div class="card-footer">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </section>
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
@endsection
