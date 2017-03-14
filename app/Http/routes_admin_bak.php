<?php
Route::get('/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
Route::post('/checklogin', ['as' => 'auth.checklogin', 'uses' => 'Auth\AuthController@checkLogin']);

Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
    //退出登录
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AdminController@logout']);
    //后台首页
    Route::get('/index', ['as' => 'admin.hhs', 'uses' => 'AdminController@index']);
    //用户管理列表
    Route::get('/user', ['as' => 'admin.user', 'uses' => 'UserController@index']);
    //添加用户界面
    Route::get('/usercreate', ['as' => 'admin.usercreate', 'uses' => 'UserController@userCreatePage']);
    //添加用户
    Route::post('/saveuser', ['as' => 'admin.saveuser', 'uses' => 'UserController@saveUser']);
    //编辑用户界面
    Route::get('/usereditcreate/{uid}', ['as' => 'admin.usereditcreate', 'uses' => 'UserController@userEditCreate']);
    //重置密码
    Route::post('/resetpwd', ['as' => 'admin.resetpwd', 'uses' => 'UserController@resetPwd']);
    //用户详细信息
    Route::get('/userinfo/{uid}', ['as' => 'admin.userinfo', 'uses' => 'UserController@userInfo']);
    //编辑菜单
    Route::post('/edituser', ['as' => 'admin.edituser', 'uses' => 'UserController@editUser']);
    //用户列表
    Route::get('/getuser', ['as' => 'admin.getuser', 'uses' => 'UserController@userList']);
    //用户添加角色页面
    Route::get('/userfunc/{uid}', ['as' => 'admin.userfunc', 'uses' => 'UserController@userFunc']);
    //启用或禁用用户
    Route::post('/updatestatus', ['as' => 'admin.updatestatus', 'uses' => 'UserController@updateUserStatus']);
    //给用户添加角色
    Route::post('/saveuserroles', ['as' => 'admin.saveuserroles', 'uses' => 'UserController@saveUserRoles']);
    //菜单管理列表
    Route::get('/menu', ['as' => 'admin.menu', 'uses' => 'MenuController@index']);
    //菜单列表
    Route::get('/getmenus', ['as' => 'admin.getmenus', 'uses' => 'MenuController@menuList']);
    //添加菜单界面
    Route::get('/menucreate', ['as' => 'admin.menucreate', 'uses' => 'MenuController@menuCreatePage']);
    //更新菜单状态
    Route::post('/menustatus', ['as' => 'admin.menustatus', 'uses' => 'MenuController@updateMenuStatus']);
    //保存菜单
    Route::post('/savemenu', ['as' => 'admin.savemenu', 'uses' => 'MenuController@saveMenu']);
    //跳转到编辑菜单页面
    Route::get('/menueditcreate/{mid}', ['as' => 'admin.menueditcreate', 'uses' => 'MenuController@menuEditCreate']);
    //编辑菜单
    Route::post('/editmenu', ['as' => 'admin.editmenu', 'uses' => 'MenuController@editMenu']);
    //删除菜单
    Route::post('/delmenu', ['as' => 'admin.delmenu', 'uses' => 'MenuController@menuDel']);
    //角色列表
    Route::get('/role', ['as' => 'admin.role', 'uses' => 'RoleController@index']);
    //更新角色状态
    Route::post('/rolestatus', ['as' => 'admin.rolestatus', 'uses' => 'RoleController@updateroleStatus']);
    //删除角色
    Route::post('/delrole', ['as' => 'admin.delrole', 'uses' => 'RoleController@roleDel']);
    //角色列表
    Route::get('/getroles', ['as' => 'admin.getroles', 'uses' => 'RoleController@roleList']);
    //添加角色界面
    Route::get('/rolecreate', ['as' => 'admin.rolecreate', 'uses' => 'RoleController@roleCreatePage']);
    //保存角色
    Route::post('/saverole', ['as' => 'admin.saverole', 'uses' => 'RoleController@saveRole']);
    //编辑角色页面
    Route::get('/roleeditcreate/{rid}', ['as' => 'admin.roleeditcreate', 'uses' => 'RoleController@roleEditCreate']);
    //编辑角色保存
    Route::post('/editrole', ['as' => 'admin.editrole', 'uses' => 'RoleController@editRole']);
    //角色权限
    Route::get('/rolefunc/{rid}', ['as' => 'admin.rolefunc', 'uses' => 'RoleController@roleFunc']);
    //保存角色权限关联
    Route::post('/savemenus', ['as' => 'admin.savemenus', 'uses' => 'RoleController@saveRoleMenus']);
});
