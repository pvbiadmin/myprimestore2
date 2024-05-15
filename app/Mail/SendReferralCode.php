<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\Pure;

class SendReferralCode extends Mailable
{
    use Queueable, SerializesModels;

    public mixed $messageContent;
    public mixed $fromAddress;

    /**
     * Create a new message instance.
     */
    public function __construct($messageContent, $fromAddress)
    {
        $this->messageContent = $messageContent;
        $this->fromAddress = $fromAddress;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->fromAddress,
            subject: 'Send Referral Code',
        );
    }

    /**
     * Get the message content definition.
     */
    #[Pure] public function content(): Content
    {
        return new Content(
            view: 'mail.send-referral-code',
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
