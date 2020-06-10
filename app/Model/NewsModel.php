<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    //
    protected $table = 'news';
    public $fillable = ['title', 'slug', 'cate_id', 'summary', 'content', 'folder', 'image'];

    public function addTag($tags){
        TagNewsModel::where('news_id', $this->id)->delete();
        foreach ($tags as $tag){
            TagNewsModel::create([
                'name' =>$tag,
                'news_id' => $this->id,
            ]);
        }
    }
    public function cate(){
        return $this->belongsTo('App\Model\CateNewsModel', 'cate_id', 'id');
    }
    public function tags(){
        return $this->hasMany('App\Model\TagNewsModel', 'news_id', 'id');
    }
}
