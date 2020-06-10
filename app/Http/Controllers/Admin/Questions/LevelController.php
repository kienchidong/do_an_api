<?php

namespace App\Http\Controllers\Admin\Questions;

use App\Http\Controllers\Controller;
use App\Model\Question\LevelModel;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //
    public function getList(){
        $level = LevelModel::select('id', 'name')->get();

        return response()->json($level);
    }

    public function getDetail(){
        return view('level')->render();
    }
}
