<?php

namespace App\Model;

use App\Http\Resources\Questions\GroupQuestionsListCollection;
use App\Model\Question\QuestionGroupModel;
use Illuminate\Database\Eloquent\Model;

class SyntheticModel extends Model
{
    //
    protected $table ='synthetic_questions';
    protected $fillable = ['listening', 'reading'];

    public function createTest($data)
    {
        return 1;
    }
    public function list_reading()
    {
        $reading = QuestionGroupModel::whereIn('id', $this->reading)->get();

        return new GroupQuestionsListCollection($reading);
    }
    public function list_listening()
    {
        $reading = QuestionGroupModel::whereIn('id', $this->listening)->get();

        return new GroupQuestionsListCollection($reading);
    }
}
