<?php

namespace App\Model\Question;

use Illuminate\Database\Eloquent\Model;

class QuestionGroupModel extends Model
{
    //
    protected $table = 'group_questions';
    public $timestamps = false;
    protected $fillable = ['name', 'describe', 'level', 'type', 'audio'];
    public $label =['A', 'B', 'C', 'D'];

    public function questions(){
        return $this->hasMany( QuestionModel::class, 'group_id', 'id');
    }

    public function listExcel()
    {
        $array = [];
        foreach ($this->questions as $key =>$value){
            $array[$key]['question']= $value->question;
            foreach ($value->answers as $answerKey => $answer){
                $array[$key][$this->label[$answerKey]]= $answer->answer;
                if($answer->status){
                    $array[$key]['right']= $this->label[$answerKey];
                }
                $array[$key]['explain']= $value->explain;
            }
        }
        return $array;
    }
}
