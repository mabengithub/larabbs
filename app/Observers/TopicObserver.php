<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    //在topic模型保存时候触发saving事件，对excerpt字段进行赋值
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');
        // 生成话题摘录
    	$topic->excerpt = make_excerpt($topic->body);
        // 如 slug字段无内容,即使用翻译器 对title 进行翻译
        if ( ! $topic->slug ) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}