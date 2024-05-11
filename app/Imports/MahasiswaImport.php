<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Role;
use App\Models\Studi;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;


class MahasiswaImport implements ToCollection, WithHeadingRow, WithChunkReading
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
                // Cek apakah peran dengan slug "dosen" ada di database
                $role = Role::where('slug', 'mahasiswa')->first();
                $existingMahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
                if ($existingMahasiswa) {
                    continue;
                }
                // Cari program studi berdasarkan kode yang diberikan
                $studi = Studi::where('name', $row['kode_program_studi'])->first();

                if ($studi) {
                    // Buat user baru
                    $user = User::create([
                        'username' => $row['nim'],
                        'password' => bcrypt($row['nim']),
                        'role_id' => $role->id,
                    ]);
                    // Buat instansi Dosen terkait
                    Mahasiswa::create([
                        'nim' => $row['nim'],
                        'name' => $row['nama'],
                        'studi_id' => $studi->id,
                        'angkatan' => $row['angkatan'],
                        'user_id' => $user->id // Menggunakan id user yang baru dibuat
                    ]);
                } else {
                    $studi = Studi::where('code', '000')->first();
                    $user = User::create([
                        'username' => $row['nim'],
                        'password' => bcrypt($row['nim']),
                        'role_id' => $role->id,
                    ]);
                    // Buat instansi Dosen terkait
                    Mahasiswa::create([
                        'nim' => $row['nim'],
                        'name' => $row['nama'],
                        'studi_id' => $studi->id,
                        'angkatan' => $row['angkatan'],
                        'user_id' => $user->id // Menggunakan id user yang baru dibuat
                    ]);
                    // Jika program studi tidak ditemukan, log pesan kesalahan dan lanjutkan ke baris berikutnya

                }
            } catch (\Throwable $th) {
                // Tangani kesalahan di sini
                \Log::error('Error importing row: ' . $th->getMessage());
                // Kembalikan null untuk melewati baris ini dan lanjutkan impor
                return null;
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
        return 300; // Ubah ukuran chunk sesuai kebutuhan Anda
    }
}
