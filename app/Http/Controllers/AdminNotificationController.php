<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');
        $query = Notification::orderBy('created_at', 'desc');
        if ($filter === 'unread') {
            $query->where('is_read', false);

            
        } elseif ($filter === 'read') {
            $query->where('is_read', true);
        }
        $notifications = $query->get();
        return view('admin.notifications', compact('notifications', 'filter'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();
        return redirect()->route('admin.notifications')->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}
