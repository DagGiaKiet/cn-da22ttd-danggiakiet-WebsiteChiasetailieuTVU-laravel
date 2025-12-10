<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->take(8)->get();
        $blogs = Blog::latest()->take(5)->get();
        return view('welcome', compact('documents', 'blogs'));
    }
}
