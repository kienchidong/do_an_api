<?php

namespace App\Model;

use App\Model\Question\QuestionModel;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ResultModel extends Model
{
    //
    protected $table = 'results';
    protected $fillable = ['user_id', 'question_id', 'point', 'time', 'level', 'is_simple', 'is_group', 'answer_detail'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => 'Guest'
        ]);
    }

    public function answerHistory()
    {
        $result = [];
        $detail = json_encode($this->answer_detail);

        foreach ($detail as $key => $value) {
            $question = QuestionModel::find($value->question_id);
            $data['question'] = $question->question;
            $answers = $question->answers;
            foreach($answers as $answerKey => $answer){
                if($answer->id == $value->chose_id){
                    $answers[$answerKey]['chosen'] = 1;
                    $data['status'] = $answer->status;
                }else{
                    $answers[$answerKey]['chosen'] = 0;
                }
            }
            $result[$key]['answers'] = $answers;
        }

        return $result;
    }
}
