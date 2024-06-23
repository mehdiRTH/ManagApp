<?php

namespace App\Repositories;

class NotificationRepository{
    public function readNotification($notification)
    {
        $notification->update(['read_at' => now()]);
        return back();
    }
}
