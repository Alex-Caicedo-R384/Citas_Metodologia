<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('status', 'Notifications marked as read!');
    }
}