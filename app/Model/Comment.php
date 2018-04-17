<?php

namespace App\Model;

use App\Model\Answer;
use Jcc\LaravelVote\CanBeVoted;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use CanBeVoted;

    protected $vote = User::class;

    protected $fillable = [
    	'body'
    ];
    public function answer(){
    	return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function path(){
        return route('comments.show', $this->id);
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }
}
