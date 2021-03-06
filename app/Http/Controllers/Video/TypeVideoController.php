<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeVideo\TypeVideoCollection;
use App\Http\Resources\Video\VideoCollection;
use App\Model\Video\TypeVideoModel;
use App\Model\Video\VideoModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeVideoController extends Controller
{
    //
    use ApiResponser;
    public function getList(Request $request)
    {
        $type =TypeVideoModel::paginate(10);
        return $this->successResponseMessage(new TypeVideoCollection($type),200, 'success');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:type_videos,name',
        ]);
        $input = $request->all();
        $input['slug'] = $this->name_image($input['name']) . '.html';
        TypeVideoModel::create($input);

        return $this->successResponse([], 200);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => [
                'bail',
                'required',
                Rule::unique('cate_news')->ignore($id),
            ],
        ]);
        $input = $request->all();
        $input['slug'] = $this->name_image($input['name']) . '.html';
        TypeVideoModel::find($id)->update($input);
        return $this->successResponse([], 200);
    }
    public function destroy($id)
    {
        $cate = TypeVideoModel::find($id);
        $cate->delete();
        return $this->successResponse([], 200);
    }

    public function getListVideo(Request $request)
    {
        $slug = $request->get('slug', '');
        if($slug == ''){
            $videos = VideoModel::paginate(10);
        } else {
            $videos = TypeVideoModel::whereSlug($request->slug)->first()->videos()->paginate(10);
        }
        return $this->successResponseMessage(new VideoCollection($videos), 200, 'success');
    }

    public function getListMenu()
    {
        $type = TypeVideoModel::withCount('videos')->orderBy('videos_count','desc')->paginate(5);

        return $this->successResponseMessage(new TypeVideoCollection($type), 200,'success');
    }
}
