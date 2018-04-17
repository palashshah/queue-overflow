<?php

use App\Model\User;
use App\Model\Answer;
use Faker\Generator as Faker;

$factory->define(App\Model\Question::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'views' => $faker->numberBetween(0, 10000),
        'upvotes' => $faker->numberBetween(0, 10000),
        'downvotes' => $faker->numberBetween(0, 10000),
      	'user_id' => function(){
      		return User::all()->random();
      	}
    ];
});
