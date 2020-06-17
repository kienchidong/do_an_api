<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'number_comment' => $this->comments()->count(),
            'number_like' => $this->likes()->count(),
            'liked' => $this->liked()
        ];
    }
}
