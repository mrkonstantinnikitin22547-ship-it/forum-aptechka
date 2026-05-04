<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_reply_id',
        'file_path',
        'file_name',
        'file_type',
    ];

    public function reply()
    {
        return $this->belongsTo(TopicReply::class, 'topic_reply_id');
    }

    public function isImage()
    {
        return str_starts_with($this->file_type, 'image/');
    }
}