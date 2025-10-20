@extends('layouts.layout-daotao')

@section('title', 'Thêm Chương trình khung')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Thêm Chương trình khung</h3>
                    <p class="text-subtitle text-muted">Thêm môn học vào chương trình khung chuyên ngành</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin chương trình khung</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.chuong-trinh-khung.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chuyen_nganh_id" class="form-label">
                                        Chuyên ngành <span class="text-danger">*</span>
                                    </label>
                                    <select name="chuyen_nganh_id" id="chuyen_nganh_id"
                                        class="form-select @error('chuyen_nganh_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn chuyên ngành --</option>
                                        @foreach ($chuyenNganhs as $chuyenNganh)
                                            <option value="{{ $chuyenNganh->id }}"
                                                {{ old('chuyen_nganh_id') == $chuyenNganh->id ? 'selected' : '' }}>
                                                {{ $chuyenNganh->ten_chuyen_nganh }}
                                                ({{ $chuyenNganh->nganh->ten_nganh ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('chuyen_nganh_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mon_hoc_id" class="form-label">
                                        Môn học <span class="text-danger">*</span>
                                    </label>
                                    <select name="mon_hoc_id" id="mon_hoc_id"
                                        class="form-select @error('mon_hoc_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn môn học --</option>
                                        @foreach ($monHocs as $monHoc)
                                            <option value="{{ $monHoc->id }}"
                                                {{ old('mon_hoc_id') == $monHoc->id ? 'selected' : '' }}>
                                                {{ $monHoc->ten_mon }} ({{ $monHoc->ma_mon }}) -
                                                {{ $monHoc->so_tin_chi }} TC
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mon_hoc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hoc_ky_goi_y" class="form-label">
                                        Học kỳ gợi ý <span class="text-danger">*</span>
                                    </label>
                                    <select name="hoc_ky_goi_y" id="hoc_ky_goi_y"
                                        class="form-select @error('hoc_ky_goi_y') is-invalid @enderror" required>
                                        <option value="">-- Chọn học kỳ --</option>
                                        @for ($i = 1; $i <= 8; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('hoc_ky_goi_y') == $i ? 'selected' : '' }}>
                                                Học kỳ {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('hoc_ky_goi_y')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loai_mon_hoc" class="form-label">
                                        Loại môn học <span class="text-danger">*</span>
                                    </label>
                                    <select name="loai_mon_hoc" id="loai_mon_hoc"
                                        class="form-select @error('loai_mon_hoc') is-invalid @enderror" required>
                                        <option value="">-- Chọn loại môn --</option>
                                        <option value="Bắt buộc" {{ old('loai_mon_hoc') == 'Bắt buộc' ? 'selected' : '' }}>
                                            Bắt buộc
                                        </option>
                                        <option value="Chuyên ngành bắt buộc"
                                            {{ old('loai_mon_hoc') == 'Chuyên ngành bắt buộc' ? 'selected' : '' }}>
                                            Chuyên ngành bắt buộc
                                        </option>
                                        <option value="Tự chọn" {{ old('loai_mon_hoc') == 'Tự chọn' ? 'selected' : '' }}>
                                            Tự chọn
                                        </option>
                                    </select>
                                    @error('loai_mon_hoc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Lưu
                            </button>
                            <a href="{{ route('dao-tao.chuong-trinh-khung.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
