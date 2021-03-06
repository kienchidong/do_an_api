<?php

namespace App;

use App\Model\News\NewsModel;
use App\Model\ResultModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'folder', 'avatar', 'gender', 'cover', 'birthday', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
        return $this->name;
    }

    public function result()
    {
        return $this->hasMany(ResultModel::class, 'user_id', 'id');
    }

    public function news()
    {
        return $this->hasMany(NewsModel::class, 'author_id', 'id');
    }
}
