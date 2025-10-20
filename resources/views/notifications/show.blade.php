@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Chi tiết Thông báo</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Thông báo</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Notification Content Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">{{ $notification->tieu_de }}</h4>
                                <div>
                                    @if ($notification->loai == 'thong_tin')
                                        <span class="badge bg-info">Thông tin</span>
                                    @elseif($notification->loai == 'canh_bao')
                                        <span class="badge bg-warning text-dark">Cảnh báo</span>
                                    @else
                                        <span class="badge bg-danger">Quan trọng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="notification-content mb-4">
                                {!! nl2br(e($notification->noi_dung)) !!}
                            </div>

                            @if ($notification->lien_ket)
                                <div class="alert alert-info">
                                    <i class="bi bi-link-45deg me-2"></i>
                                    <strong>Liên kết:</strong>
                                    <a href="{{ $notification->lien_ket }}" target="_blank" class="alert-link">
                                        {{ $notification->lien_ket }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-light">
                            <div class="row text-muted small">
                                <div class="col-md-6">
                                    <i class="bi bi-clock me-1"></i>
                                    <strong>Thời gian:</strong> {{ $notification->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <i class="bi bi-{{ $notification->da_doc ? 'envelope-open' : 'envelope' }} me-1"></i>
                                    <strong>Trạng thái:</strong>
                                    @if ($notification->da_doc)
                                        <span class="text-success">Đã đọc</span>
                                    @else
                                        <span class="text-warning">Chưa đọc</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>

                        @if (!$notification->da_doc)
                            <button type="button" class="btn btn-primary"
                                onclick="markAsReadAndReload({{ $notification->id }})">
                                <i class="bi bi-check-circle me-1"></i> Đánh dấu đã đọc
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Info Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3">
                                    <strong class="d-block mb-1">Loại thông báo</strong>
                                    @if ($notification->loai == 'thong_tin')
                                        <span class="badge bg-info">
                                            <i class="bi bi-info-circle me-1"></i> Thông tin
                                        </span>
                                    @elseif($notification->loai == 'canh_bao')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Cảnh báo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-circle me-1"></i> Quan trọng
                                        </span>
                                    @endif
                                </li>

                                <li class="mb-3">
                                    <strong class="d-block mb-1">Ngày nhận</strong>
                                    <small class="text-muted">
                                        {{ $notification->created_at->format('l, d/m/Y') }}<br>
                                        {{ $notification->created_at->format('H:i:s') }}
                                    </small>
                                </li>

                                <li class="mb-3">
                                    <strong class="d-block mb-1">Thời gian trước</strong>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </li>

                                @if ($notification->nguoiTao)
                                    <li class="mb-3">
                                        <strong class="d-block mb-1">Người gửi</strong>
                                        <small class="text-muted">{{ $notification->nguoiTao->name }}</small>
                                    </li>
                                @endif

                                <li class="mb-0">
                                    <strong class="d-block mb-1">Trạng thái</strong>
                                    @if ($notification->da_doc)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i> Đã đọc
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-envelope me-1"></i> Chưa đọc
                                        </span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function markAsReadAndReload(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi đánh dấu đã đọc');
                });
        }
    </script>
@endsection
