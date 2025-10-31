<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    /**
     * Cria uma nova instância da notificação.
     */
    public function __construct(string $token)
    {
        // Nós recebemos o token e o armazenamos na classe
        $this->token = $token; 
    }

    /**
     * Pega os canais de notificação.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Pega a representação em e-mail da notificação.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = 'http://localhost:3000/password-recovery/' . $this->token;

        return (new MailMessage)
                    ->subject('PetTracker - Redefinição de Senha') 
                    ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.') 
                    ->action('Redefinir Senha', $url) 
                    ->line('Este link de redefinição de senha expirará em 60 minutos.')
                    ->line('Se você não solicitou uma redefinição de senha, nenhuma ação é necessária.')
                    ->line('Obrigado por usar nosso aplicativo!')
                    ->line('---')
                    ->line('Token (Para fins de teste): ' . $this->token);
    }
}