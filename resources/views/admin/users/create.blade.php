@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Người dùng Mới</h3>
                    <p class="text-subtitle text-muted">
                        @if ($role === 'admin')
                            Tạo tài khoản Admin
                        @elseif($role === 'dao_tao')
                            Tạo tài khoản Đào tạo
                        @elseif($role === 'giang_vien')
                            Tạo tài khoản Giảng viên
                        @elseif($role === 'sinh_vien')
                            Tạo tài khoản Sinh viên
                        @endif
                    </p>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người dùng</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Thông tin đăng nhập</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Thông tin cá nhân</h5>
                    </div>
                    <div class="card-body">
                        @if ($role === 'admin' || $role === 'dao_tao')
                            @include('admin.users.forms.basic-form')
                        @elseif($role === 'giang_vien')
                            @include('admin.users.forms.giangvien-form')
                        @elseif($role === 'sinh_vien')
                            @include('admin.users.forms.sinhvien-form')
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index', ['role' => $role]) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Tạo tài khoản
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    @push('scripts')
        <script>
            // Auto load ngành khi chọn khoa (cho sinh viên)
            @if ($role === 'sinh_vien')
                const nganhsData = @json($nganhs);
                const chuyenNganhsData = @json($chuyenNganhs);

                document.getElementById('khoa_id')?.addEventListener('change', function() {
                    const khoaId = this.value;
                    const nganhSelect = document.getElementById('nganh_id');
                    const chuyenNganhSelect = document.getElementById('chuyen_nganh_id');

                    // Reset
                    nganhSelect.innerHTML = '<option value="">-- Chọn ngành --</option>';
                    chuyenNganhSelect.innerHTML = '<option value="">-- Chọn chuyên ngành --</option>';

                    // Load ngành theo khoa
                    const filteredNganhs = nganhsData.filter(n => n.khoa_id == khoaId);
                    filteredNganhs.forEach(nganh => {
                        nganhSelect.innerHTML += `<option value="${nganh.id}">${nganh.ten_nganh}</option>`;
                    });
                });

                document.getElementById('nganh_id')?.addEventListener('change', function() {
                    const nganhId = this.value;
                    const chuyenNganhSelect = document.getElementById('chuyen_nganh_id');

                    // Reset
                    chuyenNganhSelect.innerHTML = '<option value="">-- Chọn chuyên ngành --</option>';

                    // Load chuyên ngành theo ngành
                    const filteredChuyenNganhs = chuyenNganhsData.filter(cn => cn.nganh_id == nganhId);
                    filteredChuyenNganhs.forEach(cn => {
                        chuyenNganhSelect.innerHTML +=
                            `<option value="${cn.id}">${cn.ten_chuyen_nganh}</option>`;
                    });
                });
            @endif
        </script>
    @endpush
@endsection
