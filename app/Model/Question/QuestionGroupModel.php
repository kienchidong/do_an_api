<?php

namespace App\Model\Question;

use Illuminate\Database\Eloquent\Model;

class QuestionGroupModel extends Model
{
    //
    protected $table = 'group_questions';
    public $timestamps = false;
    protected $fillable = ['name', 'describe', 'level'];

    public function questions(){
        return $this->hasMany( QuestionModel::class, 'group_id', 'id');
    }
}
