@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Chỉnh sửa Khoa</h3>
                    <p class="text-subtitle text-muted">Cập nhật thông tin khoa</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.khoa.index') }}">Khoa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin Khoa</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.khoa.update', $khoa->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="ten_khoa" class="form-label">Tên Khoa <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ten_khoa') is-invalid @enderror"
                                        id="ten_khoa" name="ten_khoa" value="{{ old('ten_khoa', $khoa->ten_khoa) }}"
                                        placeholder="Nhập tên khoa" required>
                                    @error('ten_khoa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">Thông tin liên quan</h6>
                                    <ul class="mb-0">
                                        <li>Số ngành: <strong>{{ $khoa->nganhs_count }}</strong></li>
                                        <li>Số giảng viên: <strong>{{ $khoa->giang_viens_count }}</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dao-tao.khoa.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Quay lại
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Cập nhật
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
