<?php

namespace App\Http\Controllers;

use App\Imports\StudiImport;
use App\Models\Studi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Jurusan;


class StudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studis = Studi::all();
        return view('admin.superadmin.study_program.study_program')->with('data', $studis);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jurusan = Jurusan::all()->toArray();
        $data = [
            'jurusan' => $jurusan
        ];
        return view('admin.superadmin.study_program.add')->with('data', $data);
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
            'name' => 'required',
            'slug' => 'required|unique:studis',
            'code' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        Studi::create($request->all());

        return redirect()->route('studis.index')
            ->with('success', 'Studi created successfully.');
    }

    public function import()
    {
        Excel::import(new StudiImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Studi  $studi
     * @return \Illuminate\Http\Response
     */
    public function show(Studi $studi)
    {
        return view('studis.show', compact('studi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Studi  $studi
     * @return \Illuminate\Http\Response
     */
    public function edit(Studi $studi)
    {
        return view('studis.edit', compact('studi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Studi  $studi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Studi $studi)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:studis,slug,' . $studi->id,
            'code' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $studi->update($request->all());

        return redirect()->route('studis.index')
            ->with('success', 'Studi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Studi  $studi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Studi $studi)
    {
        $studi->delete();

        return redirect()->route('studis.index')
            ->with('success', 'Studi deleted successfully');
    }
}
