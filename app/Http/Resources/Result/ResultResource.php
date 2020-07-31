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
        $code = ($this->is_simple == 1) ? 'S': 'G';
        return [
            'id' => $this->id,
            'test_id' => $this->test_id,
            'user' => new UserDetailResource($this->user),
            'code' => $code,
            'time' => $this->time,
            'point' => $this->point_number,
            'percent' => $this->percent,
            'answer_detail' => $this->answerHistory()
        ];
    }
}
