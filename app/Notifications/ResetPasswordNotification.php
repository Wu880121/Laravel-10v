<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
	 public $token;
	 
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
		
		$resetUrl = "http://localhost:8080/reset_password?token={$this->token}&email={$notifiable->email}";
		
        return (new MailMessage)
					->subject('🔐 重設您的密碼')
                    ->line('您收到這封信是因為我們收到了您的帳號的密碼重設請求。')
                    ->action('點我重設密碼', $resetUrl)
                    ->line('如果您沒有要求重設密碼，請忽略這封信即可。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
