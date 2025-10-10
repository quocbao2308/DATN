<section>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                id="current_password" name="current_password" required>
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                id="password" name="password" required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Tối thiểu 8 ký tự</small>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-shield-check me-2"></i>Đổi mật khẩu
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success">
                    <i class="bi bi-check-circle me-1"></i>Đã đổi mật khẩu thành công!
                </span>
            @endif
        </div>
    </form>
</section>
