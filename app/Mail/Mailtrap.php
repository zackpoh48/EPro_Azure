<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Mailtrap extends Mailable
{
    use Queueable, SerializesModels;

    public array $details;
    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->details["subject"]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: $this->details["template"]);
    }
}
