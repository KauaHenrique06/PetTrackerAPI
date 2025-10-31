<?php

namespace App\Notifications;

use App\Mail\AccountCreated as AccountCreatedMailable; // 👈 Importe seu Mailable
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AccountCreated extends Notification
{
    use Queueable;

    public $user; 

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Pega a representação em e-mail da notificação.
     */
    public function toMail(object $notifiable): \Illuminate\Mail\Mailable
    {
        return (new AccountCreatedMailable($this->user))
                    ->to($notifiable->email);
    }
}