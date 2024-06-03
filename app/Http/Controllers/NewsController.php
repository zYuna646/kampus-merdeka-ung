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
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id', // Asumsi ada tabel categories
        ]);

        // Membuat berita baru
        $news = News::create($validatedData);

        return response()->json($news, 201);
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
