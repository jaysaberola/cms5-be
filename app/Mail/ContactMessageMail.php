<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $customerEmail = trim((string) ($this->data['email'] ?? ''));
        $customerName = trim(
            trim((string) ($this->data['first_name'] ?? '')) . ' ' . trim((string) ($this->data['last_name'] ?? ''))
        );

        $mailable = $this->subject('New Inquiry Received')
            ->view('emails.contact-message');

        if ($customerEmail !== '' && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $mailable->replyTo($customerEmail, $customerName !== '' ? $customerName : $customerEmail);
        }

        return $mailable;
    }
}
