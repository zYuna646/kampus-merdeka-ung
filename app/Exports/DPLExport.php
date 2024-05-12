<?php

namespace App\Exports;

use App\Models\DPL;
use Maatwebsite\Excel\Concerns\FromCollection;

class DPLExport implements  FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DPL::all();
    }

    public function map($dpl): array
    {
        $mahasiswas = $dpl->mahasiswa->flatMap(function ($mahasiswa) {
            return $mahasiswa->mahasiswa->name;
        })->implode(', ');

        return [
            'NIDN' => $dpl->dosen->nidn,
            'Nama' => $dpl->dosen->name,
            'Mahasiswa' => $mahasiswas
        ];
    }

    public function headings(): array
    {
        return [
            'NIDN',
            'Nama',
            'Mahasiswa'
        ];
    }
}
