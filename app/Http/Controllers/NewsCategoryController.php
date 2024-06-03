<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CategoryNews; // Asumsi kita memiliki model CategoryNews

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data kategori berita
        $categories = CategoryNews::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Membuat slug dari name
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Membuat kategori berita baru
        $category = CategoryNews::create($validatedData);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail kategori berita berdasarkan ID
        $category = CategoryNews::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        // Mengupdate data kategori berita
        $category = CategoryNews::findOrFail($id);
        
        if ($request->has('name')) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $category->update($validatedData);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menghapus kategori berita
        $category = CategoryNews::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}
