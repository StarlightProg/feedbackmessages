<?php

namespace App\Services;

use App\Mail\SendMessageMail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendMail(array $data, string $name)
    {
        Mail::to(env('MAIL_USERNAME'))->queue(new SendMessageMail($data, $name));
    }
}