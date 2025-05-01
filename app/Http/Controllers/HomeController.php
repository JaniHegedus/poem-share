<?php
namespace App\Http\Controllers;
use App\Models\Poem;

class HomeController extends Controller
{
    public function index()
    {
        $poems = Poem::public()->latest()->take(5)->get();

        return view('home', compact('poems'));
    }
}
