@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Học kỳ</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.hoc-ky.index') }}">Học kỳ</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.hoc-ky.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="khoa_hoc_id" class="form-label">Khóa học <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('khoa_hoc_id') is-invalid @enderror"
                                        name="khoa_hoc_id" required>
                                        <option value="">-- Chọn khóa học --</option>
                                        @foreach ($khoaHocs as $khoaHoc)
                                            <option value="{{ $khoaHoc->id }}"
                                                {{ old('khoa_hoc_id') == $khoaHoc->id ? 'selected' : '' }}>
                                                {{ $khoaHoc->ten_khoa_hoc }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('khoa_hoc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hoc_ky" class="form-label">Học kỳ <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('hoc_ky') is-invalid @enderror"
                                        name="hoc_ky" value="{{ old('hoc_ky', 1) }}" min="1" max="10"
                                        required>
                                    @error('hoc_ky')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('ngay_bat_dau') is-invalid @enderror"
                                        name="ngay_bat_dau" value="{{ old('ngay_bat_dau') }}" required>
                                    @error('ngay_bat_dau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('ngay_ket_thuc') is-invalid @enderror"
                                        name="ngay_ket_thuc" value="{{ old('ngay_ket_thuc') }}" required>
                                    @error('ngay_ket_thuc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mo_ta" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('mo_ta') is-invalid @enderror" name="mo_ta" rows="3">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.hoc-ky.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Lưu lại
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
