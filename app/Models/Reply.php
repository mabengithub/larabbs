<?php

namespace App\Models;

class Reply extends Model
{
	// 允许修改的字段白名单
    protected $fillable = ['content'];

    // 一条回复对应一个话题
    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }

    // 一条回复对应一个作者
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
