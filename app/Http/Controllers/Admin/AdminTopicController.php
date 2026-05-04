<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class AdminTopicController extends Controller
{
    public function index()
    {
        $topics = Topic::with('user')->latest()->get();

        return view('admin.topics.index', compact('topics'));
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('admin.topics')
            ->with('success', 'Тема удалена');
    }
}