<?php

namespace App\Model\News;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    //
    protected $table = 'comments';
    protected $fillable = ['news_id', 'user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
