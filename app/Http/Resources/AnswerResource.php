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
            'is_best' => $this->views,
            'votes_count' => $this->votes_count,
            'user' => new UsersResource($this->user),
            'question_id' => $this->question_id,
            'created_date' => $this->created_date
        ];
    }
}
