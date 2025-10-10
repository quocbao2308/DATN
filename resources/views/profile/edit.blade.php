@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <h3>Hồ sơ cá nhân</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-4">
                <!-- Card thông tin cơ bản -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ asset('assets/images/faces/1.jpg') }}" alt="Admin" class="rounded-circle"
                                width="150">
                            <div class="mt-3">
                                <h4>{{ $user->name }}</h4>
                                <p class="text-secondary mb-1">{{ $role }}</p>
                                <p class="text-muted font-size-sm">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card thông tin chi tiết theo vai trò -->
                @if ($details)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Thông tin chi tiết</h5>

                            @if ($role === 'Admin')
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Mã Admin:</strong></div>
                                    <div class="col-sm-7">{{ $details->ma_admin ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Số điện thoại:</strong></div>
                                    <div class="col-sm-7">{{ $details->sdt ?? 'N/A' }}</div>
                                </div>
                            @elseif($role === 'Đào tạo')
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Mã Đào tạo:</strong></div>
                                    <div class="col-sm-7">{{ $details->ma_dao_tao ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Số điện thoại:</strong></div>
                                    <div class="col-sm-7">{{ $details->sdt ?? 'N/A' }}</div>
                                </div>
                            @elseif($role === 'Giảng viên')
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Mã GV:</strong></div>
                                    <div class="col-sm-7">{{ $details->ma_giang_vien ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Khoa:</strong></div>
                                    <div class="col-sm-7">{{ $details->ten_khoa ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Trình độ:</strong></div>
                                    <div class="col-sm-7">{{ $details->ten_trinh_do ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Số điện thoại:</strong></div>
                                    <div class="col-sm-7">{{ $details->sdt ?? 'N/A' }}</div>
                                </div>
                            @elseif($role === 'Sinh viên')
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Mã SV:</strong></div>
                                    <div class="col-sm-7">{{ $details->ma_sinh_vien ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Ngành:</strong></div>
                                    <div class="col-sm-7">{{ $details->ten_nganh ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Chuyên ngành:</strong></div>
                                    <div class="col-sm-7">{{ $details->ten_chuyen_nganh ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Khóa học:</strong></div>
                                    <div class="col-sm-7">{{ $details->ten_khoa_hoc ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Trạng thái:</strong></div>
                                    <div class="col-sm-7">
                                        <span class="badge bg-success">{{ $details->ten_trang_thai ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Số điện thoại:</strong></div>
                                    <div class="col-sm-7">{{ $details->sdt ?? 'N/A' }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-12 col-lg-8">
                <!-- Thông tin tài khoản -->
                <div class="card">
                    <div class="card-header">
                        <h4>Thông tin tài khoản</h4>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Đổi mật khẩu</h4>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
