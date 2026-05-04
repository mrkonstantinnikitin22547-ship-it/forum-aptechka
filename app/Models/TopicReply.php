<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'topic_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function attachments()
    {
        return $this->hasMany(TopicReplyAttachment::class);
    }
    public function likes()
    {
        return $this->hasMany(\App\Models\ReplyLike::class, 'reply_id');
    }
}
