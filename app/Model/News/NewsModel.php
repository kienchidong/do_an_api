<?php

namespace App\Model\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NewsModel extends Model
{
    //
    protected $table = 'news';
    public $fillable = ['title', 'slug', 'cate_id', 'summary', 'content', 'folder', 'image'];

    public function addTag($tags)
    {
        TagNewsModel::where('news_id', $this->id)->delete();
        foreach ($tags as $tag) {
            TagNewsModel::create([
                'name' => $tag,
                'news_id' => $this->id,
            ]);
        }
    }

    public function cate()
    {
        return $this->belongsTo('App\Model\News\CateNewsModel', 'cate_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany('App\Model\News\TagNewsModel', 'news_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(LikeModel::class, 'news_id', 'id');
    }

    public function liked()
    {
        $user_id = (Auth::id()) ? Auth::id() : 0;
        return in_array($user_id, $this->likes()->pluck('user_id')->toArray());
    }
}
