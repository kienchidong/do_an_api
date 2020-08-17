<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoCollection;
use App\Model\Video\VideoModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use ApiResponser;

    public function getList(Request $request)
    {
        $size = $request->get('size', 10);
        $videos = VideoModel::orderBy('created_at', 'desc')->paginate($size);
        return $this->successResponseMessage(new VideoCollection($videos), 200, 'success');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_video' => 'required',
            'type_id' => 'bail|required|exists:type_videos,id',
        ]);
        $name = $request->get('name', '');
        if($name == ''){

            $html = file_get_html('https://www.youtube.com/watch?v='.$request->id_video);

            $meta = $html->find('meta[property=og:title]', 0);

            $request->request->set('name', $meta->content);
        }

        VideoModel::create($request->all());
        return $this->successResponse([], 200);
    }
}
