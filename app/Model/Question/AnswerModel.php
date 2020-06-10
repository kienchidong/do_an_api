<?php

namespace App\Model\Question;

use Illuminate\Database\Eloquent\Model;

class AnswerModel extends Model
{
    //
    protected $table = 'answers';
    public $timestamps = false;
    protected $fillable = ['question_id', 'answer', 'status'];


}
