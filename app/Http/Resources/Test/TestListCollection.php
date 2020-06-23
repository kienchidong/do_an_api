<?php

namespace App\Http\Resources\Test;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TestListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $next_page = 0;
        $current_page = ($this->currentPage() !== null) ? $this->currentPage() : 0;
        $last_page = ($this->lastPage()) ? $this->lastPage() : 0;
        if ($current_page < $last_page) {
            $next_page = $current_page + 1;
        }
        return [
            'lists' => TestListResource::collection($this->collection),
            'next_page'=>$next_page,
            'total_page' => $last_page
        ];
    }
}
