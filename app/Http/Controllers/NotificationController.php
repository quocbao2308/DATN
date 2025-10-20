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
        $notifications = ThongBao::where('tai_khoan_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = ThongBao::where('tai_khoan_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        ThongBao::where('tai_khoan_id', Auth::id())
            ->where('da_doc', false)
            ->update(['da_doc' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Get unread count.
     */
    public function getUnreadCount()
    {
        $count = ThongBao::where('tai_khoan_id', Auth::id())
            ->where('da_doc', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
