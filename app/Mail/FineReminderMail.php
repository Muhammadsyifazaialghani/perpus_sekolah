<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Borrowing;

class FineReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $borrowing;

    /**
     * Create a new message instance.
     */
    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder Denda Peminjaman Buku - Perpustakaan Sekolah',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.fine_reminder',
            with: [
                'borrowing' => $this->borrowing,
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
