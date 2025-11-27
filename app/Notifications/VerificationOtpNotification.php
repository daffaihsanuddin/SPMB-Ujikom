<?php
// app/Notifications/VerificationOtpNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class VerificationOtpNotification extends Notification
{
    use Queueable;

    public $otp;
    public $userName;

    public function __construct($otp, $userName = null)
    {
        $this->otp = $otp;
        $this->userName = $userName;
    }

    public function via($notifiable)
    {
        // Coba email dulu, jika gagal akan throw exception
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Log::info('Mencoba mengirim OTP email ke: ' . $notifiable->email);
        
        return (new MailMessage)
            ->subject('Kode Verifikasi OTP - SPMB Online')
            ->greeting('Halo ' . ($this->userName ?: $notifiable->nama) . '!')
            ->line('Terima kasih telah mendaftar di Sistem Penerimaan Murid Baru Online.')
            ->line('Gunakan kode OTP berikut untuk verifikasi akun Anda:')
            ->line('## **' . $this->otp . '**')
            ->line('Kode OTP ini berlaku selama 10 menit.')
            ->action('Verifikasi Sekarang', url('/verification/otp'))
            ->line('Jika Anda tidak merasa mendaftar, abaikan email ini.')
            ->salutation('Hormat kami, Tim SPMB Online');
    }

    public function toArray($notifiable)
    {
        return [
            'otp' => $this->otp,
        ];
    }
}