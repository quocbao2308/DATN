@extends('layouts.layout-daotao')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Danh sách điểm</h3>
            </div>
        </div>
    </div>
<!-- Ghí chsu quản lý đểm  -->
    <section class="section">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách điểm</h5>
                <a href="{{ route('dao-tao.grades.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Thêm điểm mới
                </a>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <select name="sinh_vien_id" class="form-select">
                            <option value="">-- Chọn sinh viên --</option>
                            @foreach($sinhViens as $sv)
                                <option value="{{ $sv->id }}" {{ request('sinh_vien_id') == $sv->id ? 'selected' : '' }}>
                                    {{ $sv->ho_ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="mon_hoc_id" class="form-select">
                            <option value="">-- Chọn môn học --</option>
                            @foreach($monHocs as $mon)
                                <option value="{{ $mon->id }}" {{ request('mon_hoc_id') == $mon->id ? 'selected' : '' }}>
                                    {{ $mon->ten_mon }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                        <button class="btn btn-primary">Lọc</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sinh viên</th>
                                <th>Môn học</th>
                                <th>Điểm quá trình</th>
                                <th>Điểm thi</th>
                                <th>Điểm tổng kết</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                                <tr>
                                    <td>{{ $grade->id }}</td>
                                    <td>{{ $grade->sinhVien->ho_ten ?? '-' }}</td>
                                    <td>{{ $grade->monHoc->ten_mon ?? '-' }}</td>
                                    <td>{{ $grade->diem_qua_trinh ?? '-' }}</td>
                                    <td>{{ $grade->diem_thi ?? '-' }}</td>
                                    <td>{{ $grade->diem_tong_ket ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('dao-tao.grades.edit', $grade->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('dao-tao.grades.destroy', $grade->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa điểm này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center">Chưa có điểm nào</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $grades->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
