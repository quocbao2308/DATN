@extends('layouts.layout-daotao')

@section('content')
<div class="page-heading">
	<div class="page-title">
		<div class="row">
			<div class="col-12 col-md-6">
				<h3>Quản lý Lịch học</h3>
			</div>
			<div class="col-12 col-md-6">
				<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('dao-tao.dashboard') }}">Dashboard</a></li>
						<li class="breadcrumb-item active">Lịch học</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>

	<section class="section">
		<div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Danh sách Lịch học</h5>
					<a href="{{ route('dao-tao.lich-hoc.create') }}" class="btn btn-primary">
						<i class="bi bi-plus-circle"></i> Thêm lịch học
					</a>
				</div>
			</div>

			<div class="card-body">
				@if(session('success'))
					<div class="alert alert-success">{{ session('success') }}</div>
				@endif

				<form method="GET" action="{{ route('dao-tao.lich-hoc.index') }}" class="mb-3">
					<div class="row g-3">
						<div class="col-md-4">
							<input type="text" name="search" class="form-control"
								placeholder="Tìm kiếm lớp học phần..." value="{{ request('search') }}">
						</div>

						<div class="col-md-3">
							<select name="hinh_thuc_buoi_hoc" class="form-select">
								<option value="">-- Tất cả hình thức --</option>
								<option value="offline" {{ request('hinh_thuc_buoi_hoc') == 'offline' ? 'selected' : '' }}>Offline</option>
								<option value="online" {{ request('hinh_thuc_buoi_hoc') == 'online' ? 'selected' : '' }}>Online</option>
								<option value="hybrid" {{ request('hinh_thuc_buoi_hoc') == 'hybrid' ? 'selected' : '' }}>Kết hợp</option>
							</select>
						</div>
                        
						<div class="col-md-3">
							<input type="date" name="ngay" class="form-control" value="{{ request('ngay') }}">
						</div>

						<div class="col-md-2">
							<button type="submit" class="btn btn-primary w-100">
								<i class="bi bi-search"></i> Tìm
							</button>
						</div>
					</div>
				</form>

				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead>
							<tr>
								<th>STT</th>
								<th>Lớp học phần</th>
								<th>Ngày</th>
								<th>Giờ</th>
								<th>Phòng</th>
								<th>Hình thức</th>
								<th>Giảng viên</th>
								<th>Ghi chú</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($lichHoc as $index => $lich)
								<tr>
									<td>{{ $lichHoc->firstItem() + $index }}</td>
									<td>{{ $lich->lopHocPhan->ma_lop_hp ?? 'Chưa có' }}</td>
									<td>{{ \Carbon\Carbon::parse($lich->ngay)->format('d/m/Y') }}</td>
									<td>{{ $lich->gio_bat_dau }} - {{ $lich->gio_ket_thuc }}</td>
									<td>{{ $lich->phongHoc->ten_phong ?? 'N/A' }}</td>
									<td>
										@switch($lich->hinh_thuc_buoi_hoc)
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
									<td>{{ $lich->giangVien->ho_ten ?? '-' }}</td>
									<td>{{ Str::limit($lich->ghi_chu ?? '-', 60) }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('dao-tao.lich-hoc.show', $lich->id) }}" 
												class="btn btn-sm btn-info" title="Xem">
												<i class="bi bi-eye"></i>
											</a>
											<a href="{{ route('dao-tao.lich-hoc.edit', $lich->id) }}" 
												class="btn btn-sm btn-warning" title="Sửa">
												<i class="bi bi-pencil"></i>
											</a>
											<form action="{{ route('dao-tao.lich-hoc.destroy', $lich->id) }}" 
												method="POST" class="d-inline"
												onsubmit="return confirm('Bạn có chắc muốn xóa lịch học này?')">
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
									<td colspan="9" class="text-center">Không có dữ liệu lịch học</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				<div class="d-flex justify-content-center">
					{{ $lichHoc->links() }}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
