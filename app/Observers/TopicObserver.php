<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHander;
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

    public function saving(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
        $topic->body = clean($topic->body, 'user_topic_body');
        // 如果还未翻译过，则翻译
        if (! $topic->slug) {
            $topic->slug = app(SlugTranslateHander::class)->translate($topic->title);
        }
    }
}
