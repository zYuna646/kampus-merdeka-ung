<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;

class DailyLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyLogs = DailyLog::all();
        return view('daily_logs.index', compact('dailyLogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('daily_logs.create');
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
            'date' => 'required|date',
            'msg' => 'nullable',
            'status' => 'required|in:completed,pending',
        ]);

        DailyLog::create($request->all());

        return redirect()->route('daily_logs.index')
            ->with('success', 'Daily Log created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyLog  $dailyLog
     * @return \Illuminate\Http\Response
     */
    public function show(DailyLog $dailyLog)
    {
        return view('daily_logs.show', compact('dailyLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyLog  $dailyLog
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyLog $dailyLog)
    {
        return view('daily_logs.edit', compact('dailyLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyLog  $dailyLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyLog $dailyLog)
    {
        $request->validate([
            'program_transaction_id' => 'required|exists:program_transactions,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'desc' => 'required',
            'date' => 'required|date',
            'msg' => 'nullable',
            'status' => 'required|in:completed,pending',
        ]);

        $dailyLog->update($request->all());

        return redirect()->route('daily_logs.index')
            ->with('success', 'Daily Log updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyLog  $dailyLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyLog $dailyLog)
    {
        $dailyLog->delete();

        return redirect()->route('daily_logs.index')
            ->with('success', 'Daily Log deleted successfully');
    }
}
