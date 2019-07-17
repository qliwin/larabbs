<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use App\Models\Reply;

class User extends Authenticatable  implements MustVerifyEmailContract
{
    // use Notifiable, MustVerifyEmailTrait;
    use MustVerifyEmailTrait;
    use Notifiable {
        // 将Notifiable trait中的自带notify方法改名，与自定义方法名冲突，最后还是要用该方法发送消息通知
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 话题关联
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 语义化，给定模型里的user_id是否为当前登录用户
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 用户与回复的关联关系
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，则不必通知
        if ($this->id == \Auth::id()) {
            return;
        }

        if (method_exists($instance,'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }
}
