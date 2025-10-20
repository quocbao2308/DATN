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

        // Nhóm thông báo theo batch_id HOẶC theo nội dung giống nhau
        $allNotifications = $query->get()->groupBy(function ($notification) {
            // Nếu có batch_id thì nhóm theo batch_id
            if ($notification->batch_id) {
                return 'batch_' . $notification->batch_id;
            }
            // Nếu không có batch_id, nhóm theo nội dung giống nhau (tieu_de + noi_dung + created_at trong cùng phút)
            $groupKey = md5($notification->tieu_de . $notification->noi_dung . $notification->created_at->format('Y-m-d H:i'));
            return 'content_' . $groupKey;
        })->map(function ($group) {
            $first = $group->first();
            $count = $group->count();

            // Nếu nhóm có nhiều hơn 1 thông báo, đánh dấu là batch
            if ($count > 1) {
                $first->recipient_count = $count;
                $first->read_count = $group->where('da_doc', true)->count();
                $first->is_batch = true;
                $first->recipients = $group->pluck('nguoiNhan')->filter(); // Danh sách người nhận
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
    public function show($id)
    {
        $notification = ThongBao::with(['nguoiNhan', 'nguoiTao'])->findOrFail($id);
        
        // Lấy tất cả thông báo trong cùng batch (nếu là batch)
        $recipients = collect();
        if ($notification->batch_id) {
            // Nhóm theo batch_id
            $recipients = ThongBao::with('nguoiNhan')
                ->where('batch_id', $notification->batch_id)
                ->orderBy('da_doc', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Nhóm theo nội dung giống nhau (cùng thời gian gửi)
            $groupKey = md5($notification->tieu_de . $notification->noi_dung . $notification->created_at->format('Y-m-d H:i'));
            $recipients = ThongBao::with('nguoiNhan')
                ->where('tieu_de', $notification->tieu_de)
                ->where('noi_dung', $notification->noi_dung)
                ->whereBetween('created_at', [
                    $notification->created_at->copy()->subMinute(),
                    $notification->created_at->copy()->addMinute()
                ])
                ->orderBy('da_doc', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        $isBatch = $recipients->count() > 1;
        
        return view('admin.notifications.show', compact('notification', 'recipients', 'isBatch'));
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy($id)
    {
        try {
            $notification = ThongBao::findOrFail($id);
            
            // Nếu thông báo thuộc một batch, xóa toàn bộ batch
            if ($notification->batch_id) {
                $count = ThongBao::where('batch_id', $notification->batch_id)->count();
                ThongBao::where('batch_id', $notification->batch_id)->delete();
                $message = "Đã xóa thông báo (gồm {$count} người nhận) thành công!";
            } else {
                // Xóa các thông báo có nội dung giống nhau (cùng thời gian)
                $groupKey = md5($notification->tieu_de . $notification->noi_dung . $notification->created_at->format('Y-m-d H:i'));
                $similarNotifications = ThongBao::where('tieu_de', $notification->tieu_de)
                    ->where('noi_dung', $notification->noi_dung)
                    ->whereBetween('created_at', [
                        $notification->created_at->copy()->subMinute(),
                        $notification->created_at->copy()->addMinute()
                    ])
                    ->get();
                
                if ($similarNotifications->count() > 1) {
                    $count = $similarNotifications->count();
                    ThongBao::whereIn('id', $similarNotifications->pluck('id'))->delete();
                    $message = "Đã xóa thông báo (gồm {$count} người nhận) thành công!";
                } else {
                    $notification->delete();
                    $message = 'Đã xóa thông báo thành công!';
                }
            }

            return redirect()
                ->route('admin.notifications.index')
                ->with('success', $message);
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
            $deletedCount = 0;
            $batchesProcessed = [];
            
            foreach ($validated['notification_ids'] as $id) {
                $notification = ThongBao::find($id);
                
                if (!$notification) continue;
                
                // Nếu có batch_id và chưa xử lý batch này
                if ($notification->batch_id && !in_array($notification->batch_id, $batchesProcessed)) {
                    $count = ThongBao::where('batch_id', $notification->batch_id)->count();
                    ThongBao::where('batch_id', $notification->batch_id)->delete();
                    $deletedCount += $count;
                    $batchesProcessed[] = $notification->batch_id;
                } 
                // Nếu không có batch_id, xóa các thông báo giống nhau
                else if (!$notification->batch_id) {
                    $groupKey = md5($notification->tieu_de . $notification->noi_dung . $notification->created_at->format('Y-m-d H:i'));
                    
                    // Kiểm tra xem đã xử lý nhóm này chưa
                    if (!in_array($groupKey, $batchesProcessed)) {
                        $similarNotifications = ThongBao::where('tieu_de', $notification->tieu_de)
                            ->where('noi_dung', $notification->noi_dung)
                            ->whereBetween('created_at', [
                                $notification->created_at->copy()->subMinute(),
                                $notification->created_at->copy()->addMinute()
                            ])
                            ->get();
                        
                        if ($similarNotifications->count() > 0) {
                            ThongBao::whereIn('id', $similarNotifications->pluck('id'))->delete();
                            $deletedCount += $similarNotifications->count();
                            $batchesProcessed[] = $groupKey;
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ' . $deletedCount . ' thông báo'
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
