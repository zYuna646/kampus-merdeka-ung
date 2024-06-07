<?php

namespace App\Http\Controllers;

use App\Exports\MitraExport;
use App\Imports\GuruImport;
use App\Models\DailyLog;
use App\Models\Guru;
use App\Models\Lokasi;
use App\Models\MitraTransaction;
use App\Models\ProgramTransaction;
use App\Models\Role;
use App\Models\User;
use App\Models\WeeklyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gurus = Guru::with([
            'lokasis.provinsi', 
            'lokasis.kabupaten', 
            'lokasis.kecamatan', 
            'lokasis.kelurahan'
        ])->get();
        return view('admin.superadmin.guru.guru')->with('data', $gurus);
    }

    public function dashboard()
    {
        try {
            $dpl = Auth::user()->guru->mitra;

        } catch (\Throwable $th) {
            // Tangani kesalahan jika diperlukan
            $dpl = '';
        }


        $data = [
            'program' => $dpl,
            'mitra' => Auth::user()->guru->mitra()->latest()->first()
        ];

        return view('admin.pamong.dashboard_pamong')->with('data', $data);
    }


    public function review(Request $request, $id, $status)
    {
        // Ambil data daily berdasarkan ID
        $daily = DailyLog::find($id);

        if ($request->status === 'terima') {
            $daily->status = 'terima';
        } else {
            $daily->status = 'tolak';
        }
        if ($request->msg) {
            $daily->msg = $request->input('msg');
        } else {
            $daily->msg = '';
        }

        // Simpan perubahan ke dalam database
        $daily->save();

        // Redirect kembali ke weekly_review_dpl dengan weekly_log_id dari daily
        return redirect()->route('guru.daily.log', ['id' => $daily->weekly_log_id]);
    }


    public function getPesertaDetail($id)
    {
        // Ambil data peserta berdasarkan ID
        $peserta = ProgramTransaction::findOrFail($id);
        // Kembalikan tampilan detail peserta
        return view('admin.pamong.peserta_detail', ['peserta' => $peserta]);
    }

    public function programDetail(Request $request, $lowongan_id, )
    {
        // Ambil data peserta berdasarkan lowongan_id dan lokasi_id
        $mitra = MitraTransaction::where('lowongan_id', $lowongan_id)
            ->where('guru_id', Auth::user()->guru->id)
            ->first();

        if ($request->search) {
            $searchTerm = $request->input('search');
            $isAllNumber = is_numeric($searchTerm);
            // dd($isAllNumber); // Anda dapat menggunakan ini untuk debugging
            if ($isAllNumber) {
                // Jika nilai search adalah angka, cari berdasarkan NIM
                $peserta = $mitra->mahasiswa()->whereHas('mahasiswa', function ($query) use ($searchTerm) {
                    $query->where('nim', 'like', '%' . $searchTerm . '%');
                })->paginate(5);
            } else {
                // Jika nilai search bukan angka, cari berdasarkan nama
                $peserta = $mitra->mahasiswa()->whereHas('mahasiswa', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                })->paginate(5);
            }


        } else {
            // Jika tidak ada pencarian, ambil semua data mahasiswa yang terkait dengan DPL
            $peserta = $mitra->mahasiswa()->paginate(5);
        }

        $data = [
            'peserta' => $peserta,
            'mitra' => $mitra,
        ];

        return view('admin.pamong.program_details_pamong', compact('data'));
    }

    public function dailyBook($id)
    {
        $weeklyLog = WeeklyLog::find($id);
        return view('admin.pamong.daily_logbook_pamong')->with('data', $weeklyLog);
    }

    public function rancangan(Request $request, $id)
    {
        $peserta = ProgramTransaction::find($id);
        if ($request->status == 'terima') {
            $peserta->status_rancangan_pamong = 'terima';
        } else {
            $peserta->status_rancangan_pamong = 'tolak';
        }

        // Pastikan properti 'msg' ada dalam request sebelum mencoba mengaksesnya
        if ($request->msg) {
            $peserta->msg_pamong = $request->msg;
        } else {
            $peserta->msg_pamong = '';
        }
        $peserta->save();
        return redirect()->back();
    }

    public function dailyReview($id)
    {
        $weeklyLog = DailyLog::find($id);
        return view('admin.pamong.daily_review_pamong')->with('data', $weeklyLog);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::all();
        return view('admin.superadmin.guru.add')->with('data', $lokasi);
    }

    public function export()
    {
        return Excel::download(new MitraExport, 'mitra.xlsx');
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
            'nik' => 'required|unique:gurus',
            'name' => 'required',
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);
        $role = Role::where('slug', 'guru')->first();

        $user = User::create([
            'username' => $request->nik,
            'password' => bcrypt($request->nik),
            'role_id' => $role->id,
        ]);


        $guru = Guru::create([
            'nik' => $request->nik,
            'name' => $request->name,   
            'user_id' => $user->id,
        ]);

        foreach ($request->lokasi_id as $value) {
            $guru->lokasis()->attach($value);
        }

        return redirect()->route('admin.guru')
            ->with('success', 'Guru created successfully.');
    }

    public function import()
    {
        Excel::import(new GuruImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show(Guru $guru)
    {
        return view('gurus.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $lokasis = Lokasi::all(); // Fetch all Lokasi
    
        return view('admin.superadmin.guru.edit', compact('guru', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Retrieve the Guru instance by the provided id
        $guru = Guru::findOrFail($id);
    
        // Validate the input
        $request->validate([
            'nik' => 'required|unique:gurus,nik,' . $guru->id,
            'name' => 'required',
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);
    
        // Update the Guru's attributes
        $guru->update([
            'nik' => $request->nik,
            'name' => $request->name,
        ]);
    
        // Optionally update the associated User
        $guru->user->update([
            'username' => $request->nik,
            'password' => bcrypt($request->nik),
        ]);
    
        // Update the many-to-many relationship with Lokasi
        $guru->lokasis()->sync($request->lokasi_id);
    
        // Redirect with success message
        return redirect()->route('admin.guru')
            ->with('success', 'Guru updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('gurus.index')
            ->with('success', 'Guru deleted successfully');
    }
}
