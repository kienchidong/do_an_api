<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    //
    protected $table = 'feed_backs';
    protected $fillable = ['user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
           'name' => 'Guest'
        ]);
    }
}
