@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chi tiết Lớp học phần</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.lop-hoc-phan.index') }}">Lớp học phần</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- Cột trái: Thông tin cơ bản --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-journal-code" style="font-size: 80px; color: #4e73df;"></i>
                            </div>
                            <h4 class="mb-1">{{ $lopHocPhan->ma_lop_hp }}</h4>
                            <p class="text-muted">Mã lớp học phần</p>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ route('dao-tao.lop-hoc-phan.edit', $lopHocPhan->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('dao-tao.lop-hoc-phan.destroy', $lopHocPhan->id) }}" 
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa lớp học phần này?')">
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
                            <h5 class="mb-0">Thông tin lớp học phần</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="200"><strong>Mã lớp học phần:</strong></td>
                                            <td>{{ $lopHocPhan->ma_lop_hp }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Môn học:</strong></td>
                                            <td>{{ $lopHocPhan->monHoc->ten_mon ?? 'Chưa có' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Học kỳ:</strong></td>
                                            <td>{{ $lopHocPhan->hocKy->ten_hoc_ky ?? 'Chưa có' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Sức chứa:</strong></td>
                                            <td>{{ $lopHocPhan->suc_chua ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hình thức học:</strong></td>
                                            <td>
                                                @if($lopHocPhan->hinh_thuc === 'online')
                                                    <span class="badge bg-success">Online</span>
                                                @else
                                                    <span class="badge bg-primary">Offline</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($lopHocPhan->hinh_thuc === 'online')
                                        <tr>
                                            <td><strong>Link học online:</strong></td>
                                            <td>
                                                <a href="{{ $lopHocPhan->link_online }}" target="_blank">
                                                    {{ $lopHocPhan->link_online }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Trạng thái lớp:</strong></td>
                                            <td>
                                                @switch($lopHocPhan->trang_thai_lop)
                                                    @case('mo_dang_ky')
                                                        <span class="badge bg-success">Mở đăng ký</span>
                                                        @break
                                                    @case('dang_hoc')
                                                        <span class="badge bg-info">Đang học</span>
                                                        @break
                                                    @case('ket_thuc')
                                                        <span class="badge bg-secondary">Kết thúc</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-dark">Không xác định</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ghi chú:</strong></td>
                                            <td>{{ $lopHocPhan->ghi_chu ?? 'Không có ghi chú' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin thêm (nếu có giảng viên hoặc thời khóa biểu) --}}
                    @if(isset($lopHocPhan->giangVien))
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Giảng viên phụ trách</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Họ tên:</strong> {{ $lopHocPhan->giangVien->ho_ten ?? 'Chưa có' }}</p>
                            <p><strong>Email:</strong> {{ $lopHocPhan->giangVien->email ?? '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Nút quay lại --}}
            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('dao-tao.lop-hoc-phan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
