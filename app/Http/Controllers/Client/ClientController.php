<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserResource;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class ClientController extends Controller
{
    use ApiResponser;
    protected $jwt;

    //
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required',
            'password' => 'bail|required',
        ]);
        $credentials = $request->only('email', 'password');
        $user = User::where([
            ['email', $request->email],
            ])->first();
        if ($user !== null) {
            if($user->status === 0){
                return $this->errorResponse('Your account has been temporarily locked!!!', 401);
            }
            if (!($token = $this->jwt->attempt($credentials))) {
                return $this->errorResponse('Password is incorrect', 401);
            }
            $user->update([
               'api_token' => $token,
            ]);
            $data = [
                'token' => $token,
                'user' => new UserDetailResource($user),
            ];
            return $this->successResponseMessage($data, 200, 'ok');
        }
        return $this->errorResponse('Email does not exist!!!', 401);
    }

    public function logout(){
        User::find(Auth::id())->update([
            'api_token' => null,
        ]);
        Auth::logout();
        $this->jwt->invalidate();
        return $this->successResponseMessage('', 200, "Logout success");
    }

    public function test()
    {
        return response()->json(Auth::user());
    }
}
