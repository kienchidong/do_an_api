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
    public $size = 0;

    public function __construct($size = 0){
        $this->size = $size;
    }

    public function view(): View
    {
        $size = $this->size;
        $question = QuestionModel::whereNull('group_id')
        ->when($size != 0, function($query) use ($size){
            return $query->limit($size);
        })->get();
        $array = [];
        foreach ($question as $key =>$value){
            $array[$key]['question']= $value->question;
            foreach ($value->answers as $answerKey => $answer){
                $array[$key][$this->label[$answerKey]]= $answer->answer;
                if($answer->status){
                    $array[$key]['right']= $this->label[$answerKey];
                }
                $array[$key]['explain']= $answer->explain;
            }
        }

        return View('Excel.SimpleQuestion', compact('array'));
    }
}
