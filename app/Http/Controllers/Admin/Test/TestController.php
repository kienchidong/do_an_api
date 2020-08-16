<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use App\Http\Resources\Test\TestCollection;
use App\Http\Resources\Test\TestListCollection;
use App\Http\Resources\Test\TestResource;
use App\Model\Question\QuestionModel;
use App\Model\Test\TestModel;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->get('size', 10);
        $test = TestModel::orderByDESC('created_at')->paginate($size);


        return response()->json(new TestCollection($test));
    }

    public function store(Request $request)
    {
        $request->validate([
          'number' => 'bail|required|numeric|min:15',
       ]);
        $list = json_decode($request->list_question);
        $data =$request->all();
        $data['level'] = 1;
        if(sizeof($list) == 0){
            $questions = QuestionModel::whereNull('group_id')->whereLevel($data['level'])->pluck('id')->toArray();

            for($i=1; $i<=$data['number']; $i++) {
                $data['list_question'] = json_encode(array_rand(array_flip($questions), 20));
            }
        }
        $arr = TestModel::create($data);
        return response()->json(['ok' => 'ok']);
    }

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
            $data['list_question'] = json_encode(array_rand(array_flip($questions), 20));
            $arr = TestModel::create($data);
        }

        echo 'ok';
    }
}
