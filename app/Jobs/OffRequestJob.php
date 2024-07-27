<?php

namespace App\Jobs;

use App\Models\OffRequest;
use App\Models\User;
use App\Notifications\OffRequestNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class OffRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $offRequest,$type;
    public function __construct(OffRequest $offRequest, $type='send to HR')
    {
        $this->offRequest=$offRequest;
        $this->type=$type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->type=='send to HR'){
            $hrUsers=User::role('HR')->get();
            Notification::send($hrUsers,new OffRequestNotification($this->offRequest,'sender'));
        }
        else {
            $user=$this->offRequest->user;
            Notification::send($user,new OffRequestNotification($this->offRequest,'receiver'));
        }
    }
}
