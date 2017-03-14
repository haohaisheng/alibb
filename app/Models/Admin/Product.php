<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Log;

class Product extends Model
{
    //
    protected $table = 'hdb_product';

    protected $primaryKey = 'id';

    public $timestamps = false;

    //保持商品属性
    public function saveAttributes($parm = array())
    {
        $flag = DB::insert('insert into hdb_product_attribute (productID,attributeID, attributeName,value,isCustom) values (?,?,?,?, ?)', [$parm['productID'], $parm['attributeID'], $parm['attributeName'], $parm['value'], $parm['value']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    //保持商品价格区间
    public function savePriceRange($parm = array())
    {
        $flag = DB::insert('insert into hdb_price_ranges (productID, startQuantity,price) values (?,?,?)', [$parm['productID'], $parm['startQuantity'], $parm['price']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function saveCount($parm = array())
    {
        $flag = DB::insert('insert into hdb_count (log, token,total) values (?,?,?)', [1, $parm['token'], $parm['total']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function getCount($token)
    {
        $data = DB::table('hdb_count')
            ->select('log', 'token', 'total')
            ->where('token', $token)
            ->get();
        return $data;
    }

    public function delCount($token)
    {
        $flag = DB::delete('delete from hdb_count where token=?', [$token]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function deleteProductById($productid, $userid)
    {
        $flag = DB::delete('delete from hdb_product where productID=? and userid=?', [$productid, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * 获取所有商品列表
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductList($num, $para, $userid)
    {
        if (!empty($para)) {
            if ($para == 'online') {
                $products = DB::table('hdb_product')
                    ->where('userid', $userid)
                    ->where('status', 'online')
                    ->orWhere('status', 'published ')
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            } else if ($para == 'all') {
                $products = DB::table('hdb_product')
                    ->where('userid', $userid)
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            } else {
                $products = DB::table('hdb_product')
                    ->where('userid', $userid)
                    ->where('status', $para)
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            }
        }
        return $products;
    }

    /**
     * @param $num
     * @param $para
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日修改
     */
    public function getTodayProduct_bak($num, $para, $time)
    {
        if (!empty($para)) {
            if ($para == 'send') {
                $products = DB::table('hdb_product')
                    ->where('status', 'online')
                    ->where('lastUpdateTime', '', $time)
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            } else if ($para == 'edit') {
                $date = strtotime(date('Y-m-d'));
                $products = DB::table('hdb_product')
                    ->where('lastUpdateTime', '>', $date)
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            }
        }
        return $products;
    }


    /**
     * @param $num
     * @param $time
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日操作
     */
    public function getTodayProduct($num, $time)
    {
        $products = DB::table('hdb_product')
            ->where('lastUpdateTime', '>', $time)
            ->orderBy('createTime', 'desc')
            ->paginate($num);
        return $products;
    }

    /**
     * @param $num
     * @param $time
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日创建
     */
    public function getTodayCreate($num, $time)
    {
        $products = DB::table('hdb_product')
            ->where('createTime', '>', $time)
            ->orderBy('createTime', 'desc')
            ->paginate($num);
        return $products;
    }

    /**
     * @param $num
     * @param $time
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日更新
     */
    public function getTodayUpdate($num, $time)
    {
        $products = DB::table('hdb_product')
            ->where('lastUpdateTime', '>', $time)
            ->orderBy('createTime', 'desc')
            ->paginate($num);
        return $products;
    }

    /**
     * @param $num
     * @param $para
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 产品搜索
     */
    public function searchProduct($num, $key, $cateid)
    {
        if (!empty($cateid)) {
            $products = DB::table('hdb_product')
                ->where('categoryID', $cateid)
                ->where('subject', 'like', '%' . $key . '%')
                ->orderBy('createTime', 'desc')
                ->paginate($num);
        } else {
            $products = DB::table('hdb_product')
                ->where('subject', 'like', '%' . $key . '%')
                ->orderBy('createTime', 'desc')
                ->paginate($num);
        }

        return $products;
    }

    /**
     * @param $num
     * @param $key
     * @param $cateid
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 搜索__今日操作搜索
     */
    public function searchProductToday($num, $key, $cateid, $time)
    {
        if (!empty($cateid)) {
            $products = DB::table('hdb_product')
                ->where('categoryID', $cateid)
                ->where('lastUpdateTime', '>', $time)
                ->where('subject', 'like', '%' . $key . '%')
                ->orderBy('createTime', 'desc')
                ->paginate($num);
        } else {
            $products = DB::table('hdb_product')
                ->where('lastUpdateTime', '>', $time)
                ->where('subject', 'like', '%' . $key . '%')
                ->orderBy('createTime', 'desc')
                ->paginate($num);
        }
        return $products;
    }

    /**
     * @param $productid
     * @return bool
     * 删除商品基本信息
     */
    public function deleteProductBasic($productid, $userid)
    {
        $flag = DB::delete('delete from hdb_product where productID=? and userid=?', [$productid, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @param $productid
     * @return bool
     * 删除商品属性信息
     */
    public function deleteProductAttribute($productid, $userid)
    {
        $flag = DB::delete('delete from hdb_product_attribute where productID=? and userid=?', [$productid, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @param $productid
     * @return bool
     * 更新价格区间
     */
    public function deleteProductPriceRange($productid)
    {
        $flag = DB::delete('delete from hdb_price_ranges where productID=?', [$productid]);
        if ($flag) {
            return true;
        }
        return false;
    }


    /**
     * @param $productId
     * @return array|static[]
     * 获取单个产品信息
     */
    public function getProductById($productId, $userid)
    {
        $product = DB::table('hdb_product')
            ->where('productID', $productId)
            ->where('userid', $userid)
            ->first();
        return $product;
    }

    /**
     * 根据ID获取产品
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBatchList($ids)
    {
        $list = DB::table('hdb_product')
            ->whereIn('productID', $ids)
            ->get();
        return $list;
    }

    /**
     * @param $productId
     * @return array|static[]
     * 获取产品价格区间信息
     */
    public function getProductPriceRange($productId)
    {
        $ranges = DB::table('hdb_price_ranges')
            ->where('productID', $productId)
            ->get();
        return $ranges;
    }

    /**
     * @param $productId
     * @return array|static[]
     * 获取产品属性信息
     */
    public function getProductAttributes($productId)
    {
        $attributes = DB::table('hdb_product_attribute')
            ->where('productID', $productId)
            ->get();
        return $attributes;
    }

    /**
     * @param $productId
     * @param $json
     * @return bool
     * 更新产品的json对象
     */
    public function updateJsonData($productId, $json)
    {
        $flag = DB::update('update hdb_product set json_data =? where productID = ?', [$json, $productId]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @param $productId
     * @param $json
     * @return bool
     * 编辑产品json对象
     */
    public function updateBatchData($productId, $json, $userid)
    {
        $flag = DB::update('update hdb_product set batch_data =? where productID = ? and userid=?', [$json, $productId, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function updateTempJsonData($productId, $json, $userid)
    {
        $flag = DB::update('update hdb_product_temp set json_data =? where productID = ? and userid=?', [$json, $productId, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @param $productId
     * @param $title
     * @return bool
     * 更新产品标题
     */
    public function updateTitle($productId, $title)
    {
        $flag = DB::update('update hdb_product set subject =? where productID = ?', [$title, $productId]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function updateSubject1($productId, $title, $userid)
    {
        $flag = DB::update('update hdb_product set subject1 =? where productID = ? and userid=?', [$title, $productId, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @param $ids
     * @return bool
     * 更新产品状态为编辑状态
     */
    public function updateType($ids)
    {
        $flag = DB::table('hdb_product')
            ->whereIn('productID', $ids)
            ->update(['type' => 2]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function removeBatchPorduct($userid)
    {
        $flag = DB::update('update hdb_product set type =1 where type=2 and  userid=?', [$userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @return array|static[]
     * 获取批量编辑产品
     */
    public function getProductBatchList($userid)
    {
        $batchs = DB::table('hdb_product')
            ->where('type', 2)
            ->where('userid', $userid)
            ->orderBy('createtime', 'desc')
            ->get();
        return $batchs;
    }


    public function saveDetailImgTemp($parm = array(), $userid)
    {
        $flag = DB::insert('insert into hdb_detail_img_temp (url, count,ids,userid) values (?,?,?,?)', [$parm['url'], $parm['count'], $parm['ids'], $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function getDetailImgTemp($userid)
    {
        $list = DB::table('hdb_detail_img_temp')
            ->where('userid', $userid)
            ->get();
        return $list;
    }

    public function updateDetailImgTemp_BAK($url, $id, $count)
    {
        $flag = DB::update('update hdb_detail_img_temp set count =count+' . $count . ' ,ids=CONCAT(ids,",",?) where url = ?', [$id, $url]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function updateDetailImgTemp($url, $id, $count)
    {
        $flag = DB::update('update hdb_detail_img_temp set count =count+1 ,ids=CONCAT(ids,",",?) where url = ?', [$id, $url]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function deleteDetailImg($userid)
    {
        DB::table('hdb_detail_img_temp')->where('userid', $userid)->delete();
    }

    public function getBatchProductByIds($ids)
    {
        $list = DB::table('hdb_product')
            ->where('type', 2)
            ->whereIn('productID', $ids)
            ->orderBy('createTime', 'desc')
            ->get();
        return $list;
    }

    /**
     * @param $token
     * @return array|static[]
     * 计量单位
     */
    public function getUnit()
    {
        $data = DB::table('hdb_unit')
            ->get();
        return $data;
    }

    //获取国家列表
    public function getCountry()
    {
        $data = DB::table('hdb_country')
            ->get();
        return $data;
    }

    public function getCategoryById($cateid)
    {
        $data = DB::table('hdb_category')
            ->where('parentIDs', $cateid)
            ->get();
        return $data;
    }

    public function getAllCount($userid)
    {
        $users = DB::table('hdb_product')
            ->where('userid', $userid)
            ->count();
        return $users;
    }

    public function getCategoryList()
    {
        $data = DB::table('hdb_category')
            ->get();
        return $data;
    }

    public function getGroupList()
    {
        $data = DB::table('hdb_product_group')
            ->get();
        return $data;
    }

    public function getCountTodayCreate($time, $userid)
    {
        $count = DB::table('hdb_product')
            ->where('userid', $userid)
            ->where('createTime', '>', $time)
            ->count();
        return $count;
    }

    public function getCountTodayUpdate($time, $userid)
    {
        $count = DB::table('hdb_product')
            ->where('userid', $userid)
            ->where('lastUpdateTime', '>', $time)
            ->count();
        return $count;
    }

    public function getTotalCount($userid, $userid)
    {
        $count = DB::table('hdb_product')
            ->where('userid', $userid)
            ->count();
        return $count;
    }

    //草稿箱待发布产品
    public function getWaitFabuList($num, $userid)
    {
        $products = DB::table('hdb_product_temp')
            ->where('userid', $userid)
            ->orderBy('createTime', 'desc')
            ->paginate($num);
        return $products;
    }

    //草稿箱编辑待发布产品
    public function getWaitBatchList($num, $userid)
    {
        $products = DB::table('hdb_product')
            ->where('userid', $userid)
            ->where('type', 3)
            ->orderBy('createTime', 'desc')
            ->paginate($num);
        return $products;
    }

    //草稿箱发布
    public function getBoxList($num, $status, $key, $userid)
    {
        if ($status == 'edit') {
            $products = DB::table('hdb_product')
                ->where('userid', $userid)
                ->where('subject', 'like', '%' . $key . '%')
                ->where('type', 2)
                ->orderBy('createTime', 'desc')
                ->paginate($num);
        } else {
            $products = DB::table('hdb_product_temp')
                ->where('userid', $userid)
                ->where('subject', 'like', '%' . $key . '%')
                ->orderBy('createTime', 'desc')
                ->paginate($num);
        }
        return $products;
    }

    public function getProductBoxTempList($userid)
    {
        $products = DB::table('hdb_product_temp')
            ->where('userid', $userid)
            ->orderBy('createtime', 'desc')
            ->get();
        return $products;
    }

    public function updateTypeBox($productId, $userid)
    {
        $flag = DB::update('update hdb_product set type =1 where productID = ? and userid=?', [$productId, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function putDraftBox($userid)
    {
        $flag = DB::update('update hdb_product set type =3 where type=2 and  userid=?', [$userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function deleteProductByIds($ids, $userid)
    {
        $list = DB::table('hdb_product')
            ->where('userid', $userid)
            ->whereIn('productID', $ids)
            ->delete();
        return $list;
    }

    public function deleteProductAttributeByIds($ids, $userid)
    {
        $list = DB::table('hdb_product_attribute')
            ->where('userid', $userid)
            ->whereIn('productID', $ids)
            ->delete();
        return $list;
    }
}
