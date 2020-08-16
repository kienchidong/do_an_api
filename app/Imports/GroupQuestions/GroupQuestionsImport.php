<?php

namespace App\Imports\GroupQuestions;

use App\Model\Question\QuestionGroupModel;
use App\Model\Question\QuestionModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GroupQuestionsImport implements ToCollection, WithHeadingRow
{
    protected $name = null;
    protected $describe = null;
    protected $group_id = null;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $key => $row) {

            if (strtolower($row['title']) == 'name') {
                $this->name = $row['question'];
                continue;
            }
            if (strtolower($row['title']) == 'describe') {
                $this->describe = $row['question'];
                $this->createGroup();
                continue;
            } else {
                $data['group_id'] = $this->group_id;
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
    }

    public function createGroup()
    {
        $group = QuestionGroupModel::create([
            'name' => $this->name,
            'describe' => $this->describe,
            'level' => '1'
        ]);

        $this->group_id = $group->id;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
