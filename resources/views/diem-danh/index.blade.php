@extends('layouts.layout-daotao')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Quản lý điểm danh</h2>
                <p class="text-muted mb-0">Danh sách buổi học cần điểm danh</p>
            </div>
            <a href="{{ route('dao-tao.diem-danh.thong-ke') }}" class="btn btn-info">
                <i class="bi bi-bar-chart me-2"></i>Xem thống kê
            </a>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dao-tao.diem-danh.index') }}" class="row g-3">
                    <!-- Lớp học phần -->
                    <div class="col-md-4">
                        <label class="form-label">Lớp học phần</label>
                        <select name="lop_hoc_phan_id" class="form-select">
                            <option value="">-- Tất cả lớp học phần --</option>
                            @foreach ($danhSachLopHocPhan as $lopHocPhan)
                                <option value="{{ $lopHocPhan->id }}"
                                    {{ request('lop_hoc_phan_id') == $lopHocPhan->id ? 'selected' : '' }}>
                                    {{ $lopHocPhan->ma_lop_hp }} - {{ $lopHocPhan->monHoc->ten_mon ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ngày -->
                    <div class="col-md-3">
                        <label class="form-label">Ngày học</label>
                        <input type="date" name="ngay" class="form-control" value="{{ request('ngay') }}">
                    </div>

                    <!-- Chưa điểm danh -->
                    <div class="col-md-2">
                        <label class="form-label">Trạng thái</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="chua_diem_danh" value="1"
                                id="chua_diem_danh" {{ request('chua_diem_danh') ? 'checked' : '' }}>
                            <label class="form-check-label" for="chua_diem_danh">
                                Chưa điểm danh
                            </label>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search me-1"></i> Lọc
                        </button>
                        <a href="{{ route('dao-tao.diem-danh.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Table Card -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Lớp học phần</th>
                                <th>Môn học</th>
                                <th>Ngày học</th>
                                <th>Giờ học</th>
                                <th>Phòng</th>
                                <th>Giảng viên</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($danhSachLichHoc as $lichHoc)
                                <tr>
                                    <td>{{ $lichHoc->id }}</td>
                                    <td>
                                        <strong>{{ $lichHoc->lopHocPhan->ma_lop_hp ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $lichHoc->lopHocPhan->monHoc->ten_mon ?? 'N/A' }}</td>
                                    <td>
                                        <i class="bi bi-calendar3 text-primary me-1"></i>
                                        {{ \Carbon\Carbon::parse($lichHoc->ngay)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <i class="bi bi-clock text-muted me-1"></i>
                                        {{ $lichHoc->gio_bat_dau }} - {{ $lichHoc->gio_ket_thuc }}
                                    </td>
                                    <td>
                                        @if ($lichHoc->phongHoc)
                                            <span class="badge bg-secondary">{{ $lichHoc->phongHoc->ma_phong }}</span>
                                        @else
                                            <span class="text-muted">Online</span>
                                        @endif
                                    </td>
                                    <td>{{ $lichHoc->giangVien->ho_ten ?? 'N/A' }}</td>
                                    <td>
                                        @if ($lichHoc->diemDanh && $lichHoc->diemDanh->count() > 0)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Đã điểm danh
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock-history me-1"></i>Chưa điểm danh
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('dao-tao.diem-danh.create', $lichHoc->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            {{ $lichHoc->diemDanh && $lichHoc->diemDanh->count() > 0 ? 'Sửa' : 'Điểm danh' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mb-0 mt-2">Không có buổi học nào</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $danhSachLichHoc->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
