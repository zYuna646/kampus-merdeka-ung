<?php

namespace App\Imports;

use App\Models\ProgramKampus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProgramKampusImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            return new ProgramKampus([
                'code' => $row['kode'],
                'name' => $row['nama'],
                'slug' => Str::slug($row['nama'])
            ]);
        } catch (\Throwable $th) {
            // Handle the error here
            \Log::error('Error importing row: ' . $th->getMessage());
            // Return null to skip this row and continue with the import
            return null;
        }
    }
}
