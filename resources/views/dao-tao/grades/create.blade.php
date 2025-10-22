@extends('layouts.layout-daotao')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6"><h3>Thêm điểm mới</h3></div>
        </div>
    </div>
<!-- Ghí chsu quản lý đểm  -->
    <section class="section">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header"><h5>Thông tin điểm</h5></div>
            <div class="card-body">
                <form action="{{ route('dao-tao.grades.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sinh_vien_id" class="form-label">Sinh viên <span class="text-danger">*</span></label>
                            <select name="sinh_vien_id" id="sinh_vien_id" class="form-select @error('sinh_vien_id') is-invalid @enderror" required>
                                <option value="">-- Chọn sinh viên --</option>
                                @foreach($sinhViens as $sv)
                                    <option value="{{ $sv->id }}" {{ old('sinh_vien_id') == $sv->id ? 'selected' : '' }}>
                                        {{ $sv->ho_ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sinh_vien_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="mon_hoc_id" class="form-label">Môn học <span class="text-danger">*</span></label>
                            <select name="mon_hoc_id" id="mon_hoc_id" class="form-select @error('mon_hoc_id') is-invalid @enderror" required>
                                <option value="">-- Chọn môn học --</option>
                                @foreach($monHocs as $mon)
                                    <option value="{{ $mon->id }}" {{ old('mon_hoc_id') == $mon->id ? 'selected' : '' }}>
                                        {{ $mon->ten_mon }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mon_hoc_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="diem_qua_trinh" class="form-label">Điểm quá trình</label>
                            <input type="number" step="0.01" min="0" max="10" name="diem_qua_trinh" id="diem_qua_trinh"
                                class="form-control @error('diem_qua_trinh') is-invalid @enderror" value="{{ old('diem_qua_trinh') }}">
                            @error('diem_qua_trinh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="diem_thi" class="form-label">Điểm thi</label>
                            <input type="number" step="0.01" min="0" max="10" name="diem_thi" id="diem_thi"
                                class="form-control @error('diem_thi') is-invalid @enderror" value="{{ old('diem_thi') }}">
                            @error('diem_thi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="diem_tong_ket" class="form-label">Điểm tổng kết</label>
                            <input type="number" step="0.01" min="0" max="10" name="diem_tong_ket" id="diem_tong_ket"
                                class="form-control @error('diem_tong_ket') is-invalid @enderror" value="{{ old('diem_tong_ket') }}">
                            @error('diem_tong_ket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('dao-tao.grades.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu điểm</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

