<?php

namespace App\Http\Controllers\Client\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ApiResponser;

    public function register(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['repassword']);
        $input['folder'] = 'folder-' . $this->name_image($request->name).'-avatar';
        if($input['avatar'] != null){
            $input['avatar'] = $this->saveImgBase64($input['avatar'],'avatar/user/'.$input['folder']);
        }
        $user = User::Create($input);
        return $this->successResponseMessage(new UserDetailResource($user), 200, 'create success');
    }
}
