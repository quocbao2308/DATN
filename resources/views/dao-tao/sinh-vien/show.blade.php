@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chi tiết Sinh viên</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.sinh-vien.index') }}">Sinh viên</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($sinhVien->anh_dai_dien)
                                <img src="{{ asset('storage/' . $sinhVien->anh_dai_dien) }}" 
                                    alt="{{ $sinhVien->ho_ten }}" class="rounded-circle mb-3" 
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 60px; font-weight: bold;">
                                    {{ strtoupper(substr($sinhVien->ho_ten, 0, 1)) }}
                                </div>
                            @endif
                            <h4>{{ $sinhVien->ho_ten }}</h4>
                            <p class="text-muted">{{ $sinhVien->ma_sinh_vien }}</p>
                            <span class="badge bg-success">{{ $sinhVien->trangThaiHocTap->ten_trang_thai ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Email:</strong></td>
                                    <td>{{ $sinhVien->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày sinh:</strong></td>
                                    <td>{{ $sinhVien->ngay_sinh ? $sinhVien->ngay_sinh->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Giới tính:</strong></td>
                                    <td>{{ ucfirst($sinhVien->gioi_tinh ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Số điện thoại:</strong></td>
                                    <td>{{ $sinhVien->so_dien_thoai ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>CCCD:</strong></td>
                                    <td>{{ $sinhVien->can_cuoc_cong_dan ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Thông tin học tập</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Khoa:</strong></td>
                                    <td>{{ $sinhVien->nganh->khoa->ten_khoa ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ngành:</strong></td>
                                    <td>{{ $sinhVien->nganh->ten_nganh ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Chuyên ngành:</strong></td>
                                    <td>{{ $sinhVien->chuyenNganh->ten_chuyen_nganh ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Khóa học:</strong></td>
                                    <td>{{ $sinhVien->khoaHoc->ten_khoa_hoc ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kỳ hiện tại:</strong></td>
                                    <td>Kỳ {{ $sinhVien->ky_hien_tai ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('dao-tao.sinh-vien.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('dao-tao.sinh-vien.edit', $sinhVien->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
