@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Chi tiết Giảng viên</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.giang-vien.index') }}">Giảng viên</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- Card ảnh đại diện --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($giangVien->anh_dai_dien)
                                <img src="{{ Storage::url($giangVien->anh_dai_dien) }}" 
                                    alt="Avatar" class="img-fluid rounded-circle mb-3" 
                                    style="max-width: 200px;">
                            @else
                                <img src="{{ asset('assets/static/images/faces/1.jpg') }}" 
                                    alt="Default Avatar" class="img-fluid rounded-circle mb-3" 
                                    style="max-width: 200px;">
                            @endif
                            <h4 class="mb-1">{{ $giangVien->ho_ten }}</h4>
                            <p class="text-muted">{{ $giangVien->ma_giang_vien }}</p>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ route('dao-tao.giang-vien.edit', $giangVien->id) }}" 
                                    class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('dao-tao.giang-vien.destroy', $giangVien->id) }}" 
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa giảng viên này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card thông tin --}}
                <div class="col-md-8">
                    {{-- Thông tin cá nhân --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="200"><strong>Mã giảng viên:</strong></td>
                                            <td>{{ $giangVien->ma_giang_vien }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Họ tên:</strong></td>
                                            <td>{{ $giangVien->ho_ten }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $giangVien->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Số điện thoại:</strong></td>
                                            <td>{{ $giangVien->so_dien_thoai ?? 'Chưa cập nhật' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ngày vào trường:</strong></td>
                                            <td>{{ $giangVien->ngay_vao_truong?->format('d/m/Y') ?? 'Chưa cập nhật' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin chuyên môn --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin chuyên môn</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="200"><strong>Khoa:</strong></td>
                                            <td>{{ $giangVien->khoa->ten_khoa ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Trình độ:</strong></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $giangVien->trinhDo->ten_trinh_do ?? 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chuyên môn:</strong></td>
                                            <td>{{ $giangVien->chuyen_mon ?? 'Chưa cập nhật' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút quay lại --}}
            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('dao-tao.giang-vien.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
