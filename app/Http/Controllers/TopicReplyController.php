<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\TopicReply;
use App\Models\TopicReplyAttachment;
use Illuminate\Http\Request;

class TopicReplyController extends Controller
{
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'body' => ['required', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,txt,zip,rar',
            ],
        ]);

        $reply = TopicReply::create([
            'user_id' => auth()->id(),
            'topic_id' => $topic->id,
            'body' => $request->body,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');

                TopicReplyAttachment::create([
                    'topic_reply_id' => $reply->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                ]);
            }
        }

        return back();
    }
}