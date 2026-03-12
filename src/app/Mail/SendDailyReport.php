<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendDailyReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfPaths;

    /**
     * Create a new message instance.
     */
    public function __construct(array $pdfPaths)
    {
        $this->pdfPaths = $pdfPaths;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Daily Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.daily-report',
            with: [
                'date' => now()->toDateString(),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->pdfPaths as $pdfPath) {
            $attachments[] = Attachment::fromPath($pdfPath);
        }

        return $attachments;
    }
}
