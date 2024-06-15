<?php

namespace App\Charts;

use App\Models\Lowongan;
use App\Models\ProgramKampus;
use App\Models\ProgramTransaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProgramChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // Get unique academic years and sort them
        $tahunAkademik = Lowongan::distinct()->pluck('tahun_akademik')->sort()->toArray();
        // Get all programs
        $programs = ProgramKampus::all();

        // Initialize the data array
        $data = [];

        // Loop through each program to fetch the number of students per year
        foreach ($programs as $program) {
            $programData = [];
            
            // Loop through each academic year to get the student count
            foreach ($tahunAkademik as $tahun) {
                $count = ProgramTransaction::whereHas('lowongan', function($query) use ($program, $tahun) {
                    $query->where('program_id', $program->id)
                          ->where('tahun_akademik', $tahun);
                })->count();

                $programData[] = $count;
            }

            $data[$program->name] = $programData;
        }

        // Create a new line chart instance
        $chart = $this->chart->lineChart()
            ->setTitle('Infografis')
            ->setSubtitle('');

        // Add data to the chart
        foreach ($data as $programName => $programData) {
            $chart->addData($programName, $programData);
        }
        $tahun = [];
        foreach ($tahunAkademik as $thn) {
            $tahun[] = $thn;
        }
        // Set the X-axis labels
        $chart->setXAxis($tahun);

        return $chart;
    }
}
