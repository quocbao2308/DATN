@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Sửa Giảng viên</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.giang-vien.index') }}">Giảng viên</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Giảng viên</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.giang-vien.update', $giangVien->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Cột trái --}}
                            <div class="col-md-6">
                                {{-- Mã giảng viên --}}
                                <div class="mb-3">
                                    <label for="ma_giang_vien" class="form-label required">Mã giảng viên</label>
                                    <input type="text" name="ma_giang_vien" id="ma_giang_vien" 
                                        class="form-control @error('ma_giang_vien') is-invalid @enderror" 
                                        value="{{ old('ma_giang_vien', $giangVien->ma_giang_vien) }}" required>
                                    @error('ma_giang_vien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Họ tên --}}
                                <div class="mb-3">
                                    <label for="ho_ten" class="form-label required">Họ tên</label>
                                    <input type="text" name="ho_ten" id="ho_ten" 
                                        class="form-control @error('ho_ten') is-invalid @enderror" 
                                        value="{{ old('ho_ten', $giangVien->ho_ten) }}" required>
                                    @error('ho_ten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" name="email" id="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email', $giangVien->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Số điện thoại --}}
                                <div class="mb-3">
                                    <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                    <input type="text" name="so_dien_thoai" id="so_dien_thoai" 
                                        class="form-control @error('so_dien_thoai') is-invalid @enderror" 
                                        value="{{ old('so_dien_thoai', $giangVien->so_dien_thoai) }}">
                                    @error('so_dien_thoai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Ngày vào trường --}}
                                <div class="mb-3">
                                    <label for="ngay_vao_truong" class="form-label">Ngày vào trường</label>
                                    <input type="date" name="ngay_vao_truong" id="ngay_vao_truong" 
                                        class="form-control @error('ngay_vao_truong') is-invalid @enderror" 
                                        value="{{ old('ngay_vao_truong', $giangVien->ngay_vao_truong?->format('Y-m-d')) }}">
                                    @error('ngay_vao_truong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cột phải --}}
                            <div class="col-md-6">
                                {{-- Khoa --}}
                                <div class="mb-3">
                                    <label for="khoa_id" class="form-label required">Khoa</label>
                                    <select name="khoa_id" id="khoa_id" 
                                        class="form-select @error('khoa_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn khoa --</option>
                                        @foreach($khoas as $khoa)
                                            <option value="{{ $khoa->id }}" 
                                                {{ old('khoa_id', $giangVien->khoa_id) == $khoa->id ? 'selected' : '' }}>
                                                {{ $khoa->ten_khoa }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('khoa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Trình độ --}}
                                <div class="mb-3">
                                    <label for="trinh_do_id" class="form-label required">Trình độ</label>
                                    <select name="trinh_do_id" id="trinh_do_id" 
                                        class="form-select @error('trinh_do_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn trình độ --</option>
                                        @foreach($trinhDos as $td)
                                            <option value="{{ $td->id }}" 
                                                {{ old('trinh_do_id', $giangVien->trinh_do_id) == $td->id ? 'selected' : '' }}>
                                                {{ $td->ten_trinh_do }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trinh_do_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Chuyên môn --}}
                                <div class="mb-3">
                                    <label for="chuyen_mon" class="form-label">Chuyên môn</label>
                                    <textarea name="chuyen_mon" id="chuyen_mon" rows="3"
                                        class="form-control @error('chuyen_mon') is-invalid @enderror">{{ old('chuyen_mon', $giangVien->chuyen_mon) }}</textarea>
                                    @error('chuyen_mon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Ảnh đại diện --}}
                                <div class="mb-3">
                                    <label for="anh_dai_dien" class="form-label">Ảnh đại diện</label>
                                    @if($giangVien->anh_dai_dien)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($giangVien->anh_dai_dien) }}" 
                                                alt="Avatar" class="img-thumbnail" style="max-width: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" name="anh_dai_dien" id="anh_dai_dien" 
                                        class="form-control @error('anh_dai_dien') is-invalid @enderror" 
                                        accept="image/*">
                                    @error('anh_dai_dien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Để trống nếu không muốn thay đổi. Định dạng: JPG, PNG, JPEG (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('dao-tao.giang-vien.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <style>
        .required::after {
            content: " *";
            color: red;
        }
    </style>
@endsection
