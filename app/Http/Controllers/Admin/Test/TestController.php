<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use App\Http\Resources\Test\TestResource;
use App\Model\Question\QuestionModel;
use App\Model\Test\TestModel;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function getList(Request $request)
    {
        /*$request->validate([
           'test_id' => 'bail|required|tests,id',
        ]);*/

        $abc = TestModel::find($request->test_id);
        return response()->json(new TestResource($abc));
    }

    public function createSimpleTest(Request $request)
    {
        $questions = QuestionModel::whereNull('group_id')->whereLevel($request->level)->pluck('id')->toArray();

        $data['level'] = $request->level;
        for($i=1; $i<=$request->number; $i++) {
            $data['list_question'] = json_encode(array_rand($questions, 20));
            $arr = TestModel::create($data);
        }

        echo 'ok';
    }
}
