<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\CateCollection;
use App\Http\Resources\News\NewsCollection;
use App\Model\News\CateNewsModel;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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
        $request->validate([
           'slug' => 'bail|required',
        ]);

        $lists = NewsModel::select('news.*')->join('cate_news', 'cate_id', 'cate_news.id')->where('cate_news.slug', $request->slug)->paginate(10);
       return $this->successResponseMessage(new NewsCollection($lists), 200, 'get success');
    }
}
