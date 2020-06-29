<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeVideo\TypeVideoCollection;
use App\Model\Video\TypeVideoModel;
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
}
