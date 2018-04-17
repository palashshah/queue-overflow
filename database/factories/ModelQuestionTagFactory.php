<?php

use App\Model\Tag;
use App\Model\Question;
use Faker\Generator as Faker;

$factory->define(App\Model\QuestionTag::class, function (Faker $faker) {
    return [
        'tag_id' => function(){
      		return Tag::all()->random();
      	},
      	'question_id' => function(){
      		return Question::all()->random();
      	}
    ];
});
