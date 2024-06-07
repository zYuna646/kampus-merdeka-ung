<?php

namespace App\Http\Controllers;

use App\Imports\PesertaImport;
use App\Models\DailyLog;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramKampus;
use App\Models\ProgramTransaction;
use App\Models\WeeklyLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


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

    public function peserta()
    {
        $programTransactions = ProgramTransaction::where('status_mahasiswa', false);
        
        return view('admin.superadmin.peminat.peminat')->with('data', $programTransactions);

    }

    public function getLokasi(Request $request)
    {
        $lowonganId = $request->query('lowongan_id');
        $programTransactions = ProgramTransaction::where('lowongan_id', $lowonganId)->with('mahasiswa')->get();
        $mahasiswaList = $programTransactions->map(function ($transaction) {
            return $transaction->mahasiswa;
        });
        return response()->json($mahasiswaList);
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

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);
        $mahasiswa = ProgramTransaction::find($id);
        $mahasiswa->lokasi_id = $request->lokasi_id;
        $mahasiswa->save();
        $program = $mahasiswa;

        if ($program->lowongan->isLogBook) {
            $startDate = Carbon::parse($program->lowongan->tanggal_mulai); // Tanggal awal
            $endDate = Carbon::parse($program->lowongan->tanggal_selesai);
            $st = $startDate->copy(); // Create a separate copy of $startDate for $st
            $e_d = $startDate->endOfWeek()->copy(); // Create a separate copy for $e_d
            $wk = WeeklyLog::create([
                'program_transaction_id' => $program->id,
                'start_date' => $st, // Start date
                'end_date' => $e_d, // End date
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
        }
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

        $lowongan = Lowongan::find($request->lokasi_id);
        if ($lowongan->isLogBook) {
            $startDate = Carbon::parse($program->lowongan->tanggal_mulai); // Tanggal awal
            $endDate = Carbon::parse($program->lowongan->tanggal_selesai);
            $st = $startDate->copy(); // Create a separate copy of $startDate for $st
            $e_d = $startDate->endOfWeek()->copy(); // Create a separate copy for $e_d
            $wk = WeeklyLog::create([
                'program_transaction_id' => $program->id,
                'start_date' => $st, // Start date
                'end_date' => $e_d, // End date
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

        }

        return redirect()->route('admin.peserta')
            ->with('success', 'ProgramTransaction created successfully.');
    }

    public function import()
    {
        Excel::import(new PesertaImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
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
    public function edit($id)
    {
        $program = Lowongan::all();
        $mahasiswa = Mahasiswa::all();
        $lokasi = Lokasi::all();
        $data = [
            'program' => $program,
            'mahasiswa' => $mahasiswa,
            'lokasi' => $lokasi
        ];
        $peserta = ProgramTransaction::find($id);
        return view('admin.superadmin.programTransaction.edit', compact('data', 'peserta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramTransaction  $programTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lowongan_id' => 'required',
            'mahasiswa_id' => 'required',
            'lokasi_id' => 'required',
        ]);

        $programTransaction = ProgramTransaction::find($id);
        $programTransaction->lowongan_id = $request->lowongan_id;
        $programTransaction->lokasi_id = $request->lokasi_id;
        $programTransaction->save();

        return redirect()->route('admin.peserta')
            ->with('success', 'ProgramTransaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramTransaction  $programTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProgramTransaction::find($id)->delete();
        return redirect()->route('admin.peserta')
            ->with('success', 'Peserta deleted successfully');
    }
}
