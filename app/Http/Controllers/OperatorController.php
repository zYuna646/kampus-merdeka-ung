<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Lowongan;
use App\Models\Program;
use App\Models\ProgramKampus;
use App\Models\ProgramTransaction;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WeeklyLog;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ViewErrorBag;// Asumsi kita memiliki model Operator

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data operator
        $role = Role::where('slug', 'operator')->first();
        $operators = User::where('role_id', $role->id)->get();
        return view('admin.superadmin.operator.operator')->with('data', $operators);
    }

    public function dashboard()
    {
        $program = ProgramKampus::all();
        $lowongan = Lowongan::all();
        $data = [
            'program' => $program,
            'lowongan' => $lowongan  
        ];
        return view('admin.operator.dashboard_operator')->with('data',$data);
    }

    public function weeklyLogbook($id)
    {
        $weeklyLog = WeeklyLog::find($id);
        return view('admin.operator.weekly_review_operator')->with('data', $weeklyLog);
    }

    public function getPesertaDetail($id)
    {
        try {
            // Attempt to find the ProgramTransaction with the given ID
            $peserta = ProgramTransaction::find($id);
            
            // Check if peserta is null (not found)
            if (!$peserta) {
                // Log an error message
                \Log::error("Peserta with ID $id not found");
                
                // Return a 404 response with an error message
                return response()->json(['message' => 'Peserta not found'], 404);
            }
    
            // Render the view and pass the peserta data
            return view('admin.operator.peserta_detail', ['peserta' => $peserta]);
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error('Error retrieving peserta details: ' . $e->getMessage());
            
            // Return a 500 response with an error message
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
    

    public function create()
    {
        return view('admin.superadmin.operator.add');
    }


    public function getLowongan($id)
    {
        $data = Lowongan::find($id);
        return view('admin.operator.program_detail', compact('data'));
}

    public function detail_lowongan($id)
    {
        $lowongan = Lowongan::find($id);
        $data = [
            'lowongan' => $lowongan,
            'lokasi' => Lokasi::where('program_id', $lowongan->program->id)->get(),
            'peserta' => $lowongan->programTransaction
        ];
        return view('admin.operator.detail_lowongan', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);

        $role = Role::where('slug', 'operator')->first();

        $operator = User::create([
            'username' => $validatedData['username'], // Menggunakan 'username' dari form
            'password' => bcrypt($validatedData['password']),
            'role_id' => $role->id
        ]);

        return redirect()->route('admin.operator')->with('success', 'Operator created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail operator berdasarkan ID
        $operator = User::findOrFail($id);

    }

    public function edit($id)
    {
        // Menampilkan detail operator berdasarkan ID
        $operator = User::findOrFail($id);
        return view('admin.superadmin.operator.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Cari operator berdasarkan ID
        $operator = User::findOrFail($id);

        // Update data operator
        $operator->username = $validatedData['username'];
        if ($validatedData['password'] != null) {
            $operator->password = bcrypt($validatedData['password']);
        }

        $operator->save();

        return redirect()->route('admin.operator')->with('success', 'Operator updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menghapus operator
        $operator = User::findOrFail($id);
        $operator->delete();
    }
}
