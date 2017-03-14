<?php

namespace App\Http\Controllers\Tongbu;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Session, Response, DB;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use Log;

/**
 * create by:haohaisheng
 * Class UserController
 * date  2016/7/25
 * @package App\Http\Controllers\Tongbu
 */
class ProductController extends Controller
{
    protected $token;
    protected $userid;

    public function __construct()
    {
        $this->token = get_token(Session::get('login_alibaba'));
        $this->userid = Session::get('login_alibaba');
    }

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
        return view('tongbu/product_list')->with('curaction', $curr_action);
    }

    /**
     * @return $this
     * 今日操作
     */
    public function today()
    {
        $curr_action = $_SERVER['REQUEST_URI'];
        return view('tongbu/today_product')->with('curaction', $curr_action);
    }

    /**
     *
     * @param Request $request
     * @return mixed
     * 产品管理
     */
    public function productList(Request $request)
    {
        $product = new Product();
        $status = $request->has('status') ? $request->input('status') : '';
        $page = $request->has('page') ? $request->input('page') : 1;
        $num = 15;
        $products = $product->getProductList($num, $status, $this->userid);
        if (count($products) > 0) {
            //分组
            $pro = new Product();
            $grouplist = $pro->getGroupList();
            $group = array();
            foreach ($grouplist as $val) {
                $group[$val->groupid] = $val->name;
            }
            //类目
            $catelist = $pro->getCategoryList();
            $cate = array();
            foreach ($catelist as $val) {
                $cate[$val->categoryID] = $val->enName;
            }
            foreach ($products as $val) {
                $json = json_decode($val->json_data);
                foreach ($json->attributes as $a) {
                    if ($a->attributeName == 'Model Number') {
                        $val->xinghao = $a->value;
                    }
                }
                $val->groupname = $group[$val->groupID];
                $val->catename = $cate[$val->categoryID];
            }
            return $products;
        }
        return array();
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日操作产品
     */
    public function todayProduct(Request $request)
    {
        $product = new Product();
        $status = $request->has('status') ? $request->input('status') : 'today';
        $page = $request->has('page') ? $request->input('page') : 1;
        $num = 15;
        $time = date('Y-m-d') . ' 00:00:00';
        if ($status == 'today') {
            $products = $product->getTodayProduct($num, $time);
        } else if ($status == 'create') {
            $products = $product->getTodayCreate($num, $time);
        } else if ($status == 'update') {
            $products = $product->getTodayUpdate($num, $time);
        } else {
            $products = $product->getTodayProduct($num, $time);
        }
        if (!empty($products)) {
            $pro = new Product();
            //分组
            $grouplist = $pro->getGroupList();
            $group = array();
            foreach ($grouplist as $val) {
                $group[$val->groupid] = $val->name;
            }
            //类目
            $catelist = $pro->getCategoryList();
            $cate = array();
            foreach ($catelist as $val) {
                $cate[$val->categoryID] = $val->enName;
            }
            foreach ($products as $val) {
                $json = json_decode($val->json_data);
                foreach ($json->attributes as $a) {
                    if ($a->attributeName == 'Model Number') {
                        $val->xinghao = $a->value;
                    }
                }
                $val->groupname = $group[$val->groupID];
                $val->catename = $cate[$val->categoryID];
            }
            return $products;
        }
        return array();
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日搜索更新
     */
    public function searchToday(Request $request)
    {
        $product = new Product();
        $key = $request->has('key') ? $request->input('key') : '';
        $cateid = $request->has('cateid') ? $request->input('cateid') : '';
        $page = $request->has('page') ? $request->input('page') : 1;
        $num = 15;
        $time = date('Y-m-d') . ' 00:00:00';
        $products = $product->searchProductToday($num, $key, $cateid, $time);
        if (count($products) > 0) {
            return $products;
        }
        return array();
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 产品搜索
     */
    public function search(Request $request)
    {
        $product = new Product();
        $key = $request->has('key') ? $request->input('key') : '';
        $cateid = $request->has('cateid') ? $request->input('cateid') : '';
        $page = $request->has('page') ? $request->input('page') : 1;
        $num = 15;
        $products = $product->searchProduct($num, $key, $cateid);
        if (count($products) > 0) {
            //分组
            $pro = new Product();
            $grouplist = $pro->getGroupList();
            $group = array();
            foreach ($grouplist as $val) {
                $group[$val->groupid] = $val->name;
            }
            //类目
            $catelist = $pro->getCategoryList();
            $cate = array();
            foreach ($catelist as $val) {
                $cate[$val->categoryID] = $val->enName;
            }
            foreach ($products as $val) {
                $json = json_decode($val->json_data);
                foreach ($json->attributes as $a) {
                    if ($a->attributeName == 'Model Number') {
                        $val->xinghao = $a->value;
                    }
                }
                $val->groupname = $group[$val->groupID];
                $val->catename = $cate[$val->categoryID];
            }
            return $products;
        }
        return array();
    }

    public function deleteProduct(Request $request)
    {
        $ids = $request->has('ids') ? $request->input('ids') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $p = new Product();
        foreach ($ids as $id) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['productID'] = $id;
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.delete/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.delete/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&productID=' . $id . '&_aop_signature=' . $sing;
            $response = request_get($url);
        }
        $p->deleteProductByIds($ids, $this->userid);
        $p->deleteProductAttributeByIds($ids, $this->userid);
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

}
