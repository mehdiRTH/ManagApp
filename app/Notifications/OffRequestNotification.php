<?php

namespace App\Notifications;

use App\Models\OffRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OffRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $offRequest,$type;
    public function __construct(OffRequest $offRequest,$type)
    {
        $this->offRequest=$offRequest;
        $this->type=$type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message="";
        if($this->type=='send to HR') {
            $message=$this->offRequest->user->name." has Off Request";
        }else{
            $message="The Off Request has been ".$this->offRequest->status;
        }
        return [
            'message' => $message,
            'route' =>['url' => 'off_requests.show', 'params' => $this->offRequest->id]
        ];
    }
}
