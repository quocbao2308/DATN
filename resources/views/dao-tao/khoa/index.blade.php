@extends('layouts.layout-daotao')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Quản lý Khoa</h3>
                    <p class="text-subtitle text-muted">Danh sách các khoa trong trường</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Khoa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Thành công!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách Khoa</h5>
                        <a href="{{ route('dao-tao.khoa.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Khoa</th>
                                <th>Số Ngành</th>
                                <th>Số Giảng viên</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($khoas as $index => $khoa)
                                <tr>
                                    <td>{{ $khoas->firstItem() + $index }}</td>
                                    <td><strong>{{ $khoa->ten_khoa }}</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $khoa->nganhs_count }} ngành</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $khoa->giang_viens_count }} GV</span>
                                    </td>
                                    <td>{{ $khoa->created_at ? $khoa->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dao-tao.khoa.edit', $khoa->id) }}"
                                                class="btn btn-sm btn-warning" title="Sửa">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('dao-tao.khoa.destroy', $khoa->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa khoa {{ $khoa->ten_khoa }}?');">
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
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p>Chưa có khoa nào. <a href="{{ route('dao-tao.khoa.create') }}">Thêm mới</a></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $khoas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
