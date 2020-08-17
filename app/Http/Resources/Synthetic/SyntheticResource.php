<?php

namespace App\Http\Resources\Synthetic;

use Illuminate\Http\Resources\Json\JsonResource;

class SyntheticResource extends JsonResource
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
            'code' => 'T',
            'level' => $this->levelDetail->name,
            'listening' => $this->list_listening(),
            'reading' => $this->list_reading(),
            'time' => $this->time,
            'number_question' => $this->number_question,
        ];
    }
}
