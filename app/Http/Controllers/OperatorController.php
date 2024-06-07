<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
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
        $program = Lowongan::all();
    }

    public function create()
    {
        return view('admin.superadmin.operator.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
    
        $role = Role::where('slug', 'operator')->first();
    
        // Membuat operator baru
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
            'username' => 'required|string|max:255',
            'old_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        // Cari operator berdasarkan ID
        $operator = User::findOrFail($id);
    
        // Update data operator
        $operator->username = $validatedData['username'];
    
        // Jika password lama diisi, periksa kesesuaiannya
        if (!empty($validatedData['old_password'])) {
            if (!Hash::check($validatedData['old_password'], $operator->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak cocok.']);
            }
    
            // Jika password lama cocok, update password baru
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
