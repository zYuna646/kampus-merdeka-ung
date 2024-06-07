<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Operator; 
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
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $role = Role::where('slug', 'operator')->first();

        // Membuat operator baru
        $operator = User::create([
            'name' => $validatedData['name'],
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'password' => 'string|min:6',
        ]);

        // Mengupdate data operator
        $operator = User::findOrFail($id);
        $operator->update($validatedData);

        if ($request->has('password')) {
            $operator->password = bcrypt($request->password);
            $operator->save();
        }

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
