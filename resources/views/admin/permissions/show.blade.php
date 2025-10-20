@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Chi tiết Quyền</h3>
                    <p class="text-subtitle text-muted">Thông tin chi tiết về quyền</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Quyền</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <!-- Permission Info -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-key-fill text-primary me-2"></i>Thông tin quyền
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td><span class="badge bg-light-secondary">{{ $permission->id }}</span></td>
                                </tr>
                                <tr>
                                    <th>Mã quyền:</th>
                                    <td><code class="text-primary fs-6">{{ $permission->ma_quyen }}</code></td>
                                </tr>
                                <tr>
                                    <th>Mô tả:</th>
                                    <td>{{ $permission->mo_ta ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Vai trò sử dụng:</th>
                                    <td>
                                        <span class="badge bg-light-info fs-6">
                                            {{ $permission->vaiTros()->count() }} vai trò
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>Sửa
                                </a>
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles using this permission -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-people-fill text-info me-2"></i>Vai trò có quyền này
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($permission->vaiTros()->count() > 0)
                                <div class="list-group">
                                    @foreach ($permission->vaiTros as $vaiTro)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-shield-check text-primary me-2"></i>
                                                <strong>{{ $vaiTro->ten_vai_tro }}</strong>
                                            </div>
                                            <span class="badge bg-light-secondary">ID: {{ $vaiTro->id }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">Chưa có vai trò nào sử dụng quyền này</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
