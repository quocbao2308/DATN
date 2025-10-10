@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chỉnh sửa Ngành</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.nganh.index') }}">Ngành</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.nganh.update', $nganh->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="khoa_id" class="form-label">Khoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('khoa_id') is-invalid @enderror" name="khoa_id" required>
                                @foreach ($khoas as $khoa)
                                    <option value="{{ $khoa->id }}"
                                        {{ old('khoa_id', $nganh->khoa_id) == $khoa->id ? 'selected' : '' }}>
                                        {{ $khoa->ten_khoa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('khoa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ten_nganh" class="form-label">Tên Ngành <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten_nganh') is-invalid @enderror"
                                name="ten_nganh" value="{{ old('ten_nganh', $nganh->ten_nganh) }}" required>
                            @error('ten_nganh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <strong>Thống kê:</strong> {{ $nganh->chuyen_nganhs_count }} chuyên ngành,
                            {{ $nganh->sinh_viens_count }} sinh viên
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.nganh.index') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
