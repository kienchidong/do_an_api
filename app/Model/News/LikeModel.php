<?php

namespace App\Model\News;

use Illuminate\Database\Eloquent\Model;

class LikeModel extends Model
{
    //
    protected $table='like_news';
    protected $fillable = ['news_id', 'user_id'];
}
