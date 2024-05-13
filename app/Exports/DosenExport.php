<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DosenExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dosen::all();
    }

    public function map($dosen): array
    {
        return [
            'NIDN' => $dosen->nidn,
            'Nama' => $dosen->name,
            'Program Studi' => $dosen->studi->name
        ];
    }

    public function headings(): array
    {
        return [
            'NIDN',
            'Nama',
            'Program Studi'
        ];
    }
}
