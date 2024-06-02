<?php

namespace App\Http\Controllers;

use App\Imports\ProgramKampusImport;
use App\Models\ProgramKampus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


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
            'slug' => 'required|unique:program_kampuses',
        ]);

        ProgramKampus::create($request->all());

        return redirect()->route('program_kampuses.index')
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
    public function edit()
    {
        $program = ProgramKampus::all();
        dd($program);
        // return view('admin.superadmin.campus_merdeka_program.edit', compact('programKampus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramKampus  $programKampus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramKampus $programKampus)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:program_kampuses,slug,' . $programKampus->id,
        ]);

        $programKampus->update($request->all());

        return redirect()->route('program_kampuses.index')
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
