<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $default_folder = asset('images/news') . '/';
        $image = $default_folder . $this->folder . '/' . $this->image;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'image' => $image,
            'cate' => $this->cate->name,
            'liked' => $this->liked()
        ];
    }
}
