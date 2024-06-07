<?php

namespace App\Http\Controllers;

use App\Imports\PamongImport;
use App\Models\Dosen;
use App\Models\Guru;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\MitraTransaction;
use App\Models\ProgramTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class PamongController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dpls = MitraTransaction::all();
        return view('admin.superadmin.pamong.pamong')->with('data', $dpls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::all();

        $data = [
            'lokasi' => $lokasi,
            'pamong' => Guru::all(),
            'program' => Lowongan::all(),
        ];
        return view('admin.superadmin.pamong.add')->with('data', $data);;
    }
    public function import()
    {
        Excel::import(new PamongImport, request()->file('file'));

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
        // Validate the request...
        $request->validate([
            'pamong_id' => 'required',
            'lowongan_id' => 'required',
            'mahasiswa'=> 'required',
        ]);
        $isDpl = MitraTransaction::where('guru_id', $request->pamong_id)->where('lowongan_id', $request->lowongan_id)->first();
        if ($isDpl) {
            return redirect()->route('admin.pamong')->with('error', 'Pamong Sudah Ada.');
        }
        $pamong = MitraTransaction::create([
            'guru_id'=> $request->pamong_id,
            'lowongan_id' => $request->lowongan_id,
        ]);
        foreach ($pamong as $key => $value) {
            $pamong->mahasiswa()->attach($value);
        }

        // Attach multiple locations

        return redirect()->route('admin.pamong')->with('success', 'Pamong created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function show(DPL $dpl)
    {
        return view('dpls.show', compact('dpl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasi = Lokasi::all();
        $pamong = MitraTransaction::find( $id );
        $lokasiIds = $pamong->guru->lokasis->pluck('id'); // Assuming 'lokasis' is the relationship between Guru and Lokasi
        $mahasiswa = ProgramTransaction::whereIn('lokasi_id', $lokasiIds)->get();

        $data = [
            'lokasi' => $lokasi,
            'pamong' => $pamong,
            'mahasiswa' => $mahasiswa
        ];
        return view('admin.superadmin.pamong.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'mahasiswa' => 'required',
        ]);
        $pamong = MitraTransaction::find( $id );
        $pamong->mahasiswa()->detach();
        foreach ($request->mahasiswa as $key => $value) {
            $pamong->mahasiswa()->attach( $value );
        }

        return redirect()->route('admin.pamong')
            ->with('success', 'DPL updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        return redirect()->route('dpls.index')
            ->with('success', 'DPL deleted successfully');
    }
}
