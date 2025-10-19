@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Sửa Lịch học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.lich-hoc.index') }}">Lịch học</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Lịch học</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.lich-hoc.update', $lichHoc->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lop_hoc_phan_id" class="form-label required">Lớp học phần</label>
                                    <select name="lop_hoc_phan_id" id="lop_hoc_phan_id"
                                        class="form-select @error('lop_hoc_phan_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn lớp học phần --</option>
                                        @foreach ($lopHocPhans as $lhp)
                                            <option value="{{ $lhp->id }}"
                                                {{ old('lop_hoc_phan_id', $lichHoc->lop_hoc_phan_id) == $lhp->id ? 'selected' : '' }}>
                                                {{ $lhp->ma_lop_hp }} - {{ $lhp->monHoc->ten_mon ?? 'Không rõ môn' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('lop_hoc_phan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phong_hoc_id" class="form-label required">Phòng học</label>
                                    <select name="phong_hoc_id" id="phong_hoc_id"
                                        class="form-select @error('phong_hoc_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn phòng --</option>
                                        @foreach ($phongHocs as $phong)
                                            <option value="{{ $phong->id }}"
                                                {{ old('phong_hoc_id', $lichHoc->phong_hoc_id) == $phong->id ? 'selected' : '' }}>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ngay" class="form-label required">Ngày</label>
                                    <input type="date" name="ngay" id="ngay"
                                        class="form-control @error('ngay') is-invalid @enderror"
                                        value="{{ old('ngay', $lichHoc->ngay) }}" required>
                                    @error('ngay')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gio_bat_dau" class="form-label required">Giờ bắt đầu</label>
                                    <input type="time" name="gio_bat_dau" id="gio_bat_dau"
                                        class="form-control @error('gio_bat_dau') is-invalid @enderror"
                                        value="{{ old('gio_bat_dau', $lichHoc->gio_bat_dau) }}" required>
                                    @error('gio_bat_dau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="gio_ket_thuc" class="form-label required">Giờ kết thúc</label>
                                    <input type="time" name="gio_ket_thuc" id="gio_ket_thuc"
                                        class="form-control @error('gio_ket_thuc') is-invalid @enderror"
                                        value="{{ old('gio_ket_thuc', $lichHoc->gio_ket_thuc) }}" required>
                                    @error('gio_ket_thuc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hinh_thuc_buoi_hoc" class="form-label required">Hình thức</label>
                                    <select name="hinh_thuc_buoi_hoc" id="hinh_thuc_buoi_hoc"
                                        class="form-select @error('hinh_thuc_buoi_hoc') is-invalid @enderror" required>
                                        <option value="">-- Chọn hình thức --</option>
                                        <option value="offline" {{ old('hinh_thuc_buoi_hoc', $lichHoc->hinh_thuc_buoi_hoc) == 'offline' ? 'selected' : '' }}>Offline</option>
                                        <option value="online" {{ old('hinh_thuc_buoi_hoc', $lichHoc->hinh_thuc_buoi_hoc) == 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="hybrid" {{ old('hinh_thuc_buoi_hoc', $lichHoc->hinh_thuc_buoi_hoc) == 'hybrid' ? 'selected' : '' }}>Kết hợp</option>
                                    </select>
                                    @error('hinh_thuc_buoi_hoc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6" id="link_online_group" style="display: none;">
                                <div class="mb-3">
                                    <label for="link_online" class="form-label">Link học online</label>
                                    <input type="text" name="link_online" id="link_online"
                                        class="form-control @error('link_online') is-invalid @enderror"
                                        value="{{ old('link_online', $lichHoc->link_online) }}">
                                    @error('link_online')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="giang_vien_phu_trach" class="form-label">Giảng viên phụ trách</label>
                                    <select name="giang_vien_phu_trach" class="form-select">
                                        <option value="">-- Không chọn --</option>
                                        @foreach($giangViens as $gv)
                                            <option value="{{ $gv->id }}" {{ old('giang_vien_phu_trach', $lichHoc->giang_vien_phu_trach) == $gv->id ? 'selected' : '' }}>
                                                {{ $gv->ho_ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ghi_chu" class="form-label">Ghi chú</label>
                                    <input type="text" name="ghi_chu" id="ghi_chu" class="form-control" value="{{ old('ghi_chu', $lichHoc->ghi_chu) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('dao-tao.lich-hoc.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hinhThuc = document.getElementById('hinh_thuc_buoi_hoc');
            const linkGroup = document.getElementById('link_online_group');

            function toggleLink() {
                if (hinhThuc.value === 'online' || hinhThuc.value === 'hybrid') {
                    linkGroup.style.display = 'block';
                } else {
                    linkGroup.style.display = 'none';
                }
            }

            hinhThuc.addEventListener('change', toggleLink);
            toggleLink();
        });
    </script>
@endsection
