<?php

namespace App\Model;

use App\Http\Resources\Questions\GroupQuestionsListCollection;
use App\Model\Question\LevelModel;
use App\Model\Question\QuestionGroupModel;
use Illuminate\Database\Eloquent\Model;

class SyntheticModel extends Model
{
    //
    protected $table ='synthetic_questions';
    protected $fillable = ['listening', 'reading', 'level', 'number_question', 'time'];

    public function createTest($data)
    {
        return 1;
    }
    public function list_reading()
    {
        $reading = QuestionGroupModel::whereIn('id', json_decode($this->reading))->get();

        return new GroupQuestionsListCollection($reading);
    }
    public function list_listening()
    {
        $reading = QuestionGroupModel::whereIn('id', json_decode($this->listening))->get();

        return new GroupQuestionsListCollection($reading);
    }

    public function levelDetail()
    {
        return $this->belongsTo(LevelModel::class, 'level', 'id');
    }
}
