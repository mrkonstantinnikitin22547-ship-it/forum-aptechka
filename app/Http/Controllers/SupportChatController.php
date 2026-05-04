<?php

namespace App\Http\Controllers;

use App\Models\SupportChat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class SupportChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = auth()->user();

        /*
        если у пользователя нет чата —
        создаем
        */
        $chat = SupportChat::firstOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'status' => 'open'
            ]
        );


        ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'sender_type' => 'user',
            'message' => $request->message
        ]);


        $chat->update([
            'last_message_at' => now()
        ]);


        return back()->with(
            'success',
            'Сообщение отправлено'
        );
    }
}