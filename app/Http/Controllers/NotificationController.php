<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    //

    public function getProviderNotifications(Request $request)
    {
        // Get the authenticated provider
        // Determine the language based on the request header
        $lang = $request->header('lang', 'en');

        // Get the authenticated provider
        $providerId = Auth::id();

        // Retrieve notifications for the provider
        $notifications = Notification::where('user_id', $providerId)
            ->orderByDesc('created_at')
            ->get();

        // Prepare the response with messages and titles based on the language
        $formattedNotifications = [];
        foreach ($notifications as $notification) {
            $title = $lang === 'ar' ? $notification->title_ar : $notification->title_en;
            $message = $lang === 'ar' ? $notification->msg_ar : $notification->msg_en;

            $formattedNotifications[] = [
                'title' => $title,
                'message' => $message,
                'reservation_id'=>$notification->reservation_id,
                'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
            ];
        }
        return response()->json([
            'status' => 200,
            'msg' => null,
            'data' =>$formattedNotifications
        ]);

    }

    public function deleteProviderNotifications()
    {
        // Get the authenticated provider
        $providerId = Auth::id();

        // Delete notifications for the provider
        Notification::where('user_id', $providerId)->delete();

        // Return success response
        return response()->json([
            'status' => 200,
            'msg' => 'notifications deleted successfully',
            'data' =>null
        ]);
    }
}
