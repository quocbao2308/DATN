@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Học kỳ</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Học kỳ</li>
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
                        <h5 class="mb-0">Danh sách Học kỳ</h5>
                        <a href="{{ route('dao-tao.hoc-ky.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Khóa học</th>
                                <th>Học kỳ</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hocKys as $index => $hocKy)
                                <tr>
                                    <td>{{ $hocKys->firstItem() + $index }}</td>
                                    <td><span class="badge bg-secondary">{{ $hocKy->khoaHoc->ten_khoa_hoc ?? 'N/A' }}</span>
                                    </td>
                                    <td><strong>{{ $hocKy->ten_hoc_ky }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($hocKy->ngay_bat_dau)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($hocKy->ngay_ket_thuc)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('dao-tao.hoc-ky.edit', $hocKy->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('dao-tao.hoc-ky.destroy', $hocKy->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Xóa học kỳ này?')">
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
                                    <td colspan="6" class="text-center">Chưa có học kỳ nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $hocKys->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
