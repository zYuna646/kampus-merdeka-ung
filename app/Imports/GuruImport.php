<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Lokasi;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use App\Models\Role;

class GuruImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $nip = $row['nik'];// Generate NIP with leading zeros
                // Menambahkan tanda titik koma dan tanda kutip pada NIP
                $role = Role::where('slug', 'guru')->first();
                $existingGuru = Guru::where('nik', $nip)->first();

                if ($existingGuru) {
                    continue; // Skip baris ini jika Guru sudah ada
                }

                $lokasi = Lokasi::where('code', $row['kode_lokasi'])->first(); // Menambahkan metode first()
                if (!$lokasi) {
                    continue;
                }

                $user = User::create([
                    'username' => $nip,
                    'password' => bcrypt($nip), // Gunakan NIDN sebagai password
                    'role_id' => $role->id,
                ]);

                // Create a new Guru entry if no duplicate
                $data = [
                    "nik" => $nip,
                    "name" => $row['nama'], // Menambahkan definisi $nama_lokasi
                    "user_id" => $user->id,
                ];


                $guru = Guru::create($data);
                $guru->lokasis()->attach($lokasi->id);
            } catch (\Throwable $th) {
                // Handle the error here
                \Log::error('Error importing row: ' . $th->getMessage());
                // Also log and dd here to ensure value is not null
            }
        }
    }
}
