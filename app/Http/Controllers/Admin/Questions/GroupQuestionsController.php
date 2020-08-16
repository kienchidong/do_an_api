<?php

namespace App\Http\Controllers\Admin\Questions;

use App\Exports\GroupQuestionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionGroupRequest;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Http\Resources\Questions\GroupQuestionsResource;
use App\Imports\GroupQuestions\GroupQuestionsImport;
use App\Model\Question\QuestionGroupModel;
use App\Traits\ApiResponser;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GroupQuestionsController extends Controller
{
    //
    use ApiResponser;
    use FileUpload;
    public function store(Request $request){
        $input= $request->all();
        if ($request->hasFile('file')) {
            $input['audio']= $this->uploadFile('upload', $request->file);
        }
        $group = QuestionGroupModel::create($input);
        return $this->successResponseMessage($input, '200', 'create success!');
    }

    public function getList(Request $request){
        $group = QuestionGroupModel::whereType($request->type)->paginate(10);

        return response()->json(new GroupQuestionsCollection($group));
    }

    public function edit($id){
        $group = new GroupQuestionsResource(QuestionGroupModel::find($id));
        return response()->json($group);
    }

    public function update(QuestionGroupRequest $request, $id){
        $group = QuestionGroupModel::find($id)->update($request->all());
        return response()->json($group);
    }

    public function export(Request $request)
    {
        $size = $request->get('size', 0);
        $type = $request->get('type', 'xlsx');
        $fileName = 'ReadingQuestion.'.$type;

        return Excel::download(new GroupQuestionExport($size), 'group.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new GroupQuestionsImport(), $request->file);

        return response()->json(['ok' => 'ok']);
    }
}
