<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'slug' => $this->id . '-' .$this->slug,
            'is_favorited' => $this->is_favorited,
            'favorites_count' => $this->favorites_count,
            'views' => $this->views,
            'votes_count' => $this->votes_count,
            'answers_count' => $this->answers_count,
            'status' => $this->status,
            'user' => new UsersResource($this->user),
        ];
    }
}
