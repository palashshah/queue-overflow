<?php

namespace App\Model;

use Jcc\LaravelVote\CanBeVoted;
use App\Model\User;
use App\Model\Question;
use App\Model\Comment;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use CanBeVoted;

    protected $vote = User::class;

    protected $fillable = [
    	'body'
    ];

    protected $with = [ 'user' ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('replies_count');
        });

        static::deleted(function($answer){
            $answer->question->decrement('replies_count');
        });
    }

    public function path(){
        return route('answers.show', $this->id);
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function question(){
    	return $this->belongsTo(Question::class, 'question_id');
    }

    public function comments(){
    	return $this->hasMany(Comment::class);
    }
}
