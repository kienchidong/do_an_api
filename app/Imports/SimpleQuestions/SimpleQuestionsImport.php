<?php

namespace App\Imports\SimpleQuestions;

use App\Model\Question\AnswerModel;
use App\Model\Question\QuestionModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimpleQuestionsImport implements ToCollection, WithHeadingRow
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
                $data['question'] = $row['question'];
                $data['level'] = 1;
                $data['explain'] = $row['explain'];
                $right = strtolower($row['right_answer']);
                $answer = [];
                    array_push($answer, [
                       'value' => $row['a'],
                       'status' => $right == 'a',
                    ],[
                        'value' => $row['b'],
                        'status' => $right == 'b'
                    ],[
                        'value' => $row['c'],
                        'status' => $right == 'c'
                    ],[
                        'value' => $row['d'],
                        'status' => $right == 'd'
                    ]);
                $data['answers'] = $answer;
                QuestionModel::CreateQuestion($data);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
