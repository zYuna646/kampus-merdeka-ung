<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Program;
use App\Models\ProgramKampus;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lowongans = Lowongan::all();
        return view('admin.superadmin.lowongan.lowongan')->with('data', $lowongans);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = ProgramKampus::all();
        $data = [
            'program' => $program,
        ];
        return view('admin.superadmin.lowongan.add')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'program_id' => 'required|exists:program_kampuses,id',
            'tahun_akademik' => 'required',
            'semester' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'pendaftaran_mulai' => 'required|date',
            'pendaftaran_selesai' => 'required|date',
            'isLogBook' => 'required'
        ]);

        $existingLowongan = Lowongan::where('program_id', $request->program_id)
            ->where('tahun_akademik', $request->tahun_akademik)
            ->where('semester', $request->semester)
            ->first();

        if ($existingLowongan) {
            return redirect()->route('admin.lowongan')
                ->with('failded', 'Lowongan Sudah Ada.');
        }


        Lowongan::create([
            'program_id' => $request->program_id,
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'pendaftaran_mulai'=> $request->pendaftaran_mulai,
            'pendaftaran_selesai'=> $request->pendaftaran_selesai,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai'=>$request->tanggal_selesai,
            'isLogBook'=>$request->isLogBook,
        ]);

        return redirect()->route('admin.lowongan')
            ->with('success', 'Lowongan created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function show(Lowongan $lowongan)
    {
        return view('lowongans.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = ProgramKampus::all();
        $data = [
            'program' => $program,
            'lowongan' => Lowongan::find($id),
        ];
        $lowongan = Lowongan::find($id);
        return view('admin.superadmin.lowongan.edit', compact('lowongan', 'data'));
    }

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'program_id' => 'required|exists:program_kampuses,id',
            'tahun_akademik' => 'required',
            'semester' => 'required',
            'pendaftaran_mulai' => 'required|date',
            'pendaftaran_selesai' => 'required|date',
        ]);

        $lowongan = Lowongan::find($id);
        $lowongan->program_id = $request->program_id;
        $lowongan->semester = $request->semester;
        $lowongan->tahun_akademik = $request->tahun_akademik;
        $lowongan->tanggal_mulai = $request->pendaftaran_mulai;
        $lowongan->tanggal_selesai = $request->pendaftaran_selesai;
        $lowongan->save();
        return redirect()->route('admin.lowongan')
            ->with('success', 'Lowongan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lowongan::find($id)->delete();
        return redirect()->route('admin.lowongan')
            ->with('success', 'Lowongan deleted successfully');
    }
}
