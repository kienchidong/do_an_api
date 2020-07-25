<?php

namespace App\Imports\SimpleQuestions;

use App\Model\Question\AnswerModel;
use App\Model\Question\QuestionModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SimpleQuestionsImport implements ToCollection
{

    public $right = [
        'A' => 0,
        'B' => 1,
        'C' => 2,
        'D' => 3
    ];


    public function rules() :array
    {

    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key > 0) {
                $data['question'] = $row[0];
                $data['level'] = 1;
                $data['explain'] = $row[6];
                $answer = [];
                for ($i = 1; $i <= 4; $i++) {
                    array_push($answer, [
                       'value' => $row[$i],
                       'status' => false
                    ]);
                }
                $answer[$this->right[$row[5]]]['status'] = true;
                $data['answers'] = $answer;
                QuestionModel::CreateQuestion($data);
            }
        }
    }
}
