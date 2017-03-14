<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Log;
use Illuminate\Support\Facades\Session;

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
    /*public function index(Request $request)
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
    }*/
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 阿里巴巴请求地址
     */
    public function index(Request $request)
    {
        $param = array(
            'client_id' => APP_KEY,
            'redirect_uri' => REDIRECT_URL,
            'site' => 'intl'
        );
        $param['loginId'] = '12312';
        $param['password'] = 'password';
        $sign = getSign('', $param);
        if (!empty($sign)) {
            $get_code_url = "http://gw.api.alibaba.com/auth/authorize.htm?client_id=" . APP_KEY . "&site=intl&redirect_uri=" . REDIRECT_URL . "&_aop_signature=" . $sign . "&loginId=12312&password=password";
            return Redirect::to($get_code_url);
        }
    }

    /**
     * @param Request $request
     * @return $this
     * 阿里巴巴授权成功后回调地址
     */
    public function home(Request $request)
    {
        $code = $request->has('code') ? $request->input('code') : null;
        set_token($code);
        $token = get_token(Session::get('login_alibaba'));;
        if (empty($token)) {
            Auth::logout();
            return redirect('/');
        }
        $user = Auth::user();
        $role = new Role();
        $menus = $role->getAllMenus();
        return view('admin/index')
            ->with('topmenu', $menus)
            ->with('uname', $user->name)
            ->with('menus', $menus)
            ->with('initaction', 'dash');
    }

    /**
     * 退出登录
     * @return Redirect
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
