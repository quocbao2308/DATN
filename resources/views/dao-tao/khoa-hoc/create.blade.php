@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Khóa học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.khoa-hoc.index') }}">Khóa học</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dao-tao.khoa-hoc.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="ten_khoa_hoc" class="form-label">Tên Khóa học <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten_khoa_hoc') is-invalid @enderror"
                                name="ten_khoa_hoc" value="{{ old('ten_khoa_hoc') }}" placeholder="VD: Khóa 2024-2028"
                                required>
                            @error('ten_khoa_hoc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nam_bat_dau" class="form-label">Năm bắt đầu <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('nam_bat_dau') is-invalid @enderror"
                                        name="nam_bat_dau" value="{{ old('nam_bat_dau', date('Y')) }}" min="2000"
                                        max="2100" required>
                                    @error('nam_bat_dau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nam_ket_thuc" class="form-label">Năm kết thúc <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('nam_ket_thuc') is-invalid @enderror"
                                        name="nam_ket_thuc" value="{{ old('nam_ket_thuc', date('Y') + 4) }}" min="2000"
                                        max="2100" required>
                                    @error('nam_ket_thuc')
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
                            <a href="{{ route('dao-tao.khoa-hoc.index') }}" class="btn btn-secondary">
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
