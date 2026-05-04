<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return redirect()->route('home')->with('success', 'Вы успешно вошли!');
    }

    public function register(Request $request)
    {
        return redirect()->route('home')->with('success', 'Регистрация успешна!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Вы вышли из системы.');
    }

    public function sendSupport(Request $request)
    {
        return redirect()->route('support')->with('success', 'Ваше сообщение отправлено!');
    }

    public function ajaxLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Пожалуйста, проверьте введенные данные',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)
            ->orWhere('login', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Неверный email/логин или пароль'
            ], 401);
        }

        if ($user->is_banned) {
            return response()->json([
                'success' => false,
                'message' => 'Ваш аккаунт заблокирован администратором.'
            ], 403);
        }

        Auth::login($user, $request->has('remember'));

        if ($user->role === 'admin') {
            return response()->json([
                'success' => true,
                'message' => 'Добро пожаловать, администратор!',
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Вход выполнен успешно!',
            'redirect' => route('profile')
        ]);
    }

    public function ajaxRegister(Request $request)
    {
        Log::info('Начало регистрации', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'login' => 'required|string|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed'
            ],
        ], [
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.regex' => 'Пароль должен содержать заглавную букву, строчную букву и цифру',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        if ($validator->fails()) {
            Log::error('Ошибки валидации', $validator->errors()->toArray());

            return response()->json([
                'success' => false,
                'message' => 'Пожалуйста, исправьте ошибки',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'login' => $request->login,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'is_banned' => 0
            ]);

            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Регистрация успешна!',
                'redirect' => route('profile')
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка при регистрации', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера'
            ], 500);
        }
    }

    public function ajaxForgot(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Инструкции отправлены на email.'
        ]);
    }
}