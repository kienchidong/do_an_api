<?php

namespace App\Http\Resources\FeedBack;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FeedbackCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $next_page = ($this->currentPage() < $this->lastPage()) ? $this->currentPage() + 1 : 0;
        return [
            'lists' => FeedbackResource::collection($this->collection),
            'next_page'=>$next_page,
            'total_page' => $this->lastPage()
        ];
    }
}
