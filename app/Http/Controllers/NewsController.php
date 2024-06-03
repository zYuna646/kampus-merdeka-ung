<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News; // Asumsi kita memiliki model News

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data berita
        $news = News::all();
        return view('admin.superadmin.news.news')->with('data', $news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'judul' => 'required|unique:dosens',
            'kategori' => 'required',
            'gambar' => 'required|exists:studis,id',
            'content' => 'required|exists:studis,id',
        ]);


        Dosen::create([
            'judul' => $request->nidn,
            'kategori' => $request->name,
            'gambar' => $request->name,
            'content' => $request->studi_id,
        ]);
        
        return redirect()->route('admin.dosen')
            ->with('success', 'Dosen created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail berita berdasarkan ID
        $news = News::findOrFail($id);
        return response()->json($news);
    }

    public function create()
    {
        return view('admin.superadmin.news.add');
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|integer|exists:categories,id', // Asumsi ada tabel categories
        ]);

        // Mengupdate data berita
        $news = News::findOrFail($id);
        $news->update($validatedData);

        return response()->json($news);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menghapus berita
        $news = News::findOrFail($id);
        $news->delete();

        return response()->json(null, 204);
    }
}
