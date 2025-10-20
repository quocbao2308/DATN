@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chi tiết Môn học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.mon-hoc.index') }}">Môn học</a></li>
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
                                <i class="bi bi-book" style="font-size: 80px; color: #4e73df;"></i>
                            </div>
                            <h4 class="mb-1">{{ $monHoc->ma_mon }}</h4>
                            <p class="text-muted">Mã môn học</p>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ route('dao-tao.mon-hoc.edit', $monHoc->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('dao-tao.mon-hoc.destroy', $monHoc->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa môn học này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Statistics Card --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Thống kê</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="bi bi-journal-text text-primary"></i> Số lớp học phần:</span>
                                <strong>{{ $monHoc->lopHocPhans->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="bi bi-arrow-right-circle text-success"></i> Môn tiên quyết:</span>
                                <strong>{{ $monHoc->monTienQuyets->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-arrow-left-circle text-info"></i> Được yêu cầu bởi:</span>
                                <strong>{{ $monHoc->monHocCanTienQuyet->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cột phải: Thông tin chi tiết --}}
                <div class="col-md-8">
                    {{-- Thông tin môn học --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin môn học</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="200"><strong>Mã môn học:</strong></td>
                                        <td><span class="badge bg-primary fs-6">{{ $monHoc->ma_mon }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tên môn học:</strong></td>
                                        <td>{{ $monHoc->ten_mon }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Số tín chỉ:</strong></td>
                                        <td><span class="badge bg-info">{{ $monHoc->so_tin_chi }} TC</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Loại môn:</strong></td>
                                        <td>{{ $monHoc->loai_mon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hình thức dạy:</strong></td>
                                        <td>
                                            @switch($monHoc->hinh_thuc_day)
                                                @case('offline')
                                                    <span class="badge bg-primary">Offline</span>
                                                @break

                                                @case('online')
                                                    <span class="badge bg-success">Online</span>
                                                @break

                                                @case('hybrid')
                                                    <span class="badge bg-info">Hybrid</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $monHoc->hinh_thuc_day }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Thời lượng:</strong></td>
                                        <td>{{ $monHoc->thoi_luong ? $monHoc->thoi_luong . ' giờ' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Số buổi học:</strong></td>
                                        <td>{{ $monHoc->so_buoi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mô tả:</strong></td>
                                        <td>{{ $monHoc->mo_ta ?? 'Không có mô tả' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Môn tiên quyết --}}
                    @if ($monHoc->monTienQuyets->count() > 0)
                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-arrow-right-circle me-2"></i>
                                    Môn tiên quyết ({{ $monHoc->monTienQuyets->count() }})
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-2">Sinh viên cần hoàn thành các môn sau trước khi học môn này:</p>
                                <div class="row">
                                    @foreach ($monHoc->monTienQuyets as $mon)
                                        <div class="col-md-6 mb-2">
                                            <div class="border rounded p-2">
                                                <strong>{{ $mon->ma_mon }}</strong> - {{ $mon->ten_mon }}
                                                <span class="badge bg-info float-end">{{ $mon->so_tin_chi }} TC</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Các môn yêu cầu môn này làm tiên quyết --}}
                    @if ($monHoc->monHocCanTienQuyet->count() > 0)
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-arrow-left-circle me-2"></i>
                                    Là môn tiên quyết của ({{ $monHoc->monHocCanTienQuyet->count() }})
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-2">Môn học này là môn tiên quyết của các môn sau:</p>
                                <div class="row">
                                    @foreach ($monHoc->monHocCanTienQuyet as $mon)
                                        <div class="col-md-6 mb-2">
                                            <div class="border rounded p-2">
                                                <strong>{{ $mon->ma_mon }}</strong> - {{ $mon->ten_mon }}
                                                <span class="badge bg-info float-end">{{ $mon->so_tin_chi }} TC</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Lớp học phần --}}
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-journal-text me-2"></i>
                                Lớp học phần ({{ $monHoc->lopHocPhans->count() }})
                            </h6>
                        </div>
                        <div class="card-body">
                            @if ($monHoc->lopHocPhans->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Mã lớp</th>
                                                <th>Học kỳ</th>
                                                <th>Sức chứa</th>
                                                <th>Trạng thái</th>
                                                <th class="text-center">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monHoc->lopHocPhans as $lop)
                                                <tr>
                                                    <td><strong>{{ $lop->ma_lop_hp }}</strong></td>
                                                    <td>{{ $lop->hocKy->ten_hoc_ky ?? '-' }}</td>
                                                    <td>{{ $lop->suc_chua }}</td>
                                                    <td>
                                                        @switch($lop->trang_thai_lop)
                                                            @case('mo_dang_ky')
                                                                <span class="badge bg-success">Mở đăng ký</span>
                                                            @break

                                                            @case('dang_hoc')
                                                                <span class="badge bg-info">Đang học</span>
                                                            @break

                                                            @case('ket_thuc')
                                                                <span class="badge bg-secondary">Kết thúc</span>
                                                            @break

                                                            @case('huy')
                                                                <span class="badge bg-danger">Hủy</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('dao-tao.lop-hoc-phan.show', $lop->id) }}"
                                                            class="btn btn-sm btn-info" title="Chi tiết">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Chưa có lớp học phần nào sử dụng môn học này
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút quay lại --}}
            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('dao-tao.mon-hoc.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
