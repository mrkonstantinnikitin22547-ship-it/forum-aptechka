<?php

namespace App\Http\Controllers;

use App\Models\ReplyLike;
use Illuminate\Http\Request;

class ReplyLikeController extends Controller
{
    public function toggle($replyId)
    {
        $user = auth()->user();

        $like = ReplyLike::where('reply_id', $replyId)
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'liked' => false,
                'count' => ReplyLike::where('reply_id', $replyId)->count()
            ]);
        }

        ReplyLike::create([
            'reply_id' => $replyId,
            'user_id' => $user->id
        ]);

        return response()->json([
            'liked' => true,
            'count' => ReplyLike::where('reply_id', $replyId)->count()
        ]);
    }
}
