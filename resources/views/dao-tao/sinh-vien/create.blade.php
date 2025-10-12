@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Sinh viên</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.sinh-vien.index') }}">Sinh viên</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dao-tao.sinh-vien.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
                                    <input type="text" name="ma_sinh_vien" class="form-control @error('ma_sinh_vien') is-invalid @enderror" 
                                        value="{{ old('ma_sinh_vien') }}" required>
                                    @error('ma_sinh_vien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" name="ho_ten" class="form-control @error('ho_ten') is-invalid @enderror" 
                                        value="{{ old('ho_ten') }}" required>
                                    @error('ho_ten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="ngay_sinh" class="form-control @error('ngay_sinh') is-invalid @enderror" 
                                        value="{{ old('ngay_sinh') }}">
                                    @error('ngay_sinh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Giới tính</label>
                                    <select name="gioi_tinh" class="form-select @error('gioi_tinh') is-invalid @enderror">
                                        <option value="">-- Chọn --</option>
                                        <option value="nam" {{ old('gioi_tinh') == 'nam' ? 'selected' : '' }}>Nam</option>
                                        <option value="nu" {{ old('gioi_tinh') == 'nu' ? 'selected' : '' }}>Nữ</option>
                                        <option value="khac" {{ old('gioi_tinh') == 'khac' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                    @error('gioi_tinh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror" 
                                        value="{{ old('so_dien_thoai') }}">
                                    @error('so_dien_thoai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">CCCD</label>
                                    <input type="text" name="can_cuoc_cong_dan" class="form-control @error('can_cuoc_cong_dan') is-invalid @enderror" 
                                        value="{{ old('can_cuoc_cong_dan') }}">
                                    @error('can_cuoc_cong_dan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Ngành <span class="text-danger">*</span></label>
                                    <select name="nganh_id" class="form-select @error('nganh_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn ngành --</option>
                                        @foreach($nganhs as $nganh)
                                            <option value="{{ $nganh->id }}" {{ old('nganh_id') == $nganh->id ? 'selected' : '' }}>
                                                {{ $nganh->ten_nganh }} ({{ $nganh->khoa->ten_khoa ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nganh_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Chuyên ngành</label>
                                    <select name="chuyen_nganh_id" class="form-select @error('chuyen_nganh_id') is-invalid @enderror">
                                        <option value="">-- Chọn chuyên ngành --</option>
                                        @foreach($chuyenNganhs as $cn)
                                            <option value="{{ $cn->id }}" {{ old('chuyen_nganh_id') == $cn->id ? 'selected' : '' }}>
                                                {{ $cn->ten_chuyen_nganh }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('chuyen_nganh_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Khóa học <span class="text-danger">*</span></label>
                                    <select name="khoa_hoc_id" class="form-select @error('khoa_hoc_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn khóa học --</option>
                                        @foreach($khoaHocs as $kh)
                                            <option value="{{ $kh->id }}" {{ old('khoa_hoc_id') == $kh->id ? 'selected' : '' }}>
                                                {{ $kh->ten_khoa_hoc }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('khoa_hoc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select name="trang_thai_hoc_tap_id" class="form-select @error('trang_thai_hoc_tap_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn trạng thái --</option>
                                        @foreach($trangThais as $tt)
                                            <option value="{{ $tt->id }}" {{ old('trang_thai_hoc_tap_id') == $tt->id ? 'selected' : '' }}>
                                                {{ $tt->ten_trang_thai }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trang_thai_hoc_tap_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" name="anh_dai_dien" class="form-control @error('anh_dai_dien') is-invalid @enderror" 
                                        accept="image/*">
                                    @error('anh_dai_dien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dao-tao.sinh-vien.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
