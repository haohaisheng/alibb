<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Session, Response, DB;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use Log;

/**
 * create by:haohaisheng
 * Class UserController
 * date  2015/12/3
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{

    /**
     * 用户管理列表
     * @return Response
     */
    public function index()
    {
        /* if (empty (session('user'))) {
             return redirect('smeboy.login');
         } */
        $curr_action = $_SERVER['REQUEST_URI'];
        return view('admin/user_list')->with('curaction', $curr_action);
    }

    /**
     *
     * @param Request $request
     * @return mixed
     */
    public function userList(Request $request)
    {
        $user = new User();
        $page = $request->has('page') ? $request->input('page') : 1;
        $num = 10;
        $users = $user->getUserList($num);
        if (count($users) > 0) {
            return $users;
        }
        return array();
    }

    /**
     * 更新用户可用状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserStatus(Request $request)
    {
        $uid = $request->has('uid') ? $request->input('uid') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $user = new User();
        $flag = $user->updateStatus($uid, $status);
        return response()->json(array(
            'code' => $flag
        ));
    }

    /**
     * 添加用户界面
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function userCreatePage(Request $request)
    {
        $action = $_COOKIE["menuaction"];
        return view('admin/user_add')->with('action', $action);
    }

    /**
     * 添加用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUser(Request $request)
    {
        $unme = $request->has('unme') ? $request->input('unme') : '';
        $uacc = $request->has('uacc') ? $request->input('uacc') : '';
        $uem = $request->has('uem') ? $request->input('uem') : '';
        $phone = $request->has('phone') ? $request->input('phone') : '';
        $sex = $request->has('sex') ? $request->input('sex') : '';
        $age = $request->has('age') ? $request->input('age') : '';
        $headpic = $request->has('headpic') ? $request->input('headpic') : '';
        $address = $request->has('address') ? $request->input('address') : '';
        $remark = $request->has('remark') ? $request->input('remark') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        if ($unme == '' || $uacc == '' || $sex == '' || $status == '') {
            return response()->json(array(
                'code' => 102
            ));
        } else {
            $user = new User();
            $user['name'] = $unme;
            $user['sex'] = $sex;
            $user['age'] = $age;
            $user['account'] = $uacc;
            $user['password'] = md5(SYS_USER_PWD);
            //$user['password'] = Hash::make(SYS_USER_PWD);
            $user['headpic'] = $headpic;
            $user['phone'] = $phone;
            $user['email'] = $uem;
            $user['status'] = $status;
            $user['address'] = $address;
            $user['remark'] = $remark;
            $flag = $user->save();
            if ($flag) {
                return response()->json(array(
                    'code' => 101
                ));
            }
            return response()->json(array(
                'code' => 102
            ));
        }

    }

    /**
     * 跳转到用户编辑页面
     * @param $uid
     * @return $this
     */
    public function userEditCreate($uid)
    {
        $user = new User();
        $action = $_COOKIE["menuaction"];
        $u = $user->getUserById($uid);
        if (count($u) > 0) {
            return view('admin/user_edit')
                ->with('user', $u)
                ->with('action', $action);
        }

    }

    /**
     * 编辑菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editUser(Request $request)
    {
        $unme = $request->has('unme') ? $request->input('unme') : '';
        $uacc = $request->has('uacc') ? $request->input('uacc') : '';
        $uem = $request->has('uem') ? $request->input('uem') : '';
        $phone = $request->has('phone') ? $request->input('phone') : '';
        $sex = $request->has('sex') ? $request->input('sex') : '';
        $age = $request->has('age') ? $request->input('age') : '';
        $address = $request->has('address') ? $request->input('address') : '';
        $remark = $request->has('remark') ? $request->input('remark') : '';
        $uid = $request->has('uid') ? $request->input('uid') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        if ($unme == '' || $uacc == '' || $sex == '' || $status == '') {
            return response()->json(array(
                'code' => 102
            ));
        } else {
            $user = new User();
            $userInfo = $user->getUserById($uid);
            $user['id'] = intval($uid);
            $user['name'] = $unme;
            $user['sex'] = $sex;
            $user['age'] = intval($age);
            $user['account'] = $uacc;
            $user['phone'] = $phone;
            $user['address'] = $address;
            $user['email'] = $uem;
            $user['status'] = $status;
            $user['remark'] = $remark;
            if (collect($user) == collect($userInfo)) {
                return response()->json(array(
                    'code' => 101
                ));
            } else {
                $flag = $user->editUser($user);
                if ($flag) {
                    return response()->json(array(
                        'code' => 101
                    ));
                } else {
                    return response()->json(array(
                        'code' => 102
                    ));
                }
            }
        }
    }

    /**
     * 重置密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPwd(Request $request)
    {
        $uid = $request->has('uid') ? $request->input('uid') : '';
        $user = new User();
        $flag = $user->resetPwd($uid);
        if ($flag) {
            return response()->json(array(
                'code' => 101
            ));
        } else {
            return response()->json(array(
                'code' => 102
            ));
        }
    }

    /**
     * 用户详情
     * @param $uid
     * @return $this
     */
    public function userInfo($uid)
    {
        $user = new User();
        $u = $user->getUserInfo($uid);
        return view('admin/user_info')
            ->with('user', $u);
    }

    /**
     * 用户添加角色页面
     * @param $uid
     * @return $this
     */
    function userFunc($uid)
    {
        $role = new Role();
        $roles = $role->getAllRoles();
        $user_role_arr = $role->getUserRoles($uid);
        if (empty($user_role_arr)) {
            $user_role_arr = array();
        }
        return view('admin/user_role')
            ->with('roles', $roles)
            ->with('uid', $uid)
            ->with('userRole', $user_role_arr);
    }

    /**
     * 给用户添加角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserRoles(Request $request)
    {

        $uid = $request->has('uid') ? $request->input('uid') : '';
        $rid = $request->has('rid') ? $request->input('rid') : '';
        if (empty($uid) || empty($rid)) {
            return response()->json(array(
                'code' => 102,
                'msg' => 'sucess'
            ));
        } else {
            $user = new User();
            $user->delUserRoles($uid);
            Log::info('用户ID-------------' . $uid);
            $flag = $user->saveUserRoles($uid, $rid);
            if ($flag) {
                return response()->json(array(
                    'code' => 101,
                    'msg' => 'sucess'
                ));
            }
            return response()->json(array(
                'code' => 102,
                'msg' => 'fail'
            ));
        }
    }

}
