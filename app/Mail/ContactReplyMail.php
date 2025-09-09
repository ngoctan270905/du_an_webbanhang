<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $replyContent;
    public $contact;

    public function __construct($contact, $replyContent)
    {
        $this->contact = $contact;
        $this->replyContent = $replyContent;
    }

    public function build()
    {
        return $this->subject('Phản hồi liên hệ từ chúng tôi')
                    ->view('emails.contact_reply');
    }
}
