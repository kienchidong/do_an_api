<?php

namespace App\Model\Test;

use App\Http\Resources\Questions\QuestionsListCollection;
use App\Model\Question\LevelModel;
use App\Model\Question\QuestionModel;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    //
    protected $table = 'tests';
    protected $fillable = ['list_question', 'level', 'status'];

    public function Questions()
    {
        $questions=  QuestionModel::whereIn('id', json_decode($this->list_question))->get();
        return new QuestionsListCollection($questions);
    }

    public function test_level()
    {
        return $this->belongsTo(LevelModel::class, 'level', 'id');
    }
}
