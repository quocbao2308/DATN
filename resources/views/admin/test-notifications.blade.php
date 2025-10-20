@extends('layouts.layout-admin')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>🧪 Test Thông báo Tự động</h3>
                    <p class="text-subtitle text-muted">Demo và test các loại thông báo tự động</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <section class="section">
            <div class="row">
                <!-- Thông báo cho Sinh viên -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">🎓 Thông báo cho Sinh viên</h5>
                        </div>
                        <div class="card-body">
                            <!-- Thêm vào lớp -->
                            <form action="{{ route('admin.test-notifications.send') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="type" value="student_added">
                                <div class="mb-2">
                                    <label class="form-label">ID Sinh viên:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm w-100">
                                    <i class="bi bi-person-plus me-1"></i> Thêm vào lớp học
                                </button>
                            </form>

                            <hr>

                            <!-- Điểm mới -->
                            <form action="{{ route('admin.test-notifications.send') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="type" value="new_grade">
                                <div class="mb-2">
                                    <label class="form-label">ID Sinh viên:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-file-earmark-text me-1"></i> Có điểm mới
                                </button>
                            </form>

                            <hr>

                            <!-- Cảnh báo điểm danh -->
                            <form action="{{ route('admin.test-notifications.send') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="type" value="attendance_warning">
                                <div class="mb-2">
                                    <label class="form-label">ID Sinh viên:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Cảnh báo điểm danh
                                </button>
                            </form>

                            <hr>

                            <!-- Vi phạm -->
                            <form action="{{ route('admin.test-notifications.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="attendance_violation">
                                <div class="mb-2">
                                    <label class="form-label">ID Sinh viên:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-x-circle me-1"></i> Vi phạm điểm danh
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Thông báo cho Giảng viên -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">👨‍🏫 Thông báo cho Giảng viên</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.test-notifications.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="teacher_assigned">
                                <div class="mb-2">
                                    <label class="form-label">ID Giảng viên:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm w-100">
                                    <i class="bi bi-clipboard-check me-1"></i> Phân công lớp học
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Thông báo cho Đào tạo -->
                    <div class="card mt-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">🏢 Thông báo cho Đào tạo</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.test-notifications.send') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="type" value="class_nearly_full">
                                <div class="mb-2">
                                    <label class="form-label">ID Đào tạo:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-people me-1"></i> Lớp gần đầy
                                </button>
                            </form>

                            <hr>

                            <form action="{{ route('admin.test-notifications.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="student_violation">
                                <div class="mb-2">
                                    <label class="form-label">ID Đào tạo:</label>
                                    <input type="number" name="user_id" class="form-control" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-exclamation-octagon me-1"></i> SV vi phạm điểm danh
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Thông báo khác -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">🎯 Thông báo khác</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ route('admin.test-notifications.send') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="new_user">
                                        <div class="mb-2">
                                            <label class="form-label">ID Admin:</label>
                                            <input type="number" name="user_id" class="form-control" value="1"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-person-plus-fill me-1"></i> Tài khoản mới (Admin)
                                        </button>
                                    </form>
                                </div>

                                <div class="col-md-6">
                                    <form action="{{ route('admin.test-notifications.send') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="send_to_multiple">
                                        <div class="mb-2">
                                            <label class="form-label">Số lượng user:</label>
                                            <input type="number" name="count" class="form-control" value="3"
                                                min="1" max="10">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-sm w-100">
                                            <i class="bi bi-send me-1"></i> Gửi nhiều người
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hướng dẫn -->
                <div class="col-12 mt-4">
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle me-2"></i>Hướng dẫn</h5>
                        <ul class="mb-0">
                            <li>Nhập ID của user muốn gửi thông báo test</li>
                            <li>Click nút tương ứng với loại thông báo muốn test</li>
                            <li>Kiểm tra thông báo tại <a href="{{ route('notifications.index') }}"
                                    target="_blank">/notifications</a></li>
                            <li>Hoặc xem dropdown thông báo ở header (icon chuông)</li>
                            <li>Code mẫu xem tại: <code>AUTO_NOTIFICATION_GUIDE.md</code></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
