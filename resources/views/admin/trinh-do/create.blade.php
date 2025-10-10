@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Trình độ</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.trinh-do.index') }}">Trình độ</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.trinh-do.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="ten_trinh_do" class="form-label">Tên Trình độ <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten_trinh_do') is-invalid @enderror"
                                name="ten_trinh_do" value="{{ old('ten_trinh_do') }}"
                                placeholder="VD: Đại học, Cao đẳng, Thạc sĩ..." required>
                            @error('ten_trinh_do')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.trinh-do.index') }}" class="btn btn-secondary">
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
