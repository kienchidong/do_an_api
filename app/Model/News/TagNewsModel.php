<?php

namespace App\Model\News;

use Illuminate\Database\Eloquent\Model;

class TagNewsModel extends Model
{
    //
    protected $table = 'tagnews';
    public $fillable = ['name', 'news_id'];

    public $timestamps = false;

    protected $primaryKey = null;
}
