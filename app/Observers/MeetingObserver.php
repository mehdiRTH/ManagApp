<?php

namespace App\Observers;

use App\Mail\MeetingMail;
use App\Models\Meeting;
use App\Notifications\MeetingNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class MeetingObserver
{
    /**
     * Handle the Meeting "created" event.
     */
    public function created(Meeting $meeting): void
    {
        //Meeting Emails
        Mail::to($meeting->participants)->send(new MeetingMail($meeting,'created'));

        //Meeting Notifications
        Notification::send($meeting->participants, new MeetingNotification($meeting, 'created'));
    }

    /**
     * Handle the Meeting "updated" event.
     */
    public function updated(Meeting $meeting): void
    {
        //Meeting Emails
        Mail::to($meeting->participants)->send(new MeetingMail($meeting,'updated'));

        //Meeting Notifications
        Notification::send($meeting->participants, new MeetingNotification($meeting, 'updated'));
    }

    /**
     * Handle the Meeting "deleted" event.
     */
    public function deleted(Meeting $meeting): void
    {
        //Meeting Emails
        Mail::to($meeting->participants)->send(new MeetingMail($meeting,'deleted'));

        //Meeting Notifications
        Notification::send($meeting->participants, new MeetingNotification($meeting, 'deleted'));
    }

    /**
     * Handle the Meeting "restored" event.
     */
    public function restored(Meeting $meeting): void
    {
        //
    }

    /**
     * Handle the Meeting "force deleted" event.
     */
    public function forceDeleted(Meeting $meeting): void
    {
        //
    }
}
