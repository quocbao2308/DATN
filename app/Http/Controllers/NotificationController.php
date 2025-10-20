<?php

namespace App\Http\Controllers;

use App\Models\HeThong\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = ThongBao::where('nguoi_nhan_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Display notification detail.
     */
    public function show($id)
    {
        $notification = ThongBao::where('nguoi_nhan_id', Auth::id())
            ->findOrFail($id);

        // Tự động đánh dấu đã đọc khi xem chi tiết
        if (!$notification->da_doc) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = ThongBao::where('nguoi_nhan_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        ThongBao::where('nguoi_nhan_id', Auth::id())
            ->where('da_doc', false)
            ->update(['da_doc' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Get unread count.
     */
    public function getUnreadCount()
    {
        $count = ThongBao::where('nguoi_nhan_id', Auth::id())
            ->where('da_doc', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
