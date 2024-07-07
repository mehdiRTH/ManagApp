<?php

namespace App\Notifications;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingNotification extends Notification
{
    use Queueable;

    public $meeting, $event;
    /**
     * Create a new notification instance.
     */
    public function __construct(Meeting $meeting,string $event)
    {
        //Initialize the Meeting
        $this->meeting = $meeting;

        //initilize the Event
        $this->event = $event;
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
        $message='';

        if($this->event=='created') $message='You have a meeting at ' . date('d, M H:m', strtotime($this->meeting->start_date));
        else if($this->event=='updated') $message='Update : You have a meeting at ' . date('d, M H:m', strtotime($this->meeting->start_date));
        else $message='The meeeting at '.date('d, M H:m', strtotime($this->meeting->start_date)).' with '.$this->meeting->responsible->name.' has been canceled';

        return [
            'message' => $message,
            'route' => $this->event == 'deleted' ? null : ['url' => 'meetings.show', 'params' => $this->meeting->id]
        ];
    }
}
