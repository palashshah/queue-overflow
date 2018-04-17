<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\Resource;

class QuestionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->body,
            'views' => $this->views,
            'votes' => $this->upvotes - $this->downvotes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author_id' => $this->user_id
        ];
    }
}
