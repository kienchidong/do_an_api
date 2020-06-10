<?php

namespace App\Http\Controllers\Admin;

use App\AdminModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\Admin\AdminCollection;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AdminAccountController extends Controller
{
    use ApiResponser;

    public function getList(Request $request)
    {
        $data = new AdminCollection(AdminModel::where('name', 'like', '%' . $request->name . '%')->orWhere('email', 'like', '%' . $request->name . '%')->Paginate(10));
        return response()->json($data);
    }

    public function getRoles()
    {
        return response()->json(Role::all());
    }

    public function getPermissions($role_id)
    {
        $permissions = Role::where('id', $role_id)->orWhere('name', $role_id)->first()->permissions;
        return response()->json($permissions);
    }

    public function store(AdminRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['repassword']);
        $input['folder'] = 'folder-' . $this->name_image($request->name) . '-avatar';
        $input['avatar'] = $this->saveImgBase64($request->image, 'avatar/admins/' . $input['folder']);
        $admin = AdminModel::Create($input);
        $admin->givePermissionTo($input['permission_id']);
        return $this->successResponseMessage([], 200, 'created success');
    }

    public function adminHasPermission($id)
    {
        $permission = AdminModel::find($id)->getPermissionsId();
        return response()->json($permission);
    }

    public function setPermission(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'permissions' => 'required'
        ]);
        AdminModel::find($request->id)->setPermission($request->permissions);
    }
}
