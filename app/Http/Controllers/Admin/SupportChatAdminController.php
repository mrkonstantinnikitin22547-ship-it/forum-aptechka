<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportChat;
use App\Models\ChatMessage;

class SupportChatAdminController extends Controller
{
    public function index()
    {
        $chats = SupportChat::with(['user', 'messages'])
            ->orderByDesc('last_message_at')
            ->get();

        return view('admin.support.index', compact('chats'));
    }

    public function show($id)
    {
        $chat = SupportChat::with('user')->findOrFail($id);

        $messages = ChatMessage::where('chat_id', $chat->id)
            ->orderBy('created_at', 'asc') 
            ->get();

        return view('admin.support.chat', compact('chat', 'messages'));
    }
    public function send(Request $request, SupportChat $chat)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => auth()->id(),
            'sender_type' => 'admin',
            'message' => $request->message
        ]);

        $chat->update([
            'last_message_at' => now()
        ]);

        return redirect()->route('admin.support.show', $chat->id);
    }
}
