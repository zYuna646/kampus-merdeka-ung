<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogbookNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $judul;
    protected $pesan;
    protected $tipe;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($judul, $pesan, $tipe = 'daily_logbook')
    {
        $this->judul = $judul;
        $this->pesan = $pesan;
        $this->tipe = $tipe; // 'daily_logbook' atau 'weekly_logbook'
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $urlPath = $this->tipe == 'daily_logbook' ? '/student/daily-log' : '/student/weekly-log';
        
        return (new MailMessage)
            ->subject($this->judul)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($this->pesan)
            ->line('Anda tidak dapat mengisi logbook sampai dibuka kembali.')
            ->action('Lihat Detail', url($urlPath))
            ->line('Terima kasih telah menggunakan aplikasi Kamp Merdeka!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'tipe' => $this->tipe,
        ];
    }
}