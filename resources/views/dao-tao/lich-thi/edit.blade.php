@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Sửa Lịch thi</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.lich-thi.index') }}">Lịch thi</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Lịch thi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.lich-thi.update', $lichThi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Lớp học phần --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lop_hoc_phan_id" class="form-label required">Lớp học phần</label>
                                    <select name="lop_hoc_phan_id" id="lop_hoc_phan_id"
                                        class="form-select @error('lop_hoc_phan_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn lớp học phần --</option>
                                        @foreach($lopHocPhan as $lhp)
                                            <option value="{{ $lhp->id }}"
                                                {{ old('lop_hoc_phan_id', $lichThi->lop_hoc_phan_id) == $lhp->id ? 'selected' : '' }}>
                                                {{ $lhp->ma_lop_hp }} - {{ $lhp->monHoc->ten_mon ?? 'Không rõ môn' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lop_hoc_phan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Phòng học --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phong_hoc_id" class="form-label required">Phòng thi</label>
                                    <select name="phong_hoc_id" id="phong_hoc_id"
                                        class="form-select @error('phong_hoc_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn phòng học --</option>
                                        @foreach($phongHoc as $phong)
                                            <option value="{{ $phong->id }}"
                                                {{ old('phong_hoc_id', $lichThi->phong_hoc_id) == $phong->id ? 'selected' : '' }}>
                                                {{ $phong->ten_phong }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('phong_hoc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Ngày thi --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ngay_thi" class="form-label required">Ngày thi</label>
                                    <input type="date" name="ngay_thi" id="ngay_thi"
                                        class="form-control @error('ngay_thi') is-invalid @enderror"
                                        value="{{ old('ngay_thi', $lichThi->ngay_thi) }}" required>
                                    @error('ngay_thi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Giờ bắt đầu --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gio_bat_dau" class="form-label required">Giờ bắt đầu</label>
                                    <input type="time" name="gio_bat_dau" id="gio_bat_dau"
                                        class="form-control @error('gio_bat_dau') is-invalid @enderror"
                                        value="{{ old('gio_bat_dau', $lichThi->gio_bat_dau) }}" required>
                                    @error('gio_bat_dau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Giờ kết thúc --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gio_ket_thuc" class="form-label required">Giờ kết thúc</label>
                                    <input type="time" name="gio_ket_thuc" id="gio_ket_thuc"
                                        class="form-control @error('gio_ket_thuc') is-invalid @enderror"
                                        value="{{ old('gio_ket_thuc', $lichThi->gio_ket_thuc) }}" required>
                                    @error('gio_ket_thuc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Hình thức --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hinh_thuc" class="form-label required">Hình thức thi</label>
                                    <select name="hinh_thuc" id="hinh_thuc"
                                        class="form-select @error('hinh_thuc') is-invalid @enderror" required>
                                        <option value="">-- Chọn hình thức --</option>
                                        <option value="offline" {{ old('hinh_thuc', $lichThi->hinh_thuc) == 'offline' ? 'selected' : '' }}>Offline</option>
                                        <option value="online" {{ old('hinh_thuc', $lichThi->hinh_thuc) == 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="hybrid" {{ old('hinh_thuc', $lichThi->hinh_thuc) == 'hybrid' ? 'selected' : '' }}>Kết hợp</option>
                                    </select>
                                    @error('hinh_thuc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Link online --}}
                            <div class="col-md-6" id="link_online_group" style="display: none;">
                                <div class="mb-3">
                                    <label for="link_online" class="form-label">Link thi online</label>
                                    <input type="text" name="link_online" id="link_online"
                                        class="form-control @error('link_online') is-invalid @enderror"
                                        value="{{ old('link_online', $lichThi->link_online) }}">
                                    @error('link_online')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- File PDF --}}
                        <div class="mb-3">
                            <label for="file_pdf" class="form-label">File đề thi (PDF)</label>
                            @if($lichThi->file_pdf)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $lichThi->file_pdf) }}" target="_blank">
                                        {{ basename($lichThi->file_pdf) }}
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file_pdf" id="file_pdf"
                                class="form-control @error('file_pdf') is-invalid @enderror"
                                accept="application/pdf">
                            @error('file_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Chọn file mới nếu muốn thay đổi (chỉ PDF, tối đa 10MB)</small>
                        </div>

                        {{-- Ngày gửi --}}
                        <div class="mb-3">
                            <label for="ngay_gui" class="form-label">Ngày gửi</label>
                            <input type="datetime-local" name="ngay_gui" id="ngay_gui"
                                class="form-control @error('ngay_gui') is-invalid @enderror"
                                value="{{ old('ngay_gui', \Carbon\Carbon::parse($lichThi->ngay_gui)->format('Y-m-d\TH:i')) }}">
                            @error('ngay_gui')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('dao-tao.lich-thi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <style>
        .required::after {
            content: " *";
            color: red;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hinhThuc = document.getElementById('hinh_thuc');
            const linkGroup = document.getElementById('link_online_group');

            function toggleLink() {
                if (hinhThuc.value === 'online' || hinhThuc.value === 'hybrid') {
                    linkGroup.style.display = 'block';
                } else {
                    linkGroup.style.display = 'none';
                }
            }

            hinhThuc.addEventListener('change', toggleLink);
            toggleLink(); // Chạy khi load trang
        });
    </script>
@endsection
