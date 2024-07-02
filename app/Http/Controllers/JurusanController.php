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
    public function index(Request $request)
    {
        $query = Jurusan::query();

        if ($request->has('fakultas') && !empty($request->fakultas)) {
            $query->whereHas('fakultas', function($q) use ($request) {
                $q->where('id', $request->fakultas);
            });
        }

        $jurusans = $query->get();

        // Mengambil data fakultas untuk dropdown filter
        $fakultas = Fakultas::all();

        return view('admin.superadmin.departement.departement')->with([
            'data' => $jurusans,
            'fakultas' => $fakultas,
            'selectedFakultas' => $request->fakultas
        ]);
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

        $slug = Str::slug($request->name);

        // Check if the slug already exists and belongs to a different record
        $existingSlug = Jurusan::where('slug', $slug)
            ->exists();

        // If the slug exists, return with an error
        if ($existingSlug) {
            return redirect()->route('admin.departement')
                ->with('error', 'Sudah ada nama yang sama');
        }

        Jurusan::create([
            'name' => $request->name,
            'code' => $request->code,
            'fakultas_id' => $request->fakultas_id,
            'slug' => $slug,
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
            'code' => 'required|unique:jurusans,code,' . $jurusan->id,
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $slug = Str::slug($request->name);
    
        // Check if the slug already exists and belongs to a different record
        $existingSlug = Jurusan::where('slug', $slug)
                                      ->where('id', '!=', $jurusan->id)
                                      ->exists();
    
        // If the slug exists, return with an error
        if ($existingSlug) {
            return redirect()->route('admin.departement')
                ->with('error', 'Sudah ada nama program yang sama');
        }

    
        $jurusan->update($request->except('slug'));
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
    public function destroy($id)
    {
        Jurusan::find($id)->delete(); 

        return redirect()->route('admin.departement')
            ->with('success', 'Jurusan deleted successfully');
    }
}
