@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Sửa Lớp học phần</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.lop-hoc-phan.index') }}">Lớp học phần</a></li>
                            <li class="breadcrumb-item active">Sửa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Lớp học phần</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.lop-hoc-phan.update', $lopHocPhan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Cột trái --}}
                            <div class="col-md-6">
                                {{-- Mã lớp học phần --}}
                                <div class="mb-3">
                                    <label for="ma_lop_hp" class="form-label required">Mã lớp học phần</label>
                                    <input type="text" name="ma_lop_hp" id="ma_lop_hp"
                                        class="form-control @error('ma_lop_hp') is-invalid @enderror"
                                        value="{{ old('ma_lop_hp', $lopHocPhan->ma_lop_hp) }}" required>
                                    @error('ma_lop_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Môn học --}}
                                <div class="mb-3">
                                    <label for="mon_hoc_id" class="form-label required">Môn học</label>
                                    <select name="mon_hoc_id" id="mon_hoc_id"
                                        class="form-select @error('mon_hoc_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn môn học --</option>
                                        @foreach($monHocs as $mon)
                                            <option value="{{ $mon->id }}" 
                                                {{ old('mon_hoc_id', $lopHocPhan->mon_hoc_id) == $mon->id ? 'selected' : '' }}>
                                                {{ $mon->ten_mon }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mon_hoc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Học kỳ --}}
                                <div class="mb-3">
                                    <label for="hoc_ky_id" class="form-label required">Học kỳ</label>
                                    <select name="hoc_ky_id" id="hoc_ky_id"
                                        class="form-select @error('hoc_ky_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn học kỳ --</option>
                                        @foreach($hocKys as $hk)
                                            <option value="{{ $hk->id }}" 
                                                {{ old('hoc_ky_id', $lopHocPhan->hoc_ky_id) == $hk->id ? 'selected' : '' }}>
                                                {{ $hk->ten_hoc_ky }} ({{ $hk->nam_bat_dau }} - {{ $hk->nam_ket_thuc }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hoc_ky_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Sức chứa --}}
                                <div class="mb-3">
                                    <label for="suc_chua" class="form-label">Sức chứa</label>
                                    <input type="number" name="suc_chua" id="suc_chua"
                                        class="form-control @error('suc_chua') is-invalid @enderror"
                                        value="{{ old('suc_chua', $lopHocPhan->suc_chua) }}">
                                    @error('suc_chua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cột phải --}}
                            <div class="col-md-6">
                                {{-- Hình thức học --}}
                                <div class="mb-3">
                                    <label for="hinh_thuc" class="form-label required">Hình thức học</label>
                                    <select name="hinh_thuc" id="hinh_thuc"
                                        class="form-select @error('hinh_thuc') is-invalid @enderror" required>
                                        <option value="">-- Chọn hình thức --</option>
                                        <option value="offline" {{ old('hinh_thuc', $lopHocPhan->hinh_thuc) == 'offline' ? 'selected' : '' }}>Offline</option>
                                        <option value="online" {{ old('hinh_thuc', $lopHocPhan->hinh_thuc) == 'online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('hinh_thuc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Link online (chỉ hiện nếu là online) --}}
                                <div class="mb-3" id="link_online_group" style="display: none;">
                                    <label for="link_online" class="form-label">Link học online</label>
                                    <input type="url" name="link_online" id="link_online"
                                        class="form-control @error('link_online') is-invalid @enderror"
                                        value="{{ old('link_online', $lopHocPhan->link_online) }}"
                                        placeholder="https://...">
                                    @error('link_online')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Trạng thái lớp --}}
                                <div class="mb-3">
                                    <label for="trang_thai_lop" class="form-label required">Trạng thái lớp</label>
                                    <select name="trang_thai_lop" id="trang_thai_lop"
                                        class="form-select @error('trang_thai_lop') is-invalid @enderror" required>
                                        <option value="">-- Chọn trạng thái --</option>
                                        <option value="mo_dang_ky" {{ old('trang_thai_lop', $lopHocPhan->trang_thai_lop) == 'mo_dang_ky' ? 'selected' : '' }}>Mở đăng ký</option>
                                        <option value="dang_hoc" {{ old('trang_thai_lop', $lopHocPhan->trang_thai_lop) == 'dang_hoc' ? 'selected' : '' }}>Đang học</option>
                                        <option value="ket_thuc" {{ old('trang_thai_lop', $lopHocPhan->trang_thai_lop) == 'ket_thuc' ? 'selected' : '' }}>Kết thúc</option>
                                    </select>
                                    @error('trang_thai_lop')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Ghi chú --}}
                                <div class="mb-3">
                                    <label for="ghi_chu" class="form-label">Ghi chú</label>
                                    <textarea name="ghi_chu" id="ghi_chu" rows="3"
                                        class="form-control @error('ghi_chu') is-invalid @enderror">{{ old('ghi_chu', $lopHocPhan->ghi_chu) }}</textarea>
                                    @error('ghi_chu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('dao-tao.lop-hoc-phan.index') }}" class="btn btn-secondary">
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
        // Hiện/ẩn input link online theo hình thức học
        document.addEventListener("DOMContentLoaded", function() {
            const hinhThuc = document.getElementById('hinh_thuc');
            const linkGroup = document.getElementById('link_online_group');

            function toggleLink() {
                if (hinhThuc.value === 'online') {
                    linkGroup.style.display = 'block';
                } else {
                    linkGroup.style.display = 'none';
                }
            }

            hinhThuc.addEventListener('change', toggleLink);
            toggleLink(); // chạy khi load trang
        });
    </script>
@endsection
