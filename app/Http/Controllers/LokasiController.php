<?php

namespace App\Http\Controllers;

use App\Exports\LokasiExport;
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
    public function index(Request $request)
{
    $query = Lokasi::query();

    // Apply filters
    if ($request->has('program') && !empty($request->program)) {
        $query->where('program_id', $request->program);
    }
    if ($request->has('provinsi') && !empty($request->provinsi)) {
        $query->where('provinsi_id', $request->provinsi);
    }
    if ($request->has('kabupaten') && !empty($request->kabupaten)) {
        $query->where('kabupaten_id', $request->kabupaten);
    }
    if ($request->has('kecamatan') && !empty($request->kecamatan)) {
        $query->where('kecamatan_id', $request->kecamatan);
    }
    if ($request->has('kelurahan') && !empty($request->kelurahan)) {
        $query->where('kelurahan_id', $request->kelurahan);
    }

    // Get filtered results
    $lokasis = $query->get();

    // Get distinct values for filters
    $programs = Lokasi::select('program_id')->distinct()->get();
    $provinsis = Lokasi::select('provinsi_id')->distinct()->get();
    $kabupatens = Lokasi::select('kabupaten_id')->distinct()->get();
    $kecamatans = Lokasi::select('kecamatan_id')->distinct()->get();
    $kelurahans = Lokasi::select('kelurahan_id')->distinct()->get();

    return view('admin.superadmin.location.location')->with([
        'data' => $lokasis,
        'programs' => $programs,
        'provinsis' => $provinsis,
        'kabupatens' => $kabupatens,
        'kecamatans' => $kecamatans,
        'kelurahans' => $kelurahans,
    ]);
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

    public function export(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        return Excel::download(new LokasiExport($data), 'lokasi.xlsx');
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
        ]);
       
        Lokasi::create([
            'program_id' => $request->program_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kabupaten_id' => $request->kabupaten_id,
            'provinsi_id' => $request->provinsi_id,
            'kelurahan_id' => $request->kelurahan_id,
            'name' => $request->name,
        ]);

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
    public function edit($id)
    {
        $lokasi = Lokasi::find($id);
        $program = ProgramKampus::all()->toArray(); // Mengubah koleksi menjadi array
        $data = [
            'program' => $program // Menyimpan array program dalam 'program' di dalam array $data
        ];
        return view('admin.superadmin.location.edit', compact('lokasi', 'data'));
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
            'name' => 'required',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('admin.location')
            ->with('success', 'Lokasi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Lokasi::find($id)->delete();

        return redirect()->route('admin.location')
            ->with('success', 'Lokasi deleted successfully');
    }
}
