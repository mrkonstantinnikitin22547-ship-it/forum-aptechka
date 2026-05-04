<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\SupportChat;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home')
                ->with('error', 'Сначала войдите в систему');
        }

        $user = Auth::user();

        // 📌 темы пользователя
        $topics = Topic::query()
            ->where('user_id', $user->id)
            ->orWhereHas('replies', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest('updated_at')
            ->distinct()
            ->limit(5)
            ->get();

        // 💬 ЧАТ ПОДДЕРЖКИ
        $chat = SupportChat::where('user_id', $user->id)->first();

        $messages = [];

        if ($chat) {
            $messages = ChatMessage::where('chat_id', $chat->id)
                ->orderBy('created_at', 'asc') // 🔥 ВАЖНО: сверху вниз
                ->get();
        }

        // 📦 передаём всё в view
        return view('profile.show', compact(
            'user',
            'topics',
            'chat',
            'messages'
        ));
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('password_error', 'Текущий пароль указан неверно.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', 'Пароль успешно изменён.');
    }
}
