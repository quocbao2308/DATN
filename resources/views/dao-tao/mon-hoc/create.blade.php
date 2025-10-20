@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Thêm Môn học mới</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.mon-hoc.index') }}">Môn học</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin môn học</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dao-tao.mon-hoc.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Mã môn học --}}
                            <div class="col-md-6 mb-3">
                                <label for="ma_mon" class="form-label">
                                    Mã môn học <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="ma_mon" id="ma_mon"
                                    class="form-control @error('ma_mon') is-invalid @enderror" value="{{ old('ma_mon') }}"
                                    placeholder="VD: IT101" required>
                                @error('ma_mon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tên môn học --}}
                            <div class="col-md-6 mb-3">
                                <label for="ten_mon" class="form-label">
                                    Tên môn học <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="ten_mon" id="ten_mon"
                                    class="form-control @error('ten_mon') is-invalid @enderror" value="{{ old('ten_mon') }}"
                                    placeholder="VD: Lập trình Java" required>
                                @error('ten_mon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Số tín chỉ --}}
                            <div class="col-md-4 mb-3">
                                <label for="so_tin_chi" class="form-label">
                                    Số tín chỉ <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="so_tin_chi" id="so_tin_chi"
                                    class="form-control @error('so_tin_chi') is-invalid @enderror"
                                    value="{{ old('so_tin_chi', 3) }}" min="1" max="10" required>
                                @error('so_tin_chi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Loại môn --}}
                            <div class="col-md-4 mb-3">
                                <label for="loai_mon" class="form-label">
                                    Loại môn <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="loai_mon" id="loai_mon"
                                    class="form-control @error('loai_mon') is-invalid @enderror"
                                    value="{{ old('loai_mon') }}" placeholder="VD: Đại cương, Cơ sở, Chuyên ngành"
                                    required>
                                @error('loai_mon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hình thức dạy --}}
                            <div class="col-md-4 mb-3">
                                <label for="hinh_thuc_day" class="form-label">
                                    Hình thức dạy <span class="text-danger">*</span>
                                </label>
                                <select name="hinh_thuc_day" id="hinh_thuc_day"
                                    class="form-select @error('hinh_thuc_day') is-invalid @enderror" required>
                                    <option value="">-- Chọn hình thức --</option>
                                    @foreach (\App\Constants\SystemConstants::TEACHING_MODES as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('hinh_thuc_day') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('hinh_thuc_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Thời lượng --}}
                            <div class="col-md-6 mb-3">
                                <label for="thoi_luong" class="form-label">Thời lượng (giờ)</label>
                                <input type="number" name="thoi_luong" id="thoi_luong"
                                    class="form-control @error('thoi_luong') is-invalid @enderror"
                                    value="{{ old('thoi_luong') }}" min="0" placeholder="VD: 45">
                                @error('thoi_luong')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Số buổi học --}}
                            <div class="col-md-6 mb-3">
                                <label for="so_buoi" class="form-label">Số buổi học</label>
                                <input type="number" name="so_buoi" id="so_buoi"
                                    class="form-control @error('so_buoi') is-invalid @enderror"
                                    value="{{ old('so_buoi') }}" min="0" placeholder="VD: 15">
                                @error('so_buoi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mô tả --}}
                            <div class="col-12 mb-3">
                                <label for="mo_ta" class="form-label">Mô tả môn học</label>
                                <textarea name="mo_ta" id="mo_ta" rows="3" class="form-control @error('mo_ta') is-invalid @enderror"
                                    placeholder="Nhập mô tả về môn học...">{{ old('mo_ta') }}</textarea>
                                @error('mo_ta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Môn tiên quyết --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Môn tiên quyết</label>
                                <div class="card">
                                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                        @forelse($allMonHocs as $mon)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mon_tien_quyet_ids[]" value="{{ $mon->id }}"
                                                    id="mon_{{ $mon->id }}"
                                                    {{ in_array($mon->id, old('mon_tien_quyet_ids', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mon_{{ $mon->id }}">
                                                    <strong>{{ $mon->ma_mon }}</strong> - {{ $mon->ten_mon }}
                                                    <span class="badge bg-info">{{ $mon->so_tin_chi }} TC</span>
                                                </label>
                                            </div>
                                        @empty
                                            <p class="text-muted mb-0">Chưa có môn học nào</p>
                                        @endforelse
                                    </div>
                                </div>
                                <small class="text-muted">Chọn các môn học mà sinh viên cần hoàn thành trước khi học môn
                                    này</small>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('dao-tao.mon-hoc.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Lưu môn học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
