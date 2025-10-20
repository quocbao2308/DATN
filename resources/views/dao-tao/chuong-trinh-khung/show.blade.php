@extends('layouts.layout-daotao')

@section('title', 'Chi tiết Chương trình khung')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Chi tiết Chương trình khung</h3>
                    <p class="text-subtitle text-muted">Thông tin chi tiết chương trình khung</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thông tin chương trình khung</h5>
                    <div>
                        <a href="{{ route('dao-tao.chuong-trinh-khung.edit', $chuongTrinhKhung->id) }}"
                            class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="{{ route('dao-tao.chuong-trinh-khung.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">ID:</th>
                                    <td>{{ $chuongTrinhKhung->id }}</td>
                                </tr>
                                <tr>
                                    <th>Chuyên ngành:</th>
                                    <td>
                                        <strong>{{ $chuongTrinhKhung->chuyenNganh->ten_chuyen_nganh }}</strong><br>
                                        <small class="text-muted">
                                            Ngành: {{ $chuongTrinhKhung->chuyenNganh->nganh->ten_nganh ?? 'N/A' }}<br>
                                            Khoa: {{ $chuongTrinhKhung->chuyenNganh->nganh->khoa->ten_khoa ?? 'N/A' }}
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Môn học:</th>
                                    <td>
                                        <strong>{{ $chuongTrinhKhung->monHoc->ten_mon }}</strong><br>
                                        <small class="text-muted">
                                            Mã môn: {{ $chuongTrinhKhung->monHoc->ma_mon }}<br>
                                            Số tín chỉ: {{ $chuongTrinhKhung->monHoc->so_tin_chi }}
                                        </small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Học kỳ gợi ý:</th>
                                    <td><span class="badge bg-info">Kỳ {{ $chuongTrinhKhung->hoc_ky_goi_y }}</span></td>
                                </tr>
                                <tr>
                                    <th>Loại môn học:</th>
                                    <td>
                                        @if ($chuongTrinhKhung->loai_mon_hoc == 'Bắt buộc')
                                            <span class="badge bg-danger">{{ $chuongTrinhKhung->loai_mon_hoc }}</span>
                                        @elseif($chuongTrinhKhung->loai_mon_hoc == 'Chuyên ngành bắt buộc')
                                            <span class="badge bg-warning">{{ $chuongTrinhKhung->loai_mon_hoc }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $chuongTrinhKhung->loai_mon_hoc }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo:</th>
                                    <td>{{ $chuongTrinhKhung->created_at ? $chuongTrinhKhung->created_at->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày cập nhật:</th>
                                    <td>{{ $chuongTrinhKhung->updated_at ? $chuongTrinhKhung->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-4 mb-3">Thông tin môn học chi tiết</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="20%">Hình thức dạy:</th>
                                    <td>{{ $chuongTrinhKhung->monHoc->hinh_thuc_day ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Thời lượng:</th>
                                    <td>{{ $chuongTrinhKhung->monHoc->thoi_luong ?? 'N/A' }} giờ</td>
                                </tr>
                                <tr>
                                    <th>Số buổi:</th>
                                    <td>{{ $chuongTrinhKhung->monHoc->so_buoi ?? 'N/A' }} buổi</td>
                                </tr>
                                <tr>
                                    <th>Mô tả:</th>
                                    <td>{{ $chuongTrinhKhung->monHoc->mo_ta ?? 'Chưa có mô tả' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
