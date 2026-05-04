<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'login',
        'password',
        'avatar',
        'bio',
        'phone',
        'birth_date',
        'city',
        'diagnosis',
        'is_admin', // Изменили с is_doctor на is_admin
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'is_admin' => 'boolean', // Изменили с is_doctor на is_admin
    ];

    // Измените метод
    public function isAdmin()
    {
        return $this->is_admin === true;
    }

    /**
     * Связь с темами (если пользователь создает темы)
     * ЗАКОММЕНТИРУЙТЕ если моделей Topic/Message еще нет
     */
    /*
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    */

    /**
     * Получить отображаемое имя пользователя
     */
    public function getDisplayNameAttribute()
    {
        return $this->name ?: $this->login;
    }

    /**
     * Проверить, является ли пользователь врачом
     */
    public function isDoctor()
    {
        return $this->is_doctor === true;
    }

    /**
     * Получить URL аватара
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }

        // Генерация градиента на основе имени
        $colors = [
            ['#667eea', '#764ba2'],
            ['#f093fb', '#f5576c'],
            ['#4facfe', '#00f2fe'],
            ['#43e97b', '#38f9d7'],
            ['#fa709a', '#fee140'],
        ];

        $hash = crc32($this->email);
        $colorIndex = abs($hash) % count($colors);

        return 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:' . $colors[$colorIndex][0] . '"/><stop offset="100%" style="stop-color:' . $colors[$colorIndex][1] . '"/></linearGradient></defs><circle cx="50" cy="50" r="50" fill="url(#grad)"/><text x="50" y="55" text-anchor="middle" fill="white" font-size="40" font-family="Arial, sans-serif">' . strtoupper(substr($this->name, 0, 1)) . '</text></svg>';
    }
    public function supportChat()
    {
        return $this->hasOne(
            \App\Models\SupportChat::class
        );
    }

    public function chatMessages()
    {
        return $this->hasMany(
            \App\Models\ChatMessage::class,
            'sender_id'
        );
    }
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }
}
