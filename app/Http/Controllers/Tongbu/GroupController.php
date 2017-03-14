<?php

namespace App\Http\Controllers\Tongbu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, Response, DB;
use App\Models\Admin\Group;
use Log;

/**
 * create by:haohaisheng
 * Class UserController
 * date  2016/7/25
 * @package App\Http\Controllers\Tongbu
 */
class GroupController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = get_token(Session::get('login_alibaba'));;
    }

    /**
     *
     * @param Request $request
     * @return mixed
     *
     */
    public function getGroupById($groupid)
    {
        if (empty($groupid)) {
            echo 'groupid  is null ';
            return false;
        }
        // session_start();
        //$token_one = $_SESSION['login_alibaba'];

        $token_one = get_token(Session::get('login_alibaba'));
        // Log::info('get group  ------2---' . $token_one . '++++++++++++' . Session::get('login_alibaba'));
        $post_data['access_token'] = $token_one;
        $post_data['webSite'] = 'alibaba';
        $post_data['groupID'] = $groupid;
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.group.getList/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.group.getList/" . APP_KEY . "?access_token=" . $token_one . '&groupID=' . $groupid . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        if (property_exists(json_decode($response), 'productGroupInfo')) {
            $data = json_decode($response)->productGroupInfo;
            if (!empty($data)) {
                foreach ($data as $val) {
                    $group = new Group();
                    $info = $group->getGroupInfo($val->name);
                    if (empty($info)) {
                        $group->groupid = $val->id;
                        $group->name = $val->name;
                        $group->parentID = $val->parentID;
                        $group->save();
                    }
                    $this->getGroupById($val->id);
                }
            }
        }

    }

    public function getGroupById1($groupid)
    {
        if (empty($groupid)) {
            echo 'groupid  is null ';
            return false;
        }
        // session_start();
        //$token_one = $_SESSION['login_alibaba'];

        $token_one = get_token(Session::get('login_alibaba'));
        // Log::info('get group  ------2---' . $token_one . '++++++++++++' . Session::get('login_alibaba'));
        $post_data['access_token'] = $token_one;
        $post_data['webSite'] = 'alibaba';
        $post_data['groupID'] = $groupid;
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.group.getList/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.group.getList/" . APP_KEY . "?access_token=" . $token_one . '&groupID=' . $groupid . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        if (property_exists(json_decode($response), 'productGroupInfo')) {
            $data = json_decode($response)->productGroupInfo;
            if (!empty($data)) {
                foreach ($data as $val) {
                    $group = new Group();
                    $info = $group->getGroupInfo($val->name);
                    if (empty($info)) {
                        $group->groupid = $val->id;
                        $group->name = $val->name;
                        $group->parentID = $val->parentID;
                        $group->save();
                    }
                    $this->getGroupById($val->id);
                }
            }
        }
        return response()->json(array(
            'code' => 101
        ));

    }

    public function getCategoryById($cateid)
    {
        if (empty($cateid)) {
            echo 'groupid  is null ';
            return false;
        }
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $post_data['groupID'] = $cateid;
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.group.getList/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.group.getList/" . APP_KEY . "?access_token=" . $this->token . '&groupID=' . $groupid . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $data = json_decode($response)->productGroupInfo;
        if (!empty($data)) {
            foreach ($data as $val) {
                $group = new Group();
                $group->groupid = $val->id;
                $group->name = $val->name;
                $group->parentID = $val->parentID;
                //$group->save();
                $this->getGroupById($val->id);
            }
        }
    }

    public function getGroupList()
    {
        $group = new Group();
        $data = $group->getGroupList();
        return json_encode($data);
    }
}
