<?php

namespace App\Model;

use App\Model\Question\QuestionGroupModel;
use App\Model\Question\QuestionModel;
use App\Traits\Result\ResultAttribute;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ResultModel extends Model
{
    //
    use ResultAttribute;
    protected $table = 'results';
    protected $fillable = ['user_id', 'test_id', 'point', 'time', 'level', 'is_simple', 'is_read', 'is_listen', 'answer_detail'];

    protected $appends = ['point_number', 'percent'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => 'Guest'
        ]);
    }

    public function answerHistory()
    {
        $result = [];
        $data = [];
        $detail = json_decode($this->answer_detail, true);


        if ($this->is_simple == 0) {
            $group = QuestionGroupModel::find($this->test_id);
            $result['name'] = $group->name;
            $result['describe'] = $group->describe;
            $result['audio'] = ($group->audio) ? asset('upload') . '/' . $group->audio : 0;
        }

        foreach ($detail as $key => $value) {
            $question = QuestionModel::find($value['question_id']);

            $data[$key]['question'] = $question->question;
            $answers = $question->answers;
            foreach ($answers as $answerKey => $answer) {
                if ($answer->id == $value['chose_id']) {
                    $answers[$answerKey]['chosen'] = 1;
                    $data[$key]['status'] = $answer->status;
                } else {
                    $answers[$answerKey]['chosen'] = 0;
                }
            }
            $data[$key]['answers'] = $answers;
            $data[$key]['image'] = ($question->image) ? asset('images/questions/simple') . '/' . $question->image : null;
            $data[$key]['explain'] = $question->explain;
        }

        $result['detail'] = $data;
        return $result;
    }

}
