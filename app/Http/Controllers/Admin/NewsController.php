<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\News\NewsCollection;
use App\Http\Resources\News\NewsDetailResource;
use App\Model\NewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Model\CateNewsModel;

class NewsController extends Controller
{
    //
    use ApiResponser;

    public function getList(Request $request){
        $new = new NewsCollection(NewsModel::paginate(10));
        return response()->json($new);
    }

    public function store(NewsRequest $request){
        $input =$request->all();
        $input['slug'] = $this->name_image($input['title']).'.html';
        $input['folder'] = 'folder-' . $this->name_image($input['title']);
        $input['cate_id'] = CateNewsModel::where('name', $input['cate'])->pluck('id')->first();
        $input['image'] = $this->saveImgBase64($input['image'],'news/'.$input['folder']);

        $new = NewsModel::create($input);
        $new->addTag($input['tag']);
        return response()->json(['ok' => 'ok']);
    }

    public function edit($id){
        $news = new NewsDetailResource(NewsModel::findOrFail($id));
        return response()->json($news);
    }

    public function update(NewsRequest $request, $id){
        $new = NewsModel::find($id);
        $input = $request->all();
        $edit_img = strpos($input['image'],$new->image);

        if(!$edit_img){
            if(file_exists('images/news/'.$new->folder.'/'.$new->image)){
                unlink('images/news/'.$new->folder.'/'.$new->image);
           }
           $input['image'] = $this->saveImgBase64($input['image'],'news/'.$new->folder);
        } else{
            $input['image'] = $new->image;
        }
        $input['slug'] = $this->name_image($input['title']).'.html';
        $input['cate_id'] = CateNewsModel::where('name', $input['cate'])->pluck('id')->first();
        $new->update($input);
        $new->addTag($input['tag']);

        return response()->json(['ok' => 'ok']);
    }
    public function destroy($id){
        $new = NewsModel::find($id);
        $this->deleteFolder('images/news/'.$new->folder);
        $new->delete();
        return response()->json(['ok' => 'ok']);
    }
}
