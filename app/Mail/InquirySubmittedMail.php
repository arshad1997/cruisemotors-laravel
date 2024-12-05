<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquirySubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    /**
     * Create a new message instance.
     *
     * @param $inquiry
     */
    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for your inquiry',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-submitted', // Your email view
            with: [
                'inquiry' => $this->inquiry, // Pass inquiry data to the view
            ],
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
