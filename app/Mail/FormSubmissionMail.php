<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class FormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;
    public string $formType;
    public $userDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($formType, $formData, $userDetails)
    {
        $this->formType = $formType;
        $this->formData = $formData;
        $this->userDetails = $userDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Form Submission Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.form-submitted', // Your email view
            with: [
                'data' => $this->formData, // Pass form data to the view,
                'type' => $this->formType,
                'user' => $this->userDetails
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
        $attachments = [];

        if ($this->formType === 'documentation') {
            if ($this->formData->attachments) {
                foreach ($this->formData->attachments as $attachment) {
                    $attachments[] = Attachment::fromPath($attachment->file->path)
                        ->as($attachment->file->new_name)
                        ->withMime($attachment->file->type);
                }
            }
        }
        return $attachments;
    }
}
