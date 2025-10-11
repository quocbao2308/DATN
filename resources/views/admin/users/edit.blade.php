@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sửa Người dùng</h3>
                    <p class="text-subtitle text-muted">Chỉnh sửa thông tin tài khoản và vai trò</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người dùng</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            {{-- Card hiển thị ảnh đại diện hiện tại --}}
            @if ($roleData)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if (isset($roleData->anh_dai_dien) && $roleData->anh_dai_dien)
                                    <img src="{{ asset('storage/' . $roleData->anh_dai_dien) }}" alt="Ảnh đại diện"
                                        class="rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #e9ecef;">
                                @else
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 32px; font-weight: bold; border: 3px solid #e9ecef;">
                                        {{ strtoupper(substr($roleData->ho_ten ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <h5 class="mb-0">{{ $roleData->ho_ten ?? $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $currentRole }}</p>
                                @if (isset($roleData->anh_dai_dien) && $roleData->anh_dai_dien)
                                    <small class="text-success"><i class="bi bi-check-circle"></i> Đã có ảnh đại
                                        diện</small>
                                @else
                                    <small class="text-muted"><i class="bi bi-info-circle"></i> Chưa có ảnh đại diện</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Vai trò hiện tại:</strong> {{ $currentRole }}
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Thông tin đăng nhập --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Tên đăng nhập <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Để trống nếu không muốn đổi mật khẩu</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role" class="form-label">Vai trò <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role"
                                        name="role" required>
                                        <option value="">-- Chọn vai trò --</option>
                                        <option value="admin" {{ old('role', $roleKey) == 'admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="dao_tao" {{ old('role', $roleKey) == 'dao_tao' ? 'selected' : '' }}>
                                            Đào tạo</option>
                                        <option value="giang_vien"
                                            {{ old('role', $roleKey) == 'giang_vien' ? 'selected' : '' }}>Giảng viên
                                        </option>
                                        <option value="sinh_vien"
                                            {{ old('role', $roleKey) == 'sinh_vien' ? 'selected' : '' }}>Sinh viên</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Phần phân quyền --}}
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="bi bi-shield-lock"></i> Phân quyền</h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="vai_tro_id" class="form-label">Vai trò phân quyền <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('vai_tro_id') is-invalid @enderror"
                                            id="vai_tro_id" name="vai_tro_id" required>
                                            <option value="">-- Chọn vai trò --</option>
                                            @foreach ($allVaiTros as $vaiTro)
                                                <option value="{{ $vaiTro->id }}"
                                                    {{ old('vai_tro_id', $userRole->id ?? '') == $vaiTro->id ? 'selected' : '' }}>
                                                    {{ $vaiTro->ten_vai_tro }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vai_tro_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            Vai trò hiện tại: <strong>{{ $userRole->ten_vai_tro ?? 'Chưa có' }}</strong>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Quyền hiện tại</label>
                                    <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                                        @if ($userRole)
                                            @php
                                                $permissions = DB::table('vai_tro_quyen')
                                                    ->join('quyen', 'vai_tro_quyen.quyen_id', '=', 'quyen.id')
                                                    ->where('vai_tro_quyen.vai_tro_id', $userRole->id)
                                                    ->pluck('quyen.mo_ta');
                                            @endphp
                                            @foreach ($permissions as $permission)
                                                <span class="badge bg-success mb-1">{{ $permission }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Chưa có quyền</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Form chung cho tất cả vai trò --}}
                        <div id="common-fields">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="ho_ten" class="form-label">Họ và tên <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('ho_ten') is-invalid @enderror"
                                            id="ho_ten" name="ho_ten"
                                            value="{{ old('ho_ten', $roleData->ho_ten ?? '') }}" required>
                                        @error('ho_ten')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                        <input type="text"
                                            class="form-control @error('so_dien_thoai') is-invalid @enderror"
                                            id="so_dien_thoai" name="so_dien_thoai"
                                            value="{{ old('so_dien_thoai', $roleData->so_dien_thoai ?? '') }}">
                                        @error('so_dien_thoai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Include forms cho từng vai trò (edit version) --}}
                        <div id="role-specific-fields">
                            @include('admin.users.forms.admin-edit-form')
                            @include('admin.users.forms.daotao-edit-form')
                            @include('admin.users.forms.giangvien-edit-form')
                            @include('admin.users.forms.sinhvien-edit-form')
                        </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Ẩn/hiện form theo vai trò
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const adminForm = document.getElementById('admin-form');
            const daoTaoForm = document.getElementById('daotao-form');
            const giangVienForm = document.getElementById('giangvien-form');
            const sinhVienForm = document.getElementById('sinhvien-form');

            function toggleRoleForms() {
                const selectedRole = roleSelect.value;

                // Ẩn tất cả forms bằng class d-none (không dùng display: none để input file vẫn được submit)
                if (adminForm) adminForm.classList.add('d-none');
                if (daoTaoForm) daoTaoForm.classList.add('d-none');
                if (giangVienForm) giangVienForm.classList.add('d-none');
                if (sinhVienForm) sinhVienForm.classList.add('d-none');

                // Hiện form tương ứng
                if (selectedRole === 'admin' && adminForm) {
                    adminForm.classList.remove('d-none');
                } else if (selectedRole === 'dao_tao' && daoTaoForm) {
                    daoTaoForm.classList.remove('d-none');
                } else if (selectedRole === 'giang_vien' && giangVienForm) {
                    giangVienForm.classList.remove('d-none');
                } else if (selectedRole === 'sinh_vien' && sinhVienForm) {
                    sinhVienForm.classList.remove('d-none');
                }
            }

            roleSelect.addEventListener('change', toggleRoleForms);
            toggleRoleForms(); // Chạy lần đầu khi load page
        });
    </script>
@endsection
