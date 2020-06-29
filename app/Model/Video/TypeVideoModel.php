<?php

namespace App\Model\Video;

use Illuminate\Database\Eloquent\Model;

class TypeVideoModel extends Model
{
    //
    protected $table = 'type_videos';

    protected $fillable = ['name', 'slug'];

    public function videos()
    {
        return $this->hasMany(VideoModel::class, 'type_id', 'id');
    }
}
