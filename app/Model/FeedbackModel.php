<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    //
    protected $table = 'feed_backs';
    protected $fillable = ['user_id', 'user_name', 'email', 'content'];
}
