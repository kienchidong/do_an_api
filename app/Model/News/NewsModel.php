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
        return $this->belongsTo(CateNewsModel::class, 'cate_id', 'id');
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
        return ($this->likes()->whereUserId(Auth::id())->count() == 0) ? false : true;
    }

    public function comments()
    {
        return $this->hasMany(CommentsModel::class, 'news_id', 'id');
    }
}
