<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\Resource;

class QuestionCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'views' => $this->views,
            'votes' => $this->upvotes - $this->downvotes,
            'created_at' => $this->created_at,
            'author_id' => $this->user_id,
            'href' => [
                'link' => route('questions.show', $this->id)
            ],
        ];
    }
}
