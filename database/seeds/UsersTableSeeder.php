<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取Faker实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function ($user, $index) use ($faker, $avatars) {
                            // 给用户集合中每一个用户随机一个头像
                            $user->avatar = $faker->randomElement($avatars);
                        });
        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 批量插入数据库
        User::insert($user_array);

        // 单独处理第一个用户数据
        $first_user = User::find(1);
        $first_user->name = 'admin';
        $first_user->email = 'admin@test.com';
        $first_user->password = bcrypt(1);
        $first_user->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $first_user->save();
    }

}
