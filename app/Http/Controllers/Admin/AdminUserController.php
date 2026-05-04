<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function toggleBan($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете изменить собственный статус');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Нельзя банить администратора');
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        return back()->with('success', 'Статус пользователя обновлён');
    }

    public function changeRole($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете изменить собственную роль');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Нельзя менять роль администратора');
        }

        $user->role = 'admin';
        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'Роль пользователя изменена');
    }
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Пароль изменён');
    }
    public function editPassword($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.password', compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Пароль успешно изменён');
    }
}
