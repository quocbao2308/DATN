@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Khóa học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Khóa học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Danh sách Khóa học</h5>
                        <a href="{{ route('dao-tao.khoa-hoc.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Khóa học</th>
                                <th>Năm bắt đầu</th>
                                <th>Năm kết thúc</th>
                                <th>Số Sinh viên</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($khoaHocs as $index => $khoaHoc)
                                <tr>
                                    <td>{{ $khoaHocs->firstItem() + $index }}</td>
                                    <td><strong>{{ $khoaHoc->ten_khoa_hoc }}</strong></td>
                                    <td><span class="badge bg-info">{{ $khoaHoc->nam_bat_dau }}</span></td>
                                    <td><span class="badge bg-info">{{ $khoaHoc->nam_ket_thuc }}</span></td>
                                    <td><span class="badge bg-primary">{{ $khoaHoc->sinh_viens_count }}</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('dao-tao.khoa-hoc.edit', $khoaHoc->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('dao-tao.khoa-hoc.destroy', $khoaHoc->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Xóa khóa học này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có khóa học nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $khoaHocs->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
