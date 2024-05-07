<?php

namespace App\Http\Controllers;

use App\Imports\MahasiswaImport;
use App\Models\DailyLog;
use App\Models\Mahasiswa;
use App\Models\WeeklyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('admin.superadmin.student.student')->with('data', $mahasiswas);

    }

    public function dashboard()
    {
        try {
            $programTransaction = Auth::user()->mahasiswa->programTransaction;
        } catch (\Throwable $th) {
            //throw $th;
            $programTransaction = '';
        }
        $data = [
            'programTransaction' => $programTransaction,
        ];


        return view('admin.student.dashboard')->with('data', $data);
    }

    public function weeklyBook()
    {
        try {
            $programTransaction = Auth::user()->mahasiswa->programTransaction;
        } catch (\Throwable $th) {
            //throw $th;
            $programTransaction = '';
        }
        $data = [
            'programTransaction' => $programTransaction,
        ];


        return view('admin.student.weekly_logbook')->with('data', $data);
    }

    public function dailyBook($id)
    {
        $weeklyLog = WeeklyLog::find($id);
        return view('admin.student.daily_logbook')->with('data', $weeklyLog);
    }
    public function dailyLogForm($id)
    {
        $dailyLog = DailyLog::find($id);
        return view('admin.student.daily_logbook_form')->with('data', $dailyLog);
    }

    public function dailyLog(Request $request, $id)
    {
        // Mengambil data dari request
        $data = $request->all();

        // Mengonversi deskripsi menjadi string
        $desc = json_encode([
            "deskripsi" => $data['deskripsi'],
            "rencana" => $data['rencana'],
            "persentase" => $data['persentase'],
            "hambatan" => $data['hambatan'],
            "solusi" => $data['solusi']
        ]);

        // Mengupdate daily log dengan deskripsi yang sudah dikonversi
        $dailyLog = DailyLog::find($id);
        $dailyLog->desc = $desc;
        $dailyLog->status = 'proses';
        $dailyLog->save();

        // Redirect atau kembalikan ke halaman yang sesuai
        return redirect()->route('student.weekly_logbook')->with('success', 'Daily log berhasil disimpan');
    }

    public function weeklyLog(Request $request, $id)
    {
        // Mengambil data dari request
        $data = $request->all();


        // Mengupdate daily log dengan deskripsi yang sudah dikonversi
        $weeklyLog = WeeklyLog::find($id);
        $weeklyLog->status = 'proses';
        $weeklyLog->save();

        // Redirect atau kembalikan ke halaman yang sesuai
        return redirect()->route('student.weekly_logbook')->with('success', 'Daily log berhasil disimpan');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswas.create');
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
            'nim' => 'required|unique:mahasiswas',
            'name' => 'required',
            'studi_id' => 'required|exists:studis,id',
            'angkatan' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa created successfully.');
    }

    public function import()
    {
        Excel::import(new MahasiswaImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswas.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswas.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'name' => 'required',
            'studi_id' => 'required|exists:studis,id',
            'angkatan' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $mahasiswa->update($request->all());

        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa deleted successfully');
    }
}
