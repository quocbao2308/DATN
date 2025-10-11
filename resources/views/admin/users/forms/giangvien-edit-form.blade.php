<div id="giangvien-form" class="d-none">
    <h6 class="text-primary mt-4 mb-3">💼 Thông tin Giảng viên</h6>

    <div class="row">
        {{-- Mã giảng viên --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Mã giảng viên <span class="text-danger">*</span></label>
                <input type="text" name="ma_giang_vien"
                    class="form-control @error('ma_giang_vien') is-invalid @enderror"
                    value="{{ old('ma_giang_vien', $roleData->ma_giang_vien ?? '') }}" placeholder="VD: GV001">
                @error('ma_giang_vien')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Khoa --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Khoa <span class="text-danger">*</span></label>
                <select name="khoa_id" class="form-select @error('khoa_id') is-invalid @enderror">
                    <option value="">-- Chọn khoa --</option>
                    @foreach ($khoas as $khoa)
                        <option value="{{ $khoa->id }}"
                            {{ old('khoa_id', $roleData->khoa_id ?? '') == $khoa->id ? 'selected' : '' }}>
                            {{ $khoa->ten_khoa }}
                        </option>
                    @endforeach
                </select>
                @error('khoa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Trình độ --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Trình độ <span class="text-danger">*</span></label>
                <select name="trinh_do_id" class="form-select @error('trinh_do_id') is-invalid @enderror">
                    <option value="">-- Chọn trình độ --</option>
                    @foreach ($trinhDos as $trinhDo)
                        <option value="{{ $trinhDo->id }}"
                            {{ old('trinh_do_id', $roleData->trinh_do_id ?? '') == $trinhDo->id ? 'selected' : '' }}>
                            {{ $trinhDo->ten_trinh_do }}
                        </option>
                    @endforeach
                </select>
                @error('trinh_do_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Ngày vào trường --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Ngày vào trường</label>
                <input type="date" name="ngay_vao_truong"
                    class="form-control @error('ngay_vao_truong') is-invalid @enderror"
                    value="{{ old('ngay_vao_truong', $roleData->ngay_vao_truong ?? '') }}">
                @error('ngay_vao_truong')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Chuyên môn --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Chuyên môn</label>
                <input type="text" name="chuyen_mon" class="form-control @error('chuyen_mon') is-invalid @enderror"
                    value="{{ old('chuyen_mon', $roleData->chuyen_mon ?? '') }}" placeholder="VD: Công nghệ phần mềm">
                @error('chuyen_mon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <p class="text-muted mt-3">
        <i class="bi bi-info-circle"></i> Để cập nhật ảnh đại diện, vui lòng sử dụng chức năng <strong>Hồ sơ cá
            nhân</strong>
    </p>
</div>
