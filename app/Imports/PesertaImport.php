<?php

namespace App\Imports;

use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use App\Models\DailyLog;
use App\Models\WeeklyLog;


class PesertaImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $tmp = null; // Initialize $tmp with null
        foreach ($collection as $index => $row) {
            try {
                if (!$row['nim']) {
                    continue;
                }
                // Menambahkan tanda titik koma dan tanda kutip pada NIP
                if ($row['lokasi']) {
                    $lokasi = Lokasi::where('name', $row['lokasi'])->first(); // Menambahkan metode first()
                    $tmp = $lokasi; // Assign $lokasi to $tmp
                } else {
                    $lokasi = $tmp; // Assign $tmp to $lokasi if $row['lokasi'] is empty
                }

                $mahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
                $lowongan = Lowongan::where('code', $row['lowongan'])->first(); // Add missing semicolon

                $programTransaction = ProgramTransaction::where('mahasiswa_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();
                if ($programTransaction) {
                    continue;
                }

                $program = ProgramTransaction::create([
                    'lokasi_id' => $tmp->id,
                    'mahasiswa_id' => $mahasiswa->id, // Add missing comma
                    'lowongan_id' => $lowongan->id,
                    'status_mahasiswa' => true
                ]);

                if ($lowongan->isLogBook) {
                    $startDate = Carbon::parse($program->lowongan->tanggal_mulai); // Tanggal awal
                    $endDate = Carbon::parse($program->lowongan->tanggal_selesai);
                    $st = $startDate->copy(); // Create a separate copy of $startDate for $st
                    $e_d = $startDate->endOfWeek()->copy(); // Create a separate copy for $e_d
                    $wk = WeeklyLog::create([
                        'program_transaction_id' => $program->id,
                        'start_date' => $st, // Start date
                        'end_date' => $e_d, // End date
                    ]);



                    $tmp_date = $startDate->copy()->addWeek()->startOfWeek();
                    while ($tmp_date->lte($endDate)) {
                        // Buat weekly log untuk minggu ini

                        $tmp_end_week = $tmp_date->copy()->endOfWeek();
                        if ($tmp_end_week->gte($endDate)) {
                            $tmp_end_week = $endDate;
                        }

                        WeeklyLog::create([
                            'program_transaction_id' => $program->id,
                            'start_date' => $tmp_date->copy()->startOfWeek(), // Start date
                            'end_date' => $tmp_end_week, // End date
                        ]);

                        // Lanjutkan ke minggu berikutnya
                        $tmp_date->addWeek();
                    }

                    foreach ($program->weeklyLog as $key => $item) {
                        $startDate = Carbon::parse($item->start_date); // Konversi ke objek Carbon
                        $endDate = Carbon::parse($item->end_date); // Konversi ke objek Carbon
                        while ($startDate <= $endDate) {
                            DailyLog::create([
                                'program_transaction_id' => $program->id,
                                'date' => $startDate,
                                'weekly_log_id' => $item->id,
                                'dokumentasi' => ''
                            ]);

                            $startDate->addDay(); // Perbaikan sintaks
                        }
                    }
                }


            } catch (\Throwable $th) {
                // Handle the error here
                dd($row);
                \Log::error('Error importing row: ' . $th->getMessage());
                dd($th); // Also log and dd here to ensure value is not null
            }
        }
    }
}
