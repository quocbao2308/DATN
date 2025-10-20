@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sửa Quyền</h3>
                    <p class="text-subtitle text-muted">Chỉnh sửa thông tin quyền</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Quyền</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil text-warning me-2"></i>Chỉnh sửa quyền:
                        <code>{{ $permission->ma_quyen }}</code>
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ma_quyen" class="form-label">
                                        Mã quyền <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('ma_quyen') is-invalid @enderror"
                                        id="ma_quyen" name="ma_quyen" value="{{ old('ma_quyen', $permission->ma_quyen) }}"
                                        required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Chỉ dùng chữ thường và dấu gạch dưới (_)
                                    </div>
                                    @error('ma_quyen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mo_ta" class="form-label">
                                        Mô tả
                                    </label>
                                    <input type="text" class="form-control @error('mo_ta') is-invalid @enderror"
                                        id="mo_ta" name="mo_ta" value="{{ old('mo_ta', $permission->mo_ta) }}">
                                    @error('mo_ta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if ($permission->vaiTros()->count() > 0)
                            <div class="alert alert-warning">
                                <h6 class="alert-heading">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Cảnh báo
                                </h6>
                                <p class="mb-0">
                                    Quyền này đang được gán cho <strong>{{ $permission->vaiTros()->count() }}</strong> vai
                                    trò.
                                    Thay đổi mã quyền có thể ảnh hưởng đến hệ thống!
                                </p>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save me-1"></i>Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
