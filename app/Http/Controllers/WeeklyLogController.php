<?php

namespace App\Http\Controllers;

use App\Models\WeeklyLog;
use Illuminate\Http\Request;

class WeeklyLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weeklyLogs = WeeklyLog::all();
        return view('weekly_logs.index', compact('weeklyLogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('weekly_logs.create');
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
            'program_transaction_id' => 'required|exists:program_transactions,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'desc' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'msg' => 'nullable',
            'status' => 'nullable',
        ]);

        WeeklyLog::create($request->all());

        return redirect()->route('weekly_logs.index')
            ->with('success', 'WeeklyLog created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeeklyLog  $weeklyLog
     * @return \Illuminate\Http\Response
     */
    public function show(WeeklyLog $weeklyLog)
    {
        return view('weekly_logs.show', compact('weeklyLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeeklyLog  $weeklyLog
     * @return \Illuminate\Http\Response
     */
    public function edit(WeeklyLog $weeklyLog)
    {
        return view('weekly_logs.edit', compact('weeklyLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeeklyLog  $weeklyLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeeklyLog $weeklyLog)
    {
        $request->validate([
            'program_transaction_id' => 'required|exists:program_transactions,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'desc' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'msg' => 'nullable',
            'status' => 'nullable',
        ]);

        $weeklyLog->update($request->all());

        return redirect()->route('weekly_logs.index')
            ->with('success', 'WeeklyLog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeeklyLog  $weeklyLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeeklyLog $weeklyLog)
    {
        $weeklyLog->delete();

        return redirect()->route('weekly_logs.index')
            ->with('success', 'WeeklyLog deleted successfully');
    }
}
