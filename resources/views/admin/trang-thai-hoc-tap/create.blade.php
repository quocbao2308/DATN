@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Trạng thái học tập</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.trang-thai-hoc-tap.index') }}">Trạng thái
                                    học tập</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.trang-thai-hoc-tap.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="ten_trang_thai" class="form-label">Tên Trạng thái <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten_trang_thai') is-invalid @enderror"
                                name="ten_trang_thai" value="{{ old('ten_trang_thai') }}"
                                placeholder="VD: Đang học, Bảo lưu, Thôi học..." required>
                            @error('ten_trang_thai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.trang-thai-hoc-tap.index') }}" class="btn btn-secondary">
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
