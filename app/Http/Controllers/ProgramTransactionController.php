<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramKampus;
use App\Models\ProgramTransaction;
use App\Models\WeeklyLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProgramTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programTransactions = ProgramTransaction::all();
        return view('admin.superadmin.programTransaction.programTransaction')->with('data', $programTransactions);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = Lowongan::all();
        $mahasiswa = Mahasiswa::all();
        $lokasi = Lokasi::all();
        $data = [
            'program' => $program,
            'mahasiswa' => $mahasiswa,
            'lokasi' => $lokasi
        ];
        return view('admin.superadmin.programTransaction.add')->with('data', $data);
    }

    public function getPesertaDetail($id)
    {
        // Ambil data peserta berdasarkan ID
        $peserta = ProgramTransaction::findOrFail($id);
        // Kembalikan tampilan detail peserta
        return view('admin.dpl.peserta_detail', ['peserta' => $peserta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
        ]);

        $program = ProgramTransaction::create($request->all());

        $startDate = Carbon::parse($program->lowongan->tanggal_mulai); // Tanggal awal
        $endDate = Carbon::parse($program->lowongan->tanggal_selesai);

        WeeklyLog::create([
            'program_transaction_id' => $program->id,
            'start_date' => $startDate, // Start date
            'end_date' => $startDate->endOfWeek(), // End date
            'desc' => ''
        ]);

        $tmp_date = $startDate->copy()->addWeek()->startOfWeek();
        while ($tmp_date->lte($endDate)) {
            // Buat weekly log untuk minggu ini

            $tmp_end_week = $tmp_date->copy()->endOfWeek();
            if ($tmp_end_week->gte($endDate)) {
                $tmp_end_week = $endDate;
            }

            WeeklyLog::create([
                'program_transaction_id' => $program->id,
                'start_date' => $tmp_date->copy()->startOfWeek(), // Start date
                'end_date' => $tmp_end_week, // End date
                'desc' => ''

            ]);

            // Lanjutkan ke minggu berikutnya
            $tmp_date->addWeek();
        }

        foreach ($program->weeklyLog as $key => $item) {
            $startDate = Carbon::parse($item->start_date); // Konversi ke objek Carbon
            $endDate = Carbon::parse($item->end_date); // Konversi ke objek Carbon

            while ($startDate <= $endDate) {
                DailyLog::create([
                    'program_transaction_id' => $program->id,
                    'desc' => '',
                    'date' => $startDate,
                    'weekly_log_id' => $item->id,
                ]);

                $startDate->addDay(); // Perbaikan sintaks
            }
        }

        return redirect()->route('admin.peserta')
            ->with('success', 'ProgramTransaction created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramTransaction  $programTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramTransaction $programTransaction)
    {
        return view('program_transactions.show', compact('programTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramTransaction  $programTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramTransaction $programTransaction)
    {
        return view('program_transactions.edit', compact('programTransaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramTransaction  $programTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramTransaction $programTransaction)
    {
        $request->validate([
            'program_id' => 'required|exists:program_kampuses,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'guru_id' => 'required|exists:gurus,id',
            'dosen_id' => 'required|exists:dosens,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
        ]);

        $programTransaction->update($request->all());

        return redirect()->route('program_transactions.index')
            ->with('success', 'ProgramTransaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramTransaction  $programTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramTransaction $programTransaction)
    {
        $programTransaction->delete();

        return redirect()->route('program_transactions.index')
            ->with('success', 'ProgramTransaction deleted successfully');
    }
}
