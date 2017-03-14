<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Auth;
use Log;
use Redirect;


class AdminController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth', ['except' => 'logout']);
    }*/

    /**
     * 后台主界面
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $role = new Role();
        if ($user->account == 'admin') {
            $menus = $role->getAllMenus();
        } else {
            $roleids = $role->getUserRoles($user->id);
            $menus = $role->getMenusByRids($roleids);
        }
        return view('admin\index')
            ->with('topmenu', $menus)
            ->with('uname', $user->name)
            ->with('menus', $menus);
    }

    /**
     * 退出登录
     * @return Redirect
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
