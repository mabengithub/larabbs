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
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
        	'http://img.52z.com/upload/news/image/20181017/20181017095519_13946.jpg',
        	'http://img3.imgtn.bdimg.com/it/u=2428811347,97105724&fm=26&gp=0.jpg',
        	'http://img.52z.com/upload/news/image/20180927/20180927082822_99903.jpg',
        	'http://img.duoziwang.com/2018/06/2017123130129596.jpg',
        	'http://img.52z.com/upload/news/image/20180212/20180212084625_34342.jpg',
        	'http://image.biaobaiju.com/uploads/20180802/01/1533145976-xYZtlJEKbf.jpg',
        	'http://img.52z.com/upload/news/image/20180907/20180907094142_97002.jpg',
        	'http://img.52z.com/upload/news/image/20180224/20180224072745_22418.jpg',
        ];

        // 生成数据集合
        $users = factory(User::class)
        				->times(10)
        				->make()
        				->each(function ($user, $index)
        					use ($faker, $avatars){
        					// 从头像数据中随机取出一个并赋值
        					$user->avatar = $faker->randomElement($avatars);
        				});

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'admin';
        $user->email = 'mabenchn@gmail.com';
        $user->avatar = 'http://img.52z.com/upload/news/image/20180516/20180516053202_97519.jpg';
        $user->save();

        // 初始化用户角色， 将1 号用户指派为站长
        $user->assignRole('Founder');

        // 将2号用户指派为管理员
        $user = User::find(2);
        $user->assignRole('Maintainer');
        
    }
}
