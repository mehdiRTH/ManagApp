<?php

namespace App\Http\Controllers;

use App\Models\Notification as ModelsNotification;

class NotificationController extends Controller
{

    public function deleteNotification(ModelsNotification $notification)
    {
        $notification->delete();

        return back();
    }
}
