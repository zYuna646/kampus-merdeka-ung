<?php

namespace App\Exports;

use App\Models\Lowongan;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PaymentExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
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
            'Program Studi',
            'Tahun Akademik',
            'Semester',
            'Ukuran Baju',
            'Total Pembayaran',
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
            $program = $lowongan->program;
            return [
                'NIM' => $mahasiswa->nim,
                'Nama' => $mahasiswa->name,
                'Kode Lowongan' => $lowongan->code,
                'Program' => $program->name,
                'Program Studi' => $mahasiswa->studi->name,
                'Tahun Akademik' => $lowongan->tahun_akademik ?? '',
                'Semester' => $lowongan->semester ?? '',
                'Ukuran Baju' => $item['ukuran_baju'] ?? '',
                'Total Pembayaran' => 'Rp. ' . ($item['total_pembayaran'] ?? ''),

            ];
        });
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Apply styles to the header row (now A1:I1)
        $sheet->getStyle('A1:I1')->applyFromArray([
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

        // Style the entire data rows (A2 to I last row)
        $sheet->getStyle('A2:I' . $sheet->getHighestRow())->applyFromArray([
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
            'E' => 30,  // Program Studi
            'F' => 20,  // Tahun Akademik
            'G' => 15,  // Semester
            'H' => 15,  // Ukuran Baju
            'I' => 20,  // Total Pembayaran
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
