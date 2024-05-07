<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Fakultas; // Import model Fakultas
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JurusanImport implements ToCollection, WithHeadingRow
{
    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {

                // Cek apakah entri dengan slug yang sama sudah ada dalam database
                $existingFakultas = Jurusan::where('code', $row['kode'])->first();
                // Jika entri sudah ada, lewati proses impor untuk baris ini
                if ($existingFakultas) {
                    continue;
                }

                $fakultas = Fakultas::where('code', $row['kode_fakultas'])->first();
                if (!$fakultas) {
                    continue;
                }
                // Buat entri baru jika tidak ada duplikat
                Jurusan::create([
                    'code' => $row['kode'],
                    'name' => $row['nama'],
                    'slug' => Str::slug($row['nama']),
                    'fakultas_id' => $fakultas->id
                ]);
            } catch (\Throwable $th) {
                // Handle the error here
            }
        }
    }
}
