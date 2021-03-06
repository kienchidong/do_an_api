<?php

namespace App\Http\Resources\News;

use App\Http\Resources\Questions\GroupQuestionsResource;
use App\Http\Resources\User\UserDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class NewsDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = (Auth::id()) ? Auth::id() : 0;
        $default_folder = asset('images/news') . '/';
        $image = $default_folder . $this->folder . '/' . $this->image;
        $tags = $this->tags;
        $write = asset('images/toeic.jpg');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'image' => ($this->question_id) ? $write : $image,
            'cate' => $this->cate->name,
            'tag' => $tags,
            'number_comment' => $this->comments()->count(),
            'number_like' => $this->likes->count(),
            'liked' => $this->liked(),
            'cate_slug' => $this->cate->slug,
            'author' => new UserDetailResource($this->author),
            'question' => new GroupQuestionsResource($this->question),
        ];
    }
}
