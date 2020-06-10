<?php

use App\AdminModel;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ROLE_SUPER_ADMIN = Role::create(['guard_name' => 'admin', 'name' => ROLE_SUPER_ADMIN]);
        $ROLE_ADMINSTRATOR = Role::create(['guard_name' => 'admin', 'name' => ROLE_ADMINSTRATOR]);
        $ROLE_EDITOR = Role::create(['guard_name' => 'admin', 'name' => ROLE_EDITOR]);
        $ROLE_AUTHOR = Role::create(['guard_name' => 'admin', 'name' => ROLE_AUTHOR]);
        $ROLE_BOOKINGSYS = Role::create(['guard_name' => 'admin', 'name' => ROLE_BOOKINGSYS]);

        $PERMISSION_ACCOUNT_VIEW = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_ACCOUNT_VIEW]);
        $PERMISSION_ACCOUNT_ADD = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_ACCOUNT_ADD]);
        $PERMISSION_ACCOUNT_EDIT = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_ACCOUNT_EDIT]);
        $PERMISSION_ACCOUNT_DELETE = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_ACCOUNT_DELETE]);

        $PERMISSION_DATA_IMPORT = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_DATA_IMPORT]);
        $PERMISSION_DATA_EXPORT = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_DATA_EXPORT]);

        $PERMISSION_POSTS_VIEW = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_POSTS_VIEW]);
        $PERMISSION_POSTS_ADD = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_POSTS_ADD]);
        $PERMISSION_POSTS_DELETE = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_POSTS_DELETE]);
        $PERMISSION_POSTS_APPROVED = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_POSTS_APPROVED]);

        $PERMISSION_PRODUCTS_VIEW = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_PRODUCTS_VIEW]);
        $PERMISSION_PRODUCTS_ADD = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_PRODUCTS_ADD]);
        $PERMISSION_PRODUCTS_EDIT = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_PRODUCTS_EDIT]);
        $PERMISSION_PRODUCTS_DELETE = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_PRODUCTS_DELETE]);
        $PERMISSION_PRODUCTS_APPROVED = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_PRODUCTS_APPROVED]);

        $PERMISSION_ORDER_VIEW = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_ORDER_VIEW]);
        $PERMISSION_ORDER_HANDLING = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_ORDER_HANDLING]);

        $PERMISSION_SETTING_SETTING = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_SETTING_SETTING]);
        $PERMISSION_SETTING_BANNER = Permission::create(['guard_name' => 'admin', 'name' => PERMISSION_SETTING_BANNER]);

        $ROLE_SUPER_ADMIN->syncPermissions(
            $PERMISSION_ACCOUNT_VIEW,
            $PERMISSION_ACCOUNT_ADD,
            $PERMISSION_ACCOUNT_EDIT,
            $PERMISSION_ACCOUNT_DELETE,
            $PERMISSION_DATA_IMPORT,
            $PERMISSION_DATA_EXPORT,
            $PERMISSION_POSTS_VIEW,
            $PERMISSION_POSTS_ADD,
            $PERMISSION_POSTS_DELETE,
            $PERMISSION_POSTS_APPROVED,
            $PERMISSION_PRODUCTS_VIEW,
            $PERMISSION_PRODUCTS_ADD,
            $PERMISSION_PRODUCTS_EDIT,
            $PERMISSION_PRODUCTS_DELETE,
            $PERMISSION_PRODUCTS_APPROVED,
            $PERMISSION_ORDER_VIEW,
            $PERMISSION_ORDER_HANDLING,
            $PERMISSION_SETTING_SETTING,
            $PERMISSION_SETTING_BANNER
        );

        $ROLE_ADMINSTRATOR->syncPermissions(
            $PERMISSION_ACCOUNT_VIEW,
            $PERMISSION_DATA_IMPORT,
            $PERMISSION_DATA_EXPORT,
            $PERMISSION_POSTS_VIEW,
            $PERMISSION_POSTS_ADD,
            $PERMISSION_POSTS_DELETE,
            $PERMISSION_POSTS_APPROVED,
            $PERMISSION_PRODUCTS_VIEW,
            $PERMISSION_PRODUCTS_ADD,
            $PERMISSION_PRODUCTS_EDIT,
            $PERMISSION_PRODUCTS_DELETE,
            $PERMISSION_PRODUCTS_APPROVED,
            $PERMISSION_ORDER_VIEW,
            $PERMISSION_ORDER_HANDLING
        );

        $ROLE_EDITOR->syncPermissions(
            $PERMISSION_POSTS_VIEW,
            $PERMISSION_POSTS_ADD,
            $PERMISSION_POSTS_DELETE,
            $PERMISSION_POSTS_APPROVED,
            $PERMISSION_PRODUCTS_VIEW,
            $PERMISSION_PRODUCTS_ADD,
            $PERMISSION_PRODUCTS_EDIT,
            $PERMISSION_PRODUCTS_DELETE,
            $PERMISSION_PRODUCTS_APPROVED,
            $PERMISSION_ORDER_VIEW,
            $PERMISSION_ORDER_HANDLING
        );

        $ROLE_AUTHOR->syncPermissions(
            $PERMISSION_POSTS_VIEW,
            $PERMISSION_POSTS_ADD,
            $PERMISSION_POSTS_DELETE,
            $PERMISSION_PRODUCTS_VIEW,
            $PERMISSION_PRODUCTS_ADD,
            $PERMISSION_PRODUCTS_EDIT,
            $PERMISSION_PRODUCTS_DELETE,
            $PERMISSION_ORDER_VIEW,
            $PERMISSION_ORDER_HANDLING
        );

        $ROLE_BOOKINGSYS->syncPermissions(
            $PERMISSION_ORDER_VIEW,
            $PERMISSION_ORDER_HANDLING
        );
        //admin
        $admin = AdminModel::find(1);
        $admin->givePermissionTo(Permission::all()->pluck('id'));
    }
}
