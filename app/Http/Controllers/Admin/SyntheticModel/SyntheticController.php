<?php

namespace App\Http\Controllers\Admin\SyntheticModel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Model\Question\QuestionGroupModel;
use App\Model\SyntheticModel;
use Illuminate\Http\Request;

class SyntheticController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->get('size', 10);
        $list = SyntheticModel::paginate($size);
         return response()->json($list);
    }


    public function store(Request $request)
    {
        $request->validate([
            'reading' => 'required',
            'listening' => 'required',
        ]);

        SyntheticModel::create($request->all());

        return response()->json(['ok' => 'ok']);

    }


}
