@extends('layouts.layout-admin')

@section('content')
    <div class="container py-4">
        <h2>Chi tiết người dùng</h2>

        <div class="row mt-4">
            <div class="col-md-4">
                {{-- Card ảnh đại diện --}}
                <div class="card mb-3">
                    <div class="card-body text-center">
                        @if ($details && isset($details->anh_dai_dien) && $details->anh_dai_dien)
                            <img src="{{ asset('storage/' . $details->anh_dai_dien) }}" alt="Ảnh đại diện"
                                class="img-fluid rounded-circle mb-3"
                                style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #e9ecef;">
                        @else
                            {{-- Avatar mặc định với chữ cái đầu --}}
                            <div class="rounded-circle mb-3 d-inline-flex align-items-center justify-content-center"
                                style="width: 180px; height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 72px; font-weight: bold; border: 4px solid #e9ecef;">
                                {{ $details ? strtoupper(substr($details->ho_ten, 0, 1)) : 'U' }}
                            </div>
                        @endif

                        @if ($details)
                            <h5 class="mb-1">{{ $details->ho_ten }}</h5>
                            @if ($role === 'Admin')
                                <p class="text-muted mb-0"><i class="fas fa-user-shield"></i> Quản trị viên</p>
                            @elseif ($role === 'Đào tạo')
                                <p class="text-muted mb-0"><i class="fas fa-graduation-cap"></i> Đào tạo</p>
                            @elseif ($role === 'Giảng viên')
                                <p class="text-muted mb-0"><i class="fas fa-chalkboard-teacher"></i>
                                    {{ $details->ma_giang_vien }}</p>
                            @elseif ($role === 'Sinh viên')
                                <p class="text-muted mb-0"><i class="fas fa-user-graduate"></i> {{ $details->ma_sinh_vien }}
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Card thông tin đăng nhập --}}
                <div class="card mb-3">
                    <div class="card-header">Thông tin đăng nhập</div>
                    <div class="card-body">
                        <p><strong>Vai trò:</strong> {{ $role }}</p>
                        <p><strong>Username:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                </div>

                {{-- Buttons --}}
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-edit"></i> Sửa thông tin
                </a>

                {{-- Reset Password Button --}}
                <form action="{{ route('admin.users.resetPassword', $user) }}" method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn reset mật khẩu cho người dùng này?\n\nMật khẩu mới sẽ được tạo ngẫu nhiên và hiển thị sau khi reset.');">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-key"></i> Reset mật khẩu
                    </button>
                </form>
            </div>

            <div class="col-md-8">
                @if ($details)
                    <div class="card">
                        <div class="card-header">Thông tin chi tiết</div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th width="30%">Họ tên:</th>
                                    <td>{{ $details->ho_ten }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $details->email }}</td>
                                </tr>
                                <tr>
                                    <th>SĐT:</th>
                                    <td>{{ $details->so_dien_thoai ?? 'Chưa có' }}</td>
                                </tr>

                                @if ($role === 'Giảng viên')
                                    <tr>
                                        <th>Mã GV:</th>
                                        <td><span class="badge bg-dark">{{ $details->ma_giang_vien }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Khoa:</th>
                                        <td>{{ $details->ten_khoa }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trình độ:</th>
                                        <td>{{ $details->ten_trinh_do }}</td>
                                    </tr>
                                    @if (isset($details->chuyen_mon))
                                        <tr>
                                            <th>Chuyên môn:</th>
                                            <td>{{ $details->chuyen_mon }}</td>
                                        </tr>
                                    @endif
                                    @if (isset($details->ngay_vao_truong))
                                        <tr>
                                            <th>Ngày vào trường:</th>
                                            <td>{{ date('d/m/Y', strtotime($details->ngay_vao_truong)) }}</td>
                                        </tr>
                                    @endif
                                @endif

                                @if ($role === 'Sinh viên')
                                    <tr>
                                        <th>Mã SV:</th>
                                        <td><span class="badge bg-dark">{{ $details->ma_sinh_vien }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Ngành:</th>
                                        <td>{{ $details->ten_nganh }}</td>
                                    </tr>
                                    <tr>
                                        <th>Chuyên ngành:</th>
                                        <td>{{ $details->ten_chuyen_nganh }}</td>
                                    </tr>
                                    <tr>
                                        <th>Khóa học:</th>
                                        <td>{{ $details->ten_khoa_hoc }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kỳ hiện tại:</th>
                                        <td>Kỳ {{ $details->ky_hien_tai ?? 1 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td><span class="badge bg-success">{{ $details->ten_trang_thai }}</span></td>
                                    </tr>

                                    @if (isset($details->ngay_sinh))
                                        <tr>
                                            <th>Ngày sinh:</th>
                                            <td>{{ date('d/m/Y', strtotime($details->ngay_sinh)) }}</td>
                                        </tr>
                                    @endif
                                    @if (isset($details->gioi_tinh))
                                        <tr>
                                            <th>Giới tính:</th>
                                            <td>{{ $details->gioi_tinh }}</td>
                                        </tr>
                                    @endif

                                    @if (isset($details->so_nha_duong) ||
                                            isset($details->phuong_xa) ||
                                            isset($details->quan_huyen) ||
                                            isset($details->tinh_thanh))
                                        <tr>
                                            <th>Địa chỉ:</th>
                                            <td>
                                                @if (isset($details->so_nha_duong))
                                                    {{ $details->so_nha_duong }},
                                                @endif
                                                @if (isset($details->phuong_xa))
                                                    {{ $details->phuong_xa }},
                                                @endif
                                                @if (isset($details->quan_huyen))
                                                    {{ $details->quan_huyen }},
                                                @endif
                                                @if (isset($details->tinh_thanh))
                                                    {{ $details->tinh_thanh }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif

                                    @if (isset($details->can_cuoc_cong_dan))
                                        <tr>
                                            <th>CCCD:</th>
                                            <td>{{ $details->can_cuoc_cong_dan }}</td>
                                        </tr>
                                    @endif
                                    @if (isset($details->ngay_cap_cccd))
                                        <tr>
                                            <th>Ngày cấp CCCD:</th>
                                            <td>{{ date('d/m/Y', strtotime($details->ngay_cap_cccd)) }}</td>
                                        </tr>
                                    @endif
                                    @if (isset($details->noi_cap_cccd))
                                        <tr>
                                            <th>Nơi cấp CCCD:</th>
                                            <td>{{ $details->noi_cap_cccd }}</td>
                                        </tr>
                                    @endif
                                @endif
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">Không có thông tin chi tiết</div>
                @endif
            </div>
        </div>
    </div>
@endsection
