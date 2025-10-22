@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Quản lý Ngành</h3>
                    <p class="text-subtitle text-muted">Danh sách các ngành học</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ngành</li>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách Ngành</h5>
                        <a href="{{ route('dao-tao.nganh.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Ngành</th>
                                <th>Khoa</th>
                                <th>Số Chuyên ngành</th>
                                <th>Số Sinh viên</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nganhs as $index => $nganh)
                                <tr>
                                    <td>{{ $nganhs->firstItem() + $index }}</td>
                                    <td><strong>{{ $nganh->ten_nganh }}</strong></td>
                                    <td><span class="badge bg-secondary">{{ $nganh->khoa->ten_khoa ?? 'N/A' }}</span></td>
                                    <td><span class="badge bg-primary">{{ $nganh->chuyen_nganhs_count }}</span></td>
                                    <td><span class="badge bg-info">{{ $nganh->sinh_viens_count }}</span></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dao-tao.nganh.edit', $nganh->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('dao-tao.nganh.destroy', $nganh->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Xóa ngành này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Chưa có ngành nào. <a href="{{ route('dao-tao.nganh.create') }}">Thêm mới</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $nganhs->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
