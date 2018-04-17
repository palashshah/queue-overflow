<?php

use App\Model\User;
use App\Model\Answer;
use Faker\Generator as Faker;

$factory->define(App\Model\Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->sentence,
        'user_id' => function(){
          return User::all()->random();
        },
      	'answer_id' => function(){
      		return Answer::all()->random();
      	}
    ];
});
