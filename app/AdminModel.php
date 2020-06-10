<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


class AdminModel extends Authenticatable
{
    use HasRoles;
    protected $guard_name = 'admin';
    public $table = 'admins';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'folder', 'avatar', 'email', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];



    public function destroyAdmin()
    {
        DB::table('model_has_permissions')->where('model_id', $this->id)->delete();
        if (is_dir('images/avatar/' . $this->folder)) {
            $objects = scandir('images/avatar/' . $this->folder);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype('images/avatar/' . $this->folder . '/' . $object) == "dir") remove_dir('images/' . $this->folder . '/' . $object);
                    else unlink('images/avatar/' . $this->folder . '/' . $object);
                }
            }
            reset($objects);
            rmdir('images/avatar/' . $this->folder);
        }
        $this->delete();
    }
    public function role()
    {
        return $this->belongsTo('Spatie\Permission\Models\Role', 'role_id', 'id');
    }

    public function getPermission(){
        $data['admin'] = $this;

        $data['roles'] = DB::table('permissions')
            ->select('permissions.id', 'permissions.name', DB::raw('if((select count(*) from model_has_permissions where model_has_permissions.model_id =' . $this->id . ' and model_has_permissions.permission_id = permissions.id) = 1,true, false) as has'))
            ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $data['admin']->role_id)
            ->get();
        return $data;
    }

    public function setPermission($data){
        DB::table('model_has_permissions')->where([
            ['model_type', $this->getMorphClass()],
            ['model_id', $this->id]
        ])->delete();
        self::givePermissionTo($data);
    }

    public function updateInfor($data){
        $this->name =$data['name'];
        $this->avatar =$data['avatar'];
        $this->save();
    }
    public function changePass($password){
        $this->password =$password;
        $this->save();
    }

    public function getPermissionsId(){
        return DB::table('model_has_permissions')->where([
            ['model_type', $this->getMorphClass()],
            ['model_id', $this->id]
        ])->pluck('permission_id');
    }
}
