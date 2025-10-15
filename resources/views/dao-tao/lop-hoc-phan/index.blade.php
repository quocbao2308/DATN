@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Lớp học phần</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Lớp học phần</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách Lớp học phần</h5>
                        <a href="{{ route('dao-tao.lop-hoc-phan.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm lớp học phần
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Bộ lọc --}}
                    <form method="GET" action="{{ route('dao-tao.lop-hoc-phan.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                    placeholder="Tìm kiếm lớp học phần..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="mon_hoc_id" class="form-select">
                                    <option value="">-- Tất cả môn học --</option>
                                    @foreach($monHocs as $mon)
                                        <option value="{{ $mon->id }}" {{ request('mon_hoc_id') == $mon->id ? 'selected' : '' }}>
                                            {{ $mon->ten_mon }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="hoc_ky_id" class="form-select">
                                    <option value="">-- Tất cả học kỳ --</option>
                                    @foreach($hocKys as $hk)
                                        <option value="{{ $hk->id }}" {{ request('hoc_ky_id') == $hk->id ? 'selected' : '' }}>
                                            {{ $hk->ten_hoc_ky }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="trang_thai_lop" class="form-select">
                                    <option value="">-- Trạng thái --</option>
                                    <option value="mo_dang_ky" {{ request('trang_thai_lop') == 'mo_dang_ky' ? 'selected' : '' }}>Mở đăng ký</option>
                                    <option value="dang_hoc" {{ request('trang_thai_lop') == 'dang_hoc' ? 'selected' : '' }}>Đang học</option>
                                    <option value="ket_thuc" {{ request('trang_thai_lop') == 'ket_thuc' ? 'selected' : '' }}>Kết thúc</option>
                                    <option value="huy" {{ request('trang_thai_lop') == 'huy' ? 'selected' : '' }}>Hủy</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Bảng dữ liệu --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã lớp HP</th>
                                    <th>Môn học</th>
                                    <th>Học kỳ</th>
                                    <th>Hình thức</th>
                                    <th>Sức chứa</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lopHocPhans as $index => $lop)
                                    <tr>
                                        <td>{{ $lopHocPhans->firstItem() + $index }}</td>
                                        <td><strong>{{ $lop->ma_lop_hp }}</strong></td>
                                        <td>{{ $lop->monHoc->ten_mon ?? 'N/A' }}</td>
                                        <td>{{ $lop->hocKy->ten_hoc_ky ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-info text-dark">  
                                                {{ ucfirst($lop->hinh_thuc) }}
                                            </span>
                                        </td>
                                        <td>{{ $lop->suc_chua ?? '—' }}</td>
                                        <td>
                                            @switch($lop->trang_thai_lop)
                                                @case('mo_dang_ky')
                                                    <span class="badge bg-success">Mở đăng ký</span>
                                                    @break
                                                @case('dang_hoc')
                                                    <span class="badge bg-primary">Đang học</span>
                                                    @break
                                                @case('ket_thuc')
                                                    <span class="badge bg-secondary">Kết thúc</span>
                                                    @break
                                                @case('huy')
                                                    <span class="badge bg-danger">Hủy</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('dao-tao.lop-hoc-phan.show', $lop->id) }}" 
                                                    class="btn btn-sm btn-info" title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dao-tao.lop-hoc-phan.edit', $lop->id) }}" 
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dao-tao.lop-hoc-phan.destroy', $lop->id) }}" 
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa lớp học phần này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có dữ liệu lớp học phần</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Phân trang --}}
                    <div class="d-flex justify-content-center">
                        {{ $lopHocPhans->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
