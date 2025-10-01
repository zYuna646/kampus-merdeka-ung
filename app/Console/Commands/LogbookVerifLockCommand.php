<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyLog;
use App\Models\WeeklyLog;
use App\Notifications\LogbookNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogbookVerifLockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logbook:verif-lock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lock verification for daily and weekly logs that have passed the verification deadline';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting logbook verification lock process...');
        
        // Ambil nilai deadline dari env
        $verifDeadlineDays = env('LOGBOOK_VERIFICAION_DEADLINE_DAYS', 7);
        $notificationDays = env('LOGBOOK_NOTIFICATION_DAYS', 2);
        
        // Hitung tanggal deadline
        $deadline = Carbon::now()->subDays($verifDeadlineDays);
        $notificationDate = Carbon::now()->addDays($notificationDays);
        
        $this->info("Verification deadline set to {$verifDeadlineDays} days, checking logs before: {$deadline->format('Y-m-d')}");
        $this->info("Notification will be sent for logs with deadline on: {$notificationDate->format('Y-m-d')}");
        
        // Kunci verifikasi daily logbook yang sudah melewati batas waktu
        $this->lockDailyVerification($deadline, $verifDeadlineDays);
        
        // Kunci verifikasi weekly logbook yang sudah melewati batas waktu
        $this->lockWeeklyVerification($deadline, $verifDeadlineDays);
        
        // Kirim notifikasi untuk logbook yang mendekati deadline verifikasi
        $this->sendVerificationDeadlineNotifications($notificationDays);
        
        $this->info('Logbook verification lock process completed.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Lock verification for daily logs that have passed the deadline
     *
     * @param Carbon $deadline
     * @param int $verifDeadlineDays
     * @return void
     */
    private function lockDailyVerification($deadline, $verifDeadlineDays)
    {
        $expiredDailyLogs = DailyLog::where('created_at', '<', $deadline)
            ->where('is_verif_lock', false)
            ->where('status', 'proses')
            ->get();
            
        $this->info("Found {$expiredDailyLogs->count()} daily logs to lock verification.");
        
        foreach ($expiredDailyLogs as $dailyLog) {
            $dailyLog->is_verif_lock = true;
            $dailyLog->save();
            
            Log::info('Mengunci verifikasi daily logbook', [
                'logbook_id' => $dailyLog->id,
                'created_at' => $dailyLog->created_at,
                'verif_deadline_days' => $verifDeadlineDays
            ]);
            
            // Kirim notifikasi ke pamong/guru
            try {
                $programTransaction = $dailyLog->programTransaction;
                if ($programTransaction && $programTransaction->pamong && $programTransaction->pamong->user) {
                    $programTransaction->pamong->user->notify(
                        new LogbookNotification(
                            'Verifikasi Logbook Harian Dikunci',
                            "Verifikasi logbook harian tanggal {$dailyLog->date} telah dikunci secara otomatis karena melewati batas waktu verifikasi {$verifDeadlineDays} hari.",
                            'daily_logbook'
                        )
                    );
                    $this->info("Sent verification lock notification to teacher for daily logbook ID: {$dailyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for daily logbook ID {$dailyLog->id}: {$e->getMessage()}");
            }
            
            $this->info("Locked verification for daily logbook ID: {$dailyLog->id}");
        }
    }
    
    /**
     * Lock verification for weekly logs that have passed the deadline
     *
     * @param Carbon $deadline
     * @param int $verifDeadlineDays
     * @return void
     */
    private function lockWeeklyVerification($deadline, $verifDeadlineDays)
    {
        $expiredWeeklyLogs = WeeklyLog::where('created_at', '<', $deadline)
            ->where('is_verif_lock', false)
            ->where('status', 'proses')
            ->get();
            
        $this->info("Found {$expiredWeeklyLogs->count()} weekly logs to lock verification.");
        
        foreach ($expiredWeeklyLogs as $weeklyLog) {
            $weeklyLog->is_verif_lock = true;
            $weeklyLog->save();
            
            Log::info('Mengunci verifikasi weekly logbook', [
                'logbook_id' => $weeklyLog->id,
                'created_at' => $weeklyLog->created_at,
                'verif_deadline_days' => $verifDeadlineDays
            ]);
            
            // Kirim notifikasi ke DPL
            try {
                $programTransaction = $weeklyLog->programTransaction;
                if ($programTransaction && $programTransaction->dpl && $programTransaction->dpl->user) {
                    $programTransaction->dpl->user->notify(
                        new LogbookNotification(
                            'Verifikasi Logbook Mingguan Dikunci',
                            "Verifikasi logbook mingguan minggu ke-{$weeklyLog->minggu_ke} telah dikunci secara otomatis karena melewati batas waktu verifikasi {$verifDeadlineDays} hari.",
                            'weekly_logbook'
                        )
                    );
                    $this->info("Sent verification lock notification to lecturer for weekly logbook ID: {$weeklyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for weekly logbook ID {$weeklyLog->id}: {$e->getMessage()}");
            }
            
            $this->info("Locked verification for weekly logbook ID: {$weeklyLog->id}");
        }
    }
    
    /**
     * Send notifications for logs approaching verification deadline
     *
     * @param int $notificationDays
     * @return void
     */
    private function sendVerificationDeadlineNotifications($notificationDays)
    {
        $verifDeadlineDays = env('LOGBOOK_VERIFICAION_DEADLINE_DAYS', 7);
        $notificationDate = Carbon::now()->addDays($notificationDays);
        $targetDate = Carbon::now()->addDays($verifDeadlineDays - $notificationDays);
        
        $this->info("Sending notifications for logs created on: {$targetDate->format('Y-m-d')}");
        
        // Notifikasi untuk daily logs
        $dailyLogs = DailyLog::whereDate('created_at', $targetDate)
            ->where('is_verif_lock', false)
            ->where('status', 'proses')
            ->get();
            
        $this->info("Found {$dailyLogs->count()} daily logs approaching verification deadline.");
        
        foreach ($dailyLogs as $dailyLog) {
            try {
                $programTransaction = $dailyLog->programTransaction;
                if ($programTransaction && $programTransaction->pamong && $programTransaction->pamong->user) {
                    $programTransaction->pamong->user->notify(
                        new LogbookNotification(
                            'Pengingat Batas Waktu Verifikasi Logbook Harian',
                            "Verifikasi logbook harian tanggal {$dailyLog->date} akan dikunci dalam {$notificationDays} hari. Harap segera melakukan verifikasi.",
                            'daily_logbook'
                        )
                    );
                    $this->info("Sent verification deadline notification to teacher for daily logbook ID: {$dailyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for daily logbook ID {$dailyLog->id}: {$e->getMessage()}");
            }
        }
        
        // Notifikasi untuk weekly logs
        $weeklyLogs = WeeklyLog::whereDate('created_at', $targetDate)
            ->where('is_verif_lock', false)
            ->where('status', 'proses')
            ->get();
            
        $this->info("Found {$weeklyLogs->count()} weekly logs approaching verification deadline.");
        
        foreach ($weeklyLogs as $weeklyLog) {
            try {
                $programTransaction = $weeklyLog->programTransaction;
                if ($programTransaction && $programTransaction->dpl && $programTransaction->dpl->user) {
                    $programTransaction->dpl->user->notify(
                        new LogbookNotification(
                            'Pengingat Batas Waktu Verifikasi Logbook Mingguan',
                            "Verifikasi logbook mingguan minggu ke-{$weeklyLog->minggu_ke} akan dikunci dalam {$notificationDays} hari. Harap segera melakukan verifikasi.",
                            'weekly_logbook'
                        )
                    );
                    $this->info("Sent verification deadline notification to lecturer for weekly logbook ID: {$weeklyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for weekly logbook ID {$weeklyLog->id}: {$e->getMessage()}");
            }
        }
    }
}