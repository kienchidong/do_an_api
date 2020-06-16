<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'comment_id' => $this->id,
            'content' => $this->content,
            'user_create' => new UserDetailResource($this->user),
        ];
    }
}
