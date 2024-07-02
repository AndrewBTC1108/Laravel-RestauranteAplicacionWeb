<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verificar Cuenta')
                ->line('Tu cuenta ya esta casi lista, solo debes presionar el enlace a continuación')
                ->action('Confirmar cuenta', $url)
                ->line('Si no creaste esta cuenta, puedes ignorar el mensaje');
        });

        // Personalizar el correo electrónico de restablecimiento de contraseña
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $email = $notifiable->getEmailForPasswordReset();
            $resetUrl = env('FRONTEND_URL') . '/auth/reset-password?token=' . $token . '&email=' . $email;
            return (new MailMessage)
                ->subject('Restablecer Contraseña')
                ->line('Recibes este correo porque solicitaste un restablecimiento de contraseña para tu cuenta.')
                ->action('Restablecer Contraseña', $resetUrl)
                ->line('Si no solicitaste un restablecimiento de contraseña, puedes ignorar este correo.');
        });
    }
}
