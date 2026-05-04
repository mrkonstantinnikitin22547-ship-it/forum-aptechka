<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints_table';

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'reply_id',
        'reason',
    ];
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function reply()
    {
        return $this->belongsTo(TopicReply::class);
    }
}
