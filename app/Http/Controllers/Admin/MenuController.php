<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;
use Session, DB;
use Log;

class MenuController extends Controller
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
        return view('admin/menu_list');
    }

    /**
     * 创建菜单页面
     * @return $this
     */
    public function menuCreatePage()
    {
        $menu = new Menu();
        $menus = $menu->getTopMenus();
        $action = $_COOKIE["menuaction"];
        return view('admin/menu_add')->with('menus', $menus)->with('action', $action);
    }

    /**
     * 添加菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveMenu(Request $request)
    {
        $mname = $request->has('mname') ? $request->input('mname') : '';
        $murl = $request->has('murl') ? $request->input('murl') : '';
        $fid = $request->has('fid') ? $request->input('fid') : '';
        $sort = $request->has('sort') ? $request->input('sort') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $icon = $request->has('icon') ? $request->input('icon') : '';
        if ($mname == '' || $murl == '' || $fid == '' || $sort == '' || $status == '') {
            return response()->json(array(
                'code' => 102
            ));
        } else {
            $menu = new Menu();
            $menu['menu_name'] = $mname;
            $menu['menu_url'] = $murl;
            $menu['fid'] = $fid;
            $menu['sort'] = $sort;
            $menu['status'] = $status;
            $menu['icon'] = $icon;
            $flag = $menu->save();
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
     * 获取所有菜单列表
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function menuList(Request $request)
    {
        $num = 10;
        $menu = new Menu();
        $menus = $menu->getMenuList($num);
        $fmenus = $menu->getAllMenus();
        $fmenus[0] = '顶级菜单';
        $ids = collect($fmenus)->keys();
        $ids = json_decode(json_encode($ids), true);
        if (count($menus) > 0) {
            foreach ($menus as $key => $value) {
                if (in_array($menus[$key]->fid, $ids)) {
                    $menus[$key]->fname = $fmenus[$menus[$key]->fid];
                } else {
                    $menus[$key]->fname = '';
                }
            }
            return $menus;
        }
    }

    /**
     * 更新菜单可用状态̬
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMenuStatus(Request $request)
    {
        $uid = $request->has('uid') ? $request->input('uid') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $menu = new Menu();
        $flag = $menu->updateStatus($uid, $status);
        return response()->json(array(
            'code' => $flag
        ));
    }

    /**
     * 跳转到菜单编辑页面̬
     * @param $mid
     * @return $this
     */
    public function menuEditCreate($mid)
    {
        $menu = new Menu();
        $menus = $menu->getTopMenus();
        $action = $_COOKIE["menuaction"];
        if ($mid != '') {
            $m = $menu->getMenuInfoById($mid);
            if (count($m) > 0) {
                return view('admin/menu_edit')
                    ->with('menus', $menus)
                    ->with('action', $action)
                    ->with('menu', $m);
            }
        }
    }

    /**
     * 编辑菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editMenu(Request $request)
    {
        $mname = $request->has('mname') ? $request->input('mname') : '';
        $murl = $request->has('murl') ? $request->input('murl') : '';
        $fid = $request->has('fid') ? $request->input('fid') : '';
        $mid = $request->has('mid') ? $request->input('mid') : '';
        $sort = $request->has('sort') ? $request->input('sort') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        if ($mname == '' || $murl == '' || $fid == '' || $sort == '' || $status == '') {
            return response()->json(array(
                'code' => 102
            ));
        } else {
            $menu = new Menu();
            $menuInfo = $menu->getMenuInfoById($mid);
            $menu['menu_id'] = intval($mid);
            $menu['menu_name'] = $mname;
            $menu['menu_url'] = $murl;
            $menu['fid'] = intval($fid);
            $menu['status'] = $status;
            $menu['sort'] = intval($sort);
            if (collect($menu) == collect($menuInfo)) {
                return response()->json(array(
                    'code' => 101
                ));
            } else {
                $flag = $menu->editMenu($menu);
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
     * 删除菜单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function menuDel(Request $request)
    {
        $mid = $request->has('mid') ? $request->input('mid') : '';
        $ids = explode(',', $mid);
        Menu::destroy($ids);
        return response()->json(array(
            'code' => 101
        ));
    }

}
