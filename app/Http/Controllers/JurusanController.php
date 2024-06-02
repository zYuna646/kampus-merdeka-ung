<?php

namespace App\Http\Controllers;

use App\Imports\JurusanImport;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Fakultas;
use Illuminate\Support\Str;


class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('admin.superadmin.departement.departement')->with('data', $jurusans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $fakultases = Fakultas::all();
        return view('admin.superadmin.departement.add', compact('fakultases'));
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
            'code' => 'required|unique:jurusans',
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        Jurusan::create([
            'name' => $request->name,
            'code' => $request->code,
            'fakultas_id' => $request->fakultas_id,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.departement')
            ->with('success', 'Jurusan created successfully.');
    }

    public function import()
    {
        Excel::import(new JurusanImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function show(Jurusan $jurusan)
    {
        return view('jurusans.show', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jurusan = Jurusan::find($id);
        $fakultases = Fakultas::all();
        return view('admin.superadmin.departement.edit', compact('jurusan', 'fakultases'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::find($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:jurusans',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);
    
        $jurusan->update($request->all());
        $jurusan->slug = Str::slug($request->name);
        return redirect()->route('admin.departement')
            ->with('success', 'Jurusan updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('jurusans.index')
            ->with('success', 'Jurusan deleted successfully');
    }
}
