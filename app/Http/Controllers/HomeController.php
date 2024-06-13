<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\news;
use App\Models\ProgramKampus;
use Illuminate\Http\Request;
use App\Models\CategoryNews;

class HomeController extends Controller
{
    public function home()
    {
        $latestNews = news::orderBy('created_at', 'desc')->take(3)->get(); // Fetch 3 latest news items
        return view('landing.home')->with('latestNews', $latestNews);
    }

    public function berita()
    {
        $newsByTitle = news::orderBy('title', 'asc')->get();
        $latestNews = news::orderBy('created_at', 'desc')->take(5)->get(); // You can adjust the number of latest news items

        return view('landing.news')
            ->with('newsByTitle', $newsByTitle)
            ->with('latestNews', $latestNews);
    }

    public function lowongan()
    {
        $currentDate = now();
        $data = Lowongan::where('pendaftaran_mulai', '<=', $currentDate)
            ->where('pendaftaran_selesai', '>=', $currentDate)
            ->get();
        
        
        $latestPrograms = Lowongan::where('pendaftaran_mulai', '<=', $currentDate)
            ->where('pendaftaran_selesai', '>=', $currentDate)
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal pembuatan terbaru
            ->take(3) // Ambil 3 program terbaru
            ->get();

        return view('landing.programs')->with(['data' => $data, 'latestPrograms' => $latestPrograms]);
    }
    

    public function detail_lowongan($id)
    {
        $data = Lowongan::find($id);
        return view('landing.detail_news', compact('data'));
    }

    public function infografis()
    {
        $data = [
            'program' => ProgramKampus::all(),
        ];
        return view('landing.infographic')->with('data', $data);
    }

    public function detail_news($id)
    {
        $data = news::find($id);
        $latestNews = news::orderBy('created_at', 'desc')->take(5)->get();
        return view('landing.detail_news')
            ->with('data', $data)
            ->with('latestNews', $latestNews);
    }

    public function program()
    {
        return view('landing.programs');
    }

    public function showNews($id)
    {
        $data = news::find($id);
        $latestNews = news::orderBy('created_at', 'desc')->take(5)->get();
        return view('landing.detail_news')
            ->with('data', $data)
            ->with('latestNews', $latestNews);
    }
    public function newsByCategory($category)
    {
        $category = CategoryNews::where('name', $category)->firstOrFail();
        $news = $category->news()->get();
        $latestNews = news::orderBy('created_at', 'desc')->take(5)->get();
        return view('landing.news_by_category')->with('data', $news)->with('category', $category)  ->with('latestNews', $latestNews);;
    }
}
