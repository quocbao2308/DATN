@extends('layouts.layout-admin')

@section('title', 'Tạo Thông báo mới')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="mb-1">Tạo Thông báo mới</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Thông báo</a></li>
                    <li class="breadcrumb-item active">Tạo mới</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Thông tin Thông báo</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.notifications.store') }}" method="POST" id="notificationForm">
                            @csrf

                            <!-- Tiêu đề -->
                            <div class="mb-3">
                                <label for="tieu_de" class="form-label">
                                    Tiêu đề <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('tieu_de') is-invalid @enderror"
                                    id="tieu_de" name="tieu_de" value="{{ old('tieu_de') }}"
                                    placeholder="Nhập tiêu đề thông báo" required>
                                @error('tieu_de')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nội dung -->
                            <div class="mb-3">
                                <label for="noi_dung" class="form-label">
                                    Nội dung <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('noi_dung') is-invalid @enderror" id="noi_dung" name="noi_dung" rows="6"
                                    placeholder="Nhập nội dung thông báo" required>{{ old('noi_dung') }}</textarea>
                                @error('noi_dung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hỗ trợ định dạng văn bản đơn giản</small>
                            </div>

                            <!-- Loại thông báo -->
                            <div class="mb-3">
                                <label for="loai" class="form-label">
                                    Loại thông báo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('loai') is-invalid @enderror" id="loai"
                                    name="loai" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="thong_tin" {{ old('loai') == 'thong_tin' ? 'selected' : '' }}>
                                        Thông tin
                                    </option>
                                    <option value="canh_bao" {{ old('loai') == 'canh_bao' ? 'selected' : '' }}>
                                        Cảnh báo
                                    </option>
                                    <option value="quan_trong" {{ old('loai') == 'quan_trong' ? 'selected' : '' }}>
                                        Quan trọng
                                    </option>
                                </select>
                                @error('loai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Đối tượng nhận -->
                            <div class="mb-3">
                                <label for="vai_tro_nhan" class="form-label">
                                    Đối tượng nhận <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('vai_tro_nhan') is-invalid @enderror" id="vai_tro_nhan"
                                    name="vai_tro_nhan" required>
                                    <option value="">-- Chọn đối tượng --</option>
                                    <option value="all" {{ old('vai_tro_nhan') == 'all' ? 'selected' : '' }}>
                                        Tất cả người dùng
                                    </option>
                                    <option value="admin" {{ old('vai_tro_nhan') == 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="dao_tao" {{ old('vai_tro_nhan') == 'dao_tao' ? 'selected' : '' }}>
                                        Đào tạo
                                    </option>
                                    <option value="giang_vien" {{ old('vai_tro_nhan') == 'giang_vien' ? 'selected' : '' }}>
                                        Giảng viên
                                    </option>
                                    <option value="sinh_vien" {{ old('vai_tro_nhan') == 'sinh_vien' ? 'selected' : '' }}>
                                        Sinh viên
                                    </option>
                                    <option value="specific" {{ old('vai_tro_nhan') == 'specific' ? 'selected' : '' }}>
                                        Người dùng cụ thể
                                    </option>
                                </select>
                                @error('vai_tro_nhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Người nhận cụ thể (ẩn mặc định) -->
                            <div class="mb-3" id="specificUsers" style="display: none;">
                                <label for="nguoi_nhan_ids" class="form-label">
                                    Chọn người nhận <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('nguoi_nhan_ids') is-invalid @enderror"
                                    id="nguoi_nhan_ids" name="nguoi_nhan_ids[]" multiple size="5">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, old('nguoi_nhan_ids', [])) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('nguoi_nhan_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Giữ Ctrl (hoặc Cmd) để chọn nhiều người dùng</small>
                            </div>

                            <!-- Liên kết (tùy chọn) -->
                            <div class="mb-3">
                                <label for="lien_ket" class="form-label">
                                    Liên kết (tùy chọn)
                                    <i class="bi bi-info-circle text-muted" data-bs-toggle="tooltip"
                                        title="Để trống nếu không cần chuyển hướng"></i>
                                </label>
                                <input type="text" class="form-control @error('lien_ket') is-invalid @enderror"
                                    id="lien_ket" name="lien_ket" value="{{ old('lien_ket') }}"
                                    placeholder="Để trống hoặc nhập URL/đường dẫn">
                                @error('lien_ket')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">
                                    <strong>Ví dụ:</strong><br>
                                    <span class="text-success">✓ Để trống</span> - Thông báo chỉ hiển thị, không chuyển
                                    hướng<br>
                                    <span class="text-success">✓ /admin/users</span> - Chuyển đến trang quản lý người
                                    dùng<br>
                                    <span class="text-success">✓ https://example.com</span> - Chuyển đến website bên ngoài
                                </small>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Gửi thông báo
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="previewBtn">
                                    <i class="bi bi-eye"></i> Xem trước
                                </button>
                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Preview Card -->
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Xem trước</h5>
                    </div>
                    <div class="card-body">
                        <div id="previewContent">
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle"></i>
                                Nhập thông tin để xem trước thông báo
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Hướng dẫn</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">📌 Loại thông báo</h6>
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success"></i>
                                <strong>Thông tin:</strong> Thông báo chung
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-exclamation-triangle text-warning"></i>
                                <strong>Cảnh báo:</strong> Lưu ý quan trọng
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-exclamation-circle text-danger"></i>
                                <strong>Quan trọng:</strong> Yêu cầu hành động
                            </li>
                        </ul>

                        <hr>

                        <h6 class="mb-3">🔗 Liên kết (tùy chọn)</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-x-circle text-muted"></i>
                                <strong>Để trống:</strong> Chỉ hiển thị
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-house-door text-primary"></i>
                                <strong>Route:</strong> /admin/users
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-link-45deg text-info"></i>
                                <strong>URL:</strong> https://example.com
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle specific users field
                const vaiTroNhanSelect = document.getElementById('vai_tro_nhan');
                const specificUsersDiv = document.getElementById('specificUsers');
                const nguoiNhanIdsSelect = document.getElementById('nguoi_nhan_ids');

                if (vaiTroNhanSelect) {
                    vaiTroNhanSelect.addEventListener('change', function() {
                        if (this.value === 'specific') {
                            specificUsersDiv.style.display = 'block';
                            nguoiNhanIdsSelect.required = true;
                        } else {
                            specificUsersDiv.style.display = 'none';
                            nguoiNhanIdsSelect.required = false;
                        }
                    });

                    // Initialize on page load
                    if (vaiTroNhanSelect.value === 'specific') {
                        specificUsersDiv.style.display = 'block';
                        nguoiNhanIdsSelect.required = true;
                    }
                }

                // Live preview
                function updatePreview() {
                    const tieuDeInput = document.getElementById('tieu_de');
                    const noiDungInput = document.getElementById('noi_dung');
                    const loaiSelect = document.getElementById('loai');
                    const vaiTroNhanSelect = document.getElementById('vai_tro_nhan');
                    const previewContent = document.getElementById('previewContent');

                    if (!tieuDeInput || !noiDungInput || !loaiSelect || !vaiTroNhanSelect || !previewContent) {
                        console.error('Missing preview elements');
                        return;
                    }

                    const tieu_de = tieuDeInput.value;
                    const noi_dung = noiDungInput.value;
                    const loai = loaiSelect.value;
                    const vai_tro_nhan = vaiTroNhanSelect.value;

                    let badgeClass = 'bg-info';
                    let badgeText = 'Thông tin';

                    if (loai === 'canh_bao') {
                        badgeClass = 'bg-warning text-dark';
                        badgeText = 'Cảnh báo';
                    } else if (loai === 'quan_trong') {
                        badgeClass = 'bg-danger';
                        badgeText = 'Quan trọng';
                    }

                    let roleBadge = '';
                    const roleText = {
                        'all': 'Tất cả',
                        'admin': 'Admin',
                        'dao_tao': 'Đào tạo',
                        'giang_vien': 'Giảng viên',
                        'sinh_vien': 'Sinh viên',
                        'specific': 'Cá nhân'
                    };

                    if (vai_tro_nhan && roleText[vai_tro_nhan]) {
                        roleBadge = `<span class="badge bg-secondary mt-2">${roleText[vai_tro_nhan]}</span>`;
                    }

                    const preview = `
            <div class="notification-preview">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0">${tieu_de || '<em class="text-muted">Tiêu đề thông báo</em>'}</h6>
                    ${loai ? `<span class="badge ${badgeClass}">${badgeText}</span>` : ''}
                </div>
                ${roleBadge}
                <p class="text-muted mb-0 mt-2" style="font-size: 0.9rem;">
                    ${noi_dung || '<em>Nội dung thông báo</em>'}
                </p>
                <small class="text-muted mt-2 d-block">
                    <i class="bi bi-clock"></i> ${new Date().toLocaleString('vi-VN')}
                </small>
            </div>
        `;

                    previewContent.innerHTML = preview;
                }

                // Update preview on input
                const fieldsToWatch = ['tieu_de', 'noi_dung', 'loai', 'vai_tro_nhan'];
                fieldsToWatch.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.addEventListener('input', updatePreview);
                        element.addEventListener('change', updatePreview);
                    }
                });

                // Preview button
                const previewBtn = document.getElementById('previewBtn');
                if (previewBtn) {
                    previewBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        updatePreview();
                    });
                }

                // Initial preview
                updatePreview();
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .notification-preview {
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                border-left: 4px solid #0d6efd;
            }
        </style>
    @endpush
@endsection
