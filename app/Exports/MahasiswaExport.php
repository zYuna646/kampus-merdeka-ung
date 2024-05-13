<?php

namespace App\Exports;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MahasiswaExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mahasiswa::all();
    }

    public function map($mahasiswa): array
    {
        return [
            'NIM' => $mahasiswa->nim,
            'Nama' => $mahasiswa->name,
            'Program Studi' => $mahasiswa->studi->name,
            'Angkatan' => $mahasiswa->angkatan
        ];
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Program Studi',
            'Angkatan'
        ];
    }
}
