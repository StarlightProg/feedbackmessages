<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class SendMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $filename;
    /**
     * Create a new message instance.
     */
    public function __construct($data,$filename)
    {
        $this->mailData = $data;
        $this->filename = $filename;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('test0site@rambler.ru', 'Egor Novikov'),
            subject: 'Сообщение из формы',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.message',
            with: [
                'theme' => $this->mailData['theme'],
                'message' => $this->mailData['message'],
                'file' => $this->mailData['file'],
                'user_id' => $this->mailData['user_id']
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
        return [
            Attachment::fromPath(Storage::path("public/".$this->filename))
        ];
    }
}
