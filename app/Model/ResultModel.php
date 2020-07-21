<?php

namespace App\Model;

use App\Model\Question\QuestionModel;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ResultModel extends Model
{
    //
    protected $table = 'results';
    protected $fillable = ['user_id', 'test_id', 'point', 'time', 'level', 'is_simple', 'is_read', 'is_listen', 'answer_detail'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => 'Guest'
        ]);
    }

    public function answerHistory()
    {
        $result = [];
        $detail = json_decode($this->answer_detail, true);

        foreach ($detail as $key => $value) {
            $question = QuestionModel::find($value['question_id']);
            $data[$key]['question'] = $question->question;
            $answers = $question->answers;
            foreach($answers as $answerKey => $answer){
                if($answer->id == $value['chose_id']){
                    $answers[$answerKey]['chosen'] = 1;
                    $data[$key]['status'] = $answer->status;
                }else{
                    $answers[$answerKey]['chosen'] = 0;
                }
            }
            $data[$key]['answers'] = $answers;
            $data[$key]['explain'] = $question->explain;
        }

        return $data;
    }
}
