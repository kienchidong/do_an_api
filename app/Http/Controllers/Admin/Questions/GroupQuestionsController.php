<?php

namespace App\Http\Controllers\Admin\Questions;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionGroupRequest;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Http\Resources\Questions\GroupQuestionsResource;
use App\Model\Question\QuestionGroupModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class GroupQuestionsController extends Controller
{
    //
    use ApiResponser;
    public function store(QuestionGroupRequest $request){
        $group = QuestionGroupModel::create($request->all());
        return $this->successResponseMessage($group, '200', 'create success!');
    }

    public function getList(){
        $group = QuestionGroupModel::paginate(10);

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
}
