<?php

namespace App\Http\Controllers\Client\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsDetailResource;
use App\Model\News\CommentsModel;
use App\Model\News\LikeModel;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class NewsController extends Controller
{
    //
    use ApiResponser;

    public function getNews(Request $request)
    {
        $request->validate([
            'slug' => 'required',
        ]);

        $new = NewsModel::where('slug', $request->slug)->firstOrFail();
        return $this->successResponseMessage(new NewsDetailResource($new), '200', 'success');
    }

    public function likeNews(Request $request)
    {
        $request->validate([
            'news_id' => 'bail|required|exists:news,id',
        ]);

        $request->request->set('user_id', Auth::id());

        LikeModel::create($request->all());
        return response()->json(Auth::user());
    }


}
