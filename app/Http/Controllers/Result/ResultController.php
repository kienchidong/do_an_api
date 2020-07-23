<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Http\Resources\Result\ResultCollection;
use App\Http\Resources\Result\ResultResource;
use App\Model\Question\QuestionGroupModel;
use App\Model\Question\QuestionModel;
use App\Model\ResultModel;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Runner\DefaultTestResultCache;

class ResultController extends Controller
{
    use ApiResponser;
    //
    public function store(Request $request)
    {
        $this->validate($request, [
            'test_id' => 'bail|required|numeric',
            'point' => 'bail|required',
            'time' => 'bail|required',
        ]);

        if($request->is_simple == 1){
          $level = QuestionModel::find($request->test_id)->level;
        }else{
          $level = QuestionGroupModel::find($request->test_id)->level;
        }
        $request->request->set('level', $level);
        $request->request->set('user_id', Auth::id());
        $result = ResultModel::create($request->all());

        return $this->successResponseMessage(new ResultResource($result), 200, 'create success');

       /* $r = ResultModel::find(1);
        return $this->successResponseMessage(new ResultResource($r), 200, 'create success');*/
    }

    public function getList(Request $request)
    {
        $size = $request->get('size', 10);

        $result = ResultModel::orderByDESC('created_at')->paginate($size);

        return response()->json(new ResultCollection($result));
    }

    public function getListByUser(Request $request)
    {/*
        $size = $request->get('size', 10);
        $result = Auth::user()->result()
        ->when($request->has('simple'), function ($query){
            $query->whereIsSimple(1);
        })
        ->when($request->has('group'), function ($query){
            $query->whereIsGroup(1);
        })->paginate($size);

        return response()->json($result);*/

        /*$question = QuestionModel::find(1);
        $chose_id = 1;
        $data['question'] = $question->question;

        $answers = $question->answers;
        foreach($answers as $key => $answer){
            if($answer->id == $chose_id){
                $answers[$key]['chosen'] = 1;
                $data['status'] = $answer->status;
            }else{
                $answers[$key]['chosen'] = 0;
            }
        }
        $data['answers'] = $answers;

        return response()->json($data);*/
    }
}
