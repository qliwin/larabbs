<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'reply_count',
        'view_count',
        'last_reply_user_id',
        'order',
        'excerpt',
        'slug',
    ];

    // 一个话题属于一个分类
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 一个话题属于一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        // 预加载 防止N+1问题
        return $query->with('user', 'category');
    }

    // 按照创建时间排序
    public function scopeRecent($query)
    {
       return $query->orderBy('created_at', 'desc');
    }

    // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
    // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
    
}
