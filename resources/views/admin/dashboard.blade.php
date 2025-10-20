@extends('layouts.layout-admin')

@push('styles')
    <link href="{{ asset('css/dashboard-custom.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Dashboard Admin</h3>
            <div class="text-muted">
                <i class="bi bi-calendar3"></i> {{ date('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <!-- Stats Cards Row 1 -->
                <div class="row">
                    <!-- Card Tổng Users -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon bg-primary mb-2">
                                            <i class="bi bi-people-fill text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Tổng Users</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($stats['total_users']) }}</h6>
                                        <small class="text-success">
                                            <i class="bi bi-arrow-up"></i> +{{ $newUsersLast7Days }} tuần này
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Sinh viên -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-mortarboard text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Sinh viên</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($stats['total_sinh_vien']) }}</h6>
                                        <small class="text-success">
                                            <i class="bi bi-arrow-up"></i> +{{ $newSinhVienLast30Days }} tháng này
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Giảng viên -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-person-workspace text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Giảng viên</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($stats['total_giang_vien']) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Khoa -->
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi bi-building text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Khoa</h6>
                                        <h6 class="font-extrabold mb-0">{{ number_format($stats['total_khoa']) }}</h6>
                                        <small class="text-muted">{{ number_format($stats['total_nganh']) }} ngành</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <!-- Thống kê Sinh viên -->
                    <div class="col-12">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0 text-white"><i class="bi bi-mortarboard-fill"></i> Thống kê Sinh viên
                                    </h4>
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSinhVien">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Sinh viên theo trạng thái -->
                                    <div class="col-md-6 mb-4">
                                        <h5 class="text-dark fw-bold mb-3 ms-2"><i class="bi bi-activity me-2"></i>Theo
                                            Trạng thái Học tập</h5>
                                        <div id="chartSinhVienByStatus"></div>

                                        <!-- Chi tiết collapse -->
                                        <div class="collapse show" id="collapseSinhVien">
                                            <div class="row g-2 mt-3">
                                                @php $totalSV = $sinhVienHoatDong->sum('total'); @endphp
                                                @foreach ($sinhVienHoatDong as $status)
                                                    <div class="col-6">
                                                        <div class="stats-card-mini border-start border-4 border-primary">
                                                            <small class="text-muted">{{ $status->ten_trang_thai }}</small>
                                                            <h5 class="mb-1 text-primary">
                                                                {{ number_format($status->total) }}
                                                            </h5>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                                {{ $totalSV > 0 ? round(($status->total / $totalSV) * 100, 1) : 0 }}%
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sinh viên theo ngành -->
                                    <div class="col-md-6 mb-4">
                                        <h5 class="text-dark fw-bold mb-3 ms-2"><i class="bi bi-bookmark-fill me-2"></i>Top
                                            5 Ngành có nhiều SV nhất</h5>
                                        <div id="chartSinhVienByNganh"></div>

                                        <!-- Progress bars collapse -->
                                        <div class="collapse show" id="collapseSinhVien">
                                            <div class="mt-3">
                                                @php $maxSV = $sinhVienByNganh->max('total'); @endphp
                                                @foreach ($sinhVienByNganh as $index => $nganh)
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <small class="fw-bold">#{{ $index + 1 }}
                                                                {{ $nganh->ten_nganh }}</small>
                                                            <span
                                                                class="badge bg-primary bg-opacity-10 text-primary">{{ number_format($nganh->total) }}
                                                                SV</span>
                                                        </div>
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                style="width: {{ $maxSV > 0 ? ($nganh->total / $maxSV) * 100 : 0 }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thống kê Giảng viên -->
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 text-white"><i class="bi bi-person-workspace"></i> Thống kê Giảng viên
                                </h4>
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseGiangVien">
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Giảng viên theo trình độ -->
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-dark fw-bold mb-3 ms-2"><i class="bi bi-mortarboard me-2"></i>Theo
                                        Trình độ</h5>
                                    <div id="chartGiangVienByTrinhDo"></div>

                                    <!-- Chi tiết collapse -->
                                    <div class="collapse show" id="collapseGiangVien">
                                        <div class="row g-2 mt-3">
                                            @php $totalGV = $giangVienByTrinhDo->sum('total'); @endphp
                                            @foreach ($giangVienByTrinhDo as $trinhDo)
                                                <div class="col-6">
                                                    <div class="stats-card-mini border-start border-4 border-primary">
                                                        <small class="text-muted">{{ $trinhDo->ten_trinh_do }}</small>
                                                        <h5 class="mb-1 text-primary">{{ number_format($trinhDo->total) }}
                                                        </h5>
                                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                                            {{ $totalGV > 0 ? round(($trinhDo->total / $totalGV) * 100, 1) : 0 }}%
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Giảng viên theo khoa -->
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-dark fw-bold mb-3 ms-2"><i class="bi bi-building me-2"></i>Theo Khoa
                                    </h5>
                                    <div id="chartGiangVienByKhoa"></div>

                                    <!-- Progress bars collapse -->
                                    <div class="collapse show" id="collapseGiangVien">
                                        <div class="mt-3">
                                            @php $maxGV = $giangVienByKhoa->max('total'); @endphp
                                            @foreach ($giangVienByKhoa as $khoa)
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <small class="fw-bold">{{ $khoa->ten_khoa }}</small>
                                                        <span
                                                            class="badge bg-primary bg-opacity-10 text-primary">{{ number_format($khoa->total) }}
                                                            GV</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ $maxGV > 0 ? ($khoa->total / $maxGV) * 100 : 0 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tăng trưởng Users -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0 text-white"><i class="bi bi-graph-up"></i> Tăng trưởng Users (6 tháng
                                        gần nhất)
                                    </h4>
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseUsers">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chartUsersByMonth"></div>

                                <!-- Timeline cards collapse -->
                                <div class="collapse show" id="collapseUsers">
                                    <div class="row g-3 mt-4">
                                        @foreach ($usersByMonth as $index => $month)
                                            <div class="col-md-4 col-sm-6">
                                                <div class="card border-start border-4 border-primary h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <small class="text-muted">{{ $month->month }}</small>
                                                                <h4 class="mb-0 text-primary">
                                                                    {{ number_format($month->total) }}</h4>
                                                                <small class="text-muted">users</small>
                                                            </div>
                                                            <div class="text-end">
                                                                @if ($index > 0)
                                                                    @php
                                                                        $prevTotal = $usersByMonth[$index - 1]->total;
                                                                        $growth =
                                                                            $prevTotal > 0
                                                                                ? round(
                                                                                    (($month->total - $prevTotal) /
                                                                                        $prevTotal) *
                                                                                        100,
                                                                                    1,
                                                                                )
                                                                                : 0;
                                                                    @endphp
                                                                    @if ($growth > 0)
                                                                        <span class="badge bg-success">
                                                                            <i class="bi bi-arrow-up"></i>
                                                                            {{ $growth }}%
                                                                        </span>
                                                                    @elseif($growth < 0)
                                                                        <span class="badge bg-danger">
                                                                            <i class="bi bi-arrow-down"></i>
                                                                            {{ abs($growth) }}%
                                                                        </span>
                                                                    @else
                                                                        <span class="badge bg-secondary">0%</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Tổng cộng -->
                                        <div class="col-12">
                                            <div class="alert alert-primary mb-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span><i class="bi bi-info-circle"></i> <strong>Tổng
                                                            cộng</strong></span>
                                                    <h4 class="mb-0">{{ number_format($usersByMonth->sum('total')) }}
                                                        users</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="bi bi-clock-history text-success"></i> Hoạt động gần đây</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="25%">Tên</th>
                                                    <th width="25%">Email</th>
                                                    <th width="15%">Vai trò</th>
                                                    <th width="20%">Thời gian</th>
                                                    <th width="10%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentUsers as $index => $user)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $user->name }}</strong>
                                                        </td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            @if ($user->role === 'Admin')
                                                                <span class="badge bg-danger">{{ $user->role }}</span>
                                                            @elseif($user->role === 'Đào tạo')
                                                                <span class="badge bg-primary">{{ $user->role }}</span>
                                                            @elseif($user->role === 'Giảng viên')
                                                                <span class="badge bg-info">{{ $user->role }}</span>
                                                            @elseif($user->role === 'Sinh viên')
                                                                <span class="badge bg-success">{{ $user->role }}</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-secondary">{{ $user->role }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">
                                                                <i class="bi bi-clock"></i>
                                                                {{ $user->created_at->diffForHumans() }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                                class="btn btn-sm btn-info" title="Xem chi tiết">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">Chưa có hoạt
                                                            động
                                                            nào
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="bi bi-lightning-charge text-warning"></i> Chức năng quản lý</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.users.index') }}"
                                                class="btn btn-primary btn-block w-100 py-3">
                                                <i class="bi bi-people-fill fs-4 d-block mb-2"></i>
                                                <span>Quản lý Users</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.roles.index') }}"
                                                class="btn btn-danger btn-block w-100 py-3">
                                                <i class="bi bi-shield-check fs-4 d-block mb-2"></i>
                                                <span>Quản lý Vai trò</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.khoa.index') }}"
                                                class="btn btn-info btn-block w-100 py-3">
                                                <i class="bi bi-building fs-4 d-block mb-2"></i>
                                                <span>Quản lý Khoa</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.nganh.index') }}"
                                                class="btn btn-success btn-block w-100 py-3">
                                                <i class="bi bi-grid-3x3-gap fs-4 d-block mb-2"></i>
                                                <span>Quản lý Ngành</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.khoa-hoc.index') }}"
                                                class="btn btn-warning btn-block w-100 py-3">
                                                <i class="bi bi-calendar3 fs-4 d-block mb-2"></i>
                                                <span>Quản lý Khóa học</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.phong-hoc.index') }}"
                                                class="btn btn-secondary btn-block w-100 py-3">
                                                <i class="bi bi-door-open fs-4 d-block mb-2"></i>
                                                <span>Quản lý Phòng học</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.permissions.index') }}"
                                                class="btn btn-dark btn-block w-100 py-3">
                                                <i class="bi bi-key-fill fs-4 d-block mb-2"></i>
                                                <span>Quản lý Quyền</span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('admin.hoc-ky.index') }}"
                                                class="btn btn-primary btn-block w-100 py-3">
                                                <i class="bi bi-calendar-week fs-4 d-block mb-2"></i>
                                                <span>Quản lý Học kỳ</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // ==================== THỐNG KÊ SINH VIÊN ====================

        // Chart 1: Sinh viên theo trạng thái
        var optionsSinhVienByStatus = {
            series: [
                @foreach ($sinhVienHoatDong as $status)
                    {{ $status->total }},
                @endforeach
            ],
            chart: {
                type: 'donut',
                height: 250
            },
            labels: [
                @foreach ($sinhVienHoatDong as $status)
                    '{{ $status->ten_trang_thai }}',
                @endforeach
            ],
            colors: ['#198754', '#ffc107', '#fd7e14', '#dc3545'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true
            }
        };
        new ApexCharts(document.querySelector("#chartSinhVienByStatus"), optionsSinhVienByStatus).render();

        // Chart 2: Sinh viên theo ngành
        var optionsSinhVienByNganh = {
            series: [{
                name: 'Sinh viên',
                data: [
                    @foreach ($sinhVienByNganh as $nganh)
                        {{ $nganh->total }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true
                }
            },
            colors: ['#0d6efd'],
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: [
                    @foreach ($sinhVienByNganh as $nganh)
                        '{{ Str::limit($nganh->ten_nganh, 20) }}',
                    @endforeach
                ]
            }
        };
        new ApexCharts(document.querySelector("#chartSinhVienByNganh"), optionsSinhVienByNganh).render();

        // ==================== THỐNG KÊ GIẢNG VIÊN ====================

        // Chart 3: Giảng viên theo trình độ
        var optionsGiangVienByTrinhDo = {
            series: [
                @foreach ($giangVienByTrinhDo as $trinhDo)
                    {{ $trinhDo->total }},
                @endforeach
            ],
            chart: {
                type: 'donut',
                height: 250
            },
            labels: [
                @foreach ($giangVienByTrinhDo as $trinhDo)
                    '{{ $trinhDo->ten_trinh_do }}',
                @endforeach
            ],
            colors: ['#6f42c1', '#0dcaf0', '#198754', '#ffc107', '#fd7e14'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true
            }
        };
        new ApexCharts(document.querySelector("#chartGiangVienByTrinhDo"), optionsGiangVienByTrinhDo).render();

        // Chart 4: Giảng viên theo khoa
        var optionsGiangVienByKhoa = {
            series: [{
                name: 'Giảng viên',
                data: [
                    @foreach ($giangVienByKhoa as $khoa)
                        {{ $khoa->total }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true
                }
            },
            colors: ['#0dcaf0'],
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: [
                    @foreach ($giangVienByKhoa as $khoa)
                        '{{ Str::limit($khoa->ten_khoa, 20) }}',
                    @endforeach
                ]
            }
        };
        new ApexCharts(document.querySelector("#chartGiangVienByKhoa"), optionsGiangVienByKhoa).render();

        // ==================== TĂNG TRƯỞNG USERS ====================

        // Chart 5: Users theo tháng
        var optionsUsersByMonth = {
            series: [{
                name: 'Users mới',
                data: [
                    @foreach ($usersByMonth as $month)
                        {{ $month->total }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: ['#0d6efd'],
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.6,
                    opacityTo: 0.2
                }
            },
            xaxis: {
                categories: [
                    @foreach ($usersByMonth as $month)
                        '{{ $month->month }}',
                    @endforeach
                ]
            }
        };
        new ApexCharts(document.querySelector("#chartUsersByMonth"), optionsUsersByMonth).render();

        // Toggle collapse icon rotation
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            const target = document.querySelector(button.getAttribute('data-bs-target'));
            if (target) {
                target.addEventListener('show.bs.collapse', () => {
                    button.querySelector('i').classList.remove('bi-chevron-down');
                    button.querySelector('i').classList.add('bi-chevron-up');
                });
                target.addEventListener('hide.bs.collapse', () => {
                    button.querySelector('i').classList.remove('bi-chevron-up');
                    button.querySelector('i').classList.add('bi-chevron-down');
                });
            }
        });
    </script>
@endpush
