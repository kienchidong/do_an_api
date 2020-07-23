<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsCollection;
use App\Http\Resources\User\UserCollection;
use App\Model\News\NewsModel;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Api;

class HomeController extends Controller
{
    //
    use ApiResponser;

    public function getHotNews()
    {
        $news = NewsModel::withCount('likes', 'comments')
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->paginate(3);

        return $this->successResponseMessage(new NewsCollection($news), 200, 'get success');
    }

    public function getListNewsUser()
    {
        $user = User::orderByDESC('created_at')->paginate(4);
        return $this->successResponseMessage(new UserCollection($user), 200, 'get success');

    }

    public function getFeedback()
    {
        
    }
}
