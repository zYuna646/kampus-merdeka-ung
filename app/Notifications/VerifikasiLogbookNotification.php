<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DailyLog;
use App\Models\WeeklyLog;

class VerifikasiLogbookNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $logbook;
    protected $status;
    protected $pesan;
    protected $verifikator;
    protected $tipe;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($logbook, $status, $pesan, $verifikator, $tipe = 'daily')
    {
        $this->logbook = $logbook;
        $this->status = $status;
        $this->pesan = $pesan;
        $this->verifikator = $verifikator;
        $this->tipe = $tipe; // 'daily' atau 'weekly'
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
        $statusText = $this->status == 'terima' ? 'diterima' : 'ditolak';
        $verifikatorText = $this->verifikator == 'dpl' ? 'DPL' : 'Pamong';
        $tipeText = $this->tipe == 'daily' ? 'Harian' : 'Mingguan';
        $urlPath = $this->tipe == 'daily' ? '/student/daily-log' : '/student/weekly-log';
        
        $tanggal = $this->tipe == 'daily' 
            ? $this->logbook->tanggal 
            : 'Minggu ke-' . $this->logbook->minggu_ke;
        
        return (new MailMessage)
            ->subject('Verifikasi Logbook ' . $tipeText)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Logbook ' . $tipeText . ' Anda tanggal ' . $tanggal . ' telah ' . $statusText . ' oleh ' . $verifikatorText . '.')
            ->line('Pesan: ' . ($this->pesan ?: '-'))
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
            'logbook_id' => $this->logbook->id,
            'logbook_type' => $this->tipe,
            'status' => $this->status,
            'pesan' => $this->pesan,
            'verifikator' => $this->verifikator,
        ];
    }
}