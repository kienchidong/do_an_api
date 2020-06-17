<?php

namespace App\Http\Controllers\Client\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentCollection;
use App\Model\News\CommentsModel;
use App\Model\News\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
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
        CommentsModel::create($request->only('news_id', 'user_id', 'content'));
        return response()->json(Auth::user());
    }

    public function getComment(Request $request)
    {
        $request->validate([
            'news_id' => 'bail|required|exists:news,id',
        ]);

        $news = NewsModel::find($request->news_id)->comments()->paginate(5);
        return response()->json(new CommentCollection($news));
    }
}
