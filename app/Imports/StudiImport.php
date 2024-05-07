<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Studi;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudiImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {

                // Cek apakah entri dengan slug yang sama sudah ada dalam database
                $existingFakultas = Studi::where('code', $row['kode'])->first();
                // Jika entri sudah ada, lewati proses impor untuk baris ini
                if ($existingFakultas) {
                    continue;
                }

                $fakultas = Jurusan::where('code', $row['kode_jurusan'])->first();
                if (!$fakultas) {
                    continue;
                }
                // Buat entri baru jika tidak ada duplikat
                Studi::create([
                    'code' => $row['kode'],
                    'name' => $row['nama'],
                    'slug' => Str::slug($row['nama']),
                    'jurusan_id' => $fakultas->id
                ]);
            } catch (\Throwable $th) {
                // Handle the error here
            }
        }
    }
}
