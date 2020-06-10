<?php

namespace App\Http\Resources\Dictionary;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DictionaryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return DictionaryResource::collection($this->collection);
    }
}
