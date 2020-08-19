<?php

namespace App\Http\Controllers\Admin\SyntheticModel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Http\Resources\Synthetic\SyntheticCollection;
use App\Http\Resources\Synthetic\SyntheticResource;
use App\Model\Question\QuestionGroupModel;
use App\Model\SyntheticModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SyntheticController extends Controller
{
    use ApiResponser;
    //
    public function index(Request $request)
    {
        $size = $request->get('size', 10);
        $list = SyntheticModel::paginate($size);
         return response()->json(new SyntheticCollection($list));
    }


    public function store(Request $request)
    {
        $request->validate([
            'reading' => 'required',
            'listening' => 'required',
        ]);

        $request->request->set('time', $request->number_question);
        SyntheticModel::create($request->all());

        return response()->json(['ok' => 'ok']);

    }


    public function getList(Request $request)
    {
        $size = $request->get('size', 9);
        $test = SyntheticModel::orderByDESC('created_at')->paginate($size);

        return $this->successResponseMessage(new SyntheticCollection($test), 200, 'success');
    }

    public function getDetail(Request $request)
    {
        $request->validate([
            'id' => 'bail|required|exists:synthetic_questions,id',
        ]);

        $test = new SyntheticResource(SyntheticModel::find($request->id));

        return $this->successResponseMessage($test, 200, 'success');

    }
}
