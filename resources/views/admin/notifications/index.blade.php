@extends('layouts.layout-admin')

@section('title', 'Quản lý Thông báo')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Quản lý Thông báo</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thông báo</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tạo thông báo mới
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Tổng thông báo</p>
                                <h3 class="mb-0">{{ $stats['total'] }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-bell-fill text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Chưa đọc</p>
                                <h3 class="mb-0">{{ $stats['unread'] }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-envelope-fill text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Đã đọc</p>
                                <h3 class="mb-0">{{ $stats['read'] }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-envelope-check-fill text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Tỷ lệ đọc</p>
                                <h3 class="mb-0">
                                    {{ $stats['total'] > 0 ? round(($stats['read'] / $stats['total']) * 100) : 0 }}%</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-graph-up text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.notifications.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Tìm kiếm theo tiêu đề, nội dung..." value="{{ $search }}">
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">-- Tất cả loại --</option>
                                <option value="thong_tin" {{ $type == 'thong_tin' ? 'selected' : '' }}>Thông tin</option>
                                <option value="canh_bao" {{ $type == 'canh_bao' ? 'selected' : '' }}>Cảnh báo</option>
                                <option value="quan_trong" {{ $type == 'quan_trong' ? 'selected' : '' }}>Quan trọng
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="role" class="form-select">
                                <option value="">-- Tất cả vai trò --</option>
                                <option value="all" {{ $role == 'all' ? 'selected' : '' }}>Tất cả</option>
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="dao_tao" {{ $role == 'dao_tao' ? 'selected' : '' }}>Đào tạo</option>
                                <option value="giang_vien" {{ $role == 'giang_vien' ? 'selected' : '' }}>Giảng viên
                                </option>
                                <option value="sinh_vien" {{ $role == 'sinh_vien' ? 'selected' : '' }}>Sinh viên</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifications Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách Thông báo</h5>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="deleteSelected" style="display: none;">
                        <i class="bi bi-trash"></i> Xóa đã chọn
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($notifications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Tiêu đề</th>
                                    <th>Loại</th>
                                    <th>Đối tượng</th>
                                    <th>Người tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày gửi</th>
                                    <th width="100">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input notification-checkbox"
                                                value="{{ $notification->id }}">
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ Str::limit($notification->tieu_de, 50) }}</strong>
                                                @if ($notification->is_batch ?? false)
                                                    <span class="badge bg-primary ms-2">
                                                        <i class="bi bi-people-fill"></i>
                                                        {{ $notification->recipient_count }} người
                                                    </span>
                                                @endif
                                                <br>
                                                <small
                                                    class="text-muted">{{ Str::limit($notification->noi_dung, 80) }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($notification->loai == 'thong_tin')
                                                <span class="badge bg-info">Thông tin</span>
                                            @elseif($notification->loai == 'canh_bao')
                                                <span class="badge bg-warning">Cảnh báo</span>
                                            @else
                                                <span class="badge bg-danger">Quan trọng</span>
                                            @endif
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
                                            {{ $notification->nguoiTao->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($notification->is_batch ?? false)
                                                <span class="badge bg-info">
                                                    {{ $notification->read_count }}/{{ $notification->recipient_count }}
                                                    đã đọc
                                                </span>
                                            @else
                                                @if ($notification->da_doc)
                                                    <span class="badge bg-success">Đã đọc</span>
                                                @else
                                                    <span class="badge bg-warning">Chưa đọc</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                                    class="btn btn-outline-info" title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông báo này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Không có thông báo nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Select all checkboxes
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.notification-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleDeleteButton();
            });

            // Toggle delete button
            document.querySelectorAll('.notification-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', toggleDeleteButton);
            });

            function toggleDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.notification-checkbox:checked');
                const deleteBtn = document.getElementById('deleteSelected');
                deleteBtn.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
            }

            // Delete selected notifications
            document.getElementById('deleteSelected')?.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.notification-checkbox:checked');
                const ids = Array.from(checkedBoxes).map(cb => cb.value);

                if (ids.length === 0) return;

                if (!confirm(`Bạn có chắc chắn muốn xóa ${ids.length} thông báo đã chọn?`)) return;

                fetch('{{ route('admin.notifications.destroyMultiple') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            notification_ids: ids
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xóa thông báo');
                    });
            });
        </script>
    @endpush
@endsection
