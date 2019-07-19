<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;
use App\Jobs\TranslateSlug;

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
        // if (! $topic->slug) {
        //     // 即时翻译
        //     // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        //
        //     // 推送任务到队列
        //     dispatch(new TranslateSlug($topic));
        // }
    }

    public function saved(Topic $topic)
    {
        // 等有了id后再分发
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
        // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}
