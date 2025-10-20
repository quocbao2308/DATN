@extends('layouts.layout-admin')

@section('title', 'Chi tiết Thông báo')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="mb-1">Chi tiết Thông báo</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Thông báo</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Notification Content Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $notification->tieu_de }}</h5>
                            <div class="d-flex gap-2">
                                @if ($notification->loai == 'thong_tin')
                                    <span class="badge bg-info">Thông tin</span>
                                @elseif($notification->loai == 'canh_bao')
                                    <span class="badge bg-warning">Cảnh báo</span>
                                @else
                                    <span class="badge bg-danger">Quan trọng</span>
                                @endif

                                @if ($notification->da_doc)
                                    <span class="badge bg-success">Đã đọc</span>
                                @else
                                    <span class="badge bg-warning">Chưa đọc</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="notification-content">
                            {!! nl2br(e($notification->noi_dung)) !!}
                        </div>

                        @if ($notification->lien_ket)
                            <div class="mt-3">
                                <a href="{{ $notification->lien_ket }}" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="bi bi-link-45deg"></i> Xem chi tiết
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="bi bi-person"></i>
                                <strong>Người gửi:</strong> {{ $notification->nguoiTao->name ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 text-md-end">
                                <i class="bi bi-clock"></i>
                                <strong>Thời gian:</strong> {{ $notification->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recipients Card -->
                @if ($isBatch)
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-people-fill"></i> Danh sách Người nhận ({{ $recipients->count() }})
                                </h5>
                                <div>
                                    <span class="badge bg-success">{{ $recipients->where('da_doc', true)->count() }} đã
                                        đọc</span>
                                    <span class="badge bg-warning">{{ $recipients->where('da_doc', false)->count() }} chưa
                                        đọc</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Người nhận</th>
                                            <th>Email</th>
                                            <th width="120">Trạng thái</th>
                                            <th width="150">Thời gian đọc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recipients as $index => $recipient)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <i class="bi bi-person-circle"></i>
                                                    {{ $recipient->nguoiNhan->name ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <small
                                                        class="text-muted">{{ $recipient->nguoiNhan->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    @if ($recipient->da_doc)
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle"></i> Đã đọc
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="bi bi-envelope"></i> Chưa đọc
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($recipient->da_doc)
                                                        <small
                                                            class="text-muted">{{ $recipient->updated_at->diffForHumans() }}</small>
                                                    @else
                                                        <small class="text-muted">-</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Thông báo này được gửi cho {{ $recipients->count() }} người vào lúc
                                {{ $notification->created_at->format('d/m/Y H:i:s') }}
                            </small>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Thông tin người nhận</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Đối tượng:</strong>
                                        @if ($notification->vai_tro_nhan == 'all')
                                            <span class="badge bg-primary">Tất cả</span>
                                        @elseif($notification->vai_tro_nhan == 'admin')
                                            <span class="badge bg-dark">Admin</span>
                                        @elseif($notification->vai_tro_nhan == 'dao_tao')
                                            <span class="badge bg-success">Đào tạo</span>
                                        @elseif($notification->vai_tro_nhan == 'giang_vien')
                                            <span class="badge bg-info">Giảng viên</span>
                                        @elseif($notification->vai_tro_nhan == 'sinh_vien')
                                            <span class="badge bg-warning">Sinh viên</span>
                                        @else
                                            <span class="badge bg-secondary">Cá nhân</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Người nhận:</strong> {{ $notification->nguoiNhan->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            @if ($notification->nguoiNhan)
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted small">
                                            <i class="bi bi-envelope"></i> {{ $notification->nguoiNhan->email }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted small">
                                            <i class="bi bi-calendar"></i>
                                            Đã nhận: {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Actions Card -->
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Thao tác</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Quay lại danh sách
                            </a>

                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông báo này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Xóa thông báo
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Thông tin thêm</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <strong>ID:</strong> #{{ $notification->id }}
                            </li>
                            <li class="mb-2">
                                <strong>Ngày tạo:</strong><br>
                                <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i:s') }}</small>
                            </li>
                            <li class="mb-2">
                                <strong>Cập nhật:</strong><br>
                                <small class="text-muted">{{ $notification->updated_at->format('d/m/Y H:i:s') }}</small>
                            </li>
                            @if ($notification->da_doc && $notification->updated_at != $notification->created_at)
                                <li class="mb-2">
                                    <strong>Đã đọc lúc:</strong><br>
                                    <small class="text-muted">{{ $notification->updated_at->diffForHumans() }}</small>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .notification-content {
                font-size: 1rem;
                line-height: 1.6;
                color: #333;
            }
        </style>
    @endpush
@endsection
