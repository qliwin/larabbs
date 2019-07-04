<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    $data_time = $faker->date . ' ' . $faker->time;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt(1),
        'introduction' => $faker->sentence(),  // 随机小段落
        'created_at' => $data_time,
        'updated_at' => $data_time,
        // 'remember_token' => Str::random(10),
        // 'avatar' => $faker->randomElement($avatars),
    ];
});
