@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Phòng học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Phòng học</li>
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
                        <h5 class="mb-0">Danh sách Phòng học</h5>
                        <a href="{{ route('admin.phong-hoc.create') }}" class="btn btn-primary"><i
                                class="bi bi-plus-circle"></i> Thêm mới</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã phòng</th>
                                <th>Tên phòng</th>
                                <th>Sức chứa</th>
                                <th>Vị trí</th>
                                <th>Loại phòng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($phongHocs as $index => $phong)
                                <tr>
                                    <td>{{ $phongHocs->firstItem() + $index }}</td>
                                    <td><strong>{{ $phong->ma_phong }}</strong></td>
                                    <td>{{ $phong->ten_phong }}</td>
                                    <td><span class="badge bg-info">{{ $phong->suc_chua }} chỗ</span></td>
                                    <td>{{ $phong->vi_tri }}</td>
                                    <td>
                                        @if ($phong->loai_phong)
                                            <span class="badge bg-primary">{{ $phong->loai_phong }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($phong->trang_thai == 'Hoạt động')
                                            <span class="badge bg-success">{{ $phong->trang_thai }}</span>
                                        @elseif($phong->trang_thai == 'Bảo trì')
                                            <span class="badge bg-warning">{{ $phong->trang_thai }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $phong->trang_thai }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.phong-hoc.edit', $phong->id) }}"
                                                class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.phong-hoc.destroy', $phong->id) }}"
                                                method="POST" class="d-inline" onsubmit="return confirm('Xóa phòng này?')">
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
                                    <td colspan="8" class="text-center">Chưa có phòng học nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $phongHocs->links('pagination::bootstrap-5') }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
