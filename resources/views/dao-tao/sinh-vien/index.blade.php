@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Sinh viên</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sinh viên</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách Sinh viên</h5>
                        <a href="{{ route('dao-tao.sinh-vien.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm sinh viên
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Bộ lọc --}}
                    <form method="GET" action="{{ route('dao-tao.sinh-vien.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                    placeholder="Tìm kiếm..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="khoa_id" class="form-select">
                                    <option value="">-- Tất cả khoa --</option>
                                    @foreach($khoas as $khoa)
                                        <option value="{{ $khoa->id }}" {{ request('khoa_id') == $khoa->id ? 'selected' : '' }}>
                                            {{ $khoa->ten_khoa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="nganh_id" class="form-select">
                                    <option value="">-- Tất cả ngành --</option>
                                    @foreach($nganhs as $nganh)
                                        <option value="{{ $nganh->id }}" {{ request('nganh_id') == $nganh->id ? 'selected' : '' }}>
                                            {{ $nganh->ten_nganh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="khoa_hoc_id" class="form-select">
                                    <option value="">-- Tất cả khóa --</option>
                                    @foreach($khoaHocs as $khoaHoc)
                                        <option value="{{ $khoaHoc->id }}" {{ request('khoa_hoc_id') == $khoaHoc->id ? 'selected' : '' }}>
                                            {{ $khoaHoc->ten_khoa_hoc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="trang_thai_id" class="form-select">
                                    <option value="">-- Trạng thái --</option>
                                    @foreach($trangThais as $tt)
                                        <option value="{{ $tt->id }}" {{ request('trang_thai_id') == $tt->id ? 'selected' : '' }}>
                                            {{ $tt->ten_trang_thai }}
                                        </option>
                                    @endforeach
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
                                    <th>Mã SV</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Ngành</th>
                                    <th>Khóa học</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sinhViens as $index => $sv)
                                    <tr>
                                        <td>{{ $sinhViens->firstItem() + $index }}</td>
                                        <td><strong>{{ $sv->ma_sinh_vien }}</strong></td>
                                        <td>{{ $sv->ho_ten }}</td>
                                        <td>{{ $sv->email }}</td>
                                        <td>{{ $sv->nganh->ten_nganh ?? 'N/A' }}</td>
                                        <td>{{ $sv->khoaHoc->ten_khoa_hoc ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $sv->trangThaiHocTap->ten_trang_thai ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('dao-tao.sinh-vien.show', $sv->id) }}" 
                                                    class="btn btn-sm btn-info" title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dao-tao.sinh-vien.edit', $sv->id) }}" 
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dao-tao.sinh-vien.destroy', $sv->id) }}" 
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa sinh viên này?')">
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
                                        <td colspan="8" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $sinhViens->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
