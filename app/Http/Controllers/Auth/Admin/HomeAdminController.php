<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Model\News\NewsModel;
use App\Model\Test\TestModel;
use App\User;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function getHome()
    {
        $data['users'] = User::count();
        $data['news'] = NewsModel::count();
        $data['exams'] = TestModel::count();

        return response()->json($data);
    }
}
