@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Quản lý Quyền</h3>
                    <p class="text-subtitle text-muted">Quản lý danh sách quyền hệ thống</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quyền</li>
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
                                <i class="bi bi-key-fill text-primary me-2"></i>Danh sách Quyền
                                <span class="badge bg-light-primary">{{ $permissions->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Thêm quyền mới
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.permissions.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Tìm kiếm theo mã quyền hoặc mô tả..." value="{{ $search ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i>Tìm
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Permissions Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Mã quyền</th>
                                    <th width="40%">Mô tả</th>
                                    <th width="15%" class="text-center">Vai trò sử dụng</th>
                                    <th width="15%" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>
                                            <code class="text-primary">{{ $permission->ma_quyen }}</code>
                                        </td>
                                        <td>{{ $permission->mo_ta ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light-info">
                                                {{ $permission->vaiTros()->count() }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.permissions.show', $permission) }}"
                                                    class="btn btn-info" title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.permissions.edit', $permission) }}"
                                                    class="btn btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" title="Xóa"
                                                    onclick="confirmDelete({{ $permission->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>

                                            <form id="delete-form-{{ $permission->id }}"
                                                action="{{ route('admin.permissions.destroy', $permission) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted">
                                                @if ($search)
                                                    Không tìm thấy quyền nào với từ khóa "{{ $search }}"
                                                @else
                                                    Chưa có quyền nào
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($permissions->hasPages())
                        <div class="mt-4">
                            {{ $permissions->appends(['search' => $search])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Bạn có chắc chắn muốn xóa quyền này?\n\nLưu ý: Không thể xóa quyền đang được gán cho vai trò!')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }
        </script>
    @endpush
@endsection
