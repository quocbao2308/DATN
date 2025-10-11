<section>
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Upload ảnh đại diện - CHỈ cho Admin, Đào tạo, Giảng viên --}}
        @if ($role !== 'Sinh viên')
            <div class="mb-3">
                <label for="anh_dai_dien" class="form-label">Ảnh đại diện</label>
                <div class="d-flex align-items-center gap-3">
                    @if ($details && isset($details->anh_dai_dien) && $details->anh_dai_dien)
                        <img src="{{ asset('storage/' . $details->anh_dai_dien) }}" alt="Avatar" class="rounded-circle"
                            width="80" height="80" style="object-fit: cover; border: 2px solid #e9ecef;"
                            id="preview-avatar">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 32px; font-weight: bold; border: 2px solid #e9ecef;"
                            id="preview-avatar-placeholder">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <img src="" alt="Avatar" class="rounded-circle d-none" width="80" height="80"
                            style="object-fit: cover; border: 2px solid #e9ecef;" id="preview-avatar">
                    @endif
                    <input type="file" class="form-control @error('anh_dai_dien') is-invalid @enderror"
                        id="anh_dai_dien" name="anh_dai_dien" accept="image/*" onchange="previewImage(this)">
                </div>
                @error('anh_dai_dien')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Chọn ảnh (JPG, PNG, GIF - tối đa 2MB)
                </small>
            </div>
        @else
            {{-- Thông báo cho sinh viên --}}
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Lưu ý:</strong> Ảnh đại diện của sinh viên được quản lý bởi Admin.
                Vui lòng liên hệ phòng Đào tạo để cập nhật ảnh.
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Email được sử dụng để đăng nhập vào hệ thống
            </small>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-2"></i>Lưu thay đổi
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success">
                    <i class="bi bi-check-circle me-1"></i>Đã lưu thành công!
                </span>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-avatar');
        const placeholder = document.getElementById('preview-avatar-placeholder');

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

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
    <div>
        <p class="text-sm mt-2 text-gray-800">
            {{ __('Your email address is unverified.') }}

            <button form="send-verification"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Click here to re-send the verification email.') }}
            </button>
        </p>

        @if (session('status') === 'verification-link-sent')
            <p class="mt-2 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
        @endif
    </div>
@endif
</section>
