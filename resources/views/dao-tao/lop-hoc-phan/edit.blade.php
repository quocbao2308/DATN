@extends('layouts.layout-daotao')

@section('title', 'Sửa lớp học phần')

@section('content')
<div class="container mt-4">
    <h2>Sửa Lớp học phần</h2>

    <form action="{{ route('dao-tao.lop-hoc-phan.update', $lopHocPhan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Mã lớp học phần --}}
        <div class="mb-3">
            <label for="ma_lop_hp" class="form-label">Mã lớp học phần</label>
            <input type="text" name="ma_lop_hp" id="ma_lop_hp" class="form-control" value="{{ $lopHocPhan->ma_lop_hp }}" required>
        </div>

        {{-- Môn học --}}
        <div class="mb-3">
            <label for="mon_hoc_id" class="form-label">Môn học</label>
            <select name="mon_hoc_id" id="mon_hoc_id" class="form-select" required>
                <option value="">-- Chọn môn học --</option>
                @foreach($monHocs as $mon)
                    <option value="{{ $mon->id }}" {{ $lopHocPhan->mon_hoc_id == $mon->id ? 'selected' : '' }}>
                        {{ $mon->ten_mon }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Học kỳ --}}
        <div class="mb-3">
            <label for="hoc_ky_id" class="form-label">Học kỳ</label>
            <select name="hoc_ky_id" id="hoc_ky_id" class="form-select" required>
                <option value="">-- Chọn học kỳ --</option>
                @foreach($hocKys as $hk)
                    <option value="{{ $hk->id }}" {{ $lopHocPhan->hoc_ky_id == $hk->id ? 'selected' : '' }}>
                        {{ $hk->ten_hoc_ky }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Hình thức --}}
        <div class="mb-3">
            <label for="hinh_thuc" class="form-label">Hình thức học</label>
            <select name="hinh_thuc" id="hinh_thuc" class="form-select" required>
                <option value="">-- Chọn hình thức --</option>
                <option value="offline" {{ $lopHocPhan->hinh_thuc == 'offline' ? 'selected' : '' }}>Offline</option>
                <option value="online" {{ $lopHocPhan->hinh_thuc == 'online' ? 'selected' : '' }}>Online</option>
                <option value="hybrid" {{ $lopHocPhan->hinh_thuc == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
        </div>

        {{-- Sức chứa --}}
        <div class="mb-3">
            <label for="suc_chua" class="form-label">Sức chứa</label>
            <input type="number" name="suc_chua" id="suc_chua" class="form-control" value="{{ $lopHocPhan->suc_chua }}" placeholder="Nhập số lượng tối đa">
        </div>

        {{-- Link học online (tùy chọn) --}}
        <div class="mb-3">
            <label for="link_online" class="form-label">Link học online</label>
            <input type="text" name="link_online" id="link_online" class="form-control" value="{{ $lopHocPhan->link_online }}" placeholder="Nhập link (nếu có)">
        </div>

        {{-- Ghi chú --}}
        <div class="mb-3">
            <label for="ghi_chu" class="form-label">Ghi chú</label>
            <textarea name="ghi_chu" id="ghi_chu" rows="3" class="form-control">{{ $lopHocPhan->ghi_chu }}</textarea>
        </div>

        {{-- Trạng thái lớp --}}
        <div class="mb-3">
            <label for="trang_thai_lop" class="form-label">Trạng thái lớp</label>
            <select name="trang_thai_lop" id="trang_thai_lop" class="form-select" required>
                <option value="mo_dang_ky" {{ $lopHocPhan->trang_thai_lop == 'mo_dang_ky' ? 'selected' : '' }}>Mở đăng ký</option>
                <option value="dang_hoc" {{ $lopHocPhan->trang_thai_lop == 'dang_hoc' ? 'selected' : '' }}>Đang học</option>
                <option value="ket_thuc" {{ $lopHocPhan->trang_thai_lop == 'ket_thuc' ? 'selected' : '' }}>Kết thúc</option>
                <option value="huy" {{ $lopHocPhan->trang_thai_lop == 'huy' ? 'selected' : '' }}>Hủy</option>
            </select>
        </div>

        {{-- Nút hành động --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('dao-tao.lop-hoc-phan.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
