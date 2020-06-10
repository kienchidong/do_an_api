<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\CateCollection;
use App\Model\CateNewsModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CateNewsController extends Controller
{
    //
    use ApiResponser;

    public function getList(Request $request)
    {
        $name = ($request->name) ? $request->name : null;
        $paginate = ($request->page) ? 10 : CateNewsModel::count();
        $cate = new CateCollection(CateNewsModel::where('name', 'like', '%' . $name . '%')->paginate($paginate));
        return $this->successResponseMessage($cate, 200, 'get success');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:cate_news,name',
        ]);
        $input = $request->all();
        $input['slug'] = $this->name_image($input['name']) . '.html';
        CateNewsModel::create($input);
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
        CateNewsModel::find($id)->update($input);
    }

    public function destroy($id)
    {
        $cate = CateNewsModel::find($id);
        foreach ($cate->news as $news) {
            $this->deleteFolder('images/news/' . $news->folder);
        }
        $cate->delete();
    }
}
