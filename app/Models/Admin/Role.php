<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

/**
 * 角色操作类
 * Class Role
 * @package App\Models\Admin
 */
class Role extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'hdb_role';

    protected $primaryKey = 'role_id';

    public $timestamps = false;

    /**
     * 更新角色可用状态
     * @param $rid
     * @param $status
     * @return bool
     */
    public function updateStatus($rid, $status)
    {
        $flag = DB::update("update hdb_role set status =? where role_id = ?", [$status, $rid]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    /**
     * 获取所有角色列表
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getRoleList($num)
    {
        $roles = DB::table('hdb_role')
            ->select('role_id', 'role_name', 'status')
            ->paginate($num);
        return $roles;
    }

    /**
     * 查询所有角色(返回数组)
     * @return array
     */
    public function getArryAllRoles()
    {
        $roles = DB::table('hdb_role')
            ->select('role_id', 'role_name')
            ->get();
        $arr = array();
        if ($roles != null) {
            foreach ($roles as $key => $value) {
                $arr [$roles[$key]->role_id] = $roles[$key]->role_name;
            }
        }
        return $arr;
    }

    /**
     * 根据ID获取角色信息
     * @param $rid
     * @return \___PHPSTORM_HELPERS\static
     */
    public function  getRoleInfoById($rid)
    {
        $role = DB::table('hdb_role')
            ->select('role_id', 'role_name', 'status')
            ->where('role_id', $rid)
            ->get();
        return $role[0];
    }

    /**
     * 编辑角色
     * @param $role
     * @return bool
     */
    public function editRole($role)
    {
        $flag = DB::update('update hdb_role set role_name =?,status=? where role_id = ?', [$role['role_name'], $role['status'], $role['role_id']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * 查询所有角色
     * @return array|static[]
     */
    public function getAllRoles()
    {
        $roles = DB::table('hdb_role')
            ->select('role_id', 'role_name')
            ->where('status', 'y')
            ->get();
        return $roles;
    }

    /**
     * 获取某个角色已经拥有的权限
     * @param $rid
     * @return array
     */
    public function getRoleFunc($rid)
    {
        $menus = DB::table('hdb_role_operate')
            ->select('menu_id')
            ->where('role_id', $rid)
            ->get();
        $arr = array();
        if ($menus != null) {
            foreach ($menus as $key => $value) {
                $arr [] = $menus[$key]->menu_id;
            }
        }
        return $arr;
    }

    /**
     * 保存角色权限关联
     * @param $rid
     * @param $mid
     * @return bool
     */
    public function saveRoleMenu($rid, $mid)
    {
        $flag = DB::insert('insert into hdb_role_operate (role_id, menu_id) values (?, ?)', [$rid, $mid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * 删除该角色拥有的权限
     * @param $rid
     * @return bool
     */
    public function delRoleMenu($rid)
    {
        $flag = DB::delete('delete from hdb_role_operate where role_id=?', [$rid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * 获取所有可用的菜单
     * @return array|static[]
     */
    public function getAllMenus()
    {
        $menus = DB::table('hdb_menu')
            ->select('menu_id', 'menu_name', 'sort', 'fid', 'icon','hdb_menu.menu_url')
            ->where('status', 'y')
            ->orderBy('sort', 'asc')
            ->get();
        return $menus;
    }

    /**
     * 获取某个用户拥有的角色集合数组
     * @param $uid
     * @return array
     */
    public function getUserRoles($uid)
    {
        $roles = DB::table('hdb_user_role')
            ->select('role_id', 'user_id')
            ->where('user_id', $uid)
            ->get();
        $arr = array();
        if (count($roles > 0)) {
            foreach ($roles as $key => $value) {
                $arr [] = $roles[$key]->role_id;
            }
        }
        return $arr;
    }

    /**
     * 获取角色拥有的权限
     * @param $rid
     * @return array
     */
    public function getMenusByRids($ids)
    {
        $menus = DB::table('hdb_role_operate')
            ->join('hdb_menu', 'hdb_role_operate.menu_id', '=', 'hdb_menu.menu_id')
            ->select('hdb_menu.menu_id', 'hdb_menu.menu_name', 'hdb_menu.fid', 'hdb_menu.icon', 'hdb_menu.menu_url')
            ->where('status', 'y')
            ->whereIn('hdb_role_operate.role_id', $ids)
            ->orderBy('sort', 'asc')
            ->get();
        /*$arr = array();
        if ($menus != null) {
            foreach ($menus as $key => $value) {
                $arr [] = $menus[$key]->menu_id;
            }
        }*/
        return $menus;
    }
}