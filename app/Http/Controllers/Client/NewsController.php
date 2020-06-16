<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsDetailResource;
use App\Model\News\LikeModel;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    //
    use ApiResponser;

    public function getNews(Request $request){
        $request->validate([
            'slug' => 'required',
        ]);
        dd(Auth::user());
        $new = NewsModel::where('slug', $request->slug)->firstOrFail();
        return $this->successResponseMessage(new NewsDetailResource($new), '200', 'success');
    }

    public function likeNews(Request $request){
        $request->validate([
           'news_id' => 'bail|required|exists:news,id',
        ]);
        dd(Auth::user());
        $request->request->set('user_id', Auth::id());

        $like = LikeModel::create($request->all());
        return $this->successResponseMessage($like, '200', 'success');
    }
}
