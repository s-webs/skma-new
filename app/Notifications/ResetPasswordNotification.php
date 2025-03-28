<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends ResetPassword
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {

        $resetUrl = url(route('password.reset', ['token' => $this->token, 'email' => $notifiable->email], false));


        return (new MailMessage)
            ->subject('Сброс пароля')
            ->view('mails.reset-password', ['resetUrl' => $resetUrl]);
    }
}
