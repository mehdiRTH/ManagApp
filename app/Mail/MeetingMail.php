<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $meeting, $event;
    /**
     * Create a new message instance.
     */
    public function __construct(Meeting $meeting,string $event)
    {
        //Initialize the Meeting
        $this->meeting = $meeting;

        //initilize the Event
        $this->event = $event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $message='';

        if($this->event=='created') $message='You have meeting at '.date('d,M H:m', strtotime($this->meeting->start_date)).' with '.$this->meeting->responsible->name;
        else if($this->event=='updated') $message='Update : You have meeting at '.date('d,M H:m', strtotime($this->meeting->start_date)).' with '.$this->meeting->responsible->name;
        else $message='The meeeting at '.date('d,M H:m', strtotime($this->meeting->start_date)).' with '.$this->meeting->responsible->name.' has been canceled';

        return new Envelope(
            subject: $message
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'Meetings.Email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
