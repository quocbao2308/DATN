@extends('layouts.layout-daotao')

@section('title', 'Quản lý Chương trình khung')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Quản lý Chương trình khung</h3>
                    <p class="text-subtitle text-muted">Danh sách chương trình khung của các chuyên ngành</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách chương trình khung</h5>
                    <a href="{{ route('dao-tao.chuong-trinh-khung.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('dao-tao.chuong-trinh-khung.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chuyên ngành</label>
                                    <select name="chuyen_nganh_id" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        @foreach ($chuyenNganhs as $chuyenNganh)
                                            <option value="{{ $chuyenNganh->id }}"
                                                {{ request('chuyen_nganh_id') == $chuyenNganh->id ? 'selected' : '' }}>
                                                {{ $chuyenNganh->ten_chuyen_nganh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Loại môn học</label>
                                    <select name="loai_mon_hoc" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        <option value="Bắt buộc"
                                            {{ request('loai_mon_hoc') == 'Bắt buộc' ? 'selected' : '' }}>
                                            Bắt buộc
                                        </option>
                                        <option value="Tự chọn"
                                            {{ request('loai_mon_hoc') == 'Tự chọn' ? 'selected' : '' }}>
                                            Tự chọn
                                        </option>
                                        <option value="Chuyên ngành bắt buộc"
                                            {{ request('loai_mon_hoc') == 'Chuyên ngành bắt buộc' ? 'selected' : '' }}>
                                            Chuyên ngành bắt buộc
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Học kỳ gợi ý</label>
                                    <select name="hoc_ky_goi_y" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        @for ($i = 1; $i <= 8; $i++)
                                            <option value="{{ $i }}"
                                                {{ request('hoc_ky_goi_y') == $i ? 'selected' : '' }}>
                                                Học kỳ {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Chuyên ngành</th>
                                    <th width="25%">Môn học</th>
                                    <th width="10%">Tín chỉ</th>
                                    <th width="10%">HK gợi ý</th>
                                    <th width="15%">Loại môn</th>
                                    <th width="10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($chuongTrinhKhungs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($chuongTrinhKhungs->currentPage() - 1) * $chuongTrinhKhungs->perPage() }}
                                        </td>
                                        <td>
                                            @if ($item->chuyenNganh)
                                                <strong>{{ $item->chuyenNganh->ten_chuyen_nganh }}</strong><br>
                                                <small
                                                    class="text-muted">{{ $item->chuyenNganh->nganh->ten_nganh ?? '' }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->monHoc)
                                                <strong>{{ $item->monHoc->ten_mon }}</strong><br>
                                                <small class="text-muted">{{ $item->monHoc->ma_mon }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->monHoc->so_tin_chi ?? 'N/A' }}</td>
                                        <td><span class="badge bg-info">Kỳ {{ $item->hoc_ky_goi_y }}</span></td>
                                        <td>
                                            @if ($item->loai_mon_hoc == 'Bắt buộc')
                                                <span class="badge bg-danger">{{ $item->loai_mon_hoc }}</span>
                                            @elseif($item->loai_mon_hoc == 'Chuyên ngành bắt buộc')
                                                <span class="badge bg-warning">{{ $item->loai_mon_hoc }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $item->loai_mon_hoc }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('dao-tao.chuong-trinh-khung.show', $item->id) }}"
                                                    class="btn btn-info" title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dao-tao.chuong-trinh-khung.edit', $item->id) }}"
                                                    class="btn btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dao-tao.chuong-trinh-khung.destroy', $item->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $chuongTrinhKhungs->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
