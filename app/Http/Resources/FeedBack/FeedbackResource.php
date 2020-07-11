<?php

namespace App\Http\Resources\FeedBack;

use App\Http\Resources\User\UserDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
          'content' => $this->content,
          'user' => new UserDetailResource($this->user)
        ];
    }
}
