<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserResource;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class UserAccountController extends Controller
{
    //
    use ApiResponser;
    public function getList(Request $request){
        $user = new UserCollection(User::paginate(10));
        return response()->json($user);
    }

    public function lockUser($user_id, $status){
        $kq = User::find($user_id)->setStatus($status);
        return response()->json(['abc' => $kq]);
    }

    public function store(UserRequest $request){
        $input = $request->all();
        $input['password'] = bcrypt($input['repassword']);
        $input['folder'] = 'folder-' . $this->name_image($request->name).'-avatar';
        if($input['avatar'] != null){
            $input['avatar'] = $this->saveImgBase64($input['avatar'],'avatar/user/'.$input['folder']);
        }
        $user = User::Create($input);
    }
}
