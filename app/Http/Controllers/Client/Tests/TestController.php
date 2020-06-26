<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Test\TestListCollection;
use App\Http\Resources\Test\TestResource;
use App\Model\Test\TestModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use ApiResponser;
    //

    public function getList(Request $request)
    {
        $request->validate([
           'level_id' => 'bail|required|exists:levels,id',
        ]);

        $tests = TestModel::whereLevel($request->level_id)->paginate(9);
        return $this->successResponseMessage(new TestListCollection($tests), 200, 'get success');
    }

    public function getDetail(Request $request)
    {
        $request->validate([
            'test_id' => 'bail|required|exists:tests,id'
        ]);
        $tests = TestModel::find($request->test_id);
        return $this->successResponseMessage(new TestResource($tests), 200, 'get success');

    }
}
