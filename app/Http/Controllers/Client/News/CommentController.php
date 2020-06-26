<?php

namespace App\Http\Controllers\Client\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Model\News\CommentsModel;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;

class CommentController extends Controller
{
    use ApiResponser;
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createComment(Request $request)
    {
        $request->validate([
            'news_id' => 'bail|required|exists:news,id',
            'content' => 'bail|required',
        ]);

        $request->request->set('user_id', Auth::id());
        $comment = CommentsModel::create($request->only('news_id', 'user_id', 'content'));
        return $this->successResponseMessage(new CommentResource($comment), 200, 'success');
    }

    public function getComment(Request $request)
    {
        $request->validate([
            'news_id' => 'bail|required|exists:news,id',
        ]);

        $news = NewsModel::find($request->news_id)->comments()->paginate(5);
        return $this->successResponseMessage(new CommentCollection($news), 200, 'success');

    }
}
