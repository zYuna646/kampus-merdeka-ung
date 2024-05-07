<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Role;
use App\Models\Studi;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class DosenImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
     * @param \Illuminate\Support\Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Cek apakah peran dengan slug "dosen" ada di database
                $role = Role::where('slug', 'dosen')->first();

                // Periksa apakah Dosen dengan NIDN tertentu sudah ada dalam database
                $existingDosen = Dosen::where('nidn', $row['nidn'])->first();
                if ($existingDosen) {
                    continue; // Skip baris ini jika Dosen sudah ada
                }

                // Cari program studi berdasarkan kode yang diberikan
                $studi = Studi::where('name', $row['kode_program_studi'])->first();

                if ($studi) {
                    // Buat user baru
                    $user = User::create([
                        'username' => $row['nidn'],
                        'password' => bcrypt($row['nidn']), // Gunakan NIDN sebagai password
                        'role_id' => $role->id,
                    ]);
                    // Buat instansi Dosen terkait
                    Dosen::create([
                        'nidn' => $row['nidn'],
                        'name' => $row['nama'],
                        'studi_id' => $studi->id,
                        'user_id' => $user->id // Menggunakan id user yang baru dibuat
                    ]);
                } else {
                    // Jika program studi tidak ditemukan, log pesan kesalahan dan lanjutkan ke baris berikutnya
                    \Log::error('Program Studi with code ' . $row['kode_program_studi'] . ' not found.');
                }
            } catch (\Throwable $th) {
                // Tangani kesalahan di sini
                \Log::error('Error importing row: ' . $th->getMessage());
            }
        }
    }

    /**
     * Menentukan ukuran chunk untuk pembacaan data Excel.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 300; // Sesuaikan ukuran chunk sesuai kebutuhan Anda
    }
}
