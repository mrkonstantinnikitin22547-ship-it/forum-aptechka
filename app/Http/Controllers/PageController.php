<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function topics()
{
    $topics = \App\Models\Topic::query()
        ->with('user')
        ->withCount('replies')
        ->orderByDesc('id')
        ->get();

    $popularTopics = \App\Models\Topic::query()
        ->with('user')
        ->withCount('replies')
        ->orderByDesc('views_count')
        ->orderByDesc('id')
        ->take(3)
        ->get();

    return view('pages.topics', compact('topics', 'popularTopics'));
}

    public function about()
    {
        return view('pages.about');
    }

    public function support()
    {
        return view('pages.support');
    }
}
