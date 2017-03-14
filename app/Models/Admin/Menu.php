<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Log;

class Menu extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'hdb_menu';

    protected $primaryKey = 'menu_id';

    public $timestamps = false;

    /**
     * 更新菜单可用状态
     * @param $uid
     * @param $status
     * @return bool
     */
    public function updateStatus($uid, $status)
    {
        $flag = DB::update("update hdb_menu set status =? where menu_id = ?", [$status, $uid]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    /**
     * 获取所有菜单列表
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMenuList($num)
    {
        $menus = DB::table('hdb_menu')
            ->select('menu_id', 'menu_name', 'menu_url', 'fid', 'sort', 'status', 'icon')
            ->paginate($num);
        return $menus;
    }

    /**
     * 获取所有菜单列表
     * @return array
     */
    public function getAllMenus()
    {
        $menus = DB::table('hdb_menu')
            ->select('menu_id', 'menu_name')
            ->orderBy('sort', 'asc')
            ->get();
        $arr = array();
        if ($menus != null) {
            foreach ($menus as $key => $value) {
                $arr [$menus[$key]->menu_id] = $menus[$key]->menu_name;
            }
        }
        return $arr;
    }

    /**
     * 根据ID获取菜单信息
     * @param $mid
     * @return \___PHPSTORM_HELPERS\static
     */
    public function  getMenuInfoById($mid)
    {
        $menu = DB::table('hdb_menu')
            ->select('menu_id', 'menu_name', 'menu_url', 'fid', 'status', 'sort')
            ->where('menu_id', $mid)
            ->get();
        return $menu[0];
    }

    /**
     * 获取顶级菜单
     * @return array|static[]
     */
    public function getTopMenus()
    {
        $menus = DB::table('hdb_menu')
            ->select('menu_id', 'menu_name')
            ->where('status', 'y')
            ->where('fid', 0)
            ->orderBy('sort', 'DESC')
            ->get();
        return $menus;
    }

    /**
     * 编辑菜单
     * @param $menu
     * @return bool
     */
    public function editMenu($menu)
    {
        $flag = DB::update('update hdb_menu set menu_name =?, menu_url=?,fid=?,sort=?,status=? where menu_id = ?', [$menu['menu_name'], $menu['menu_url'], $menu['fid'], $menu['sort'], $menu['status'], $menu['menu_id']]);
        if ($flag) {
            return true;
        }
        return false;
    }


}