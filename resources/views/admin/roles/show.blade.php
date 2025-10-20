@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Chi tiết Vai trò</h3>
                    <p class="text-subtitle text-muted">Thông tin chi tiết về vai trò và quyền</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Vai trò</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <!-- Role Info -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-shield-fill text-primary me-2"></i>Thông tin vai trò
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">ID:</th>
                                    <td><span class="badge bg-light-secondary">{{ $role->id }}</span></td>
                                </tr>
                                <tr>
                                    <th>Tên vai trò:</th>
                                    <td><strong>{{ $role->ten_vai_tro }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Số quyền:</th>
                                    <td>
                                        <span class="badge bg-light-info fs-6">
                                            {{ $role->quyens->count() }} quyền
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Người dùng:</th>
                                    <td>
                                        @php
                                            $userCount = DB::table('tai_khoan_vai_tro')
                                                ->where('vai_tro_id', $role->id)
                                                ->count();
                                        @endphp
                                        <span class="badge bg-light-secondary fs-6">
                                            {{ $userCount }} người
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>Sửa
                                </a>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-key-fill text-warning me-2"></i>Danh sách Quyền
                                <span class="badge bg-light-primary">{{ $role->quyens->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($role->quyens->count() > 0)
                                @foreach ($groupedPermissions as $category => $permissions)
                                    @if ($permissions->count() > 0)
                                        <div class="mb-4">
                                            <h6 class="text-primary mb-3">
                                                <i class="bi bi-folder me-2"></i>{{ $category }}
                                                <span class="badge bg-light-secondary">{{ $permissions->count() }}</span>
                                            </h6>
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-6 mb-2">
                                                        <div class="d-flex align-items-start">
                                                            <i class="bi bi-check-circle text-success me-2 mt-1"></i>
                                                            <div>
                                                                <code
                                                                    class="text-secondary">{{ $permission->ma_quyen }}</code>
                                                                <br>
                                                                <small class="text-muted">{{ $permission->mo_ta }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">Vai trò này chưa có quyền nào</p>
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="bi bi-plus-circle me-1"></i>Gán quyền ngay
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
