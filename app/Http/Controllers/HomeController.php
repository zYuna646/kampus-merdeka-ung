<?php

namespace App\Http\Controllers;

use App\Models\news;
use App\Models\ProgramKampus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $data = [
            'news' => news::first(),
        ];
        return view('landing.home')->with('data', $data);
    }

    public function berita()
    {
        return view('landing.news')->with('data', news::all());
    }

    public function infografis()
    {
        $data = [
            'program' => ProgramKampus::all(),
        ];
        return view('landing.infographic')->with('data' , $data);     
    }

    public function detail_news($id)
    {
        $data = news::find($id);
        return view('landing.detail_news', compact('data'));
    }

    public function program()
    {
        return view('landing.programs');
    }

    public function showNews($id)
    {
        $data = News::findOrFail($id); // Ambil berita berdasarkan ID yang diberikan

        return view('landing.detail_news', compact('data'));
    }
}
