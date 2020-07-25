<?php

namespace App\Exports;

use App\Model\Question\QuestionGroupModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GroupQuestionExport implements FromView, ShouldAutoSize
{

    public $size = 0;

    public function __construct($size = 0){
        $this->size = $size;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $size = $this->size;
        $group = QuestionGroupModel::whereType(0)
            ->when($size != 0, function($query) use ($size){
            return $query->limit($size);
        })->get();

        return View('excel.GroupQuestions', compact('group'));
    }
}
