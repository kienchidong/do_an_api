<?php

namespace App\Http\Resources\Questions;

use App\Http\Controllers\Admin\Questions\GroupQuestionsController;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupQuestionsResource extends JsonResource
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
            'group_id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'describe' => $this->describe,
            'questions' => new GroupAnswerCollection($this->questions)
        ];
    }
}
