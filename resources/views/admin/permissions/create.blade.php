@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Thêm Quyền Mới</h3>
                    <p class="text-subtitle text-muted">Tạo quyền mới cho hệ thống</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Quyền</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle text-primary me-2"></i>Thông tin quyền
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ma_quyen" class="form-label">
                                        Mã quyền <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('ma_quyen') is-invalid @enderror"
                                        id="ma_quyen" name="ma_quyen" value="{{ old('ma_quyen') }}"
                                        placeholder="vd: xem_bao_cao" required>
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
                                        id="mo_ta" name="mo_ta" value="{{ old('mo_ta') }}"
                                        placeholder="vd: Xem báo cáo thống kê">
                                    @error('mo_ta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="bi bi-lightbulb me-2"></i>Quy tắc đặt tên
                            </h6>
                            <ul class="mb-0">
                                <li>Sử dụng động từ + đối tượng: <code>xem_sinh_vien</code>, <code>them_lop_hoc</code></li>
                                <li>Chỉ dùng chữ thường (a-z) và dấu gạch dưới (_)</li>
                                <li>Không dùng số, khoảng trắng, ký tự đặc biệt</li>
                                <li>Ví dụ: <code>xem_diem</code>, <code>nhap_diem</code>, <code>quan_ly_khoa</code></li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Lưu quyền
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
