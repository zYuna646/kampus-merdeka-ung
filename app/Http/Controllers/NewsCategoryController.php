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
        return view('admin.superadmin.category.category')->with('data', $categories);
    }

    public function create()
    {
        return view('admin.superadmin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Membuat slug dari name
        $slug = Str::slug($request->name);

        $existingSlug = CategoryNews::where('slug', $slug)
        ->exists();
        // Membuat kategori berita baru
        if ($existingSlug) {
            return redirect()->route('admin.kategori')
                ->with('error', 'Sudah ada nama yang sama');
        }
        
        CategoryNews::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.kategori')
        ->with('success', 'Dosen created successfully.');
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

    public function edit($id){
        $data = CategoryNews::find($id);
        return view('admin.superadmin.category.edit', compact('data'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = CategoryNews::find($id);
        // Validasi data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $slug = Str::slug($request->name);

        $existingSlug = CategoryNews::where('slug', $slug)->where('id', '!=', $category->id)->exists();

        if ($existingSlug) {
            return redirect()->route('admin.kategori')
                ->with('error', 'Sudah ada nama program yang sama');
        }
        // Mengupdate data kategori berita
        $category->update($request->all());
        $category->slug = Str::slug($request->name);

        return redirect()->route('admin.kategori')
        ->with('success', 'Studi updated successfully');
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
