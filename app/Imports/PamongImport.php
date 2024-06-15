<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\MitraTransaction;
use App\Models\ProgramTransaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PamongImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            try {
                if ($row['nik']) {
                    continue;
                } 

                $dosen = Guru::where('nik', $row['nik'])->first();



                // Menambahkan tanda titik koma dan tanda kutip pada NIP
                if (!$dosen) {
                    continue; // Skip baris ini jika Guru sudah ada
                }
                $mahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
                if (!$mahasiswa) {
                    continue;
                }
                $lowongan = Lowongan::where('code', $row['kode_lowongan'])->first(); // Add missing semicolon
                if (!$lowongan) {
                    continue;
                }

                $programTransaction = ProgramTransaction::where('mahasiswa_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();

                if (!$programTransaction) {
                    continue;
                }
                $dpl = MitraTransaction::where('guru_id', $dosen->id)->first();
                if ($dpl) {
                    $dpl->mahasiswa()->attach($programTransaction->id);

                } else {
                    $dosen = MitraTransaction::create([
                        'guru_id' => $dosen->id,
                        'lowongan_id' => $lowongan->id
                    ]);
                    $dosen->mahasiswa()->attach($programTransaction->id);
                }

            } catch (\Throwable $th) {
                // Handle the error here
                \Log::error('Error importing row: ' . $th->getMessage());
                dd($th); // Also log and dd here to ensure value is not null
            }
        }
    }
}
