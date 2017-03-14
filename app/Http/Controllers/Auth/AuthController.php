<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Log;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    function login()
    {
        return view('admin/login');
    }

    function checkLogin(Request $request)
    {
        $username = $request->has('username') ? $request->input('username') : '';
        $password = $request->has('password') ? $request->input('password') : '';

        if (empty($username) || empty($password)) {
            return redirect('/')->with('error', '账号或密码错误');
        } else {
            if (Auth::attempt(['account' => $username, 'password' => $password])) {
                return redirect('/auth_url');
            } else {
                return redirect('/')->with('error', '账号或密码错误');
            }
        }
    }


}
