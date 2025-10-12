@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Giảng viên</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Giảng viên</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách Giảng viên</h5>
                        <a href="{{ route('dao-tao.giang-vien.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm giảng viên
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Bộ lọc --}}
                    <form method="GET" action="{{ route('dao-tao.giang-vien.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                    placeholder="Tìm kiếm..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="khoa_id" class="form-select">
                                    <option value="">-- Tất cả khoa --</option>
                                    @foreach($khoas as $khoa)
                                        <option value="{{ $khoa->id }}" {{ request('khoa_id') == $khoa->id ? 'selected' : '' }}>
                                            {{ $khoa->ten_khoa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="trinh_do_id" class="form-select">
                                    <option value="">-- Tất cả trình độ --</option>
                                    @foreach($trinhDos as $td)
                                        <option value="{{ $td->id }}" {{ request('trinh_do_id') == $td->id ? 'selected' : '' }}>
                                            {{ $td->ten_trinh_do }}
                                        </option>
                                    @endforeach
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
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã GV</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Khoa</th>
                                    <th>Trình độ</th>
                                    <th>Chuyên môn</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($giangViens as $index => $gv)
                                    <tr>
                                        <td>{{ $giangViens->firstItem() + $index }}</td>
                                        <td><strong>{{ $gv->ma_giang_vien }}</strong></td>
                                        <td>{{ $gv->ho_ten }}</td>
                                        <td>{{ $gv->email }}</td>
                                        <td>{{ $gv->khoa->ten_khoa ?? 'N/A' }}</td>
                                        <td><span class="badge bg-info">{{ $gv->trinhDo->ten_trinh_do ?? 'N/A' }}</span></td>
                                        <td>{{ $gv->chuyen_mon ?? 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('dao-tao.giang-vien.show', $gv->id) }}" 
                                                    class="btn btn-sm btn-info" title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dao-tao.giang-vien.edit', $gv->id) }}" 
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dao-tao.giang-vien.destroy', $gv->id) }}" 
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa giảng viên này?')">
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
                        {{ $giangViens->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
