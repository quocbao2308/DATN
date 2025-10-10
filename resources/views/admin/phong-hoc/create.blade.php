@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Phòng học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.phong-hoc.index') }}">Phòng học</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.phong-hoc.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ma_phong" class="form-label">Mã phòng <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ma_phong') is-invalid @enderror"
                                        name="ma_phong" value="{{ old('ma_phong') }}" placeholder="VD: A101" required>
                                    @error('ma_phong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ten_phong" class="form-label">Tên phòng <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ten_phong') is-invalid @enderror"
                                        name="ten_phong" value="{{ old('ten_phong') }}" placeholder="VD: Phòng A101"
                                        required>
                                    @error('ten_phong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="suc_chua" class="form-label">Sức chứa <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('suc_chua') is-invalid @enderror"
                                        name="suc_chua" value="{{ old('suc_chua') }}" min="1" max="1000"
                                        required>
                                    @error('suc_chua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="loai_phong" class="form-label">Loại phòng</label>
                                    <select class="form-select @error('loai_phong') is-invalid @enderror" name="loai_phong">
                                        <option value="">-- Chọn loại --</option>
                                        <option value="Lý thuyết" {{ old('loai_phong') == 'Lý thuyết' ? 'selected' : '' }}>
                                            Lý thuyết</option>
                                        <option value="Thực hành" {{ old('loai_phong') == 'Thực hành' ? 'selected' : '' }}>
                                            Thực hành</option>
                                        <option value="Hội trường"
                                            {{ old('loai_phong') == 'Hội trường' ? 'selected' : '' }}>Hội trường</option>
                                        <option value="Phòng máy" {{ old('loai_phong') == 'Phòng máy' ? 'selected' : '' }}>
                                            Phòng máy</option>
                                    </select>
                                    @error('loai_phong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="trang_thai" class="form-label">Trạng thái <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('trang_thai') is-invalid @enderror" name="trang_thai"
                                        required>
                                        <option value="Hoạt động"
                                            {{ old('trang_thai', 'Hoạt động') == 'Hoạt động' ? 'selected' : '' }}>Hoạt động
                                        </option>
                                        <option value="Bảo trì" {{ old('trang_thai') == 'Bảo trì' ? 'selected' : '' }}>Bảo
                                            trì</option>
                                        <option value="Không sử dụng"
                                            {{ old('trang_thai') == 'Không sử dụng' ? 'selected' : '' }}>Không sử dụng
                                        </option>
                                    </select>
                                    @error('trang_thai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="vi_tri" class="form-label">Vị trí</label>
                            <input type="text" class="form-control @error('vi_tri') is-invalid @enderror" name="vi_tri"
                                value="{{ old('vi_tri') }}" placeholder="VD: Tòa A, Tầng 1">
                            @error('vi_tri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mo_ta" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('mo_ta') is-invalid @enderror" name="mo_ta" rows="3">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.phong-hoc.index') }}" class="btn btn-secondary">
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
