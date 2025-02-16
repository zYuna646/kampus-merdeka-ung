<?php

namespace App\Exports;

use App\Models\Dosen;
use App\Models\DPL;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\MitraTransaction;
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

class PamongPesertaExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
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
            'Nama',
            'Program',
            'Tahun Akademik',
            'Semester',
            'Mahasiswa',
        ];
    }

    /**
     * Map and format the data for the export.
     */
    public function collection()
    {
        return collect($this->data)->map(function ($item, $index) {
            // Find the DPL based on dosen_id and lowongan_id
            $dpl = MitraTransaction::where('guru_id', $item['guru_id'])->where('lowongan_id', $item['lowongan_id'])->first();
            $mahasiswa = ''; // Initialize an empty string for mahasiswa
    
            // Loop through each mahasiswa associated with the DPL
            if ($dpl && $dpl->mahasiswa) {
                foreach ($dpl->mahasiswa as $key => $value) {
                    // Add mahasiswa name with a new line (use \r\n for Excel)
                    $mahasiswa .= ($key + 1) . '. ' . $value->mahasiswa->name . "(" . $value->mahasiswa->nim  . ")" . "\r\n";
                }
            }

            return [
                'Nama' => $dpl->guru->name ?? '',
                'Program' => $dpl->mahasiswa()->first()->lowongan->program->name,
                'Tahun Akademik' => $dpl->lowongan->tahun_akademik ?? '',
                'Semester' => $dpl->lowongan->semester ?? '',
                'Mahasiswa' => trim($mahasiswa), // Remove trailing newline at the end
            ];
        });
    }
    
    public function styles(Worksheet $sheet)
    {
        // Apply styles to the header row
        $sheet->getStyle('A1:E1')->applyFromArray([
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
    
        // Apply wrapText to the Mahasiswa column (G) to handle multiline content
        $sheet->getStyle('E2:E' . ($sheet->getHighestRow()))->getAlignment()->setWrapText(true);
    
        // Style the entire data rows
        $sheet->getStyle('A2:E' . ($sheet->getHighestRow()))->applyFromArray([
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
            'G' => 25,  // Semester
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
