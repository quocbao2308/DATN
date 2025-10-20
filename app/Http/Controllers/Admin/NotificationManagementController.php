<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeThong\ThongBao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationManagementController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type');
        $role = $request->get('role');

        // Lấy tất cả thông báo theo điều kiện lọc
        $query = ThongBao::with(['nguoiNhan', 'nguoiTao'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('tieu_de', 'like', "%{$search}%")
                        ->orWhere('noi_dung', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('loai', $type);
            })
            ->when($role, function ($query, $role) {
                $query->where('vai_tro_nhan', $role);
            })
            ->orderBy('created_at', 'desc');

        // Nhóm thông báo theo batch_id
        $allNotifications = $query->get()->groupBy(function ($notification) {
            return $notification->batch_id ?? 'single_' . $notification->id;
        })->map(function ($group) {
            $first = $group->first();
            $count = $group->count();
            
            // Nếu là batch (nhiều người), tính số người đã đọc
            if ($count > 1 && $first->batch_id) {
                $first->recipient_count = $count;
                $first->read_count = $group->where('da_doc', true)->count();
                $first->is_batch = true;
            } else {
                $first->is_batch = false;
            }
            
            return $first;
        })->values();

        // Phân trang thủ công
        $currentPage = request()->get('page', 1);
        $perPage = 15;
        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allNotifications->forPage($currentPage, $perPage),
            $allNotifications->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Thống kê
        $stats = [
            'total' => ThongBao::count(),
            'unread' => ThongBao::unread()->count(),
            'read' => ThongBao::read()->count(),
            'by_type' => ThongBao::select('loai', DB::raw('count(*) as total'))
                ->groupBy('loai')
                ->get(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats', 'search', 'type', 'role'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        // Lấy danh sách users để gửi thông báo cá nhân (optional)
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'loai' => 'required|in:thong_tin,canh_bao,quan_trong',
            'vai_tro_nhan' => 'required|in:all,admin,dao_tao,giang_vien,sinh_vien,specific',
            'nguoi_nhan_ids' => 'required_if:vai_tro_nhan,specific|array',
            'nguoi_nhan_ids.*' => 'exists:users,id',
            'lien_ket' => 'nullable|string|max:255',
        ], [
            'tieu_de.required' => 'Tiêu đề không được để trống',
            'noi_dung.required' => 'Nội dung không được để trống',
            'loai.required' => 'Vui lòng chọn loại thông báo',
            'vai_tro_nhan.required' => 'Vui lòng chọn đối tượng nhận',
            'nguoi_nhan_ids.required_if' => 'Vui lòng chọn người nhận',
        ]);

        DB::beginTransaction();
        try {
            // Nếu gửi cho vai trò cụ thể
            if ($validated['vai_tro_nhan'] !== 'specific') {
                // Lấy danh sách users theo vai trò
                $users = $this->getUsersByRole($validated['vai_tro_nhan']);

                // Tạo thông báo cho từng user
                foreach ($users as $user) {
                    ThongBao::create([
                        'nguoi_nhan_id' => $user->id,
                        'nguoi_tao_id' => Auth::id(),
                        'tieu_de' => $validated['tieu_de'],
                        'noi_dung' => $validated['noi_dung'],
                        'loai' => $validated['loai'],
                        'lien_ket' => $validated['lien_ket'] ?? null,
                        'vai_tro_nhan' => $validated['vai_tro_nhan'],
                        'da_doc' => false,
                    ]);
                }
            } else {
                // Gửi cho users cụ thể
                foreach ($validated['nguoi_nhan_ids'] as $userId) {
                    ThongBao::create([
                        'nguoi_nhan_id' => $userId,
                        'nguoi_tao_id' => Auth::id(),
                        'tieu_de' => $validated['tieu_de'],
                        'noi_dung' => $validated['noi_dung'],
                        'loai' => $validated['loai'],
                        'lien_ket' => $validated['lien_ket'] ?? null,
                        'vai_tro_nhan' => 'specific',
                        'da_doc' => false,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.notifications.index')
                ->with('success', 'Đã gửi thông báo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified notification.
     */
    public function show(ThongBao $notification)
    {
        $notification->load(['nguoiNhan', 'nguoiTao']);
        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy(ThongBao $notification)
    {
        try {
            $notification->delete();

            return redirect()
                ->route('admin.notifications.index')
                ->with('success', 'Đã xóa thông báo thành công!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.notifications.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple notifications
     */
    public function destroyMultiple(Request $request)
    {
        $validated = $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:thong_bao,id',
        ]);

        try {
            ThongBao::whereIn('id', $validated['notification_ids'])->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ' . count($validated['notification_ids']) . ' thông báo'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get users by role
     */
    private function getUsersByRole($role)
    {
        if ($role === 'all') {
            return User::all();
        }

        // Lấy users theo vai trò từ bảng tương ứng
        $table = $role; // admin, dao_tao, giang_vien, sinh_vien

        $userIds = DB::table($table)->pluck('user_id');

        return User::whereIn('id', $userIds)->get();
    }

    /**
     * Get statistics
     */
    public function getStats()
    {
        $stats = [
            'total' => ThongBao::count(),
            'unread' => ThongBao::unread()->count(),
            'read' => ThongBao::read()->count(),
            'today' => ThongBao::whereDate('created_at', today())->count(),
            'this_week' => ThongBao::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'by_type' => ThongBao::select('loai', DB::raw('count(*) as total'))
                ->groupBy('loai')
                ->get(),
            'by_role' => ThongBao::select('vai_tro_nhan', DB::raw('count(*) as total'))
                ->groupBy('vai_tro_nhan')
                ->get(),
        ];

        return response()->json($stats);
    }
}
