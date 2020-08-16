<?php

namespace App\Http\Resources\Questions;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupQuestionsListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return GroupQuestionsResource::collection($this->collection);
    }
}
