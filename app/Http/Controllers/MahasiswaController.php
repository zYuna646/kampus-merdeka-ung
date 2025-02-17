<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Date;
use App\Exports\MahasiswaExport;
use App\Imports\MahasiswaImport;
use App\Models\ActivityLog;
use App\Models\DailyLog;
use App\Models\Lowongan;
use App\Models\Role;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use App\Models\WeeklyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Studi;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::query();
    
        if ($request->has('jurusan') && !empty($request->jurusan)) {
            $query->whereHas('studi.jurusan', function($q) use ($request) {
                $q->where('id', $request->jurusan);
            });
        }
    
        if ($request->has('angkatan') && !empty($request->angkatan)) {
            $query->where('angkatan', $request->angkatan);
        }
    
        $mahasiswas = $query->get();
    
        $studis = Studi::all();
        $angkatans = Mahasiswa::select('angkatan')->distinct()->get();
    
        return view('admin.superadmin.student.student')->with([
            'data' => $mahasiswas,
            'studis' => $studis,
            'angkatans' => $angkatans,
            'selectedStudi' => $request->jurusan,
            'selectedAngkatan' => $request->angkatan
        ]);
    }
    

    public function dashboard()
    {
        try {
            $programTransaction = Auth::user()->mahasiswa->programTransaction()
            ->where('status_mahasiswa', true)
            ->latest()
            ->first();
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

    public function program_history()
    {
        $data =  Auth::user()->mahasiswa->programTransaction;
        return view('admin.student.program_history')->with('data', $data);
    }

    public function weeklyBook($id)
    {
        try {
            $programTransaction = ProgramTransaction::find($id);
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

    public function downloadDaily($id)
    {
        $daily = DailyLog::find($id);


        $data = [
            'program' => $daily->programTransaction->lowongan->program,
            'lokasi' => $daily->programTransaction->lokasi,
            'daily' => $daily,
            'mahasiswa' => $daily->programTransaction->mahasiswa,
            'activity' => $daily->activity,
            'pamong' => $daily->programTransaction->pamong()->latest()->first(),
            'dpl' => $daily->programTransaction->dpls()->latest()->first(),
            'jurusan' => $daily->programTransaction->mahasiswa->studi->jurusan,
        ];
        // dd($data);
        $pdf = PDF::loadView('document_daily', $data)->setPaper('a4', 'portrait');
        return $pdf->stream();
        // return view('document_daily', $data);
    }

    public function downloadWeekly($id)
    {
        $daily = WeeklyLog::find($id);


        $data = [
            'program' => $daily->programTransaction->lowongan->program,
            'lokasi' => $daily->programTransaction->lokasi,
            'daily' => $daily,
            'mahasiswa' => $daily->programTransaction->mahasiswa,
            'activity' => $daily->activity,
            'pamong' => $daily->programTransaction->pamong()->latest()->first(),
            'dpl' => $daily->programTransaction->dpls()->latest()->first(),
            'jurusan' => $daily->programTransaction->mahasiswa->studi->jurusan,
        ];
        $pdf = PDF::loadView('document_weekly', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();

    }

    public function register($id)
{
    $lowongan = Lowongan::find($id);
    $currentDate = \Carbon\Carbon::now();

    // Check if the student is already registered in the same lowongan
    $isLowongan = ProgramTransaction::where('lowongan_id', $lowongan->id)
        ->where('mahasiswa_id', Auth::user()->mahasiswa->id)
        ->first();
    if ($isLowongan) {
        return redirect()->back()->with('error', 'Anda Sudah Terdaftar');
    }

    // Check if the student is already registered in another program in the same academic year and semester
    $lowongan_tahun = Lowongan::where('tahun_akademik', $lowongan->tahun_akademik)
        ->where('semester', $lowongan->semester)
        ->pluck('id');
    
    $isAlready = ProgramTransaction::where('mahasiswa_id', Auth::user()->mahasiswa->id)
        ->whereIn('lowongan_id', $lowongan_tahun)
        ->first();
    
    if ($isAlready) {
        return redirect()->back()->with('error', 'Anda Sudah Terdaftar Pada Program Lain Pada Tahun Akademik Ini');
    }

    // Check if the registration date is within the allowed range
    if (!($lowongan->pendaftaran_mulai <= $currentDate && $currentDate <= $lowongan->pendaftaran_selesai)) {
        return redirect()->back()->with('error', 'Batas Pendaftaran Sudah Selesai');
    }

    // Register the student
    $mahasiswa = Auth::user()->mahasiswa;
    ProgramTransaction::create([
        'lowongan_id' => $lowongan->id,
        'mahasiswa_id' => $mahasiswa->id
    ]);

    return redirect()->back()->with('success', 'Berhasil mendaftar ke program');
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
        $dailyLog->activity()->delete();
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
        return redirect()->route('student.weekly_logbook', $dailyLog->program_transaction_id )->with('success', 'Daily log berhasil disimpan');
    }

    // public function register($id)
    // {
    //     $lowongan = Lowongan::find($id);
    //     $currentDate = \Carbon\Carbon::now();

    //     if (!($lowongan->pendaftaran_mulai <= $currentDate && $currentDate <= $lowongan->pendaftaran_selesai)) {
    //         return; // Or some other action, like return a response or an error message
    //     }
    //     $mahasiswa = Auth::user()->mahasiswa;
    //     ProgramTransaction::create([
    //         'lowongan_id' => $lowongan->id,
    //         'mahasiswa_id' => $mahasiswa->id
    //     ]);

    // }

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
        return redirect()->route('student.weekly_logbook', $dailyLog->program_transaction_id)->with('success', 'Daily log berhasil disimpan');
    }

    public function downloadSurat($id)
    {
        $programTransaction = ProgramTransaction::find($id);
        $currentDate = Date::now();
        $monthYear = $currentDate->format('F Y');
        $data = [
            'program' => $programTransaction->lowongan->program,
            'mahasiswa' => $programTransaction->mahasiswa,
            'jurusan' => $programTransaction->mahasiswa->studi->jurusan,
            'lowongan' => $programTransaction->lowongan,
            'date' => $monthYear,
        ];
        
        $pdf = PDF::loadView('document_sp3', $data)->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function downloadSK($id)
    {
        $programTransaction = ProgramTransaction::find($id);
        $filePath = storage_path('app/public/'.$programTransaction->lowongan->sk);
        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            abort(404);
        }
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
        $studi = Studi::all()->toArray();
        $data = [
            'studi' => $studi
        ];
        return view('admin.superadmin.student.add')->with('data', $data);
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
        ]);

        $role = Role::where('slug', 'mahasiswa')->first();
        $user = User::create([
            'username' => $request->nim,
            'password' => bcrypt($request->nim),
            'role_id' => $role->id,
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'studi_id' => $request->studi_id,
            'angkatan' => $request->angkatan,
            'user_id' => $user->id
        ]);

        return redirect()->route('admin.student')
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
    public function edit($id)
    {
        $studi = Studi::all()->toArray();
        $data = [
            'studi' => $studi
        ];
        $mahasiswa = Mahasiswa::find($id);
        return view('admin.superadmin.student.edit', compact('mahasiswa', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
    
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'name' => 'required',
            'studi_id' => 'required|exists:studis,id',
            'angkatan' => 'required|integer',
            'new_pass' => 'nullable|min:8',
            'confirm_new_pass' => 'nullable|same:new_pass',
        ]);
    
        $newUsername = $request->nim;

        $mahasiswa->update([
            'nim' => $request->nim,
            'name' => $request->name,
            'studi_id' => $request->studi_id,
            'angkatan' => $request->angkatan,
        ]);

        if ($request->filled('new_pass')) {
            $mahasiswa->user->update([
                'password' => bcrypt($request->new_pass)
            ]);
        }

          // Update the user's username if nidn has changed
        if ($mahasiswa->user->username !== $newUsername) {
            $mahasiswa->user->update([
                'username' => $newUsername
            ]);
        }
        
        return redirect()->route('admin.student')
            ->with('success', 'Mahasiswa updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa->user->delete();
        $mahasiswa->delete();
        return redirect()->route('admin.student')
            ->with('success', 'Mahasiswa deleted successfully');
    }
}
