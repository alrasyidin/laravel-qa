<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'id' => $this->id,
            'body' => $this->body,
            'body_html' => $this->body_html,
            'is_best' => $this->is_best,
            'votes_count' => $this->votes_count,
            'user' => new UsersResource($this->user),
            'user_id' => $this->user_id,
            'question_id' => $this->question_id,
            'created_date' => $this->created_date,
            'question_user_id' => $this->question->user_id
        ];
    }
}
