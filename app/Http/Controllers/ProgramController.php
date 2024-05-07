<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('programs.create');
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
            'kegiatan' => 'required',
            'program_kampus_id' => 'required|exists:program_kampuses,id',
            'studi_id' => 'required|exists:studis,id',
            'sop_pob' => 'required', // Adjust validation rules according to your needs
        ]);

        Program::create($request->all());

        return redirect()->route('programs.index')
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required',
            'kegiatan' => 'required',
            'program_kampus_id' => 'required|exists:program_kampuses,id',
            'studi_id' => 'required|exists:studis,id',
            'sop_pob' => 'required', // Adjust validation rules according to your needs
        ]);

        $program->update($request->all());

        return redirect()->route('programs.index')
            ->with('success', 'Program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully');
    }
}
