<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport;
use App\Exports\ProgramPesertaExport;
use App\Imports\PesertaImport;
use App\Imports\VerifikasiImport;
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
    public function index(Request $request)
    {
        // Initialize the query
        $query = ProgramTransaction::query();

        // Apply filters
        if ($request->has('program') && !empty($request->program)) {
            $query->whereHas('lowongan.program', function ($q) use ($request) {
                $q->where('id', $request->program);
            });
        }
        if ($request->has('tahun_akademik') && !empty($request->tahun_akademik)) {
            $query->whereHas('lowongan', function ($q) use ($request) {
                $q->where('tahun_akademik', $request->tahun_akademik);
            });
        }
        if ($request->has('semester') && !empty($request->semester)) {
            $query->whereHas('lowongan', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        // Add the status_mahasiswa filter
        $query->where('status_mahasiswa', 1);

        // Fetch the necessary data
        $programTransactions = $query->get();
        $programs = ProgramKampus::all();
        $semesters = Lowongan::select('semester')->distinct()->pluck('semester');
        $tahun_akademiks = Lowongan::select('tahun_akademik')->distinct()->pluck('tahun_akademik');

        // Return the view with data
        return view('admin.superadmin.programTransaction.programTransaction')->with([
            'data' => $programTransactions,
            'programs' => $programs,
            'semesters' => $semesters,
            'tahun_akademiks' => $tahun_akademiks,
            'selectedProgram' => $request->program,
            'selectedSemester' => $request->semester,
            'selectedTahunAkademik' => $request->tahun_akademik,
        ]);
    }

    public function deletePeserta($id)
    {
        $program = ProgramTransaction::find($id);
        $program->status_mahasiswa = 0;
        $program->save();
        return redirect()->back()->with('success', 'Peminat berhasil dihapus');
    }

    public function update_payment($id, Request $request)
    {
        // Find the transaction record or fail if not found
        $program = ProgramTransaction::findOrFail($id);

        // Prevent update if payment has already been submitted
        if ($program->status_pembayran) {
            return redirect()->back()->with('error', 'Pembayaran sudah disubmit dan tidak dapat diubah.');
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'ukuran_baju' => 'required|string|max:255',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // adjust allowed file types and size as needed
        ]);

        // Update the t-shirt size
        $program->ukuran_baju = $validatedData['ukuran_baju'];

        // Handle the file upload for payment proof
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store the file in the 'public/payment_proofs' directory
            $file->storeAs('public/payment_proofs', $filename);
            $program->bukti_pembayaran = $filename;
        }

        // Mark payment status as submitted
        // $program->status_pembayran = true;

        // Save the updated transaction
        $program->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Pembayaran berhasil diupdate.');
    }


    public function export(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        return Excel::download(new ProgramPesertaExport($data), 'peserta.xlsx');
    }

    public function export_peserta(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        return Excel::download(new PesertaExport($data), 'peserta.xlsx');
    }

    public function peserta(Request $request)
    {
        // Initialize the query
        // $query = ProgramTransaction::query();
        $query = ProgramTransaction::query()->where('status_pembayran', true);


        // Apply filters
        if ($request->has('program') && !empty($request->program)) {
            $query->whereHas('lowongan.program', function ($q) use ($request) {
                $q->where('id', $request->program);
            });
        }
        if ($request->has('tahun_akademik') && !empty($request->tahun_akademik)) {
            $query->whereHas('lowongan', function ($q) use ($request) {
                $q->where('tahun_akademik', $request->tahun_akademik);
            });
        }
        if ($request->has('semester') && !empty($request->semester)) {
            $query->whereHas('lowongan', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        $programs = ProgramKampus::all();
        $semesters = Lowongan::select('semester')->distinct()->pluck('semester');
        $tahun_akademiks = Lowongan::select('tahun_akademik')->distinct()->pluck('tahun_akademik');

        // Get filtered results
        $programTransactions = $query->where('status_mahasiswa', 0)->get();

        // Pass the current filter values to the view
        return view('admin.superadmin.peminat.peminat')->with([
            'data' => $programTransactions,
            'programs' => $programs,
            'semesters' => $semesters,
            'tahun_akademiks' => $tahun_akademiks,
            'selectedProgram' => $request->program,
            'selectedSemester' => $request->semester,
            'selectedTahunAkademik' => $request->tahun_akademik,
        ]);
    }

    public function pembayaran(Request $request)
    {
        // Initialize the query
        // $query = ProgramTransaction::query();
        $query = ProgramTransaction::query()->where('status_pembayran', false)->where('status_mahasiswa', false);


        // Apply filters
        if ($request->has('program') && !empty($request->program)) {
            $query->whereHas('lowongan.program', function ($q) use ($request) {
                $q->where('id', $request->program);
            });
        }
        if ($request->has('tahun_akademik') && !empty($request->tahun_akademik)) {
            $query->whereHas('lowongan', function ($q) use ($request) {
                $q->where('tahun_akademik', $request->tahun_akademik);
            });
        }
        if ($request->has('semester') && !empty($request->semester)) {
            $query->whereHas('lowongan', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        $programs = ProgramKampus::all();
        $semesters = Lowongan::select('semester')->distinct()->pluck('semester');
        $tahun_akademiks = Lowongan::select('tahun_akademik')->distinct()->pluck('tahun_akademik');

        // Get filtered results
        $programTransactions = $query->where('status_mahasiswa', 0)->get();

        // Pass the current filter values to the view
        return view('admin.superadmin.peminat.pembayaran')->with([
            'data' => $programTransactions,
            'programs' => $programs,
            'semesters' => $semesters,
            'tahun_akademiks' => $tahun_akademiks,
            'selectedProgram' => $request->program,
            'selectedSemester' => $request->semester,
            'selectedTahunAkademik' => $request->tahun_akademik,
        ]);
    }



    public function getLokasi(Request $request)
    {
        $lowonganId = $request->query('lowongan_id');
        $programTransactions = ProgramTransaction::where('lowongan_id', $lowonganId)->where('status_mahasiswa', true)->with('mahasiswa')->get();
        $mahasiswaList = $programTransactions->map(function ($transaction) {
            return $transaction->mahasiswa;
        });
        return response()->json($mahasiswaList);
    }

    public function getLowongan(Request $request)
    {
        $mahasiswa = ProgramTransaction::where('lowongan_id', $request->program_id)->where('status_mahasiswa', true)
            ->with('mahasiswa') // Include the mahasiswa relation
            ->get()
            ->map(function ($transaction) {
                return ['id' => $transaction->id, 'name' => $transaction->mahasiswa->name, 'nim' => $transaction->mahasiswa->nim]; // Extract the mahasiswa from each transaction
            });

        return response()->json($mahasiswa);
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

    public function verifiasi_pembayaran(Request $request, $id)
    {
        $request->validate([
            'total' => 'required',
        ]);

        $mahasiswa = ProgramTransaction::find($id);
        $mahasiswa->update([
            'status_pembayran' => true
        ]);
        $mahasiswa->save();
        return redirect()->back()->with('success', 'Peserta berhasil diverifikasi');
    }
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required|exists:lokasis,id',
        ]);
        $mahasiswa = ProgramTransaction::find($id);
        $mahasiswa->update([
            'lokasi_id' => $request->lokasi,
            'status_mahasiswa' => true
        ]);
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
                // 'desc' => ''
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
                    // 'desc' => ''

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
                        // 'desc' => '',
                        'date' => $startDate,
                        'weekly_log_id' => $item->id,
                    ]);

                    $startDate->addDay(); // Perbaikan sintaks
                }
            }
        }
        return redirect()->back()->with('success', 'Peserta berhasil diverifikasi');
    }

    public function verifikasiImport()
    {
        Excel::import(new VerifikasiImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
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
        $isProgram = ProgramTransaction::where('mahasiswa_id', $request->mahasiswa_id)->where('lowongan_id', $request->lowongan_id)->first();
        if ($isProgram) {
            return redirect()->route('admin.peserta')
                ->with('error', 'Mahasiswa already exists');
        }
        $program = ProgramTransaction::create($request->all());
        $program->status_mahasiswa = true;
        $program->save();

        $lowongan = Lowongan::find($request->lowongan_id);
        if ($lowongan->isLogBook) {
            $startDate = Carbon::parse($program->lowongan->tanggal_mulai); // Tanggal awal
            $endDate = Carbon::parse($program->lowongan->tanggal_selesai);
            $st = $startDate->copy(); // Create a separate copy of $startDate for $st
            $e_d = $startDate->endOfWeek()->copy(); // Create a separate copy for $e_d
            $wk = WeeklyLog::create([
                'program_transaction_id' => $program->id,
                'start_date' => $st, // Start date
                'end_date' => $e_d, // End date
                // 'desc' => ''
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
                    // 'desc' => ''

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
                        // 'desc' => '',
                        'dokumentasi' => '',
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
        $peserta = ProgramTransaction::find($id);

        $lokasi = Lokasi::where('program_id', $peserta->lowongan->program->id)->get();
        $data = [
            'program' => $program,
            'mahasiswa' => $mahasiswa,
            'lokasi' => $lokasi
        ];
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
            'lokasi_id' => 'required',
        ]);

        $programTransaction = ProgramTransaction::find($id);
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
