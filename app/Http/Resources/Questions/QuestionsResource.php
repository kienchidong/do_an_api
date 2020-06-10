<?php

namespace App\Http\Resources\Questions;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            'id' => $this->id,
            'group_id' => $this->group_id,
            'level' => $this->level,
            'question' => $this->question,
            'answers' => json_decode($this->answers),
        ];
    }
}
