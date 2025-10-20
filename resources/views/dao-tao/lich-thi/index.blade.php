@extends('layouts.layout-daotao')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Quản lý Lịch thi</h3>
            </div>
            <div class="col-12 col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Lịch thi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách Lịch thi</h5>
                    <a href="{{ route('dao-tao.lich-thi.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Thêm lịch thi
                    </a>
                </div>
            </div>

            <div class="card-body">
                {{-- Thông báo --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Bộ lọc --}}
                <form method="GET" action="{{ route('dao-tao.lich-thi.index') }}" class="mb-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Tìm kiếm lớp học phần..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="hinh_thuc" class="form-select">
                                <option value="">-- Tất cả hình thức --</option>
                                <option value="offline" {{ request('hinh_thuc') == 'offline' ? 'selected' : '' }}>Offline</option>
                                <option value="online" {{ request('hinh_thuc') == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="hybrid" {{ request('hinh_thuc') == 'hybrid' ? 'selected' : '' }}>Kết hợp</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <input type="date" name="ngay_thi" class="form-control" value="{{ request('ngay_thi') }}">
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Tìm
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Bảng dữ liệu --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Lớp học phần</th>
                                <th>Ngày thi</th>
                                <th>Giờ thi</th>
                                <th>Phòng</th>
                                <th>Hình thức</th>
                                <th>Link / File</th>
                                <th>Ngày gửi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lichThis as $index => $lich)
                                <tr>
                                    <td>{{ $lichThis->firstItem() + $index }}</td>
                                    <td>{{ $lich->lopHocPhan->ma_lop_hp ?? 'Chưa có' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lich->ngay_thi)->format('d/m/Y') }}</td>
                                    <td>{{ $lich->gio_bat_dau }} - {{ $lich->gio_ket_thuc }}</td>
                                    <td>{{ $lich->phongHoc->ten_phong ?? 'N/A' }}</td>
                                    <td>
                                        @switch($lich->hinh_thuc)
                                            @case('offline')
                                                <span class="badge bg-secondary">Offline</span>
                                                @break
                                            @case('online')
                                                <span class="badge bg-success">Online</span>
                                                @break
                                            @case('hybrid')
                                                <span class="badge bg-info">Kết hợp</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($lich->hinh_thuc === 'online' && $lich->link_online)
                                            <a href="{{ $lich->link_online }}" target="_blank" class="text-primary">
                                                <i class="bi bi-link-45deg"></i> Link học
                                            </a>
                                        @endif
                                        @if($lich->file_pdf)
                                            <a href="{{ Storage::url($lich->file_pdf) }}" target="_blank" class="ms-2 text-danger">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $lich->ngay_gui ? \Carbon\Carbon::parse($lich->ngay_gui)->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('dao-tao.lich-thi.show', $lich->id) }}" 
                                                class="btn btn-sm btn-info" title="Xem">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dao-tao.lich-thi.edit', $lich->id) }}" 
                                                class="btn btn-sm btn-warning" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('dao-tao.lich-thi.destroy', $lich->id) }}" 
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa lịch thi này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Không có dữ liệu lịch thi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-center">
                    {{ $lichThis->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
