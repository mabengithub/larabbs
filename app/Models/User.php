<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable {
        notify as protected laravelNotify;
    }
    use HasRoles;

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必要通知了
        if ($this->id == Auth::id()) {
            return;
        } 
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //允许修改的字段(白名单)
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //用户与话题是一对多关系
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    //一个用户可以有多条评论
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 清除消息提示
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();

    }

    public function setPasswordAttribute($value)
    {
        // 如果值得长度等于60， 即认为是已经做过加密得情况
        if (strlen($value) != 60) {
            //不等于60 ， 做密码加密处理
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 http 子串开头，那就是从后台上传得，需要补全URL
        if ( ! starts_with($path, 'http')) {
            //拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }
}
