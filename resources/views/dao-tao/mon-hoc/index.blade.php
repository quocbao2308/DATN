@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Môn học</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Môn học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            {{-- Alert messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách môn học</h5>
                    <a href="{{ route('dao-tao.mon-hoc.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Thêm môn học
                    </a>
                </div>

                <div class="card-body">
                    {{-- Filter form --}}
                    <form method="GET" action="{{ route('dao-tao.mon-hoc.index') }}" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm mã/tên môn..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="so_tin_chi" class="form-select">
                                    <option value="">-- Số tín chỉ --</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            {{ request('so_tin_chi') == $i ? 'selected' : '' }}>
                                            {{ $i }} tín chỉ
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="hinh_thuc_day" class="form-select">
                                    <option value="">-- Hình thức --</option>
                                    @foreach (\App\Constants\SystemConstants::TEACHING_MODES as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ request('hinh_thuc_day') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="loai_mon" class="form-control" placeholder="Loại môn..."
                                    value="{{ request('loai_mon') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Tìm
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 10%">Mã môn</th>
                                    <th style="width: 30%">Tên môn học</th>
                                    <th style="width: 10%" class="text-center">Tín chỉ</th>
                                    <th style="width: 15%">Loại môn</th>
                                    <th style="width: 15%">Hình thức</th>
                                    <th style="width: 10%" class="text-center">Số buổi</th>
                                    <th style="width: 10%" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monHocs as $monHoc)
                                    <tr>
                                        <td><strong>{{ $monHoc->ma_mon }}</strong></td>
                                        <td>{{ $monHoc->ten_mon }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $monHoc->so_tin_chi }}</span>
                                        </td>
                                        <td>{{ $monHoc->loai_mon ?? '-' }}</td>
                                        <td>
                                            @switch($monHoc->hinh_thuc_day)
                                                @case('offline')
                                                    <span class="badge bg-primary">Offline</span>
                                                @break

                                                @case('online')
                                                    <span class="badge bg-success">Online</span>
                                                @break

                                                @case('hybrid')
                                                    <span class="badge bg-info">Hybrid</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $monHoc->hinh_thuc_day }}</span>
                                            @endswitch
                                        </td>
                                        <td class="text-center">{{ $monHoc->so_buoi ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dao-tao.mon-hoc.show', $monHoc->id) }}"
                                                    class="btn btn-sm btn-info" title="Chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dao-tao.mon-hoc.edit', $monHoc->id) }}"
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dao-tao.mon-hoc.destroy', $monHoc->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa môn học này?')"
                                                    class="d-inline">
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
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="bi bi-inbox fs-3"></i>
                                                <p class="mt-2">Không có môn học nào</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $monHocs->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
