<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Questions\GroupQuestionsCollection;
use App\Http\Resources\Questions\GroupQuestionsResource;
use App\Http\Resources\Test\TestListCollection;
use App\Http\Resources\Test\TestResource;
use App\Model\News\CateNewsModel;
use App\Model\News\NewsModel;
use App\Model\Question\QuestionGroupModel;
use App\Model\Test\TestModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function getListReading(Request $request)
    {
        $type = $request->get('type', 0);
        $read = QuestionGroupModel::whereType($type)->paginate(10);

        return $this->successResponseMessage(new GroupQuestionsCollection($read), 200, "success");
    }

    public function getDetailReading(Request $request)
    {
        $request->validate([
            'group_id' => 'bail|required|exists:group_questions,id'
        ]);
        $tests = QuestionGroupModel::find($request->group_id);
        return $this->successResponseMessage(new GroupQuestionsResource($tests), 200, 'get success');
    }

    public function answerWriting(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'question_id' => 'bail:required|exists:group_questions,id'
        ]);
        $input = $request->all();
        $input['slug'] = $this->name_image($input['title']) . '.html';
        $input['cate_id'] = 1;
        $input['author_id'] = Auth::id();

        $new = NewsModel::create($input);
        return $this->successResponseMessage(['ok' => 'ok'], 200, 'success');
    }
}
