@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Trạng thái học tập</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Trạng thái học tập</li>
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

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Danh sách Trạng thái</h5>
                        <a href="{{ route('admin.trang-thai-hoc-tap.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trangThais as $index => $trangThai)
                                <tr>
                                    <td>{{ $trangThais->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $trangThai->ten_trang_thai }}</span>
                                    </td>
                                    <td>{{ $trangThai->created_at ? $trangThai->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.trang-thai-hoc-tap.edit', $trangThai->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.trang-thai-hoc-tap.destroy', $trangThai->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Xóa trạng thái này?')">
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
                                    <td colspan="4" class="text-center">Chưa có trạng thái nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $trangThais->links() }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
