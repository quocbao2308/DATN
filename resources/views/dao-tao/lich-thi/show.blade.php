@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chi tiết Lịch thi</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.lich-thi.index') }}">Lịch thi</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- Cột trái: biểu tượng --}}
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-calendar-check" style="font-size: 80px; color: #4e73df;"></i>
                            </div>
                            <h4 class="mb-1">{{ $lichThi->lopHocPhan->ma_lop_hp ?? 'Không rõ lớp học phần' }}</h4>
                            <p class="text-muted">Mã lớp học phần</p>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ route('dao-tao.lich-thi.edit', $lichThi->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('dao-tao.lich-thi.destroy', $lichThi->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa lịch thi này?')">
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

                {{-- Cột phải: Thông tin chi tiết --}}
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin Lịch thi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="200"><strong>Lớp học phần:</strong></td>
                                            <td>{{ $lichThi->lopHocPhan->ma_lop_hp ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Môn học:</strong></td>
                                            <td>{{ $lichThi->lopHocPhan->monHoc->ten_mon ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ngày thi:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($lichThi->ngay_thi)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Giờ bắt đầu:</strong></td>
                                            <td>{{ $lichThi->gio_bat_dau }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Giờ kết thúc:</strong></td>
                                            <td>{{ $lichThi->gio_ket_thuc }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phòng thi:</strong></td>
                                            <td>{{ $lichThi->phongHoc->ten_phong ?? 'Chưa có' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hình thức thi:</strong></td>
                                            <td>
                                                @switch($lichThi->hinh_thuc)
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
                                        @if($lichThi->hinh_thuc === 'online' || $lichThi->hinh_thuc === 'hybrid')
                                        <tr>
                                            <td><strong>Link thi online:</strong></td>
                                            <td>
                                                <a href="{{ $lichThi->link_online }}" target="_blank">
                                                    {{ $lichThi->link_online }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>File đề thi:</strong></td>
                                            <td>
                                                @if($lichThi->file_pdf)
                                                    <a href="{{ asset('storage/' . $lichThi->file_pdf) }}" target="_blank">
                                                        {{ basename($lichThi->file_pdf) }}
                                                    </a>
                                                @else
                                                    Không có file
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ngày gửi:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($lichThi->ngay_gui)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin giảng viên nếu có --}}
                    @if(isset($lichThi->lopHocPhan->giangVien))
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Giảng viên phụ trách</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Họ tên:</strong> {{ $lichThi->lopHocPhan->giangVien->ho_ten ?? 'Chưa có' }}</p>
                            <p><strong>Email:</strong> {{ $lichThi->lopHocPhan->giangVien->email ?? '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Nút quay lại --}}
            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('dao-tao.lich-thi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
