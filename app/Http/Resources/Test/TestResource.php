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
            'level' => $this->level,
            'status' => $this->status,
            'number_question' => sizeof(json_decode($this->list_question)),
            'list_question' => $this->Questions(),
            'time' => $this->time,
        ];
    }
}
