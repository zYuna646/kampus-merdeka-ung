<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\DPL;
use App\Models\Lokasi;
use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DPLImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Menambahkan tanda titik koma dan tanda kutip pada NIP
                $dosen = Dosen::where('name', $row['nama'])->first();

                if (!$dosen) {
                    continue; // Skip baris ini jika Guru sudah ada
                }
                $lokasi = Lokasi::where('name', $row['lokasi'])->first(); // Menambahkan metode first()
                if (!$lokasi) {
                    continue;
                }

                $dosen = DPL::create([
                    'dosen_id' => $dosen->id,
                ]);
                $dosen->lokasis()->attach($lokasi->id);
            } catch (\Throwable $th) {
                // Handle the error here
                \Log::error('Error importing row: ' . $th->getMessage());
                dd($th); // Also log and dd here to ensure value is not null
            }
        }
    }
}
