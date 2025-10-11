@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Chuyên ngành</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.chuyen-nganh.index') }}">Chuyên ngành</a>
                            </li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.chuyen-nganh.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="khoa_id" class="form-label">Khoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('khoa_id') is-invalid @enderror" id="khoa_id" required>
                                <option value="">-- Chọn khoa --</option>
                                @foreach ($khoas as $khoa)
                                    <option value="{{ $khoa->id }}">{{ $khoa->ten_khoa }}</option>
                                @endforeach
                            </select>
                            @error('khoa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nganh_id" class="form-label">Ngành <span class="text-danger">*</span></label>
                            <select class="form-select @error('nganh_id') is-invalid @enderror" name="nganh_id"
                                id="nganh_id" required>
                                <option value="">-- Chọn khoa trước --</option>
                                @foreach ($nganhs as $nganh)
                                    <option value="{{ $nganh->id }}" data-khoa="{{ $nganh->khoa_id }}"
                                        {{ old('nganh_id') == $nganh->id ? 'selected' : '' }}>
                                        {{ $nganh->ten_nganh }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nganh_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ten_chuyen_nganh" class="form-label">Tên Chuyên ngành <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten_chuyen_nganh') is-invalid @enderror"
                                name="ten_chuyen_nganh" value="{{ old('ten_chuyen_nganh') }}" required>
                            @error('ten_chuyen_nganh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.chuyen-nganh.index') }}" class="btn btn-secondary">
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

    <script>
        // Dùng JavaScript đơn giản để show/hide options (không dùng API)
        document.getElementById('khoa_id').addEventListener('change', function() {
            const khoaId = this.value;
            const nganhSelect = document.getElementById('nganh_id');
            const options = nganhSelect.options;

            // Reset về option đầu tiên
            nganhSelect.value = '';

            // Show/hide options dựa trên data-khoa attribute
            for (let i = 1; i < options.length; i++) {
                const option = options[i];
                if (khoaId && option.getAttribute('data-khoa') == khoaId) {
                    option.style.display = '';
                } else if (khoaId) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'none';
                }
            }
        });

        // Ẩn tất cả ngành khi page load
        window.addEventListener('DOMContentLoaded', function() {
            const nganhSelect = document.getElementById('nganh_id');
            const options = nganhSelect.options;
            for (let i = 1; i < options.length; i++) {
                options[i].style.display = 'none';
            }
        });
    </script>
@endsection
