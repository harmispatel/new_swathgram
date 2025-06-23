<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ProblemReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $problemReport,
        public $files
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Problem Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.problem_report',
            with: [
                'subject' => $this->problemReport->subject,
                'description' => $this->problemReport->description,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->files as $file) {
            $filePath = public_path('assets/images/uploads/documents/' . $file);
            
            if (file_exists($filePath)) {
                // Determine MIME type for better compatibility
                $mimeType = mime_content_type($filePath);

                // Attach the file with MIME type
                $attachments[] = Attachment::fromPath($filePath)
                    ->as(basename($filePath)) // Use original filename
                    ->withMime($mimeType);
            }
        }

        return $attachments;
    }
}
