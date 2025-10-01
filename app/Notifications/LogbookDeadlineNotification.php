<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DailyLog;
use App\Models\WeeklyLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogbookDeadlineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $logbook;
    protected $type;
    protected $role;

    /**
     * Create a new notification instance.
     *
     * @param mixed $logbook DailyLog atau WeeklyLog
     * @param string $type 'daily' atau 'weekly'
     * @param string $role 'mahasiswa', 'pamong', atau 'dpl'
     * @return void
     */
    public function __construct($logbook, $type, $role)
    {
        $this->logbook = $logbook;
        $this->type = $type;
        $this->role = $role;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Log untuk debugging
        \Log::info('LogbookDeadlineNotification via() dipanggil', [
            'email' => $notifiable->email,
            'logbook_id' => $this->logbook->id,
            'type' => $this->type,
            'role' => $this->role
        ]);
        
        // Kondisi sementara: hanya kirim notifikasi ke email tertentu
        if ($notifiable->email === 'anggarangga646@gmail.com' || $notifiable->email === 'zychan646@gmail.com') {
            \Log::info('Notifikasi akan dikirim ke: ' . $notifiable->email);
            return ['mail'];
        }
        
        // Untuk email lain, jangan kirim notifikasi
        \Log::info('Notifikasi tidak dikirim ke: ' . $notifiable->email);
        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Log untuk debugging
        \Log::info('LogbookDeadlineNotification toMail() dipanggil', [
            'email' => $notifiable->email,
            'logbook_id' => $this->logbook->id,
            'type' => $this->type,
            'role' => $this->role
        ]);
        
        $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
        $deadline = Carbon::parse($this->logbook->created_at)->addDays($deadlineDays)->format('d-m-Y');
        $daysLeft = Carbon::now()->diffInDays(Carbon::parse($this->logbook->created_at)->addDays($deadlineDays), false);
        
        \Log::info('Informasi deadline logbook', [
            'deadline_days' => $deadlineDays,
            'deadline' => $deadline,
            'days_left' => $daysLeft
        ]);
        
        $mailMessage = new MailMessage;
        $mailMessage->subject('Pengingat Batas Waktu Logbook Kampus Merdeka');
        
        // Cek apakah ini adalah dummy logbook untuk test (id = 0)
        $isDummyLogbook = ($this->logbook->id === 0);
        
        if ($this->role === 'mahasiswa') {
            if ($this->type === 'daily') {
                $mailMessage->line('Anda memiliki logbook harian yang belum diverifikasi oleh pamong.')
                    ->line("Tanggal logbook: {$this->logbook->date}")
                    ->line("Batas waktu verifikasi: {$deadline} ({$daysLeft} hari lagi)")
                    ->line('Logbook yang tidak diverifikasi dalam 7 hari akan otomatis ditolak dan dikunci.');
                
                // Tambahkan action button hanya jika bukan dummy logbook
                if (!$isDummyLogbook) {
                    $mailMessage->action('Lihat Logbook', route('mahasiswa.daily.form', ['id' => $this->logbook->id]));
                } else {
                    $mailMessage->line('Ini adalah email test untuk notifikasi deadline logbook.');
                }
            } else {
                $mailMessage->line('Anda memiliki logbook mingguan yang belum diverifikasi oleh DPL.')
                    ->line("Periode logbook: {$this->logbook->start_date} s/d {$this->logbook->end_date}")
                    ->line("Batas waktu verifikasi: {$deadline} ({$daysLeft} hari lagi)")
                    ->line('Logbook yang tidak diverifikasi dalam 7 hari akan otomatis ditolak dan dikunci.');
                
                // Tambahkan action button hanya jika bukan dummy logbook
                if (!$isDummyLogbook) {
                    $mailMessage->action('Lihat Logbook', route('mahasiswa.weekly.log', ['id' => $this->logbook->id]));
                } else {
                    $mailMessage->line('Ini adalah email test untuk notifikasi deadline logbook.');
                }
            }
        } elseif ($this->role === 'pamong') {
            // Pastikan ada program transaction dan mahasiswa
            if ($this->logbook->programTransaction && $this->logbook->programTransaction->mahasiswa) {
                $mahasiswaName = $this->logbook->programTransaction->mahasiswa->name ?? 'Mahasiswa';
                $mahasiswaNim = $this->logbook->programTransaction->mahasiswa->nim ?? '-';
                
                $mailMessage->line("Anda memiliki logbook harian dari {$mahasiswaName} ({$mahasiswaNim}) yang perlu diverifikasi.")
                    ->line("Tanggal logbook: {$this->logbook->date}")
                    ->line("Batas waktu verifikasi: {$deadline} ({$daysLeft} hari lagi)")
                    ->line('Logbook yang tidak diverifikasi dalam 7 hari akan otomatis ditolak dan dikunci.');
                
                // Tambahkan action button hanya jika bukan dummy logbook
                if (!$isDummyLogbook) {
                    $mailMessage->action('Verifikasi Logbook', route('guru.daily.review', ['id' => $this->logbook->id]));
                } else {
                    $mailMessage->line('Ini adalah email test untuk notifikasi deadline logbook.');
                }
            } else {
                $mailMessage->line('Anda memiliki logbook harian yang perlu diverifikasi.')
                    ->line("Tanggal logbook: {$this->logbook->date}")
                    ->line("Batas waktu verifikasi: {$deadline} ({$daysLeft} hari lagi)")
                    ->line('Logbook yang tidak diverifikasi dalam 7 hari akan otomatis dikunci.');
            }
        } elseif ($this->role === 'dpl') {
            // Pastikan ada program transaction dan mahasiswa
            if ($this->logbook->programTransaction && $this->logbook->programTransaction->mahasiswa) {
                $mahasiswaName = $this->logbook->programTransaction->mahasiswa->name ?? 'Mahasiswa';
                $mahasiswaNim = $this->logbook->programTransaction->mahasiswa->nim ?? '-';
                
                $mailMessage->line("Anda memiliki logbook mingguan dari {$mahasiswaName} ({$mahasiswaNim}) yang perlu diverifikasi.")
                    ->line("Periode logbook: {$this->logbook->start_date} s/d {$this->logbook->end_date}")
                    ->line("Batas waktu verifikasi: {$deadline} ({$daysLeft} hari lagi)")
                    ->line('Logbook yang tidak diverifikasi dalam 7 hari akan otomatis dikunci.');
                
                // Tambahkan action button hanya jika bukan dummy logbook
                if (!$isDummyLogbook) {
                    $mailMessage->action('Verifikasi Logbook', route('dosen.daily.book', ['id' => $this->logbook->id]));
                } else {
                    $mailMessage->line('Ini adalah email test untuk notifikasi deadline logbook.');
                }
            } else {
                $mailMessage->line('Anda memiliki logbook mingguan yang perlu diverifikasi.')
                    ->line("Periode logbook: {$this->logbook->start_date} s/d {$this->logbook->end_date}")
                    ->line("Batas waktu verifikasi: {$deadline} ({$daysLeft} hari lagi)")
                    ->line('Logbook yang tidak diverifikasi dalam 7 hari akan otomatis dikunci.');
            }
        }
        
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // Log untuk debugging
        \Log::info('LogbookDeadlineNotification toArray() dipanggil', [
            'email' => $notifiable->email,
            'logbook_id' => $this->logbook->id
        ]);
        
        $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
        $deadline = Carbon::parse($this->logbook->created_at)->addDays($deadlineDays)->format('Y-m-d');
        
        return [
            'logbook_id' => $this->logbook->id,
            'type' => $this->type,
            'role' => $this->role,
            'deadline' => $deadline
        ];
    }
}