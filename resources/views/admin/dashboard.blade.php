@extends('layouts.layout-admin')

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
                    <!-- Biểu đồ Users theo vai trò -->
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-pie-chart text-primary"></i> Phân bổ Users theo Vai trò</h4>
                            </div>
                            <div class="card-body">
                                <div id="chartUsersByRole"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Biểu đồ Sinh viên theo trạng thái -->
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-bar-chart text-success"></i> Sinh viên theo Trạng thái</h4>
                            </div>
                            <div class="card-body">
                                <div id="chartSinhVienByStatus"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 2 -->
                <div class="row">
                    <!-- Biểu đồ Sinh viên theo ngành -->
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-bar-chart-fill text-info"></i> Top 5 Ngành có nhiều Sinh viên nhất</h4>
                            </div>
                            <div class="card-body">
                                <div id="chartSinhVienByNganh"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Giảng viên theo trình độ -->
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-diagram-3 text-warning"></i> Giảng viên theo Trình độ</h4>
                            </div>
                            <div class="card-body">
                                <div id="chartGiangVienByTrinhDo"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 3 -->
                <div class="row">
                    <!-- Biểu đồ tăng trưởng users theo tháng -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-graph-up text-primary"></i> Tăng trưởng Users (6 tháng gần nhất)</h4>
                            </div>
                            <div class="card-body">
                                <div id="chartUsersByMonth"></div>
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
                                                            <span class="badge bg-secondary">{{ $user->role }}</span>
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
                                                    <td colspan="6" class="text-center text-muted">Chưa có hoạt động
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
        // Chart 1: Users theo vai trò (Donut Chart)
        var optionsUsersByRole = {
            series: [
                {{ $usersByRole['admin'] }},
                {{ $usersByRole['dao_tao'] }},
                {{ $usersByRole['giang_vien'] }},
                {{ $usersByRole['sinh_vien'] }}
            ],
            chart: {
                type: 'donut',
                height: 350
            },
            labels: ['Admin', 'Đào tạo', 'Giảng viên', 'Sinh viên'],
            colors: ['#dc3545', '#0d6efd', '#0dcaf0', '#198754'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Tổng Users',
                                fontSize: '16px',
                                fontWeight: 600
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chartUsersByRole = new ApexCharts(document.querySelector("#chartUsersByRole"), optionsUsersByRole);
        chartUsersByRole.render();

        // Chart 2: Sinh viên theo trạng thái (Bar Chart)
        var optionsSinhVienByStatus = {
            series: [{
                name: 'Số lượng',
                data: [
                    @foreach ($sinhVienByStatus as $status)
                        {{ $status->total }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    distributed: true,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            colors: ['#198754', '#ffc107', '#dc3545', '#0d6efd', '#6c757d'],
            dataLabels: {
                enabled: true,
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: [
                    @foreach ($sinhVienByStatus as $status)
                        '{{ $status->ten_trang_thai }}',
                    @endforeach
                ],
                labels: {
                    style: {
                        fontSize: '11px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Số lượng sinh viên'
                }
            },
            legend: {
                show: false
            }
        };
        var chartSinhVienByStatus = new ApexCharts(document.querySelector("#chartSinhVienByStatus"),
            optionsSinhVienByStatus);
        chartSinhVienByStatus.render();

        // Chart 3: Sinh viên theo ngành (Bar Chart)
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
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            colors: ['#0d6efd'],
            dataLabels: {
                enabled: true,
                offsetX: 30,
                style: {
                    fontSize: '12px',
                    colors: ['#304758']
                }
            },
            xaxis: {
                categories: [
                    @foreach ($sinhVienByNganh as $nganh)
                        '{{ $nganh->ten_nganh }}',
                    @endforeach
                ]
            },
            yaxis: {
                title: {
                    text: 'Ngành'
                }
            }
        };
        var chartSinhVienByNganh = new ApexCharts(document.querySelector("#chartSinhVienByNganh"),
            optionsSinhVienByNganh);
        chartSinhVienByNganh.render();

        // Chart 4: Giảng viên theo trình độ (Pie Chart)
        var optionsGiangVienByTrinhDo = {
            series: [
                @foreach ($giangVienByTrinhDo as $trinhDo)
                    {{ $trinhDo->total }},
                @endforeach
            ],
            chart: {
                type: 'pie',
                height: 350
            },
            labels: [
                @foreach ($giangVienByTrinhDo as $trinhDo)
                    '{{ $trinhDo->ten_trinh_do }}',
                @endforeach
            ],
            colors: ['#6f42c1', '#0dcaf0', '#198754', '#ffc107'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }]
        };
        var chartGiangVienByTrinhDo = new ApexCharts(document.querySelector("#chartGiangVienByTrinhDo"),
            optionsGiangVienByTrinhDo);
        chartGiangVienByTrinhDo.render();

        // Chart 5: Users theo tháng (Line Chart)
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
                height: 350,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#0d6efd'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: [
                    @foreach ($usersByMonth as $month)
                        '{{ $month->month }}',
                    @endforeach
                ],
                title: {
                    text: 'Tháng'
                }
            },
            yaxis: {
                title: {
                    text: 'Số lượng users'
                }
            },
            tooltip: {
                x: {
                    format: 'yyyy-MM'
                }
            }
        };
        var chartUsersByMonth = new ApexCharts(document.querySelector("#chartUsersByMonth"), optionsUsersByMonth);
        chartUsersByMonth.render();
    </script>
@endpush
