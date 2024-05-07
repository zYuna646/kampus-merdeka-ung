<?php

namespace App\Http\Controllers;

use App\Imports\GuruImport;
use App\Models\DailyLog;
use App\Models\Guru;
use App\Models\Lokasi;
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
        $gurus = Guru::all();
        return view('admin.superadmin.guru.guru')->with('data', $gurus);

    }

    public function dashboard()
    {
        try {
            $dpl = Auth::user()->guru;
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
        }else
        {
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

    public function programDetail($lowongan_id, $lokasi_id)
    {
        // Ambil data peserta berdasarkan lowongan_id dan lokasi_id
        $peserta = ProgramTransaction::where('lowongan_id', $lowongan_id)
            ->where('lokasi_id', $lokasi_id)
            ->get();

        $data = [
            'peserta' => $peserta
        ];

        return view('admin.pamong.program_details_pamong', compact('data'));
    }

    public function dailyBook($id)
    {
        $weeklyLog = WeeklyLog::find($id);
        return view('admin.pamong.daily_logbook_pamong')->with('data', $weeklyLog);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus',
            'name' => 'required',
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);
        $role = Role::where('slug', 'guru')->first();

        $user = User::create([
            'username' => $request->nip,
            'password' => bcrypt($request->nip),
            'role_id' => $role->id,
        ]);


        $guru = Guru::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'user_id' => $user->id,
        ]);

        $guru->lokasis()->attach($request->input('lokasi_id'));

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
    public function edit(Guru $guru)
    {
        return view('gurus.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'name' => 'required',
            'lokasi_id' => 'required|exists:lokasis,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $guru->update($request->all());

        return redirect()->route('gurus.index')
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
