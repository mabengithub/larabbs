<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    
        // 'name' => $faker->name,
        $sentence = $faker->sentence();

        //随机获取一个月内的时间
        $updated_at = $faker->dateTimeThisMonth();
        // 传参为生成最大时间不超过，创建时间永远比更改时间要早
        $created_at = $faker->dateTimeThisMonth($updated_at);

        return [
        	'title' => $sentence,//标题
        	'body' => $faker->text(),//大文本
        	'excerpt' => $sentence,//摘录
        	'created_at' => $created_at,
        	'updated_at' => $updated_at,
        ];
    
});
