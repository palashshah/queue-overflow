<?php

namespace App\Model;

use App\Model\Question;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = [ 'name' ];
	
    public function questions(){
    	return $this->belongsToMany(Question::class);
    }

    public function path(){
        return route('tags.show', $this->id);
    }
}
