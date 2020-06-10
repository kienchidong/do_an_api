<?php

namespace App\Exports;

use App\Model\Question\QuestionModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SimpleQuestionsExport implements FromView, ShouldAutoSize
{
    public $label =['A', 'B', 'C', 'D'];

    public function view(): View
    {
        $question = QuestionModel::whereNull('group_id')->get();
        $array = [];
        foreach ($question as $key =>$value){
            $array[$key]['question']= $value->question;
            foreach ($value->answers as $answerKey => $answer){
                $array[$key][$this->label[$answerKey]]= $answer->answer;
                if($answer->status){
                    $array[$key]['right']= $this->label[$answerKey];
                }
            }
        }

        return View('Excel.SimpleQuestion', compact('array'));
    }
}
