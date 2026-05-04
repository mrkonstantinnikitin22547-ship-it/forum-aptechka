<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_id',
        'sender_type',
        'message'
    ];

    public function chat()
    {
        return $this->belongsTo(
            SupportChat::class,
            'chat_id'
        );
    }

    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sender_id'
        );
    }
}