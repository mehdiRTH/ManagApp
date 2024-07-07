<?php

namespace App\Http\Controllers;

use App\Models\Notification as ModelsNotification;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{

    public function deleteNotification(ModelsNotification $notification) : RedirectResponse
    {
        $notification->delete();

        return back();
    }
}
