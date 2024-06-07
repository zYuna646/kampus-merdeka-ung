<?php

namespace App\Http\Controllers;

use App\Imports\DPLImport;
use App\Models\Dosen;
use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\ProgramTransaction;
use Illuminate\Http\Request;
use App\Models\DPL;
use Maatwebsite\Excel\Facades\Excel;


class DPLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dpls = DPL::all();
        return view('admin.superadmin.dpl.dpl')->with('data', $dpls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::all();
        $dosen = Dosen::all();
        $dosen = Dosen::all();
        $lowongan = Lowongan::all();

        $data = [
            'lokasi' => $lokasi,
            'dosen' => $dosen,
            'program' => $lowongan 
        ];
        return view('admin.superadmin.dpl.add')->with('data', $data);;
    }
    public function import()
    {
        Excel::import(new DPLImport, request()->file('file'));

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
            'dosen_id' => 'required',
            'lowongan_id' => 'required',
            'mahasiswa'=> 'required',
        ]);

        $isDpl = DPL::where('dosen_id', $request->dosen_id)->where('lowongan_id', $request->lowongan_id)->first();
        if ($isDpl) {
            return redirect()->route('admin.dpl')->with('error', 'DPL Sudah Ada.');
        }
        $dpl = DPL::create([
            'dosen_id' => $request->dosen_id,
            'lowongan_id' => $request->lowongan_id,
        ]);
        foreach ($request->mahasiswa as $key => $value) {
            $dpl->mahasiswa()->attach($value);
        }
        // Attach multiple locations
        return redirect()->route('admin.dpl')->with('success', 'DPL created successfully.');
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
        $dosen = Dosen::all();
        $data = [
            'lokasi' => $lokasi,
            'dosen' => $dosen
        ];
        $dpl = DPL::find($id);
        $data = [
            'dpl' => $dpl,
            'dosen' => Dosen::all(),
            'mahasiswa' => ProgramTransaction::where('lowongan_id', $dpl->lowongan->id)->get(),
            'lokasi' => Lokasi::all(),
            'lowongan' => Lowongan::all(),
            'program' => Lowongan::all(),
        ];
        return view('admin.superadmin.dpl.edit')->with('data', $data);
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
        $dpl = DPL::find($id);
        $dpl->mahasiswa()->detach();
        foreach ($request->mahasiswa as $key => $value) {
            $dpl->mahasiswa()->attach($value);
        }
        return redirect()->route('admin.dpl')
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
        DPL::find($id)->delete();
        return redirect()->route('admin.dpl')
            ->with('success', 'DPL deleted successfully');
    }
}
