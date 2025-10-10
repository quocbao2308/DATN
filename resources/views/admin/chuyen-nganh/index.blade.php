@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Chuyên ngành</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chuyên ngành</li>
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
                        <h5 class="mb-0">Danh sách Chuyên ngành</h5>
                        <a href="{{ route('admin.chuyen-nganh.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Chuyên ngành</th>
                                <th>Ngành</th>
                                <th>Khoa</th>
                                <th>Số Sinh viên</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chuyenNganhs as $index => $chuyenNganh)
                                <tr>
                                    <td>{{ $chuyenNganhs->firstItem() + $index }}</td>
                                    <td><strong>{{ $chuyenNganh->ten_chuyen_nganh }}</strong></td>
                                    <td>{{ $chuyenNganh->nganh->ten_nganh ?? 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-secondary">{{ $chuyenNganh->nganh->khoa->ten_khoa ?? 'N/A' }}</span>
                                    </td>
                                    <td><span class="badge bg-info">{{ $chuyenNganh->sinh_viens_count }}</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.chuyen-nganh.edit', $chuyenNganh->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.chuyen-nganh.destroy', $chuyenNganh->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Xóa chuyên ngành này?')">
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
                                    <td colspan="6" class="text-center">Chưa có chuyên ngành nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $chuyenNganhs->links() }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
