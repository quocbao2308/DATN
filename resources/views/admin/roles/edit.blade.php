@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sửa Vai trò</h3>
                    <p class="text-subtitle text-muted">Chỉnh sửa vai trò và phân quyền</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Vai trò</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

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
                                id="ten_vai_tro" name="ten_vai_tro" value="{{ old('ten_vai_tro', $role->ten_vai_tro) }}"
                                required>
                            @error('ten_vai_tro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @php
                            $userCount = DB::table('tai_khoan_vai_tro')->where('vai_tro_id', $role->id)->count();
                        @endphp
                        @if ($userCount > 0)
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Vai trò này đang được gán cho <strong>{{ $userCount }}</strong> người dùng.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Permissions Matrix -->
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-key-fill text-warning me-2"></i>Phân quyền
                                <span class="badge bg-light-success">
                                    {{ count($selectedPermissions) }}/{{ collect($groupedPermissions)->flatten()->count() }}
                                    đã chọn
                                </span>
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
                                        <span class="badge bg-light-secondary">
                                            {{ $permissions->whereIn('id', $selectedPermissions)->count() }}/{{ $permissions->count() }}
                                        </span>
                                    </h6>
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                        name="permissions[]" value="{{ $permission->id }}"
                                                        id="permission-{{ $permission->id }}"
                                                        {{ in_array($permission->id, old('permissions', $selectedPermissions)) ? 'checked' : '' }}>
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
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save me-1"></i>Cập nhật vai trò
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
