<?php

namespace App\Imports;

use App\Models\DailyLog;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use App\Models\WeeklyLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;


class VerifikasiImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            $mahasiswa = Mahasiswa::where("nim", $value['nim'])->first();
            $lowongan = Lowongan::where('code', $value['kode_lowongan'])->first();
            $lokasi = Lokasi::where('code', $value['kode_lokasi'])->first();
            if (!$mahasiswa && !$lowongan && !$lokasi) {
                continue;
            }

            $mahasiswa = ProgramTransaction::where('mahasiswa_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();
            if (!$mahasiswa) {
                continue;
            }

            $mahasiswa->status_mahasiswa = true;
            $mahasiswa->lokasi_id = $lokasi->id;
            $program = $mahasiswa;

            if ($program->lowongan->isLogBook) {
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
                        ]);

                        $startDate->addDay(); // Perbaikan sintaks
                    }
                }
            }
        }
    }
}
