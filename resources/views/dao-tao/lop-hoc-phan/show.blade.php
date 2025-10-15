@extends('layouts.layout-daotao')

@section('title', 'Chi tiết lớp học phần')

@section('content')
<div class="container mt-4">
    <h2>Chi tiết Lớp học phần</h2>

    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Mã lớp học phần:</strong> {{ $lopHocPhan->ma_lop_hp }}
                </div>
                <div class="col-md-6">
                    <strong>Môn học:</strong> {{ $lopHocPhan->monHoc->ten_mon ?? 'Không xác định' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Học kỳ:</strong> {{ $lopHocPhan->hocKy->ten_hoc_ky ?? 'Không xác định' }}
                </div>
                <div class="col-md-6">
                    <strong>Hình thức:</strong> 
                    @if($lopHocPhan->hinh_thuc == 'offline')
                        <span class="badge bg-primary">Offline</span>
                    @elseif($lopHocPhan->hinh_thuc == 'online')
                        <span class="badge bg-success">Online</span>
                    @else
                        <span class="badge bg-warning text-dark">Hybrid</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Sức chứa:</strong> {{ $lopHocPhan->suc_chua ?? 'Chưa có' }}
                </div>
                <div class="col-md-6">
                    <strong>Trạng thái lớp:</strong>
                    @switch($lopHocPhan->trang_thai_lop)
                        @case('mo_dang_ky') <span class="badge bg-info text-dark">Mở đăng ký</span> @break
                        @case('dang_hoc') <span class="badge bg-success">Đang học</span> @break
                        @case('ket_thuc') <span class="badge bg-secondary">Kết thúc</span> @break
                        @case('huy') <span class="badge bg-danger">Hủy</span> @break
                    @endswitch
                </div>
            </div>

            <div class="mb-3">
                <strong>Link học online:</strong><br>
                @if($lopHocPhan->link_online)
                    <a href="{{ $lopHocPhan->link_online }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                        <i class="bi bi-link-45deg"></i> Tham gia lớp học
                    </a>
                @else
                    <span class="text-muted">Không có</span>
                @endif
            </div>

            <div class="mb-3">
                <strong>Ghi chú:</strong><br>
                {{ $lopHocPhan->ghi_chu ?? 'Không có ghi chú' }}
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('dao-tao.lop-hoc-phan.index') }}" class="btn btn-secondary">Quay lại</a>
        <a href="{{ route('dao-tao.lop-hoc-phan.edit', $lopHocPhan->id) }}" class="btn btn-primary">Chỉnh sửa</a>
    </div>
</div>
@endsection
