<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResultModel extends Model
{
    //
    protected $table = 'results';
    protected $fillable = ['user_id', 'question_id', 'point', 'time', 'level', 'is_simple', 'is_group'];

}
