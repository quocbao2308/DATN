<div class="row">
    {{-- Mã giảng viên --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Mã giảng viên <span class="text-danger">*</span></label>
            <input type="text" name="ma_giang_vien" class="form-control @error('ma_giang_vien') is-invalid @enderror"
                value="{{ old('ma_giang_vien') }}" placeholder="VD: GV001" required>
            @error('ma_giang_vien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Họ và tên --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
            <input type="text" name="ho_ten" class="form-control @error('ho_ten') is-invalid @enderror"
                value="{{ old('ho_ten') }}" required>
            @error('ho_ten')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- THÔNG TIN CÔNG TÁC --}}
<h6 class="text-primary mt-3 mb-3">💼 Thông tin công tác</h6>
<div class="row">
    {{-- Khoa --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Khoa <span class="text-danger">*</span></label>
            <select name="khoa_id" class="form-select @error('khoa_id') is-invalid @enderror" required>
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
    </div>

    {{-- Trình độ --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Trình độ <span class="text-danger">*</span></label>
            <select name="trinh_do_id" class="form-select @error('trinh_do_id') is-invalid @enderror" required>
                <option value="">-- Chọn trình độ --</option>
                @foreach ($trinhDos as $trinhDo)
                    <option value="{{ $trinhDo->id }}" {{ old('trinh_do_id') == $trinhDo->id ? 'selected' : '' }}>
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
                value="{{ old('ngay_vao_truong') }}">
            @error('ngay_vao_truong')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Chuyên môn --}}
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label class="form-label">Chuyên môn</label>
            <input type="text" name="chuyen_mon" class="form-control @error('chuyen_mon') is-invalid @enderror"
                value="{{ old('chuyen_mon') }}" placeholder="VD: Công nghệ phần mềm, Lập trình Web">
            @error('chuyen_mon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- THÔNG TIN LIÊN HỆ --}}
<h6 class="text-primary mt-3 mb-3">📞 Thông tin liên hệ</h6>
<div class="row">
    {{-- Số điện thoại --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror"
                value="{{ old('so_dien_thoai') }}" placeholder="0987654321">
            @error('so_dien_thoai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- ẢNH ĐẠI DIỆN --}}
<h6 class="text-primary mt-3 mb-3">📷 Ảnh đại diện</h6>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Tải lên ảnh</label>
            <input type="file" name="anh_dai_dien" class="form-control @error('anh_dai_dien') is-invalid @enderror"
                accept="image/*">
            <small class="text-muted">Chấp nhận: JPG, PNG, GIF. Tối đa 2MB</small>
            @error('anh_dai_dien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@error('so_dien_thoai')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>
