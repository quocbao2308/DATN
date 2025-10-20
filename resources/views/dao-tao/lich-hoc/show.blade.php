@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chi tiết Lịch học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.lich-hoc.index') }}">Lịch học</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-calendar-check" style="font-size: 80px; color: #4e73df;"></i>
                            </div>
                            <h4 class="mb-1">{{ $lichHoc->lopHocPhan->ma_lop_hp ?? 'Không rõ' }}</h4>
                            <p class="text-muted">Mã lớp học phần</p>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ route('dao-tao.lich-hoc.edit', $lichHoc->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('dao-tao.lich-hoc.destroy', $lichHoc->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa lịch học này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin Lịch học</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="200"><strong>Lớp học phần:</strong></td>
                                            <td>{{ $lichHoc->lopHocPhan->ma_lop_hp ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Môn học:</strong></td>
                                            <td>{{ $lichHoc->lopHocPhan->monHoc->ten_mon ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ngày:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($lichHoc->ngay)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Giờ bắt đầu:</strong></td>
                                            <td>{{ $lichHoc->gio_bat_dau }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Giờ kết thúc:</strong></td>
                                            <td>{{ $lichHoc->gio_ket_thuc }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phòng:</strong></td>
                                            <td>{{ $lichHoc->phongHoc->ten_phong ?? 'Chưa có' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hình thức:</strong></td>
                                            <td>
                                                @switch($lichHoc->hinh_thuc_buoi_hoc)
                                                    @case('online')
                                                        <span class="badge bg-success">Online</span>
                                                        @break
                                                    @case('offline')
                                                        <span class="badge bg-primary">Offline</span>
                                                        @break
                                                    @case('hybrid')
                                                        <span class="badge bg-info">Kết hợp</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">Không xác định</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        @if($lichHoc->hinh_thuc_buoi_hoc === 'online' || $lichHoc->hinh_thuc_buoi_hoc === 'hybrid')
                                        <tr>
                                            <td><strong>Link học online:</strong></td>
                                            <td>
                                                <a href="{{ $lichHoc->link_online }}" target="_blank">
                                                    {{ $lichHoc->link_online }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Giảng viên:</strong></td>
                                            <td>{{ $lichHoc->giangVien->ho_ten ?? 'Chưa có' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ghi chú:</strong></td>
                                            <td>{{ $lichHoc->ghi_chu ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('dao-tao.lich-hoc.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
