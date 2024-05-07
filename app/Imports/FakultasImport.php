<?php

namespace App\Imports;

use App\Models\Fakultas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FakultasImport implements ToCollection, WithHeadingRow
{
    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {

                // Cek apakah entri dengan slug yang sama sudah ada dalam database
                $existingFakultas = Fakultas::where('code', $row['kode'])->first();
                // Jika entri sudah ada, lewati proses impor untuk baris ini
                if ($existingFakultas) {
                    continue;
                }

                // Buat entri baru jika tidak ada duplikat
                Fakultas::create([
                    'code' => $row['kode'],
                    'name' => $row['nama'],
                    'slug' => Str::slug($row['nama'])
                ]);
            } catch (\Throwable $th) {
                // Handle the error here
            }
        }
    }
}

