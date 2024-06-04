<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News; 
use Illuminate\Support\Facades\Storage;// Asumsi kita memiliki model News

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
        
        $validatedData = $request->validate([
            'judul' => 'required|unique:dosens',
            'kategori' => 'required',
            'gambar' => 'required|exists:category_news,id',
            'content' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('cober', 'public');
            $validatedData['gambar'] = $path;
        }

        News::create([
            'title' => $validatedData['judul'],
            'content' => $validatedData['content'],
            'cover' => $validatedData['gambar'],
            'category_id' => $validatedData['category_id'],
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
            'gambar' => 'required|exists:category_news,id',
            'kategori' => 'required|exists:category_news,id', // Asumsi ada tabel categories
        ]);

        // Mengupdate data berita
        $news = News::findOrFail($id);
        if ($request->hasFile('gambar')) {
            // Menghapus gambar cover lama
            if ($news->cover_image) {
                Storage::disk('public')->delete($news->cover);
            }

            $path = $request->file('gambar')->store('cover', 'public');
            $validatedData['gambar'] = $path;
            $news->cover = $path;
        }

        $news->update([
            'title' => $validatedData['judul'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
        ]);

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
