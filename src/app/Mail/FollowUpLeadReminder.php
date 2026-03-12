<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FollowUpLeadReminder extends Mailable
{
    use Queueable, SerializesModels;

    public  $reminderLeads;
    public string $founderName;

    /**
     * Create a new message instance.
     */
    public function __construct($reminderLeads, string $founderName)
    {
        $this->reminderLeads = $reminderLeads;
        $this->founderName = $founderName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Follow-Up Lead Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.lead-follow-up',
            with: [
                'reminderLeads' => $this->reminderLeads,
                'founderName' => $this->founderName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
