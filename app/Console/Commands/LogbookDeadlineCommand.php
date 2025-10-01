<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyLog;
use App\Models\WeeklyLog;
use App\Models\ProgramTransaction;
use Carbon\Carbon;
use App\Notifications\LogbookDeadlineNotification;
use Illuminate\Support\Facades\Log;

class LogbookDeadlineCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logbook:deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check logbook deadlines, send notifications, and lock expired logbooks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running logbook deadline checks...');
        
        // Cek dan kunci logbook yang sudah melewati 7 hari
        $this->lockExpiredLogbooks();
        
        // Kirim notifikasi untuk logbook yang mendekati deadline (2 hari sebelum batas waktu)
        $this->sendDeadlineNotifications();
        
        $this->info('Logbook deadline checks completed.');
        
        return 0;
    }
    
    /**
     * Kunci logbook yang sudah melewati batas waktu
     */
    private function lockExpiredLogbooks()
    {
        $this->info('Checking for expired logbooks...');
        
        // Ambil jumlah hari deadline dari env
        $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
        
        // Tanggal yang sudah melewati batas waktu
        $deadline = Carbon::now()->subDays($deadlineDays)->startOfDay();
        
        Log::info('Memeriksa logbook yang sudah melewati batas waktu', [
            'deadline_days' => $deadlineDays,
            'deadline_date' => $deadline->format('Y-m-d H:i:s')
        ]);
        
        // Kunci daily logbook yang sudah melewati batas waktu
        $expiredDailyLogs = DailyLog::where('date', '<', $deadline)
            ->where('status', 'belum')
            ->get();

        Log::info('Menemukan daily logbook yang sudah melewati batas waktu', [
            'count' => $expiredDailyLogs->count()
        ]);
        
        foreach ($expiredDailyLogs as $dailyLog) {
            $dailyLog->status = 'tolak';
            $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
            $dailyLog->msg = "Logbook telah ditolak dan dikunci karena melewati batas waktu {$deadlineDays} hari";
            $dailyLog->save();
            
            Log::info('Mengunci daily logbook', [
                'logbook_id' => $dailyLog->id,
                'created_at' => $dailyLog->created_at,
                'deadline_days' => $deadlineDays
            ]);
            
            $this->info("Locked daily logbook ID: {$dailyLog->id}");
        }
        
        // Kunci weekly logbook yang sudah melewati batas waktu
        $expiredWeeklyLogs = WeeklyLog::where('created_at', '<', $deadline)
            ->where('status', 'belum')
            ->get();
            
        foreach ($expiredWeeklyLogs as $weeklyLog) {
            $weeklyLog->status = 'tolak';
            $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
            $weeklyLog->msg = "Logbook telah ditolak dan dikunci karena melewati batas waktu {$deadlineDays} hari";
            $weeklyLog->save();
            
            Log::info('Mengunci weekly logbook', [
                'logbook_id' => $weeklyLog->id,
                'created_at' => $weeklyLog->created_at,
                'deadline_days' => $deadlineDays
            ]);
            
            $this->info("Locked weekly logbook ID: {$weeklyLog->id}");
        }
        
        $this->info('Expired logbooks have been locked.');
    }
    
    /**
     * Kirim notifikasi untuk logbook yang mendekati deadline
     */
    private function sendDeadlineNotifications()
    {
        $this->info('Sending deadline notifications...');
        
        // Ambil jumlah hari deadline dan notifikasi dari env
        $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
        $notificationDays = env('LOGBOOK_NOTIFICATION_DAYS', 2);
        
        // Tanggal untuk notifikasi (n hari sebelum batas waktu)
        $notificationDate = Carbon::now()->subDays($deadlineDays - $notificationDays)->startOfDay();
        
        // Cari daily logbook yang mendekati deadline
        $dailyLogs = DailyLog::where('created_at', '<', $notificationDate)
            ->where('created_at', '>', Carbon::now()->subDays(6)->startOfDay())
            ->where('status', 'belum')
            ->get();
            
        foreach ($dailyLogs as $dailyLog) {
            try {
                // Notifikasi ke mahasiswa
                if ($dailyLog->programTransaction && $dailyLog->programTransaction->mahasiswa && $dailyLog->programTransaction->mahasiswa->user) {
                    $user = $dailyLog->programTransaction->mahasiswa->user;
                    Log::info('Mengirim notifikasi ke mahasiswa', [
                        'email' => $user->email,
                        'logbook_id' => $dailyLog->id,
                        'type' => 'daily'
                    ]);
                    $user->notify(
                        new LogbookDeadlineNotification($dailyLog, 'daily', 'mahasiswa')
                    );
                    $this->info("Sent deadline notification to student for daily logbook ID: {$dailyLog->id}");
                }
                
                // Notifikasi ke pamong
                if ($dailyLog->programTransaction && $dailyLog->programTransaction->pamong) {
                    foreach ($dailyLog->programTransaction->pamong as $pamong) {
                        if ($pamong->guru && $pamong->guru->user) {
                            $user = $pamong->guru->user;
                            Log::info('Mengirim notifikasi ke pamong', [
                                'email' => $user->email,
                                'logbook_id' => $dailyLog->id,
                                'type' => 'daily'
                            ]);
                            $user->notify(
                                new LogbookDeadlineNotification($dailyLog, 'daily', 'pamong')
                            );
                            $this->info("Sent deadline notification to teacher for daily logbook ID: {$dailyLog->id}");
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for daily logbook ID {$dailyLog->id}: {$e->getMessage()}");
            }
        }
        
        // Cari weekly logbook yang mendekati deadline
        $weeklyLogs = WeeklyLog::where('created_at', '<', $notificationDate)
            ->where('created_at', '>', Carbon::now()->subDays(6)->startOfDay())
            ->where('status', 'belum')
            ->get();
            
        foreach ($weeklyLogs as $weeklyLog) {
            try {
                // Notifikasi ke mahasiswa
                if ($weeklyLog->programTransaction && $weeklyLog->programTransaction->mahasiswa && $weeklyLog->programTransaction->mahasiswa->user) {
                    $user = $weeklyLog->programTransaction->mahasiswa->user;
                    Log::info('Mengirim notifikasi ke mahasiswa (weekly)', [
                        'email' => $user->email,
                        'logbook_id' => $weeklyLog->id,
                        'type' => 'weekly'
                    ]);
                    $user->notify(
                        new LogbookDeadlineNotification($weeklyLog, 'weekly', 'mahasiswa')
                    );
                    $this->info("Sent deadline notification to student for weekly logbook ID: {$weeklyLog->id}");
                }
                
                // Notifikasi ke DPL
                if ($weeklyLog->programTransaction && $weeklyLog->programTransaction->dpls) {
                    foreach ($weeklyLog->programTransaction->dpls as $dpl) {
                        if ($dpl->dosen && $dpl->dosen->user) {
                            $user = $dpl->dosen->user;
                            Log::info('Mengirim notifikasi ke DPL', [
                                'email' => $user->email,
                                'logbook_id' => $weeklyLog->id,
                                'type' => 'weekly'
                            ]);
                            $user->notify(
                                new LogbookDeadlineNotification($weeklyLog, 'weekly', 'dpl')
                            );
                            $this->info("Sent deadline notification to lecturer for weekly logbook ID: {$weeklyLog->id}");
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for weekly logbook ID {$weeklyLog->id}: {$e->getMessage()}");
            }
        }
        
        $this->info('Deadline notifications have been sent.');
    }
    
    /**
     * Kirim notifikasi test ke email tertentu
     * 
     * @param string $email Email tujuan untuk test
     * @return void
     */
    public function sendDeadlineNotificationsTest($email)
    {
        $email = "anggarangga646@gmail.com";
        // Pastikan email yang digunakan adalah salah satu dari email yang diizinkan
        if ($email !== 'anggarangga646@gmail.com' && $email !== 'zychan646@gmail.com') {
            $this->error('Email tidak diizinkan. Hanya anggarangga646@gmail.com atau zychan646@gmail.com yang diizinkan.');
            $this->info('Menggunakan email anggarangga646@gmail.com sebagai gantinya.');
            $email = 'anggarangga646@gmail.com';
        }
        
        $this->info('Sending test deadline notification to ' . $email);
        
        // Ambil satu daily logbook dan weekly logbook untuk test
        $dailyLog = DailyLog::where('status', 'belum')->first();
        $weeklyLog = WeeklyLog::where('status', 'belum')->first();
        
        // Jika tidak ada logbook yang ditemukan, buat dummy logbook untuk test
        if (!$dailyLog) {
            $this->info('No pending daily logbook found, creating a dummy one for testing');
            $dailyLog = new DailyLog();
            $dailyLog->id = 0;
            $dailyLog->date = Carbon::now()->format('Y-m-d');
            $dailyLog->created_at = Carbon::now();
        }
        
        if (!$weeklyLog) {
            $this->info('No pending weekly logbook found, creating a dummy one for testing');
            $weeklyLog = new WeeklyLog();
            $weeklyLog->id = 0;
            $weeklyLog->start_date = Carbon::now()->startOfWeek()->format('Y-m-d');
            $weeklyLog->end_date = Carbon::now()->endOfWeek()->format('Y-m-d');
            $weeklyLog->created_at = Carbon::now();
        }
        
        // Buat user dummy dengan email yang ditentukan
        $user = new \App\Models\User();
        $user->id = 0; // Tambahkan ID dummy
        $user->email = $email;
        $user->name = 'Test User';
        // Pastikan user memiliki channels notifikasi yang diperlukan
        $user->email_verified_at = now();
        
        try {
            // Kirim notifikasi daily logbook
            Log::info('Mengirim notifikasi test daily logbook ke ' . $email);
            $user->notify(new LogbookDeadlineNotification($dailyLog, 'daily', 'mahasiswa'));
            $this->info('Sent test daily logbook notification to ' . $email);
            
            // Kirim notifikasi weekly logbook
            Log::info('Mengirim notifikasi test weekly logbook ke ' . $email);
            $user->notify(new LogbookDeadlineNotification($weeklyLog, 'weekly', 'mahasiswa'));
            $this->info('Sent test weekly logbook notification to ' . $email);
            
            // Kirim notifikasi sebagai pamong
            Log::info('Mengirim notifikasi test daily logbook (sebagai pamong) ke ' . $email);
            $user->notify(new LogbookDeadlineNotification($dailyLog, 'daily', 'pamong'));
            $this->info('Sent test daily logbook notification (as teacher) to ' . $email);
            
            // Kirim notifikasi sebagai DPL
            Log::info('Mengirim notifikasi test weekly logbook (sebagai DPL) ke ' . $email);
            $user->notify(new LogbookDeadlineNotification($weeklyLog, 'weekly', 'dpl'));
            $this->info('Sent test weekly logbook notification (as lecturer) to ' . $email);
            
        } catch (\Exception $e) {
            $this->error('Error sending test notification: ' . $e->getMessage());
            Log::error('Error sending test notification', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        $this->info('Test deadline notifications have been sent to ' . $email);
    }
}