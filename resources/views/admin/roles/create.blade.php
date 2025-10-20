@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Thêm Vai trò Mới</h3>
                    <p class="text-subtitle text-muted">Tạo vai trò mới và gán quyền</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Vai trò</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <!-- Role Name -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-fill text-primary me-2"></i>Thông tin vai trò
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ten_vai_tro" class="form-label">
                                Tên vai trò <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('ten_vai_tro') is-invalid @enderror"
                                id="ten_vai_tro" name="ten_vai_tro" value="{{ old('ten_vai_tro') }}"
                                placeholder="vd: Trợ giảng" required>
                            @error('ten_vai_tro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Permissions Matrix -->
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-key-fill text-warning me-2"></i>Phân quyền
                            </h5>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="checkAll()">
                                    <i class="bi bi-check-all"></i> Chọn tất cả
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="uncheckAll()">
                                    <i class="bi bi-x-circle"></i> Bỏ chọn tất cả
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($groupedPermissions as $category => $permissions)
                            @if ($permissions->count() > 0)
                                <div class="permission-group mb-4">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-folder me-2"></i>{{ $category }}
                                    </h6>
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                        name="permissions[]" value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                        <code class="text-secondary">{{ $permission->ma_quyen }}</code>
                                                        <br>
                                                        <small class="text-muted">{{ $permission->mo_ta }}</small>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach

                        @if (collect($groupedPermissions)->flatten()->count() == 0)
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Chưa có quyền nào trong hệ thống. Vui lòng tạo quyền trước.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Lưu vai trò
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    @push('scripts')
        <script>
            function checkAll() {
                document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                    checkbox.checked = true;
                });
            }

            function uncheckAll() {
                document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
            }
        </script>
    @endpush
@endsection
