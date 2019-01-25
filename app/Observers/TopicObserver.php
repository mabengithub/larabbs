<?php

namespace App\Observers;

use App\Models\Topic;

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
    	$topic->excerpt = make_excerpt($topic->body);
    }
}