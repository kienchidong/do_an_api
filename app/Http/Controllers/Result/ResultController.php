<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Model\ResultModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    use ApiResponser;
    //
    public function store(Request $request)
    {
        $this->validate($request, [
            'question_id' => 'bail|required|numeric',
            'point' => 'bail|required',
            'time' => 'bail|required',
            'level' => 'bail|required',
        ]);

        $request->request->set('user_id', Auth::id());
        ResultModel::create($request->all());

        return $this->successResponseMessage([], 200, 'create success');
    }
}
