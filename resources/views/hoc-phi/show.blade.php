@extends('layouts.layout-daotao')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dao-tao.hoc-phi.index') }}">Học phí</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h2>Chi tiết phiếu thu học phí #{{ $hocPhi->id }}</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('dao-tao.hoc-phi.edit', $hocPhi->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('dao-tao.hoc-phi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Thông tin phiếu thu -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Thông tin phiếu thu</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Mã phiếu thu:</th>
                                <td><strong class="text-primary">#{{ $hocPhi->id }}</strong></td>
                            </tr>
                            <tr>
                                <th>Số tiền:</th>
                                <td>
                                    <h4 class="text-success mb-0">{{ number_format($hocPhi->so_tien) }} VNĐ</h4>
                                </td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    @if ($hocPhi->trang_thai == 'da_nop')
                                        <span class="badge bg-success fs-6">
                                            <i class="bi bi-check-circle me-1"></i>Đã nộp
                                        </span>
                                    @elseif($hocPhi->trang_thai == 'chua_nop')
                                        <span class="badge bg-warning text-dark fs-6">
                                            <i class="bi bi-clock me-1"></i>Chưa nộp
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Nợ
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày nộp:</th>
                                <td>
                                    @if ($hocPhi->ngay_nop)
                                        <i class="bi bi-calendar-check text-success me-2"></i>
                                        {{ $hocPhi->ngay_nop->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Chưa nộp</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Học kỳ:</th>
                                <td><strong>{{ $hocPhi->hocKy->ten_hoc_ky ?? 'N/A' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Ghi chú:</th>
                                <td>{{ $hocPhi->ghi_chu ?: 'Không có ghi chú' }}</td>
                            </tr>
                            <tr>
                                <th>Ngày tạo:</th>
                                <td>
                                    <i class="bi bi-calendar-plus text-muted me-2"></i>
                                    {{ $hocPhi->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Cập nhật lần cuối:</th>
                                <td>
                                    <i class="bi bi-arrow-clockwise text-muted me-2"></i>
                                    {{ $hocPhi->updated_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Thông tin sinh viên -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Thông tin sinh viên</h5>
                    </div>
                    <div class="card-body text-center">
                        @if ($hocPhi->sinhVien && $hocPhi->sinhVien->anh_dai_dien)
                            <img src="{{ asset('storage/' . $hocPhi->sinhVien->anh_dai_dien) }}" alt="Avatar"
                                class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 100px; height: 100px;">
                                <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <h5 class="card-title mb-1">{{ $hocPhi->sinhVien->ho_ten ?? 'N/A' }}</h5>
                        <p class="text-muted mb-3">
                            <strong>{{ $hocPhi->sinhVien->ma_sinh_vien ?? 'N/A' }}</strong>
                        </p>

                        <table class="table table-sm table-borderless text-start">
                            <tr>
                                <th width="40%"><i class="bi bi-envelope me-2"></i>Email:</th>
                                <td>{{ $hocPhi->sinhVien->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th><i class="bi bi-telephone me-2"></i>SĐT:</th>
                                <td>{{ $hocPhi->sinhVien->so_dien_thoai ?? 'N/A' }}</td>
                            </tr>
                            @if ($hocPhi->sinhVien && $hocPhi->sinhVien->chuyenNganh)
                                <tr>
                                    <th><i class="bi bi-mortarboard me-2"></i>Ngành:</th>
                                    <td>{{ $hocPhi->sinhVien->chuyenNganh->ten_chuyen_nganh }}</td>
                                </tr>
                            @endif
                            @if ($hocPhi->sinhVien && $hocPhi->sinhVien->khoaHoc)
                                <tr>
                                    <th><i class="bi bi-calendar me-2"></i>Khóa:</th>
                                    <td>{{ $hocPhi->sinhVien->khoaHoc->ten_khoa_hoc }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
