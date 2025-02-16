<?php

namespace App\Exports;

use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProgramPesertaExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Define the headings for each column in the Excel file.
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Kode Lowongan',
            'Program',
            'Tahun Akademik',
            'Semester',
            'Lokasi',
        ];
    }

    /**
     * Map and format the data for the export.
     */
    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            $mahasiswa = Mahasiswa::find($item['mahasiswa_id']);
            $lowongan = Lowongan::find($item['lowongan_id']);
            $peserta = ProgramTransaction::where('mahasiswa_id', $mahasiswa->id)->where('lowongan_id', $lowongan->id)->first();
            $program = $lowongan->program;
            return [
                'NIM' => $mahasiswa->nim,
                'Nama' => $mahasiswa->name,
                'Kode Lowongan' => $lowongan->code,
                'Program' => $program->name,
                'Tahun Akademik' => $lowongan->tahun_akademik ?? '',
                'Semester' => $lowongan->semester ?? '',
                'Lokasi' => $peserta->lokasi->name ?? '',
            ];
        });
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Apply styles to the header row
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style the entire data rows
        $sheet->getStyle('A2:G' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        return $sheet;
    }

    /**
     * Set the column widths.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15,  // NIM
            'B' => 30,  // Nama
            'C' => 20,  // Kode Lowongan
            'D' => 25,  // Program
            'E' => 20,  // Tahun Akademik
            'F' => 15,  // Semester
            'G' => 15,  // Semester
        ];
    }

    /**
     * Register events to auto-size columns or freeze panes.
     */
    public function registerEvents(): array
    {
        return [
            // Freeze the top row (headings)
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $event->sheet->freezePane('A2');
            },
        ];
    }
}
