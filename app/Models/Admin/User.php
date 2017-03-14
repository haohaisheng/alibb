<?php
namespace App\Models\Admin;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Log;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'hdb_user';

    public $timestamps = false;


    /**
     * 获取所有用户列表
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserList($num)
    {
        $users = DB::table('hdb_user')
            ->select('id', 'name', 'sex', 'age', 'account', 'phone', 'address', 'status', 'time')
            ->orderBy('time', 'desc')
            ->paginate($num);
        return $users;
    }

    /**
     * 更新用户可用状态
     * @param $uid
     * @param $status
     * @return bool
     */
    public function updateStatus($uid, $status)
    {
        $flag = DB::update("update hdb_user set status =? where id = ?", [$status, $uid]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    /**
     * 根据ID获取用户信息
     * @param $uid
     * @return \___PHPSTORM_HELPERS\static
     */
    public function  getUserById($uid)
    {
        $user = DB::table('hdb_user')
            ->select('id', 'name', 'sex', 'age', 'account', 'phone', 'address', 'email', 'status', 'remark')
            ->where('id', $uid)
            ->get();
        return $user[0];
    }

    /**
     * 编辑用户
     * @param $user
     * @return bool
     */
    public function editUser($user)
    {
        $flag = DB::update('update hdb_user set name =?, sex=?,age=?,phone=?,address=?,status=?,remark=? where id = ?', [$user['name'], $user['sex'], $user['age'], $user['phone'], $user['address'], $user['status'], $user['remark'], $user['id']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * 重置用户密码
     * @param $uid
     * @return bool
     */
    public function resetPwd($uid)
    {
        $flag = DB::update("update hdb_user set password =? where id = ?", [SYS_USER_PWD, $uid]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    /**
     * 根据ID获取用户信息
     * @param $uid
     * @return \___PHPSTORM_HELPERS\static
     */
    public function  getUserInfo($uid)
    {
        $user = DB::table('hdb_user')
            ->select('id', 'name', 'sex', 'age', 'account', 'phone', 'address', 'email', 'status', 'remark', 'headpic', 'time')
            ->where('id', $uid)
            ->get();
        return $user[0];
    }

    /**
     * 删除该某个用户拥有的角色
     * @param $uid
     * @return bool
     */
    public function delUserRoles($uid)
    {
        $flag = DB::delete('delete from hdb_user_role where user_id=?', [$uid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * 用户添加角色
     * @param $uid
     * @param $rid
     * @return bool
     */
    public function saveUserRoles($uid, $rid)
    {
        $ids = explode(',', $rid);
        if (count($ids) > 0) {
            $arr = array();
            foreach ($ids as $val) {
                $arr[] = array(
                    'user_id' => $uid,
                    'role_id' => $val
                );
            }
            $flag = DB::table('hdb_user_role')->insert($arr);
            if ($flag) {
                return true;
            }
            return false;
        } else {
            $flag = DB::insert('insert into hdb_user_role (user_id, role_id) values (?, ?)', [$uid, $rid]);
            if ($flag) {
                return true;
            }
            return false;
        }

    }

    /**
     * 判断用户登录
     * @param $uname
     * @param $upwd
     * @return bool
     */
    function checkLogin($uname, $upwd)
    {
        if (!empty($uname) && !empty($upwd)) {
            $user = DB::select('select id,name from hdb_user where account =? and password =?', [$uname, $upwd]);
            if (count($user) > 0) {
                return true;
            } else {
                return false;
            }

        }
        return false;
    }
}