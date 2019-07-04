<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class,
    function (Faker $faker) {
        // 随机句子
        $sentence = $faker->sentence();

        // 随机取一个月以内的时间
        $updated_at = $faker->dateTimeThisMonth();

        // 传参为生成最大时间不超过，因为创建时间需永远比更新时间要早
        $created_at = $faker->dateTimeThisMonth($updated_at);

        return [
            'title' => $sentence,  // 标题
            'body' => $faker->text(), // 内容
            'excerpt' => $sentence, // 摘录
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
);
