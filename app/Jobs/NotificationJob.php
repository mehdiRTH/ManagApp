<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $modal_id, $user_id;
    /**
     * Create a new job instance.
     */
    public function __construct($user_id,$modal_id)
    {
        $this->modal_id=$modal_id;
        $this->user_id=$user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notifications=Notification::where('notifiable_id',$this->user_id)->whereJsonContains('data->route->params', $this->modal_id)->get();
        if($notifications)
        {
            foreach($notifications as $notification)
            {
                $notification->update([
                    'read_at'=> now()
                ]);
            }

        }
    }
}
