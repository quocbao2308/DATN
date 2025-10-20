@extends('layouts.layout-daotao')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dao-tao.hoc-phi.index') }}">Học phí</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </nav>
            <h2>Chỉnh sửa phiếu thu học phí #{{ $hocPhi->id }}</h2>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dao-tao.hoc-phi.update', $hocPhi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Sinh viên -->
                        <div class="col-md-6 mb-3">
                            <label for="sinh_vien_id" class="form-label">
                                Sinh viên <span class="text-danger">*</span>
                            </label>
                            <select name="sinh_vien_id" id="sinh_vien_id"
                                class="form-select @error('sinh_vien_id') is-invalid @enderror" required>
                                <option value="">-- Chọn sinh viên --</option>
                                @foreach ($danhSachSinhVien as $sinhVien)
                                    <option value="{{ $sinhVien->id }}"
                                        {{ old('sinh_vien_id', $hocPhi->sinh_vien_id) == $sinhVien->id ? 'selected' : '' }}>
                                        {{ $sinhVien->ma_sinh_vien }} - {{ $sinhVien->ho_ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sinh_vien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Học kỳ -->
                        <div class="col-md-6 mb-3">
                            <label for="hoc_ky_id" class="form-label">
                                Học kỳ <span class="text-danger">*</span>
                            </label>
                            <select name="hoc_ky_id" id="hoc_ky_id"
                                class="form-select @error('hoc_ky_id') is-invalid @enderror" required>
                                <option value="">-- Chọn học kỳ --</option>
                                @foreach ($danhSachHocKy as $hocKy)
                                    <option value="{{ $hocKy->id }}"
                                        {{ old('hoc_ky_id', $hocPhi->hoc_ky_id) == $hocKy->id ? 'selected' : '' }}>
                                        {{ $hocKy->ten_hoc_ky }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hoc_ky_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Số tiền -->
                        <div class="col-md-6 mb-3">
                            <label for="so_tien" class="form-label">
                                Số tiền (VNĐ) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="so_tien" id="so_tien"
                                class="form-control @error('so_tien') is-invalid @enderror" min="0" step="1000"
                                value="{{ old('so_tien', $hocPhi->so_tien) }}" required>
                            @error('so_tien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="col-md-6 mb-3">
                            <label for="trang_thai" class="form-label">
                                Trạng thái <span class="text-danger">*</span>
                            </label>
                            <select name="trang_thai" id="trang_thai"
                                class="form-select @error('trang_thai') is-invalid @enderror" required>
                                <option value="chua_nop"
                                    {{ old('trang_thai', $hocPhi->trang_thai) == 'chua_nop' ? 'selected' : '' }}>Chưa nộp
                                </option>
                                <option value="da_nop"
                                    {{ old('trang_thai', $hocPhi->trang_thai) == 'da_nop' ? 'selected' : '' }}>Đã nộp
                                </option>
                                <option value="no"
                                    {{ old('trang_thai', $hocPhi->trang_thai) == 'no' ? 'selected' : '' }}>Nợ</option>
                            </select>
                            @error('trang_thai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ngày nộp -->
                        <div class="col-md-6 mb-3">
                            <label for="ngay_nop" class="form-label">Ngày nộp</label>
                            <input type="date" name="ngay_nop" id="ngay_nop"
                                class="form-control @error('ngay_nop') is-invalid @enderror"
                                value="{{ old('ngay_nop', $hocPhi->ngay_nop ? $hocPhi->ngay_nop->format('Y-m-d') : '') }}">
                            @error('ngay_nop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Để trống nếu chưa nộp</small>
                        </div>

                        <!-- Ghi chú -->
                        <div class="col-12 mb-3">
                            <label for="ghi_chu" class="form-label">Ghi chú</label>
                            <textarea name="ghi_chu" id="ghi_chu" rows="3" class="form-control @error('ghi_chu') is-invalid @enderror">{{ old('ghi_chu', $hocPhi->ghi_chu) }}</textarea>
                            @error('ghi_chu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Cập nhật
                        </button>
                        <a href="{{ route('dao-tao.hoc-phi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
