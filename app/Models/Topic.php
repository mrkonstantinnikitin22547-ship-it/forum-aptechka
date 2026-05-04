<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'views_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ТВОИ ОТВЕТЫ (это и есть сообщения)
    public function replies()
    {
        return $this->hasMany(TopicReply::class);
    }
}
