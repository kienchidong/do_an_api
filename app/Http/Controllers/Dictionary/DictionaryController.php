<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dictionary\DictionaryCollection;
use App\Http\Resources\Dictionary\DictionaryDetailResource;
use App\Http\Resources\Dictionary\DictionaryResource;
use App\Model\DictionaryModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    //
    use ApiResponser;

    public function search(Request $request){
        $request->validate([
           'word' => 'required',
        ]);

       $word = DictionaryModel::where('word', $request->word)->first();
        if($word){
            $data['word'] = new DictionaryDetailResource($word);
        } else{
            $value = DictionaryModel::where('word', 'like', '%'.$request->word.'%')->first();
            $data['like'] = $value->word;
            $data['word'] = new DictionaryDetailResource($value);

        }
        return $this->successResponseMessage($data, '200', 'search success');
    }

    public function searchList(Request $request){
        $word =  new DictionaryCollection(DictionaryModel::where('word', 'like', '%'.$request->word.'%')->paginate(10));
        return $this->successResponseMessage($word, '200', 'search success');
    }
}
