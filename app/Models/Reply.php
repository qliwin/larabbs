<?php

namespace App\Models;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;

class Reply extends Model
{
    protected $fillable = ['content'];

    // 回复属于谁
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // 回复属于文章
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }
}
