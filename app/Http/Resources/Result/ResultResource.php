<?php

namespace App\Http\Resources\Result;

use App\Http\Resources\User\UserDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $code = ($this->is_simple = 1) ? 'S': 'G';
        return [
            'id' => $this->id,
            'user' => new UserDetailResource($this->user),
            'code' => $code
        ];
    }
}
