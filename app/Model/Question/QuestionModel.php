<?php

namespace App\Model\Question;

use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    //

    protected $table = 'questions';
    protected $fillable = ['group_id', 'question', 'level', 'explain', 'image'];
    public $timestamps = false;

    public static function CreateQuestion($data)
    {
        $question = self::create($data);
        $answers = array_filter($data['answers'], function ($val) {
            if ($val['value'] == true) {
                return true;
            }
        });
        foreach ($answers as $answer) {
            AnswerModel::create([
                'question_id' => $question->id,
                'answer' => $answer['value'],
                'status' => ($answer['status']) ? 1 : 0,
            ]);
        }
        return $answers;
    }

    public function group()
    {
        return $this->belongsTo(QuestionGroupModel::class, 'group_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(AnswerModel::class, 'question_id', 'id');
    }

    public function updateQuestion($data)
    {
        if ($data['image'] != null && $this->image != null && file_exists('images/questions/simple/'.$this->image)) {
            unlink('images/questions/simple/'.$this->image);
        }
        $this->update([
            'question' => $data['question'],
            'explain' => $data['explain'],
            'image' => $data['image'],
        ]);
        foreach ($this->answers()->pluck('id') as $key => $id) {
            AnswerModel::find($id)->update([
                'answer' => $data['answers'][$key]['value'],
                'status' => ($data['answers'][$key]['status']) ? 1 : 0,
            ]);
        }
    }
}
