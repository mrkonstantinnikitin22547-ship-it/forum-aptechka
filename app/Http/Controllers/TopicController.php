<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $topics = Topic::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->appends($request->all());

        return view('topics.index', compact('topics'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:55'],
            'content' => ['nullable', 'string'],
        ]);

        $topic = Topic::create([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'user_id' => auth()->id(),
        ]);

        $cardHtml = view('partials.topic_card', [
            'topic' => $topic,
            'members' => 0,
            'category' => 'Проблемы/вопросы',
            'desc' => "Обсуждение проблем и вопросов связанных с " . mb_strtolower($topic->title) . "..."
        ])->render();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'topic_id' => $topic->id,
                'redirect_url' => route('topics.show', $topic),
                'card_html' => $cardHtml,
            ]);
        }

        return redirect()->route('topics.show', $topic);
    }

    public function show(Topic $topic)
    {
        if (auth()->check()) {
            $userId = auth()->id();

            $alreadyViewed = DB::table('topic_views')
                ->where('topic_id', $topic->id)
                ->where('user_id', $userId)
                ->exists();

            if (!$alreadyViewed) {
                DB::table('topic_views')->insert([
                    'topic_id' => $topic->id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $topic->increment('views_count');
            }
        }

        $topic->load([
            'user',
            'replies.user',
            'replies.attachments',
        ])->loadCount('replies');

        return view('topics.show', compact('topic'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $topics = Topic::query()
            ->with('user')
            ->where(function ($qBuilder) use ($query) {
                $qBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");

                $qBuilder->orWhereHas('user', function ($userQuery) use ($query) {
                    $userQuery->where('name', 'like', "%{$query}%");
                });

                $qBuilder->orWhereHas('replies', function ($replyQuery) use ($query) {
                    $replyQuery->where('body', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('pages.search', compact('topics', 'query'));
    }
}