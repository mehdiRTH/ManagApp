<?php

namespace App\Jobs;

use App\Mail\MeetingMail;
use App\Models\Meeting;
use App\Notifications\MeetingNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class MeetingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Meeting $meeting,public string $event)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Meeting Emails
        Mail::to($this->meeting->participants)->send(new MeetingMail($this->meeting,$this->event));

        //Meeting Notifications
        Notification::send($this->meeting->participants, new MeetingNotification($this->meeting,$this->event));
    }
}
