<?php

namespace App\Http\Resources\Test;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Console\Question\Question;

class TestResource extends JsonResource
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
            'test_id' => $this->id,
            'list_question' => $this->Questions(),
            'status' => $this->status,
        ];
    }
}
