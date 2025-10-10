<div class="row">
    {{-- Mã sinh viên --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
            <input type="text" name="ma_sinh_vien" class="form-control @error('ma_sinh_vien') is-invalid @enderror"
                value="{{ old('ma_sinh_vien') }}" placeholder="VD: PH56835" required>
            @error('ma_sinh_vien')
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

{{-- THÔNG TIN HỌC TẬP --}}
<h6 class="text-primary mt-3 mb-3">📚 Thông tin học tập</h6>

<div class="row">
    {{-- Khoa --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Khoa <span class="text-danger">*</span></label>
            <select id="khoa_id" name="khoa_id" class="form-select @error('khoa_id') is-invalid @enderror" required>
                <option value="">-- Chọn khoa --</option>
                @foreach ($khoas as $khoa)
                    <option value="{{ $khoa->id }}" {{ old('khoa_id') == $khoa->id ? 'selected' : '' }}>
                        {{ $khoa->ten_khoa }}</option>
                @endforeach
            </select>
            @error('khoa_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Ngành --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Ngành <span class="text-danger">*</span></label>
            <select id="nganh_id" name="nganh_id" class="form-select @error('nganh_id') is-invalid @enderror" required
                disabled>
                <option value="">-- Chọn khoa trước --</option>
                {{-- Options sẽ được thêm động bằng JavaScript --}}
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
            <select id="chuyen_nganh_id" name="chuyen_nganh_id"
                class="form-select @error('chuyen_nganh_id') is-invalid @enderror" required disabled>
                <option value="">-- Chọn ngành trước --</option>
                {{-- Options sẽ được thêm động bằng JavaScript --}}
            </select>
            @error('chuyen_nganh_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div> {{-- Khóa học --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Khóa học <span class="text-danger">*</span></label>
            <select name="khoa_hoc_id" class="form-select @error('khoa_hoc_id') is-invalid @enderror" required>
                <option value="">-- Chọn khóa --</option>
                @foreach ($khoaHocs as $kh)
                    <option value="{{ $kh->id }}" {{ old('khoa_hoc_id') == $kh->id ? 'selected' : '' }}>
                        {{ $kh->ten_khoa_hoc }} ({{ $kh->nam_bat_dau }}-{{ $kh->nam_ket_thuc }})
                    </option>
                @endforeach
            </select>
            @error('khoa_hoc_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Trạng thái --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
            <select name="trang_thai_hoc_tap_id"
                class="form-select @error('trang_thai_hoc_tap_id') is-invalid @enderror" required>
                <option value="">-- Chọn trạng thái --</option>
                @foreach ($trangThais as $tt)
                    <option value="{{ $tt->id }}"
                        {{ old('trang_thai_hoc_tap_id') == $tt->id ? 'selected' : '' }}>
                        {{ $tt->ten_trang_thai }}
                    </option>
                @endforeach
            </select>
            @error('trang_thai_hoc_tap_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Kỳ hiện tại --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Kỳ hiện tại</label>
            <input type="number" name="ky_hien_tai" class="form-control @error('ky_hien_tai') is-invalid @enderror"
                value="{{ old('ky_hien_tai', 1) }}" min="1" max="10">
            @error('ky_hien_tai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- THÔNG TIN CÁ NHÂN --}}
<h6 class="text-primary mt-3 mb-3">👤 Thông tin cá nhân</h6>
<div class="row">
    {{-- Ngày sinh --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="ngay_sinh" class="form-control @error('ngay_sinh') is-invalid @enderror"
                value="{{ old('ngay_sinh') }}">
            @error('ngay_sinh')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Giới tính --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gioi_tinh" class="form-select @error('gioi_tinh') is-invalid @enderror">
                <option value="">-- Chọn giới tính --</option>
                <option value="nam" {{ old('gioi_tinh') == 'nam' ? 'selected' : '' }}>Nam</option>
                <option value="nu" {{ old('gioi_tinh') == 'nu' ? 'selected' : '' }}>Nữ</option>
                <option value="khac" {{ old('gioi_tinh') == 'khac' ? 'selected' : '' }}>Khác</option>
            </select>
            @error('gioi_tinh')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Số điện thoại --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="so_dien_thoai"
                class="form-control @error('so_dien_thoai') is-invalid @enderror" value="{{ old('so_dien_thoai') }}"
                placeholder="0987654321">
            @error('so_dien_thoai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- ĐỊA CHỈ --}}
<h6 class="text-primary mt-3 mb-3">📍 Địa chỉ thường trú</h6>
<div class="row">
    {{-- Số nhà, đường --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Số nhà, đường</label>
            <input type="text" name="so_nha_duong"
                class="form-control @error('so_nha_duong') is-invalid @enderror" value="{{ old('so_nha_duong') }}"
                placeholder="VD: Số 123, Đường Lê Lợi">
            @error('so_nha_duong')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Phường/Xã --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Phường/Xã</label>
            <input type="text" name="phuong_xa" class="form-control @error('phuong_xa') is-invalid @enderror"
                value="{{ old('phuong_xa') }}" placeholder="VD: Phường Bến Nghé">
            @error('phuong_xa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Quận/Huyện --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Quận/Huyện</label>
            <input type="text" name="quan_huyen" class="form-control @error('quan_huyen') is-invalid @enderror"
                value="{{ old('quan_huyen') }}" placeholder="VD: Quận 1">
            @error('quan_huyen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Tỉnh/Thành phố --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Tỉnh/Thành phố</label>
            <input type="text" name="tinh_thanh" class="form-control @error('tinh_thanh') is-invalid @enderror"
                value="{{ old('tinh_thanh') }}" placeholder="VD: TP. Hồ Chí Minh">
            @error('tinh_thanh')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- CCCD --}}
<h6 class="text-primary mt-3 mb-3">🆔 Căn cước công dân</h6>
<div class="row">
    {{-- Số CCCD --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Số CCCD</label>
            <input type="text" name="can_cuoc_cong_dan"
                class="form-control @error('can_cuoc_cong_dan') is-invalid @enderror"
                value="{{ old('can_cuoc_cong_dan') }}" placeholder="12 số" maxlength="12">
            @error('can_cuoc_cong_dan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Ngày cấp --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Ngày cấp</label>
            <input type="date" name="ngay_cap_cccd"
                class="form-control @error('ngay_cap_cccd') is-invalid @enderror"
                value="{{ old('ngay_cap_cccd') }}">
            @error('ngay_cap_cccd')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Nơi cấp --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="form-label">Nơi cấp</label>
            <input type="text" name="noi_cap_cccd"
                class="form-control @error('noi_cap_cccd') is-invalid @enderror" value="{{ old('noi_cap_cccd') }}"
                placeholder="VD: Cục Cảnh sát QLHC về TTXH">
            @error('noi_cap_cccd')
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
            <input type="file" name="anh_dai_dien"
                class="form-control @error('anh_dai_dien') is-invalid @enderror" accept="image/*">
            <small class="text-muted">Chấp nhận: JPG, PNG, GIF. Tối đa 2MB</small>
            @error('anh_dai_dien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<script>
    // Data từ server
    const allNganhs = @json($nganhs);
    const allChuyenNganhs = @json($chuyenNganhs);
    const oldKhoaId = "{{ old('khoa_id') }}";
    const oldNganhId = "{{ old('nganh_id') }}";
    const oldChuyenNganhId = "{{ old('chuyen_nganh_id') }}";

    document.addEventListener('DOMContentLoaded', function() {
        const khoaSelect = document.getElementById('khoa_id');
        const nganhSelect = document.getElementById('nganh_id');
        const chuyenNganhSelect = document.getElementById('chuyen_nganh_id');

        if (!khoaSelect || !nganhSelect || !chuyenNganhSelect) {
            return;
        }

        console.log('✅ Data loaded:', allNganhs.length, 'ngành,', allChuyenNganhs.length, 'chuyên ngành');

        // Cập nhật Ngành
        function updateNganhs(khoaId) {
            nganhSelect.innerHTML = '<option value="">-- Chọn ngành --</option>';

            if (!khoaId) {
                nganhSelect.disabled = true;
                nganhSelect.querySelector('option').textContent = '-- Chọn khoa trước --';
                updateChuyenNganhs('');
                return;
            }

            const filtered = allNganhs.filter(n => n.khoa_id == khoaId);
            filtered.forEach(nganh => {
                const opt = new Option(nganh.ten_nganh, nganh.id, false, oldNganhId == nganh.id);
                nganhSelect.add(opt);
            });

            nganhSelect.disabled = false;
            console.log('→ Hiển thị', filtered.length, 'ngành');

            if (oldNganhId && nganhSelect.value) {
                updateChuyenNganhs(nganhSelect.value);
            } else {
                updateChuyenNganhs('');
            }
        }

        // Cập nhật Chuyên ngành
        function updateChuyenNganhs(nganhId) {
            chuyenNganhSelect.innerHTML = '<option value="">-- Chọn chuyên ngành --</option>';

            if (!nganhId) {
                chuyenNganhSelect.disabled = true;
                chuyenNganhSelect.querySelector('option').textContent = '-- Chọn ngành trước --';
                return;
            }

            const filtered = allChuyenNganhs.filter(cn => cn.nganh_id == nganhId);
            filtered.forEach(cn => {
                const opt = new Option(cn.ten_chuyen_nganh, cn.id, false, oldChuyenNganhId == cn.id);
                chuyenNganhSelect.add(opt);
            });

            chuyenNganhSelect.disabled = false;
            console.log('→ Hiển thị', filtered.length, 'chuyên ngành');
        }

        // Events
        khoaSelect.addEventListener('change', () => updateNganhs(khoaSelect.value));
        nganhSelect.addEventListener('change', () => updateChuyenNganhs(nganhSelect.value));

        // Khởi tạo
        if (oldKhoaId) {
            updateNganhs(oldKhoaId);
        }
    });
</script>
