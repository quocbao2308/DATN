@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Quản lý Người dùng</h3>
                    <p class="text-subtitle text-muted">Quản lý tài khoản theo vai trò</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Người dùng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $role === 'all' ? 'active' : '' }}"
                                href="{{ route('admin.users.index', ['role' => 'all']) }}">
                                <i class="bi bi-people"></i> Tất cả
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $role === 'admin' ? 'active' : '' }}"
                                href="{{ route('admin.users.index', ['role' => 'admin']) }}">
                                <i class="bi bi-shield-check"></i> Admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $role === 'dao_tao' ? 'active' : '' }}"
                                href="{{ route('admin.users.index', ['role' => 'dao_tao']) }}">
                                <i class="bi bi-building"></i> Đào tạo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $role === 'giang_vien' ? 'active' : '' }}"
                                href="{{ route('admin.users.index', ['role' => 'giang_vien']) }}">
                                <i class="bi bi-person-workspace"></i> Giảng viên
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $role === 'sinh_vien' ? 'active' : '' }}"
                                href="{{ route('admin.users.index', ['role' => 'sinh_vien']) }}">
                                <i class="bi bi-mortarboard"></i> Sinh viên
                            </a>
                        </li>
                    </ul>

                    {{-- FORM TÌM KIẾM --}}
                    <div class="card bg-light mt-3 mb-3">
                        <div class="card-body">
                            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                                <input type="hidden" name="role" value="{{ $role }}">

                                {{-- Tìm kiếm chung --}}
                                <div class="col-md-4">
                                    <label class="form-label">Tìm kiếm</label>
                                    <input type="text" name="search" class="form-control"
                                        value="{{ request('search') }}" placeholder="Tên, email, mã, số điện thoại...">
                                </div>

                                {{-- Filter Khoa (cho Giảng viên) --}}
                                @if ($role === 'giang_vien')
                                    <div class="col-md-3">
                                        <label class="form-label">Khoa</label>
                                        <select name="khoa_id" class="form-select">
                                            <option value="">-- Tất cả --</option>
                                            @foreach ($khoas as $khoa)
                                                <option value="{{ $khoa->id }}"
                                                    {{ request('khoa_id') == $khoa->id ? 'selected' : '' }}>
                                                    {{ $khoa->ten_khoa }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                {{-- Filter Ngành (cho Sinh viên) --}}
                                @if ($role === 'sinh_vien')
                                    <div class="col-md-3">
                                        <label class="form-label">Ngành</label>
                                        <select name="nganh_id" class="form-select">
                                            <option value="">-- Tất cả --</option>
                                            @foreach ($nganhs as $nganh)
                                                <option value="{{ $nganh->id }}"
                                                    {{ request('nganh_id') == $nganh->id ? 'selected' : '' }}>
                                                    {{ $nganh->ten_nganh }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Filter Trạng thái (cho Sinh viên) --}}
                                    <div class="col-md-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select name="trang_thai_id" class="form-select">
                                            <option value="">-- Tất cả --</option>
                                            @foreach ($trangThais as $tt)
                                                <option value="{{ $tt->id }}"
                                                    {{ request('trang_thai_id') == $tt->id ? 'selected' : '' }}>
                                                    {{ $tt->ten_trang_thai }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                {{-- Buttons --}}
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tìm
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.users.index', ['role' => $role]) }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Button thêm mới -->
                    <div class="d-flex justify-content-end mt-3 mb-3">
                        @if ($role === 'admin')
                            <a href="{{ route('admin.users.create', ['role' => 'admin']) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Thêm Admin
                            </a>
                        @elseif($role === 'dao_tao')
                            <a href="{{ route('admin.users.create', ['role' => 'dao_tao']) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Thêm Đào tạo
                            </a>
                        @elseif($role === 'giang_vien')
                            <a href="{{ route('admin.users.create', ['role' => 'giang_vien']) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Thêm Giảng viên
                            </a>
                        @elseif($role === 'sinh_vien')
                            <a href="{{ route('admin.users.create', ['role' => 'sinh_vien']) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Thêm Sinh viên
                            </a>
                        @endif
                    </div>

                    <!-- Content -->
                    @if ($role === 'admin')
                        @include('admin.users.partials.admin-table')
                    @elseif($role === 'dao_tao')
                        @include('admin.users.partials.daotao-table')
                    @elseif($role === 'giang_vien')
                        @include('admin.users.partials.giangvien-table')
                    @elseif($role === 'sinh_vien')
                        @include('admin.users.partials.sinhvien-table')
                    @else
                        @include('admin.users.partials.all-table')
                    @endif

                </div>
            </div>
        </section>
    </div>
@endsection
