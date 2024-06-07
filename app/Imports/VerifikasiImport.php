<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VerifikasiImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            $mahasiswa = Mahasiswa::where("nim", $value['nim'])->first();
            $lowongan = Mahasiswa::where('code', $value['kode_lowongan'])->first();
            if (!$mahasiswa && !$lowongan) {
                continue;
            }

            $peserta = ProgramTransaction::where('mahasiswa_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();
            if (!$peserta) {
                continue;
            }

            $peserta->status_mahasiswa = true;
        }
    }
}
