<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\TopicReply;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function store(Request $request, $replyId)
    {
        $reply = TopicReply::findOrFail($replyId);

        Complaint::create([
            'from_user_id' => auth()->id(),
            'to_user_id'   => $reply->user_id,
            'reply_id'     => $reply->id,
            'reason'       => $request->reason,
        ]);

        return back()->with('success', 'Жалоба отправлена');
    }
}
