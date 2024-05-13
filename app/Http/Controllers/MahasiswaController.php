<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Models\ActivityLog;
use App\Models\DailyLog;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
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
            $programTransaction = Auth::user()->mahasiswa->programTransaction()->latest()->first();
        } catch (\Throwable $th) {
            //throw $th;
            $programTransaction = '';
        }
        $data = [
            'programTransaction' => $programTransaction,
        ];


        return view('admin.student.dashboard')->with('data', $data);
    }

    public function rancangan(Request $request, $id)
    {
        $request->validate([
            'rancangan' => 'required',
        ]);

        // Cari program transaksi berdasarkan ID
        $programTransaction = ProgramTransaction::find($id);

        // Update nilai rancangan dan status
        $programTransaction->rancangan = $request->rancangan;
        if ($programTransaction->status_rancangan_pamong != 'terima') {
            $programTransaction->status_rancangan_pamong = 'proses';

        }
        if ($programTransaction->status_rancangan_dpl != 'terima') {
            $programTransaction->status_rancangan_dpl = 'proses';

        }

        // Simpan perubahan ke dalam database
        $programTransaction->save();

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
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

    public function export()
    {
        return Excel::download(new MahasiswaExport, 'mahasiswa.xlsx');
    }
    public function dailyLogForm($id)
    {
        $dailyLog = DailyLog::find($id);
        return view('admin.student.daily_logbook_form')->with('data', $dailyLog);
    }

    public function dailyLog(Request $request, $id)
    {
        // Mengambil data dari request
        $request->validate([
            'jumlah' => 'required',
            'dokumentasi' => 'required',
        ]);
        $dailyLog = DailyLog::find($id);
        $dailyLog->status = 'proses';
        $dailyLog->dokumentasi = $request->dokumentasi;
        for ($i = 1; $i <= $request->jumlah; $i++) {
            $activity = ActivityLog::create([
                'desc' => $request['deskripsi' . $i],
                'rencana' => $request['rencana' . $i],
                'jam_mulai' => $request['jam_mulai' . $i],
                'jam_selesai' => $request['jam_selesai' . $i],
                'presentase' => $request['persentase' . $i],
                'hambatan' => $request['hambatan' . $i],
                'solusi' => $request['solusi' . $i],

            ]);
            $dailyLog->activity()->attach($activity->id);
        }
        // Mengupdate daily log dengan deskripsi yang sudah dikonversi

        $dailyLog->save();

        // Redirect atau kembalikan ke halaman yang sesuai
        return redirect()->route('student.weekly_logbook')->with('success', 'Daily log berhasil disimpan');
    }

    public function weeklyLogSubmit(Request $request, $id)
    {
        // Mengambil data dari request
        $request->validate([
            'jumlah' => 'required',
        ]);


        $dailyLog = WeeklyLog::find($id);
        $dailyLog->status = 'proses';
        for ($i = 1; $i <= $request->jumlah; $i++) {
            $activity = ActivityLog::create([
                'desc' => $request['deskripsi' . $i],
                'rencana' => $request['rencana' . $i],
                'jam_mulai' => $request['jam_mulai' . $i],
                'jam_selesai' => $request['jam_selesai' . $i],
                'presentase' => $request['persentase' . $i],
                'hambatan' => $request['hambatan' . $i],
                'solusi' => $request['solusi' . $i],

            ]);
            $dailyLog->activity()->attach($activity->id);
        }
        // Mengupdate daily log dengan deskripsi yang sudah dikonversi

        $dailyLog->save();

        // Redirect atau kembalikan ke halaman yang sesuai
        return redirect()->route('student.weekly_logbook')->with('success', 'Daily log berhasil disimpan');
    }

    public function weeklyLog(Request $request, $id)
    {
        // // Mengambil data dari request
        // $data = $request->all();

        // // Mengupdate daily log dengan deskripsi yang sudah dikonversi
        // $weeklyLog = WeeklyLog::find($id);
        // $weeklyLog->status = 'proses';
        // $weeklyLog->save();

        // Redirect atau kembalikan ke halaman yang sesuai
        $data = WeeklyLog::find($id);
        return view('admin.student.weekly_logbook_form')->with('data', $data);

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
