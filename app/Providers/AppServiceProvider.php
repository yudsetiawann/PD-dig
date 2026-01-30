<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();
        User::observe(UserObserver::class);

        // Kustomisasi Bahasa Email Verifikasi
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email Anda') // Judul Email
                ->greeting('Halo!') // Sapaan pembuka
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.') // Kalimat pengantar
                ->action('Verifikasi Email Saya', $url) // Tulisan di Tombol
                ->line('Jika Anda tidak merasa mendaftar akun ini, abaikan saja pesan ini.'); // Kalimat penutup
        });
    }
}
