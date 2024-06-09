<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Program;
use App\Models\ProgramKampus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function create()
    {
        return view('admin.superadmin.operator.add');
    }


    public function getLowongan($id)
    {
        $data = Lowongan::find($id);
        return view('admin.operator.program_detail', compact('data'));
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
