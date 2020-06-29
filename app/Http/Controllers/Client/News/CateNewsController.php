<?php

namespace App\Http\Controllers\Client\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\CateCollection;
use App\Http\Resources\News\NewsCollection;
use App\Model\News\CateNewsModel;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CateNewsController extends Controller
{
    //
    use ApiResponser;
    public function getList(){

        $cate = CateNewsModel::select('*', DB::raw('(select count(*) from news where cate_id = cate_news.id) as count'))
            ->orderBy('count', 'desc')->paginate(5);

        return $this->successResponseMessage(new CateCollection($cate), 200, 'get success');
    }

    public function getListNews(Request $request)
    {
        $slug = $request->get('slug', '');
        if($slug == ''){
            $news = NewsModel::withCount('likes', 'comments')
                ->orderBy('likes_count', 'desc')
                ->orderBy('comments_count', 'desc')
                ->paginate(10);
        } else {
            $news = CateNewsModel::whereSlug($request->slug)->first()->news()->paginate(10);
        }
       return $this->successResponseMessage(new NewsCollection($news), 200, 'get success');
    }
}
