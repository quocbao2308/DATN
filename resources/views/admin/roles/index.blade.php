@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Quản lý Vai trò</h3>
                    <p class="text-subtitle text-muted">Quản lý vai trò và phân quyền hệ thống</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vai trò</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-shield-check text-primary me-2"></i>Danh sách Vai trò
                                <span class="badge bg-light-primary">{{ $roles->count() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Thêm vai trò mới
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="30%">Tên vai trò</th>
                                    <th width="15%" class="text-center">Số quyền</th>
                                    <th width="20%" class="text-center">Người dùng</th>
                                    <th width="30%" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>
                                            <i class="bi bi-shield-fill text-primary me-2"></i>
                                            <strong>{{ $role->ten_vai_tro }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light-info fs-6">
                                                {{ $role->quyens_count }} quyền
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $userCount = DB::table('tai_khoan_vai_tro')
                                                    ->where('vai_tro_id', $role->id)
                                                    ->count();
                                            @endphp
                                            <span class="badge bg-light-secondary fs-6">
                                                {{ $userCount }} người
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-info"
                                                    title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning"
                                                    title="Sửa & Phân quyền">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" title="Xóa"
                                                    onclick="confirmDelete({{ $role->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>

                                            <form id="delete-form-{{ $role->id }}"
                                                action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted">Chưa có vai trò nào</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm(
                        'Bạn có chắc chắn muốn xóa vai trò này?\n\nLưu ý: Không thể xóa vai trò đang được gán cho người dùng!'
                        )) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }
        </script>
    @endpush
@endsection
