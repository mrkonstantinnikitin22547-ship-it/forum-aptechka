<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Тестовый Пользователь',
            'email' => 'test@example.com',
            'login' => 'testuser',
            'password' => Hash::make('password123'),
            'bio' => 'Привет! Я тестовый пользователь этого форума.',
            'city' => 'Москва',
            'diagnosis' => 'Диабет 2 типа',
            'is_doctor' => false,
        ]);

        User::create([
            'name' => 'Доктор Иванов',
            'email' => 'doctor@example.com',
            'login' => 'dr_ivanov',
            'password' => Hash::make('password123'),
            'bio' => 'Врач-эндокринолог с 10-летним опытом работы.',
            'city' => 'Санкт-Петербург',
            'diagnosis' => null,
            'is_doctor' => true,
        ]);

        // Добавьте еще пользователей по необходимости
    }
}