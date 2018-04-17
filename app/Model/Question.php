<?php

namespace App\Model;

use Jcc\LaravelVote\CanBeVoted;
use App\Model\User;
use App\Model\Tag;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use CanBeVoted;

    protected $vote = User::class;

    protected $fillable = [
    	'title', 'body', 'user_id'
    ];

    public function path(){
        return route('questions.show', $this->id);
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function answers(){
    	return $this->hasMany(Answer::class);
    }

    public function tags(){
    	return $this->belongsToMany(Tag::class);
    }

    public function addAnswer($answer){
        $answer = $this->answers()->create($answer);
        return $answer;
    }

    public function hasAcceptedAnswer(){
        if($this->accepted_answer == -1)
            return false;
        return true;
    }
}
