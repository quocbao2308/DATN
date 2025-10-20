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
                    {{-- Thông báo --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Bộ lọc --}}
                    <form method="GET" action="{{ route('dao-tao.lop-hoc-phan.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Tìm kiếm lớp học phần..." value="{{ request('search') }}">
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

                            <div class="col-md-3">
                                <select name="trang_thai" class="form-select">
                                    <option value="">-- Tất cả trạng thái --</option>
                                    <option value="mo" {{ request('trang_thai') == 'mo' ? 'selected' : '' }}>Mở</option>
                                    <option value="dong" {{ request('trang_thai') == 'dong' ? 'selected' : '' }}>Đóng</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Tìm
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Bảng dữ liệu --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã lớp HP</th>
                                    <th>Môn học</th>
                                    <th>Học kỳ</th>
                                    <th>Sức chứa</th>
                                    <th>Hình thức</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lopHocPhans as $index => $lhp)
                                    <tr>
                                        <td>{{ $lopHocPhans->firstItem() + $index }}</td>
                                        <td><strong>{{ $lhp->ma_lop_hp }}</strong></td>
                                        <td>{{ $lhp->monHoc->ten_mon ?? 'Chưa có' }}</td>
                                        <td>{{ $lhp->hocKy->ten_hoc_ky ?? 'Chưa có' }}</td>
                                        <td>{{ $lhp->suc_chua ?? '-' }}</td>
                                        <td>{{ ucfirst($lhp->hinh_thuc) }}</td>
                                        <td>
                                            <span class="badge {{ $lhp->trang_thai_lop === 'mo' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($lhp->trang_thai_lop) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('dao-tao.lop-hoc-phan.show', $lhp->id) }}" 
                                                   class="btn btn-sm btn-info" title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dao-tao.lop-hoc-phan.edit', $lhp->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dao-tao.lop-hoc-phan.destroy', $lhp->id) }}" 
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
