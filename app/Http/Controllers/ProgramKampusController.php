<?php

namespace App\Http\Controllers;

use App\Imports\ProgramKampusImport;
use App\Models\ProgramKampus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;



class ProgramKampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programKampuses = ProgramKampus::all();
        return view('admin.superadmin.campus_merdeka_program.campus_merdeka_program')->with('data', $programKampuses);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.superadmin.campus_merdeka_program.add');
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
            'code' => 'required|unique:program_kampuses',
        ]);

        ProgramKampus::create([
            'name' => $request->name,
            'code' => $request->code,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.campus_merdeka_program')
            ->with('success', 'ProgramKampus created successfully.');
    }

    public function import()
    {
        Excel::import(new ProgramKampusImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramKampus  $programKampus
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramKampus $programKampus)
    {
        return view('program_kampuses.show', compact('programKampus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramKampus  $programKampus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = ProgramKampus::find($id);
        return view('admin.superadmin.campus_merdeka_program.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramKampus  $programKampus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $programKampus = ProgramKampus::find($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:program_kampuses,code,' . $programKampus->code,
        ]);

        $programKampus->update($request->all());
        $programKampus->slug=Str::slug($request->name);
        return redirect()->route('admin.campus_merdeka_program')
            ->with('success', 'ProgramKampus updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramKampus  $programKampus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramKampus $programKampus)
    {
        $programKampus->delete();

        return redirect()->route('program_kampuses.index')
            ->with('success', 'ProgramKampus deleted successfully');
    }
}
