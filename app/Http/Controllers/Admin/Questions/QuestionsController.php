<?php

namespace App\Http\Controllers\Admin\Questions;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\Questions\QuestionsCollection;
use App\Imports\SimpleQuestions\SimpleQuestionsImport;
use App\Model\Question\QuestionModel;
use Illuminate\Http\Request;
use App\Exports\SimpleQuestionsExport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller
{
    //

    public function store(QuestionRequest $request){
        $input = $request->all();
        if($input['image'] != null){
            $name = 'simple-'.time().'.png';
            $input['image'] = $this->saveImgBase64($input['image'],'questions/simple', $name);
        }
        $kq = QuestionModel::CreateQuestion($input);
        return response()->json($kq);
    }

    public function getList(){
        $list = QuestionModel::whereNull('group_id')->paginate(10);

        return response()->json(new QuestionsCollection($list));
    }

    public function update(QuestionRequest $request, $id){
        $input = $request->all();
        if($input['image'] != null){
            $name = 'simple-'.time().'.png';
            $input['image'] = $this->saveImgBase64($input['image'],'questions/simple', $name);
        }
       $kq = QuestionModel::find($id)->updateQuestion($input);
       return response()->json($kq);
    }

    public function destroy($id){
        $qe = QuestionModel::findOrFail($id)->delete();
        return response()->json(['ok' => 'ok']);
    }

    public function import(Request $request){
        Excel::import(new SimpleQuestionsImport(), $request->file);

        return response()->json(['ok'=> 'ok']);
    }

    public function export(Request $request){
        $size = $request->get('size', 0);
        $type = $request->get('type', 'xlsx');
        $fileName = 'simpleQuestion.'.$type;
        return Excel::download(new SimpleQuestionsExport($size), $fileName);

    }
}
