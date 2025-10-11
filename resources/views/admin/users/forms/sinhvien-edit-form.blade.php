<div id="sinhvien-form" class="d-none">
    <h6 class="text-primary mt-4 mb-3">🎓 Thông tin Sinh viên</h6>

    {{-- THÔNG TIN HỌC TẬP --}}
    <h6 class="text-secondary mt-3 mb-3">📚 Thông tin học tập</h6>
    <div class="row">
        {{-- Mã sinh viên --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
                <input type="text" name="ma_sinh_vien"
                    class="form-control @error('ma_sinh_vien') is-invalid @enderror"
                    value="{{ old('ma_sinh_vien', $roleData->ma_sinh_vien ?? '') }}" placeholder="VD: PH12345">
                @error('ma_sinh_vien')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Khoa học --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Khóa học <span class="text-danger">*</span></label>
                <select name="khoa_hoc_id" class="form-select @error('khoa_hoc_id') is-invalid @enderror">
                    <option value="">-- Chọn khóa học --</option>
                    @foreach ($khoaHocs as $khoaHoc)
                        <option value="{{ $khoaHoc->id }}"
                            {{ old('khoa_hoc_id', $roleData->khoa_hoc_id ?? '') == $khoaHoc->id ? 'selected' : '' }}>
                            {{ $khoaHoc->ten_khoa_hoc }} ({{ $khoaHoc->nam_bat_dau }} - {{ $khoaHoc->nam_ket_thuc }})
                        </option>
                    @endforeach
                </select>
                @error('khoa_hoc_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Kỳ hiện tại --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Kỳ hiện tại</label>
                <input type="number" name="ky_hien_tai" class="form-control @error('ky_hien_tai') is-invalid @enderror"
                    value="{{ old('ky_hien_tai', $roleData->ky_hien_tai ?? 1) }}" min="1" max="8">
                @error('ky_hien_tai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Ngành --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Ngành <span class="text-danger">*</span></label>
                <select name="nganh_id" id="edit_nganh_id" class="form-select @error('nganh_id') is-invalid @enderror">
                    <option value="">-- Chọn ngành --</option>
                    @foreach ($nganhs as $nganh)
                        <option value="{{ $nganh->id }}" data-khoa-id="{{ $nganh->khoa_id }}"
                            {{ old('nganh_id', $roleData->nganh_id ?? '') == $nganh->id ? 'selected' : '' }}>
                            {{ $nganh->ten_nganh }}
                        </option>
                    @endforeach
                </select>
                @error('nganh_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Chuyên ngành --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Chuyên ngành <span class="text-danger">*</span></label>
                <select name="chuyen_nganh_id" id="edit_chuyen_nganh_id"
                    class="form-select @error('chuyen_nganh_id') is-invalid @enderror">
                    <option value="">-- Chọn chuyên ngành --</option>
                    @foreach ($chuyenNganhs as $chuyenNganh)
                        <option value="{{ $chuyenNganh->id }}" data-nganh-id="{{ $chuyenNganh->nganh_id }}"
                            {{ old('chuyen_nganh_id', $roleData->chuyen_nganh_id ?? '') == $chuyenNganh->id ? 'selected' : '' }}>
                            {{ $chuyenNganh->ten_chuyen_nganh }}
                        </option>
                    @endforeach
                </select>
                @error('chuyen_nganh_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Trạng thái học tập --}}
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Trạng thái học tập <span class="text-danger">*</span></label>
                <select name="trang_thai_hoc_tap_id"
                    class="form-select @error('trang_thai_hoc_tap_id') is-invalid @enderror">
                    <option value="">-- Chọn trạng thái --</option>
                    @foreach ($trangThais as $trangThai)
                        <option value="{{ $trangThai->id }}"
                            {{ old('trang_thai_hoc_tap_id', $roleData->trang_thai_hoc_tap_id ?? '') == $trangThai->id ? 'selected' : '' }}>
                            {{ $trangThai->ten_trang_thai }}
                        </option>
                    @endforeach
                </select>
                @error('trang_thai_hoc_tap_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- THÔNG TIN CÁ NHÂN --}}
    <h6 class="text-secondary mt-3 mb-3">👤 Thông tin cá nhân</h6>
    <div class="row">
        {{-- Ngày sinh --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-control @error('ngay_sinh') is-invalid @enderror"
                    value="{{ old('ngay_sinh', $roleData->ngay_sinh ?? '') }}">
                @error('ngay_sinh')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Giới tính --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gioi_tinh" class="form-select @error('gioi_tinh') is-invalid @enderror">
                    <option value="">-- Chọn giới tính --</option>
                    <option value="Nam"
                        {{ old('gioi_tinh', $roleData->gioi_tinh ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                    <option value="Nữ"
                        {{ old('gioi_tinh', $roleData->gioi_tinh ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    <option value="Khác"
                        {{ old('gioi_tinh', $roleData->gioi_tinh ?? '') == 'Khác' ? 'selected' : '' }}>Khác</option>
                </select>
                @error('gioi_tinh')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- ĐỊA CHỈ --}}
    <h6 class="text-secondary mt-3 mb-3">📍 Địa chỉ</h6>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Số nhà, đường</label>
                <input type="text" name="so_nha_duong"
                    class="form-control @error('so_nha_duong') is-invalid @enderror"
                    value="{{ old('so_nha_duong', $roleData->so_nha_duong ?? '') }}"
                    placeholder="VD: 123 Nguyễn Văn Cừ">
                @error('so_nha_duong')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Phường/Xã</label>
                <input type="text" name="phuong_xa" class="form-control @error('phuong_xa') is-invalid @enderror"
                    value="{{ old('phuong_xa', $roleData->phuong_xa ?? '') }}" placeholder="VD: Phường 1">
                @error('phuong_xa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Quận/Huyện</label>
                <input type="text" name="quan_huyen"
                    class="form-control @error('quan_huyen') is-invalid @enderror"
                    value="{{ old('quan_huyen', $roleData->quan_huyen ?? '') }}" placeholder="VD: Quận 5">
                @error('quan_huyen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Tỉnh/Thành phố</label>
                <input type="text" name="tinh_thanh"
                    class="form-control @error('tinh_thanh') is-invalid @enderror"
                    value="{{ old('tinh_thanh', $roleData->tinh_thanh ?? '') }}" placeholder="VD: TP. Hồ Chí Minh">
                @error('tinh_thanh')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- CCCD --}}
    <h6 class="text-secondary mt-3 mb-3">🆔 Căn cước công dân</h6>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Số CCCD</label>
                <input type="text" name="can_cuoc_cong_dan"
                    class="form-control @error('can_cuoc_cong_dan') is-invalid @enderror"
                    value="{{ old('can_cuoc_cong_dan', $roleData->can_cuoc_cong_dan ?? '') }}"
                    placeholder="12 chữ số" maxlength="12">
                @error('can_cuoc_cong_dan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Ngày cấp</label>
                <input type="date" name="ngay_cap_cccd"
                    class="form-control @error('ngay_cap_cccd') is-invalid @enderror"
                    value="{{ old('ngay_cap_cccd', $roleData->ngay_cap_cccd ?? '') }}">
                @error('ngay_cap_cccd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label">Nơi cấp</label>
                <input type="text" name="noi_cap_cccd"
                    class="form-control @error('noi_cap_cccd') is-invalid @enderror"
                    value="{{ old('noi_cap_cccd', $roleData->noi_cap_cccd ?? '') }}"
                    placeholder="VD: Cục Cảnh sát ĐKQL cư trú">
                @error('noi_cap_cccd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- ẢNH ĐẠI DIỆN - Chỉ admin mới sửa được cho sinh viên --}}
    <h6 class="text-secondary mt-4 mb-3">📷 Ảnh đại diện</h6>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>Lưu ý:</strong> Sinh viên không thể tự thay đổi ảnh đại diện. Chỉ Admin mới có quyền cập nhật.
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Upload ảnh mới</label>
                <input type="file" name="anh_dai_dien"
                    class="form-control @error('anh_dai_dien') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewSinhVienImage(this)">
                @error('anh_dai_dien')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Để trống nếu không muốn đổi ảnh. Định dạng: JPG, PNG, GIF. Tối đa 2MB</small>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ảnh hiện tại / Preview</label>
            <div>
                @if (isset($roleData) && isset($roleData->anh_dai_dien) && $roleData->anh_dai_dien)
                    <img src="{{ asset('storage/' . $roleData->anh_dai_dien) }}" alt="Ảnh đại diện"
                        class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;"
                        id="sinhvien-avatar-preview">
                @else
                    <div class="rounded d-inline-flex align-items-center justify-content-center"
                        style="width: 200px; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 72px; font-weight: bold;"
                        id="sinhvien-avatar-placeholder">
                        {{ isset($roleData) && isset($roleData->ho_ten) ? strtoupper(substr($roleData->ho_ten, 0, 1)) : 'S' }}
                    </div>
                    <img src="" alt="Preview" class="img-thumbnail d-none"
                        style="max-width: 200px; max-height: 200px; object-fit: cover;" id="sinhvien-avatar-preview">
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Preview ảnh sinh viên
    function previewSinhVienImage(input) {
        const preview = document.getElementById('sinhvien-avatar-preview');
        const placeholder = document.getElementById('sinhvien-avatar-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    // Show/hide chuyên ngành theo ngành (không dùng JSON, filter, forEach)
    document.addEventListener('DOMContentLoaded', function() {
        const nganhSelect = document.getElementById('edit_nganh_id');
        const chuyenNganhSelect = document.getElementById('edit_chuyen_nganh_id');

        if (!nganhSelect || !chuyenNganhSelect) return;

        const currentValue = chuyenNganhSelect.value; // Lưu giá trị hiện tại

        nganhSelect.addEventListener('change', function() {
            const selectedNganhId = this.value;
            const options = chuyenNganhSelect.options;

            // Show/hide options dựa trên data-nganh-id
            for (let i = 1; i < options.length; i++) {
                const option = options[i];
                const optionNganhId = option.getAttribute('data-nganh-id');

                if (selectedNganhId && optionNganhId == selectedNganhId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }

            // Reset selection nếu option hiện tại bị ẩn
            if (chuyenNganhSelect.value) {
                const currentOption = chuyenNganhSelect.options[chuyenNganhSelect.selectedIndex];
                if (currentOption.style.display === 'none') {
                    chuyenNganhSelect.value = '';
                }
            }
        });

        // Khởi tạo - trigger change để hiển thị đúng options
        if (nganhSelect.value) {
            nganhSelect.dispatchEvent(new Event('change'));
            // Khôi phục giá trị đã chọn
            if (currentValue) {
                chuyenNganhSelect.value = currentValue;
            }
        }
    });
</script>
