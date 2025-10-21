@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Ngành</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.nganh.index') }}">Ngành</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dao-tao.nganh.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="khoa_id" class="form-label">Khoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('khoa_id') is-invalid @enderror" name="khoa_id" required>
                                <option value="">-- Chọn khoa --</option>
                                @foreach ($khoas as $khoa)
                                    <option value="{{ $khoa->id }}" {{ old('khoa_id') == $khoa->id ? 'selected' : '' }}>
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
                                name="ten_nganh" value="{{ old('ten_nganh') }}" required>
                            @error('ten_nganh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dao-tao.nganh.index') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
