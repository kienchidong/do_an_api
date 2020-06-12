<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsDetailResource;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    use ApiResponser;

    public function getNews(Request $request){
        $request->validate([
            'slug' => 'required',
        ]);
        $new = NewsModel::where('slug', $request->slug)->firstOrFail();
        return $this->successResponseMessage(new NewsDetailResource($new), '200', 'success');
    }

    public function likeNews(Request $request){

    }
}
