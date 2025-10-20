@extends('layouts.layout-daotao')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Quản lý học phí</h2>
                <p class="text-muted mb-0">Danh sách phiếu thu học phí sinh viên</p>
            </div>
            <a href="{{ route('dao-tao.hoc-phi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tạo phiếu thu
            </a>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Tổng học phí</h6>
                        <h3 class="card-title text-primary">{{ number_format($tongHocPhi) }} VNĐ</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Đã nộp</h6>
                        <h3 class="card-title text-success">{{ number_format($daNop) }} VNĐ</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-danger">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Chưa nộp/Nợ</h6>
                        <h3 class="card-title text-danger">{{ number_format($chuaNop) }} VNĐ</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dao-tao.hoc-phi.index') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" name="search" class="form-control" placeholder="Mã SV, tên sinh viên..."
                            value="{{ request('search') }}">
                    </div>

                    <!-- Học kỳ -->
                    <div class="col-md-3">
                        <label class="form-label">Học kỳ</label>
                        <select name="hoc_ky_id" class="form-select">
                            <option value="">-- Tất cả học kỳ --</option>
                            @foreach ($danhSachHocKy as $hocKy)
                                <option value="{{ $hocKy->id }}"
                                    {{ request('hoc_ky_id') == $hocKy->id ? 'selected' : '' }}>
                                    {{ $hocKy->ten_hoc_ky }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="chua_nop" {{ request('trang_thai') == 'chua_nop' ? 'selected' : '' }}>Chưa nộp
                            </option>
                            <option value="da_nop" {{ request('trang_thai') == 'da_nop' ? 'selected' : '' }}>Đã nộp
                            </option>
                            <option value="no" {{ request('trang_thai') == 'no' ? 'selected' : '' }}>Nợ</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search me-1"></i> Lọc
                        </button>
                        <a href="{{ route('dao-tao.hoc-phi.index') }}" class="btn btn-secondary">
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
                                <th>Mã sinh viên</th>
                                <th>Họ tên</th>
                                <th>Học kỳ</th>
                                <th>Số tiền</th>
                                <th>Ngày nộp</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($danhSachHocPhi as $hocPhi)
                                <tr>
                                    <td>{{ $hocPhi->id }}</td>
                                    <td>
                                        <strong>{{ $hocPhi->sinhVien->ma_sinh_vien ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $hocPhi->sinhVien->ho_ten ?? 'N/A' }}</td>
                                    <td>{{ $hocPhi->hocKy->ten_hoc_ky ?? 'N/A' }}</td>
                                    <td>
                                        <strong class="text-primary">{{ number_format($hocPhi->so_tien) }} VNĐ</strong>
                                    </td>
                                    <td>
                                        @if ($hocPhi->ngay_nop)
                                            {{ $hocPhi->ngay_nop->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($hocPhi->trang_thai == 'da_nop')
                                            <span class="badge bg-success">Đã nộp</span>
                                        @elseif($hocPhi->trang_thai == 'chua_nop')
                                            <span class="badge bg-warning text-dark">Chưa nộp</span>
                                        @else
                                            <span class="badge bg-danger">Nợ</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dao-tao.hoc-phi.show', $hocPhi->id) }}" class="btn btn-info"
                                                title="Xem chi tiết">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dao-tao.hoc-phi.edit', $hocPhi->id) }}"
                                                class="btn btn-warning" title="Chỉnh sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('dao-tao.hoc-phi.destroy', $hocPhi->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa phiếu thu này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Xóa">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mb-0 mt-2">Không có dữ liệu học phí</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $danhSachHocPhi->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
