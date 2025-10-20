@extends('layouts.layout-daotao')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Thống kê điểm danh</h2>
                <p class="text-muted mb-0">Báo cáo tổng hợp điểm danh sinh viên</p>
            </div>
            <a href="{{ route('dao-tao.diem-danh.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Quay lại
            </a>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Tổng số buổi</h6>
                        <h3 class="card-title text-primary">{{ $tongSoBuoi }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Có mặt</h6>
                        <h3 class="card-title text-success">{{ $coMat }}</h3>
                        <small
                            class="text-muted">{{ $tongSoBuoi > 0 ? round(($coMat / $tongSoBuoi) * 100, 1) : 0 }}%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Vắng</h6>
                        <h3 class="card-title text-danger">{{ $vang }}</h3>
                        <small class="text-muted">{{ $tongSoBuoi > 0 ? round(($vang / $tongSoBuoi) * 100, 1) : 0 }}%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Đi trễ</h6>
                        <h3 class="card-title text-warning">{{ $diTre }}</h3>
                        <small
                            class="text-muted">{{ $tongSoBuoi > 0 ? round(($diTre / $tongSoBuoi) * 100, 1) : 0 }}%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dao-tao.diem-danh.thong-ke') }}" class="row g-3">
                    <!-- Lớp học phần -->
                    <div class="col-md-3">
                        <label class="form-label">Lớp học phần</label>
                        <select name="lop_hoc_phan_id" class="form-select">
                            <option value="">-- Tất cả lớp --</option>
                            @foreach ($danhSachLopHocPhan as $lopHocPhan)
                                <option value="{{ $lopHocPhan->id }}"
                                    {{ request('lop_hoc_phan_id') == $lopHocPhan->id ? 'selected' : '' }}>
                                    {{ $lopHocPhan->ma_lop_hp }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sinh viên -->
                    <div class="col-md-3">
                        <label class="form-label">Sinh viên</label>
                        <select name="sinh_vien_id" class="form-select">
                            <option value="">-- Tất cả sinh viên --</option>
                            @foreach ($danhSachSinhVien as $sinhVien)
                                <option value="{{ $sinhVien->id }}"
                                    {{ request('sinh_vien_id') == $sinhVien->id ? 'selected' : '' }}>
                                    {{ $sinhVien->ma_sinh_vien }} - {{ $sinhVien->ho_ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="co_mat" {{ request('trang_thai') == 'co_mat' ? 'selected' : '' }}>Có mặt
                            </option>
                            <option value="vang" {{ request('trang_thai') == 'vang' ? 'selected' : '' }}>Vắng</option>
                            <option value="di_tre" {{ request('trang_thai') == 'di_tre' ? 'selected' : '' }}>Đi trễ
                            </option>
                            <option value="nghi_phep" {{ request('trang_thai') == 'nghi_phep' ? 'selected' : '' }}>Nghỉ
                                phép</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search me-1"></i> Lọc
                        </button>
                        <a href="{{ route('dao-tao.diem-danh.thong-ke') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Mã sinh viên</th>
                                <th>Họ tên</th>
                                <th>Lớp học phần</th>
                                <th>Ngày điểm danh</th>
                                <th>Trạng thái</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($danhSachDiemDanh as $index => $diemDanh)
                                <tr>
                                    <td>{{ $danhSachDiemDanh->firstItem() + $index }}</td>
                                    <td><strong>{{ $diemDanh->sinhVien->ma_sinh_vien ?? 'N/A' }}</strong></td>
                                    <td>{{ $diemDanh->sinhVien->ho_ten ?? 'N/A' }}</td>
                                    <td>{{ $diemDanh->lichHoc->lopHocPhan->ma_lop_hp ?? 'N/A' }}</td>
                                    <td>
                                        <i class="bi bi-calendar3 text-muted me-1"></i>
                                        {{ $diemDanh->ngay_diem_danh->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        @if ($diemDanh->trang_thai == 'co_mat')
                                            <span class="badge bg-success">Có mặt</span>
                                        @elseif($diemDanh->trang_thai == 'vang')
                                            <span class="badge bg-danger">Vắng</span>
                                        @elseif($diemDanh->trang_thai == 'di_tre')
                                            <span class="badge bg-warning text-dark">Đi trễ</span>
                                        @else
                                            <span class="badge bg-info">Nghỉ phép</span>
                                        @endif
                                    </td>
                                    <td>{{ $diemDanh->ghi_chu ?: '--' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mb-0 mt-2">Không có dữ liệu điểm danh</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $danhSachDiemDanh->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
