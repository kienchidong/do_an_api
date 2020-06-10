<?php

const change_language = 'user.change-language';
const client = [
    'index' => 'client.index',
];

const admin = [
    'index' => 'admin.index',

    'login' => 'admin.login',
    'login_post' => 'admin.login.post',
    'logout' => 'admin.logout',

    'account_list' => 'account_list',
    'account_show' => 'account_show',
    'account_create' => 'account_create',
    'account_store' => 'account_store',
    'account_destroy' => 'account_destroy',
    'account_update' => 'account_update',
    'account_edit' => 'account_edit',
    'get_role' => 'get_role,',
    'set_role' => 'set_role,'
];

// Roles

const ROLE_SUPER_ADMIN = 'permission.group.SUPERADMIN';
const ROLE_ADMINSTRATOR = 'permission.group.ADMINSTRATOR';
const ROLE_EDITOR = 'permission.group.EDITOR';
const ROLE_AUTHOR = 'permission.group.AUTHOR';
const ROLE_BOOKINGSYS = 'permission.group.BOOKINGSYS';
const YOURSELF = 'yourself';

// permission

const PERMISSION_ACCOUNT_VIEW = 'permission.ACCOUNT.VIEW';
const PERMISSION_ACCOUNT_ADD = 'permission.ACCOUNT.ADD';
const PERMISSION_ACCOUNT_EDIT = 'permission.ACCOUNT.EDIT';
const PERMISSION_ACCOUNT_DELETE = 'permission.ACCOUNT.DELETE';

const PERMISSION_DATA_IMPORT = 'permission.DATA.IMPORT';
const PERMISSION_DATA_EXPORT = 'permission.DATA.EXPORT';

const PERMISSION_POSTS_VIEW = 'permission.POSTS.VIEW';
const PERMISSION_POSTS_ADD = 'permission.POSTS.ADD';
const PERMISSION_POSTS_EDIT = 'permission.POSTS.EDIT';
const PERMISSION_POSTS_DELETE = 'permission.POSTS.DELETE';
const PERMISSION_POSTS_APPROVED = 'permission.POSTS.APPROVED';

const PERMISSION_PRODUCTS_VIEW = 'permission.PRODUCTS.VIEW';
const PERMISSION_PRODUCTS_ADD = 'permission.PRODUCTS.ADD';
const PERMISSION_PRODUCTS_EDIT = 'permission.PRODUCTS.EDIT';
const PERMISSION_PRODUCTS_DELETE = 'permission.PRODUCTS.DELETE';
const PERMISSION_PRODUCTS_APPROVED = 'permission.PRODUCTS.APPROVED';

const PERMISSION_ORDER_VIEW = 'permission.ORDER.VIEW';
const PERMISSION_ORDER_HANDLING = 'permission.ORDER.HANDLING';

const PERMISSION_SETTING_SETTING = 'permission.SETTING.SETTING';
const PERMISSION_SETTING_BANNER = 'permission.SETTING.BANNER';

//gate
const EDIT_ROLE_YOURSELFT = 'EDIT_ROLE_YOURSELFT';
