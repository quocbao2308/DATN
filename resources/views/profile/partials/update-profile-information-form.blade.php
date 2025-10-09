<section>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

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
</div>

<div class="flex items-center gap-4">
    <x-primary-button>{{ __('Save') }}</x-primary-button>

    @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
            {{ __('Saved.') }}</p>
    @endif
</div>
</form>
</section>
