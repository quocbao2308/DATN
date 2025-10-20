@extends('layouts.layout-daotao')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dao-tao.diem-danh.index') }}">Điểm danh</a></li>
                    <li class="breadcrumb-item active">Điểm danh buổi học</li>
                </ol>
            </nav>
            <h2>Điểm danh buổi học</h2>
        </div>

        <!-- Thông tin buổi học -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Thông tin buổi học</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="30%">Lớp học phần:</th>
                                <td><strong>{{ $lichHoc->lopHocPhan->ma_lop_hp ?? 'N/A' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Môn học:</th>
                                <td>{{ $lichHoc->lopHocPhan->monHoc->ten_mon ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Ngày học:</th>
                                <td><strong
                                        class="text-primary">{{ \Carbon\Carbon::parse($lichHoc->ngay)->format('d/m/Y') }}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="30%">Giờ học:</th>
                                <td>{{ $lichHoc->gio_bat_dau }} - {{ $lichHoc->gio_ket_thuc }}</td>
                            </tr>
                            <tr>
                                <th>Phòng học:</th>
                                <td>{{ $lichHoc->phongHoc->ten_phong ?? 'Online' }}</td>
                            </tr>
                            <tr>
                                <th>Giảng viên:</th>
                                <td>{{ $lichHoc->giangVien->ho_ten ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form điểm danh -->
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Danh sách sinh viên ({{ $danhSachSinhVien->count() }}
                    sinh viên)</h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-light" onclick="selectAll('co_mat')">
                        <i class="bi bi-check-all me-1"></i>Tất cả có mặt
                    </button>
                    <button type="button" class="btn btn-light" onclick="selectAll('vang')">
                        <i class="bi bi-x-circle me-1"></i>Tất cả vắng
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('dao-tao.diem-danh.store', $lichHoc->id) }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">STT</th>
                                    <th width="12%">Mã SV</th>
                                    <th width="25%">Họ tên</th>
                                    <th width="15%">Trạng thái</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($danhSachSinhVien as $index => $sinhVien)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><strong>{{ $sinhVien->ma_sinh_vien }}</strong></td>
                                        <td>{{ $sinhVien->ho_ten }}</td>
                                        <td>
                                            <select name="diem_danh[{{ $sinhVien->id }}]"
                                                class="form-select form-select-sm status-select" required>
                                                <option value="co_mat"
                                                    {{ isset($diemDanhDaCo[$sinhVien->id]) && $diemDanhDaCo[$sinhVien->id] == 'co_mat' ? 'selected' : '' }}>
                                                    ✅ Có mặt
                                                </option>
                                                <option value="vang"
                                                    {{ isset($diemDanhDaCo[$sinhVien->id]) && $diemDanhDaCo[$sinhVien->id] == 'vang' ? 'selected' : '' }}>
                                                    ❌ Vắng
                                                </option>
                                                <option value="di_tre"
                                                    {{ isset($diemDanhDaCo[$sinhVien->id]) && $diemDanhDaCo[$sinhVien->id] == 'di_tre' ? 'selected' : '' }}>
                                                    ⏰ Đi trễ
                                                </option>
                                                <option value="nghi_phep"
                                                    {{ isset($diemDanhDaCo[$sinhVien->id]) && $diemDanhDaCo[$sinhVien->id] == 'nghi_phep' ? 'selected' : '' }}>
                                                    📄 Nghỉ phép
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="ghi_chu[{{ $sinhVien->id }}]"
                                                class="form-control form-control-sm" placeholder="Ghi chú...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Lưu điểm danh
                        </button>
                        <a href="{{ route('dao-tao.diem-danh.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function selectAll(status) {
            document.querySelectorAll('.status-select').forEach(select => {
                select.value = status;
            });
        }
    </script>
@endpush
