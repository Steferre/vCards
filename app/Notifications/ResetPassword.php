<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends ResetPasswordNotification
{
    use Queueable;

    public $token;

    public static $createUrlCallback;

    public static $toMailCallback;

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
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Notifica Reset Password'))
            ->line(Lang::get('Ricevi questo messaggio in quanto hai richiesto il reset della password per il tuo account.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('Questo link di reset scade in :count minuti.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Se non hai richeisto il reset della password, ti preghiamo di ignorare questo messaggio.'));
    }


    protected function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }


    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }


    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
