<?php

namespace Classiebit\Eventmie\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordNotification extends Notification
{
    public function __construct($token)
    {
        $this->token = $token;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {   
        $reset_link = route('eventmie.password.reset',['token' => $this->token]);
        return (new MailMessage)
            ->line(__('eventmie-pro::em.reset_password'))
            ->action(__('eventmie-pro::em.reset_password'), $reset_link);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $user_type = 'customer';
        if (Auth::guard('admin')->check())
            $user_type = "admin";
        elseif (Auth::guard('customer')->check())
            $user_type = "customer";
        return [
            'notification'  => 'Forgot Password',
            'n_type'        => 'forgot_password',
            "user_type" =>$user_type
        ];
        
    }
}
