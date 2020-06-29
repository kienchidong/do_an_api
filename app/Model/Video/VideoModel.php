<?php

namespace App\Model\Video;

use Illuminate\Database\Eloquent\Model;

class VideoModel extends Model
{
    //

    protected $table = 'videos';

    protected $fillable = ['name', 'id_video', 'type_id'];

    public function type()
    {
        return $this->belongsTo(TypeVideoModel::class, 'type_id', 'id');
    }
}
