<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Ngành</th>
                <th>Chuyên ngành</th>
                <th>Khóa</th>
                <th>Kỳ</th>
                <th>Trạng thái</th>
                <th>SĐT</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>
                        <span class="badge bg-primary">{{ $item->ma_sinh_vien }}</span>
                    </td>
                    <td>
                        <strong>{{ $item->ho_ten }}</strong>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <small>{{ $item->ten_nganh }}</small>
                    </td>
                    <td>
                        <small>{{ $item->ten_chuyen_nganh }}</small>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $item->ten_khoa_hoc }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $item->ky_hien_tai }}</span>
                    </td>
                    <td>
                        @if ($item->ten_trang_thai === 'Đang học')
                            <span class="badge bg-success">{{ $item->ten_trang_thai }}</span>
                        @elseif($item->ten_trang_thai === 'Tốt nghiệp')
                            <span class="badge bg-primary">{{ $item->ten_trang_thai }}</span>
                        @elseif($item->ten_trang_thai === 'Bảo lưu')
                            <span class="badge bg-warning">{{ $item->ten_trang_thai }}</span>
                        @else
                            <span class="badge bg-danger">{{ $item->ten_trang_thai }}</span>
                        @endif
                    </td>
                    <td>{{ $item->so_dien_thoai ?? '-' }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.show', $item->user_id) }}" class="btn btn-info"
                                title="Xem">
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
                    <td colspan="10" class="text-center">Chưa có Sinh viên nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $items->appends(['role' => 'sinh_vien'])->links('pagination::bootstrap-5') }}
</div>
