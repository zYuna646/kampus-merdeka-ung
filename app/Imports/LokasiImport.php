<?php

namespace App\Imports;

use App\Models\District;
use App\Models\Lokasi;
use App\Models\Program;
use App\Models\ProgramKampus;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class LokasiImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $nama_lokasi = $row['nama'] ?? null;
                if (!$nama_lokasi) {
                    continue;
                }
                $lokasi = Lokasi::where('name', $row['nama'])->first();
                if ($lokasi) {
                    continue;
                }

                $existingProgram = ProgramKampus::where('code', '3')->first();
                if (!$existingProgram) {
                    continue;
                }

                $province = Province::where('name', $row['provinsi'] ?? '')->first();
                $regency = Regency::where('name', $row['kabupaten'] ?? '')->first();
                $district = District::where('name', $row['kecamatan'] ?? '')->first();
                $village = Village::where('name', $row['kelurahan'] ?? '')->first();

                if (!$province) {
                    $province = Province::where('name', 'GORONTALO')->first();
                }

                if (!$regency) {
                    $regency = $province->regencies()->first(); // Assuming you want to get the first regency of the province
                }

                if (!$district) {
                    $district = $regency->districts()->first();
                }

                if (!$village) {
                    $village = $district->villages()->first();
                }

                // Create a new location entry if no duplicate
                $data = [
                    "program_id" => $existingProgram->id,
                    "name" => $nama_lokasi,
                    "lokasi" => $nama_lokasi,
                    "provinsi_id" => $province->id,
                    "kabupaten_id" => $regency->id,
                    "kecamatan_id" => $district->id,
                    "kelurahan_id" => $village->id,
                ];


                Lokasi::create($data);
            } catch (\Throwable $th) {
                // Handle the error here
                \Log::error('Error importing row: ' . $th->getMessage());
                \Log::info('Nama Lokasi:', ['nama_lokasi' => $nama_lokasi]); // Move logging inside catch block
                dd($th); // Also log and dd here to ensure value is not null
            }
        }
    }

}
