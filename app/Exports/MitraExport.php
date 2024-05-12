<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MitraExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Guru::all();
    }

    /**
    * @var Guru $guru
    */
    public function map($guru): array
    {
        return [
            'NIK' => $guru->nik,
            'Nama' => $guru->name,
            'Lokasi' => $guru->lokasis->implode('name', ', ')
        ];
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Name',
            'Lokasi'
        ];
    }
}
