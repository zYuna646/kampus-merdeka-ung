<?php

namespace App\Http\Controllers;

use App\Imports\DosenImport;
use App\Models\Dosen;
use App\Models\ProgramTransaction;
use App\Models\WeeklyLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosens = Dosen::all();
        return view('admin.superadmin.dosen.dosen')->with('data', $dosens);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dosens.create');
    }

    public function dashboard()
    {
        try {
            $dpl = Auth::user()->dosen->dpl;
            $uniqueProgramTransactions = collect([]);

            // Gunakan koleksi untuk menyimpan id program transaksi yang sudah ditemukan
            $foundIds = [];

            foreach ($dpl->lokasis as $lokasi) {
                foreach ($lokasi->programTransaction as $program) {
                    // Periksa apakah program transaksi sudah ada dalam koleksi
                    if (!in_array($program->id, $foundIds)) {
                        // Jika belum, tambahkan ke koleksi unik
                        $uniqueProgramTransactions->push($program);
                        // Tambahkan id program transaksi ke dalam array foundIds
                        $foundIds[] = $program->id;
                    }
                }
            }
        } catch (\Throwable $th) {
            // Tangani kesalahan jika diperlukan
            $dpl = '';
            $uniqueProgramTransactions = '';
        }


        $data = [
            'dpl' => $dpl,
            'program' => $uniqueProgramTransactions
        ];

        return view('admin.dpl.dashboard_dpl')->with('data', $data);
    }

    public function getPesertaDetail($id)
    {
        // Ambil data peserta berdasarkan ID
        $peserta = ProgramTransaction::findOrFail($id);
        // Kembalikan tampilan detail peserta
        return view('admin.dpl.peserta_detail', ['peserta' => $peserta]);
    }

    public function programDetail($lowongan_id, $lokasi_id)
    {
        // Ambil data peserta berdasarkan lowongan_id dan lokasi_id
        $peserta = ProgramTransaction::where('lowongan_id', $lowongan_id)
            ->where('lokasi_id', $lokasi_id)
            ->get();

        $data = [
            'peserta' => $peserta
        ];

        return view('admin.dpl.program_details_dpl', compact('data'));
    }

    public function dailyBook($id)
    {
        $weeklyLog = WeeklyLog::find($id);
        return view('admin.dpl.weekly_review_dpl')->with('data', $weeklyLog);
    }
    public function weeklyBook(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100', // Ensure nilai is numeric and between 0 and 100
            'msg' => 'string', // You can adjust this validation rule according to your requirements
        ]);

        // Find the WeeklyLog instance
        $weeklyLog = WeeklyLog::find($id);

        // Update the values
        $weeklyLog->nilai = $validatedData['nilai'];
        $weeklyLog->msg = $validatedData['msg'];
        $weeklyLog->status = 'terima';

        // Save the changes
        $weeklyLog->save();

        // Redirect or return the view
        return view('admin.dpl.weekly_review_dpl')->with('data', $weeklyLog);
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
            'nidn' => 'required|unique:dosens',
            'name' => 'required',
            'studi_id' => 'required|exists:studis,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Dosen::create($request->all());

        return redirect()->route('dosens.index')
            ->with('success', 'Dosen created successfully.');
    }

    public function import()
    {
        Excel::import(new DosenImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Dosen $dosen)
    {
        return view('dosens.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit(Dosen $dosen)
    {
        return view('dosens.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nidn' => 'required|unique:dosens,nidn,' . $dosen->id,
            'name' => 'required',
            'studi_id' => 'required|exists:studis,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $dosen->update($request->all());

        return redirect()->route('dosens.index')
            ->with('success', 'Dosen updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('dosens.index')
            ->with('success', 'Dosen deleted successfully');
    }
}
