<div class="row">
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
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror"
                value="{{ old('so_dien_thoai') }}">
            @error('so_dien_thoai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" name="anh_dai_dien" class="form-control @error('anh_dai_dien') is-invalid @enderror"
                accept="image/jpeg,image/png,image/jpg,image/gif">
            @error('anh_dai_dien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Chấp nhận: JPG, JPEG, PNG, GIF. Tối đa: 2MB</small>
        </div>
    </div>
</div>
