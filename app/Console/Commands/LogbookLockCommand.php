<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyLog;
use App\Models\WeeklyLog;
use App\Notifications\LogbookNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogbookLockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logbook:lock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lock daily and weekly logs that have passed the deadline';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting logbook lock process...');
        
        // Ambil nilai deadline dari env
        $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
        $notificationDays = env('LOGBOOK_NOTIFICATION_DAYS', 2);
        
        // Hitung tanggal deadline
        $deadline = Carbon::now()->subDays($deadlineDays);
        $notificationDate = Carbon::now()->addDays($notificationDays);
        
        $this->info("Deadline set to {$deadlineDays} days, checking logs before: {$deadline->format('Y-m-d')}");
        $this->info("Notification will be sent for logs with deadline on: {$notificationDate->format('Y-m-d')}");
        
        // Kunci daily logbook yang sudah melewati batas waktu
        $this->lockDailyLogs($deadline, $deadlineDays);
        
        // Kunci weekly logbook yang sudah melewati batas waktu
        $this->lockWeeklyLogs($deadline, $deadlineDays);
        
        // Kirim notifikasi untuk logbook yang mendekati deadline
        $this->sendDeadlineNotifications($notificationDays);
        
        $this->info('Logbook lock process completed.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Lock daily logs that have passed the deadline
     *
     * @param Carbon $deadline
     * @param int $deadlineDays
     * @return void
     */
    private function lockDailyLogs($deadline, $deadlineDays)
    {
        $expiredDailyLogs = DailyLog::where('created_at', '<', $deadline)
            ->where('is_lock', false)
            ->where('status', '!=', 'terima')
            ->get();
            
        $this->info("Found {$expiredDailyLogs->count()} expired daily logs to lock.");
        
        foreach ($expiredDailyLogs as $dailyLog) {
            $dailyLog->is_lock = true;
            $dailyLog->status = 'tolak';
            $dailyLog->msg = "Logbook telah ditolak dan dikunci karena melewati batas waktu {$deadlineDays} hari";
            $dailyLog->save();
            
            Log::info('Mengunci daily logbook', [
                'logbook_id' => $dailyLog->id,
                'created_at' => $dailyLog->created_at,
                'deadline_days' => $deadlineDays
            ]);
            
            // Kirim notifikasi ke mahasiswa
            try {
                $programTransaction = $dailyLog->programTransaction;
                if ($programTransaction && $programTransaction->mahasiswa && $programTransaction->mahasiswa->user) {
                    $programTransaction->mahasiswa->user->notify(
                        new LogbookNotification(
                            'Logbook Harian Dikunci',
                            "Logbook harian tanggal {$dailyLog->date} telah dikunci secara otomatis karena melewati batas waktu {$deadlineDays} hari.",
                            'daily_logbook'
                        )
                    );
                    $this->info("Sent lock notification to student for daily logbook ID: {$dailyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for daily logbook ID {$dailyLog->id}: {$e->getMessage()}");
            }
            
            $this->info("Locked daily logbook ID: {$dailyLog->id}");
        }
    }
    
    /**
     * Lock weekly logs that have passed the deadline
     *
     * @param Carbon $deadline
     * @param int $deadlineDays
     * @return void
     */
    private function lockWeeklyLogs($deadline, $deadlineDays)
    {
        $expiredWeeklyLogs = WeeklyLog::where('created_at', '<', $deadline)
            ->where('is_lock', false)
            ->where('status', '!=', 'terima')
            ->get();
            
        $this->info("Found {$expiredWeeklyLogs->count()} expired weekly logs to lock.");
        
        foreach ($expiredWeeklyLogs as $weeklyLog) {
            $weeklyLog->is_lock = true;
            $weeklyLog->status = 'tolak';
            $weeklyLog->msg = "Logbook telah ditolak dan dikunci karena melewati batas waktu {$deadlineDays} hari";
            $weeklyLog->save();
            
            Log::info('Mengunci weekly logbook', [
                'logbook_id' => $weeklyLog->id,
                'created_at' => $weeklyLog->created_at,
                'deadline_days' => $deadlineDays
            ]);
            
            // Kirim notifikasi ke mahasiswa
            try {
                $programTransaction = $weeklyLog->programTransaction;
                if ($programTransaction && $programTransaction->mahasiswa && $programTransaction->mahasiswa->user) {
                    $programTransaction->mahasiswa->user->notify(
                        new LogbookNotification(
                            'Logbook Mingguan Dikunci',
                            "Logbook mingguan minggu ke-{$weeklyLog->minggu_ke} telah dikunci secara otomatis karena melewati batas waktu {$deadlineDays} hari.",
                            'weekly_logbook'
                        )
                    );
                    $this->info("Sent lock notification to student for weekly logbook ID: {$weeklyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for weekly logbook ID {$weeklyLog->id}: {$e->getMessage()}");
            }
            
            $this->info("Locked weekly logbook ID: {$weeklyLog->id}");
        }
    }
    
    /**
     * Send notifications for logs approaching deadline
     *
     * @param int $notificationDays
     * @return void
     */
    private function sendDeadlineNotifications($notificationDays)
    {
        $deadlineDays = env('LOGBOOK_DEADLINE_DAYS', 7);
        $notificationDate = Carbon::now()->addDays($notificationDays);
        $targetDate = Carbon::now()->addDays($deadlineDays - $notificationDays);
        
        $this->info("Sending notifications for logs created on: {$targetDate->format('Y-m-d')}");
        
        // Notifikasi untuk daily logs
        $dailyLogs = DailyLog::whereDate('created_at', $targetDate)
            ->where('is_lock', false)
            ->where('status', '!=', 'terima')
            ->get();
            
        $this->info("Found {$dailyLogs->count()} daily logs approaching deadline.");
        
        foreach ($dailyLogs as $dailyLog) {
            try {
                $programTransaction = $dailyLog->programTransaction;
                if ($programTransaction && $programTransaction->mahasiswa && $programTransaction->mahasiswa->user) {
                    $programTransaction->mahasiswa->user->notify(
                        new LogbookNotification(
                            'Pengingat Batas Waktu Logbook Harian',
                            "Logbook harian tanggal {$dailyLog->date} akan dikunci dalam {$notificationDays} hari. Harap segera menyelesaikan logbook Anda.",
                            'daily_logbook'
                        )
                    );
                    $this->info("Sent deadline notification to student for daily logbook ID: {$dailyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for daily logbook ID {$dailyLog->id}: {$e->getMessage()}");
            }
        }
        
        // Notifikasi untuk weekly logs
        $weeklyLogs = WeeklyLog::whereDate('created_at', $targetDate)
            ->where('is_lock', false)
            ->where('status', '!=', 'terima')
            ->get();
            
        $this->info("Found {$weeklyLogs->count()} weekly logs approaching deadline.");
        
        foreach ($weeklyLogs as $weeklyLog) {
            try {
                $programTransaction = $weeklyLog->programTransaction;
                if ($programTransaction && $programTransaction->mahasiswa && $programTransaction->mahasiswa->user) {
                    $programTransaction->mahasiswa->user->notify(
                        new LogbookNotification(
                            'Pengingat Batas Waktu Logbook Mingguan',
                            "Logbook mingguan minggu ke-{$weeklyLog->minggu_ke} akan dikunci dalam {$notificationDays} hari. Harap segera menyelesaikan logbook Anda.",
                            'weekly_logbook'
                        )
                    );
                    $this->info("Sent deadline notification to student for weekly logbook ID: {$weeklyLog->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error sending notification for weekly logbook ID {$weeklyLog->id}: {$e->getMessage()}");
            }
        }
    }
}