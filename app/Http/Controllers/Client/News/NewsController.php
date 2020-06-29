<?php

namespace App\Http\Controllers\Client\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsCollection;
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


    public function getHotNews()
    {
        $news = NewsModel::withCount('likes', 'comments')
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->paginate();
        return $this->successResponseMessage(new NewsCollection($news), '200', 'success');

    }
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
        if(NewsModel::find($request->news_id)->liked()){
            LikeModel::where($request->all())->delete();
        }else{
            LikeModel::create($request->all());
        }
        $data['number'] = NewsModel::find($request->news_id)->likes()->count();

        return $this->successResponseMessage($data, '200', 'success');
    }


}
