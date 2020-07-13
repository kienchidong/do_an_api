<?php

namespace App\Http\Controllers\Admin\Questions;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\Questions\QuestionsCollection;
use App\Model\Question\QuestionModel;
use Illuminate\Http\Request;
use App\Exports\SimpleQuestionsExport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller
{
    //

    public function store(QuestionRequest $request){
        $kq = QuestionModel::CreateQuestion($request->all());
        return response()->json($kq);
    }

    public function getList(){
        $list = QuestionModel::whereNull('group_id')->paginate(10);

        return response()->json(new QuestionsCollection($list));
    }

    public function update(QuestionRequest $request, $id){
       $kq = QuestionModel::find($id)->updateQuestion($request->all());
       return response()->json($kq);
    }

    public function destroy($id){
        $qe = QuestionModel::findOrFail($id)->delete();
        return response()->json(['ok' => 'ok']);
    }

    public function import(Request $request){
        return response()->json($request->all());
    }

    public function Export(Request $request){
        $size = $request->get('size', 10);
        $type = $request->get('type', 'xlsx');
        $fileName = 'simpleQuestion.'.$type;
        return Excel::download(new SimpleQuestionsExport($size), $fileName);
    }
}
