<?php

namespace App\Imports;

use App\Models\ProgramKampus;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class ProgramKampusImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $importedRows = [];

        foreach ($rows as $row) {
            try {
                $program = ProgramKampus::where('slug', Str::slug($row['nama']))
                    ->orWhere('code', $row['kode'])
                    ->first();

                if (!$program) {
                    $importedRow = new ProgramKampus([
                        'code' => $row['kode'],
                        'name' => $row['nama'],
                        'slug' => Str::slug($row['nama'])
                    ]);

                    $importedRow->save();

                    $importedRows[] = $importedRow;
                }
            } catch (\Throwable $th) {
                // Handle the error here
                \Log::error('Error importing row: ' . $th->getMessage());
            }
        }

        return $importedRows;
    }
}
