@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Quản lý Trình độ</h3>
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Trình độ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Danh sách Trình độ</h5>
                        <a href="{{ route('admin.trinh-do.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Trình độ</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trinhDos as $index => $trinhDo)
                                <tr>
                                    <td>{{ $trinhDos->firstItem() + $index }}</td>
                                    <td><strong>{{ $trinhDo->ten_trinh_do }}</strong></td>
                                    <td>{{ $trinhDo->created_at ? $trinhDo->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.trinh-do.edit', $trinhDo->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.trinh-do.destroy', $trinhDo->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Xóa trình độ này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Chưa có trình độ nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $trinhDos->links() }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection
