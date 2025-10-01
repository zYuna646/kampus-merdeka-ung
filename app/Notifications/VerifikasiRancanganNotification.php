<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProgramTransaction;

class VerifikasiRancanganNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $programTransaction;
    protected $status;
    protected $pesan;
    protected $verifikator;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProgramTransaction $programTransaction, $status, $pesan, $verifikator)
    {
        $this->programTransaction = $programTransaction;
        $this->status = $status;
        $this->pesan = $pesan;
        $this->verifikator = $verifikator;
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
        
        return (new MailMessage)
            ->subject('Verifikasi Rancangan Kegiatan')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Rancangan kegiatan Anda telah ' . $statusText . ' oleh ' . $verifikatorText . '.')
            ->line('Program: ' . $this->programTransaction->lowongan->program->name)
            ->line('Pesan: ' . ($this->pesan ?: '-'))
            ->action('Lihat Detail', url('/student/rancangan'))
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
            'program_transaction_id' => $this->programTransaction->id,
            'status' => $this->status,
            'pesan' => $this->pesan,
            'verifikator' => $this->verifikator,
        ];
    }
}