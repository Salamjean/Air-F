<?php

namespace App\Http\Controllers\Financier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancierNotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $user = Auth::guard('user')->user();
        $notifications = $user->notifications()->paginate(15);

        return view('financier.notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read and redirect.
     */
    public function read($id)
    {
        $user = Auth::guard('user')->user();
        $notification = $user->notifications()->findOrFail($id);

        $notification->markAsRead();

        // Redirect to the intervention detail if possible
        if (isset($notification->data['intervention_id'])) {
            return redirect()->route('financier.interventions.paiement_detail', $notification->data['intervention_id']);
        }

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::guard('user')->user();
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}
