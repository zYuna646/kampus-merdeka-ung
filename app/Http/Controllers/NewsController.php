<?php

namespace App\Http\Controllers;

use App\Models\CategoryNews;
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

    public function news()
    {
        $news = News::all();
        return view('')->with('data', $news);
    }

    public function showNews($id)
    {
        $news = News::find($id);
        return view('')->with('data', $news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'gambar' => 'required',
            'content' => 'required',
        ]);
    
        

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('cover', 'public');
        }

        News::create([
            'title' => $request->judul,
            'content' => $request->content,
            'cover' => $path,
            'category_id' => $request->kategori,
        ]);
    
        
        return redirect()->route('admin.berita')
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
        $category = CategoryNews::all();
        return view('admin.superadmin.news.add')->with('data', $category);
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

        return redirect()->route('admin.berita')->with('success', 'Berita deleted successfully');
    }
}
