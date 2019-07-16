<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 所有话题 ID 数组，如：[1,2,3,4]
        $topic_ids = Topic::all()->pluck('id')->toArray();
        // 所有用户 ID 数组，如：[1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);
        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use ($faker, $topic_ids, $user_ids) {
            // 随机赋值
            $reply->topic_id = $faker->randomElement($topic_ids);
            $reply->user_id = $faker->randomElement($user_ids);
        });

        // 将数据集合转化为数组后，插入数据库
        Reply::insert($replys->toArray());
    }

}

