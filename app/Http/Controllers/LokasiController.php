<?php

namespace App\Http\Controllers;

use App\Imports\LokasiImport;
use App\Models\Lokasi;
use App\Models\ProgramKampus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasis = Lokasi::all();
        return view('admin.superadmin.location.location')->with('data', $lokasis);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = ProgramKampus::all()->toArray(); // Mengubah koleksi menjadi array
        $data = [
            'program' => $program // Menyimpan array program dalam 'program' di dalam array $data
        ];
        return view('admin.superadmin.location.add')->with('data', $data); // Mengirimkan array $data ke view
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
            'program_id' => 'required|exists:program_kampuses,id',
            'kecamatan_id' => 'required',
            'kabupaten_id' => 'required',
            'provinsi_id' => 'required',
            'kelurahan_id' => 'required',
            'name' => 'required',
            'lokasi' => 'required',
        ]);
        $data = $request->all();
        Lokasi::create($data);

        return redirect()->route('admin.location')->with('success', 'Lokasi created successfully.');
    }

    public function import()
    {
        Excel::import(new LokasiImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function show(Lokasi $lokasi)
    {
        return view('lokasis.show', compact('lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Lokasi $lokasi)
    {
        return view('lokasis.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'program_id' => 'required|exists:program_kampuses,id',
            'kecamatan_id' => 'required',
            'kabupaten_id' => 'required',
            'provinsi_id' => 'required',
            'lokasi' => 'required',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('lokasis.index')
            ->with('success', 'Lokasi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return redirect()->route('lokasis.index')
            ->with('success', 'Lokasi deleted successfully');
    }
}
