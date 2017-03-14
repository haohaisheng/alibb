<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Role;
use App\Models\Admin\Menu;
use Session, DB;
use Log;

class RoleController extends Controller
{
    public function __construct()
    {
        Session::start();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin/role_list');
    }

    /**
     * 创建角色页面
     * @return \Illuminate\View\View
     */
    public function roleCreatePage()
    {
        $action = $_COOKIE["menuaction"];
        return view('admin/role_add')->with('action', $action);
    }

    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveRole(Request $request)
    {
        $rname = $request->has('rname') ? $request->input('rname') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        if ($rname == '' || $status == '') {
            return response()->json(array(
                'code' => 102
            ));
        } else {
            $role = new Role();
            $role['role_name'] = $rname;
            $role['status'] = $status;
            $flag = $role->save();
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
     * 获取所有角色列表
     * @param Request $request
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function roleList(Request $request)
    {
        $num = 10;
        $role = new Role();
        $roles = $role->getRoleList($num);
        if (count($roles) > 0) {
            return $roles;
        }
        return array();
    }

    /**
     * 更新角色可用状态̬
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRoleStatus(Request $request)
    {
        $rid = $request->has('rid') ? $request->input('rid') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $role = new Role();
        $flag = $role->updateStatus($rid, $status);
        return response()->json(array(
            'code' => $flag
        ));
    }

    /**
     * 跳转到角色编辑页面̬
     * @param $rid
     * @return $this
     */
    public function roleEditCreate($rid)
    {
        $role = new Role();
        $action = $_COOKIE["menuaction"];
        if ($rid != '') {
            $m = $role->getRoleInfoById($rid);
            if (count($m) > 0) {
                return view('admin/role_edit')
                    ->with('action', $action)
                    ->with('role', $m);
            }
        }
    }

    /**
     * 编辑菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editRole(Request $request)
    {
        $rname = $request->has('rname') ? $request->input('rname') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $rid = $request->has('rid') ? $request->input('rid') : '';
        if ($rname == '' || $status == '' || $rid == '') {
            return response()->json(array(
                'code' => 102
            ));
        } else {
            $role = new Role();
            $roleInfo = $role->getRoleInfoById($rid);
            $role['role_id'] = intval($rid);
            $role['role_name'] = $rname;
            $role['status'] = $status;
            if (collect($role) == collect($roleInfo)) {
                return response()->json(array(
                    'code' => 101
                ));
            } else {
                $flag = $role->editRole($role);
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
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleDel(Request $request)
    {
        $rid = $request->has('rid') ? $request->input('rid') : '';
        $ids = explode(',', $rid);
        Role::destroy($ids);
        return response()->json(array(
            'code' => 101
        ));
    }

    /**
     * 角色赋权限页面
     * @param $rid
     * @return $this
     */
    public function roleFunc($rid)
    {
        $role = new Role();
        $action = $_COOKIE["menuaction"];
        $roleInfo = $role->getRoleInfoById($rid);
        $rname = $roleInfo->role_name;
        //获取该角色已经拥有的权限
        $funcs = $role->getRoleFunc($rid);
        $menus = $role->getAllMenus();
        //获取所有的权限列表
        return view('admin/role_func')
            ->with('rid', $rid)
            ->with('funcs', $funcs)
            ->with('menus', $menus)
            ->with('rname', $rname)
            ->with('action', $action);
    }

    /**
     * 保存角色权限关联
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveRoleMenus(Request $request)
    {
        $rid = $request->has('rid') ? $request->input('rid') : '';
        $mid = $request->has('mid') ? $request->input('mid') : '';
        if ($rid == '' || $mid == '') {
            return response()->json(array(
                'code' => 102
            ));
        }
        $ids = explode("-", $mid);
        $ids = array_unique($ids);
        $role = new Role();
        //保存之前先清除该角色关联的权限
        $role->delRoleMenu($rid);
        foreach ($ids as $val) {
            $flag = $role->saveRoleMenu($rid, $val);
            if (!$flag) {
                return response()->json(array(
                    'code' => 102
                ));
            }
        }
        return response()->json(array(
            'code' => 101
        ));
    }
}
