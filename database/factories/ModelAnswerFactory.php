<?php

use App\Model\User;
use App\Model\Question;
use Faker\Generator as Faker;

$factory->define(App\Model\Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'upvotes' => $faker->numberBetween(0, 10000),
        'downvotes' => $faker->numberBetween(0, 10000),
      	'user_id' => function(){
      		return User::all()->random();
      	},
      	'question_id' => function(){
      		return Question::all()->random();
      	}
    ];
});
