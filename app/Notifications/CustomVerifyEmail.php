<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;  //因為有引入這個所以不用via來告知哪種傳送方法
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;



class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        // Laravel 預設的驗證連結
        $verifyUrl = URL::temporarySignedRoute(
            'api.verify.email',  // 你定義的驗證 API 路由名稱
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        // 替換為前端驗證頁的連結（用 query string 帶參數）
        $frontendUrl = 'http://localhost:8080/register_verify_success?redirect=' . urlencode($verifyUrl);

        return (new MailMessage)
            ->subject('請驗證您的 Email')
            ->line('請點擊下方按鈕完成驗證：')
            ->action('點我驗證 Email', $frontendUrl)
            ->line('如果你沒有註冊，請忽略這封信。');
    }
}
