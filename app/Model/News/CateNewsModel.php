<?php

namespace App\Model\News;

use App\Http\Resources\News\NewsDetailResource;
use Illuminate\Database\Eloquent\Model;

class CateNewsModel extends Model
{
    //
    protected $table = 'cate_news';
    public $fillable = ['name', 'slug'];

    public function news(){
            return $this->hasMany(NewsModel::class, 'cate_id', 'id');
    }
}
