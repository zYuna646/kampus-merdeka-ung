<?php

namespace App\Http\Controllers;

use App\Imports\StudiImport;
use App\Models\Studi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Jurusan;
use Illuminate\Support\Str;



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
        $jurusans = Jurusan::all();
        return view('admin.superadmin.study_program.add', compact('jurusans'));
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
            'code' => 'required|unique:studis',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        Studi::create([
            'name' => $request->name,
            'code' => $request->code,
            'jurusan_id' => $request->jurusan_id,
            'slug' => Str::slug($request->name),
        ]);

    return redirect()->route('admin.study_program')
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
    public function edit($id)
    {
        $studi = Studi::find($id);
        $jurusans = Jurusan::all();
        return view('admin.superadmin.study_program.edit', compact('studi', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Studi  $studi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $studi = Studi::find($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $studi->update($request->all());
        $studi->slug = Str::slug($request->name);
        return redirect()->route('admin.study_program')
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
