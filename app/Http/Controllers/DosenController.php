<?php

namespace App\Http\Controllers;

use App\Exports\DosenExport;
use App\Imports\DosenImport;
use App\Models\Dosen;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Program;
use App\Models\ProgramKampus;
use App\Models\Role;
use App\Models\User;
use App\Models\DPL;
use App\Models\ProgramTransaction;
use App\Models\Studi;
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
        $studi = Studi::all()->toArray();
        $data = [
            'studi' => $studi
        ];
        return view('admin.superadmin.dosen.add')->with('data', $data);
    }

    public function export()
    {
        return Excel::download(new DosenExport, 'dosen.xlsx');
    }

    public function dashboard()
    {
        try {
            $dpl = Auth::user()->dosen->dpl()->latest()->first();
        } catch (\Throwable $th) {
            //throw $th;
            $dpl = '';
        }

        $data = [
            'program' => $dpl,
            'program_kampus' => ProgramKampus::all()
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

    public function programDetail(Request $request, $lowongan_id)
    {
        // Ambil data peserta berdasarkan lowongan_id dan lokasi_id
        $dpl = DPL::where('lowongan_id', $lowongan_id)
            ->where('dosen_id', Auth::user()->dosen->id)
            ->first();

        if ($request->search) {
            $searchTerm = $request->input('search');
            $isAllNumber = is_numeric($searchTerm);
            // dd($isAllNumber); // Anda dapat menggunakan ini untuk debugging
            if ($isAllNumber) {
                // Jika nilai search adalah angka, cari berdasarkan NIM
                $peserta = $dpl->mahasiswa()->whereHas('mahasiswa', function ($query) use ($searchTerm) {
                    $query->where('nim', 'like', '%' . $searchTerm . '%');
                })->paginate(5);
            } else {
                // Jika nilai search bukan angka, cari berdasarkan nama
                $peserta = $dpl->mahasiswa()->whereHas('mahasiswa', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                })->paginate(5);
            }


        } else {
            // Jika tidak ada pencarian, ambil semua data mahasiswa yang terkait dengan DPL
            $peserta = $dpl->mahasiswa()->paginate(5);
        }

        $lowongan = Lowongan::find($lowongan_id);

        $data = [
            'peserta' => $peserta,
            'dpl' => $dpl,
            'lokasi' => Lokasi::where('program_id', $lowongan->program->id)->get(),
        ];

        return view('admin.dpl.program_details_dpl', compact('data'));
    }

    public function dailyBook($id)
    {
        $weeklyLog = WeeklyLog::find($id);
        return view('admin.dpl.weekly_review_dpl')->with('data', $weeklyLog);
    }

    public function rancangan(Request $request, $id)
    {
        $peserta = ProgramTransaction::find($id);
        if ($request->status == 'terima') {
            $peserta->status_rancangan_dpl = 'terima';
            $peserta->msg_dpl = $request->msg ?? " ";
        }else
        {
            $peserta->status_rancangan_dpl = 'tolak';
            $peserta->msg_dpl = $request->msg ?? " ";
        }
        $peserta->save();
        return redirect()->back();
    }

    public function weeklyBook(Request $request, $id)
    {
        // Validate the request data

        // Find the WeeklyLog instance
        $weeklyLog = WeeklyLog::find($id);

        $weeklyLog->msg = $request->msg;
        $weeklyLog->status = $request->status;

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
        ]);

        $role = Role::where('slug', 'dosen')->first();
        $user = User::create([
            'username' => $request->nidn,
            'password' => bcrypt($request->nidn), // Gunakan NIDN sebagai password
            'role_id' => $role->id,
        ]);

        Dosen::create([
            'nidn' => $request->nidn,
            'name' => $request->name,
            'studi_id' => $request->studi_id,
            'user_id' => $user->id,
        ]);
        
        return redirect()->route('admin.dosen')
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
    public function edit($id)
    {
        $studi = Studi::all()->toArray();
        $data = [
            'studi' => $studi
        ];
        $dosen =  Dosen::find($id);
        return view('admin.superadmin.dosen.edit', compact('dosen', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::find($id);
        $request->validate([
            'nidn' => 'required|unique:dosens,nidn,' . $dosen->id,
            'name' => 'required',
            'studi_id' => 'required|exists:studis,id',
        ]);

        $dosen->update($request->all());
        return redirect()->route('admin.dosen')
            ->with('success', 'Dosen updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dosen::find($id)->delete();

        return redirect()->route('admin.dosen')
            ->with('success', 'Dosen deleted successfully');
    }
}
