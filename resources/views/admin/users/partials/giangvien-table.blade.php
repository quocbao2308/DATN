<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Mã GV</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Khoa</th>
                <th>Trình độ</th>
                <th>Chuyên môn</th>
                <th>SĐT</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>
                        <span class="badge bg-primary">{{ $item->ma_giang_vien }}</span>
                    </td>
                    <td>
                        <strong>{{ $item->ho_ten }}</strong>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <span class="badge bg-info">{{ $item->ten_khoa }}</span>
                    </td>
                    <td>
                        <span class="badge bg-success">{{ $item->ten_trinh_do }}</span>
                    </td>
                    <td>{{ $item->chuyen_mon ?? '-' }}</td>
                    <td>{{ $item->so_dien_thoai ?? '-' }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.show', $item->user_id) }}" class="btn btn-info" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $item->user_id) }}" class="btn btn-warning"
                                title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $item->user_id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Chưa có Giảng viên nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $items->appends(['role' => 'giang_vien'])->links('pagination::bootstrap-5') }}
</div>
