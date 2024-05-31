<?php

namespace App\Http\Controllers;

use App\Imports\FakultasImport;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fakultases = Fakultas::all();
        return view('admin.superadmin.faculties.faculties')->with('data', $fakultases);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.superadmin.faculties.add');
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
            'slug' => 'required|unique:fakultases',
            'code' => 'required|unique:fakultases',
        ]);

        Fakultas::create($request->all());

        return redirect()->route('fakultases.index')
            ->with('success', 'Fakultas created successfully.');
    }

    public function import()
    {
        Excel::import(new FakultasImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fakultas  $fakultas
     * @return \Illuminate\Http\Response
     */
    public function show(Fakultas $fakultas)
    {
        return view('fakultases.show', compact('fakultas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fakultas  $fakultas
     * @return \Illuminate\Http\Response
     */
    public function edit(Fakultas $fakultas)
    {
        return view('fakultases.edit', compact('fakultas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fakultas  $fakultas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fakultas $fakultas)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:fakultases,slug,' . $fakultas->id,
            'code' => 'required|unique:fakultases,code,' . $fakultas->id,
        ]);

        $fakultas->update($request->all());

        return redirect()->route('fakultases.index')
            ->with('success', 'Fakultas updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fakultas  $fakultas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fakultas $fakultas)
    {
        $fakultas->delete();

        return redirect()->route('fakultases.index')
            ->with('success', 'Fakultas deleted successfully');
    }
}
