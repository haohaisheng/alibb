<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class ProductTemp extends Model
{
    protected $table = 'hdb_product_temp';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * 获取所有商品列表
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductTempList($num, $status, $userid)
    {
        $products = DB::table('hdb_product_temp')
            ->where('status', $status)
            ->where('userid', $userid)
            ->orderBy('createtime', 'desc')
            ->paginate($num);
        return $products;
    }

    /**
     * @param $num
     * @param $para
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 今日修改
     */
    public function getTodayProduct($num, $para)
    {
        if (!empty($para)) {
            if ($para == 'send') {
                $products = DB::table('hdb_product')
                    ->where('status', 'online')
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
     * @param $productid
     * @return bool
     * 删除商品基本信息
     */
    public function deleteProductBasic($productid)
    {
        $flag = DB::delete('delete from hdb_product where productID=?', [$productid]);
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
    public function deleteProductAttribute($productid)
    {
        $flag = DB::delete('delete from hdb_product_attribute where productID=?', [$productid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * 情况所有复制的临时数据
     */
    public function deleteAllProductTemp($userid)
    {
        $flag = DB::table('hdb_product_temp')->where('userid', $userid)->delete();
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
     * @param $content
     * @return bool
     * 更新复制数据的
     */
    public function updateProductDesc($content, $userid)
    {
        $flag = DB::update("update hdb_product_temp set description =? ", [$content]);
        //更新json数据
        $list = DB::table('hdb_product_temp')
            ->where('userid', $userid)
            ->get();
        $pro = new Product();
        foreach ($list as $val) {
            $json = json_decode($val->json_data);
            $json->description = $content;
            $pro->updateTempJsonData($val->productID, json_encode($json), $userid);
        }
        if (!$flag) {
            return false;
        }
        return true;
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

    public function removeFabu($productid, $userid)
    {
        $flag = DB::delete('delete from hdb_product_temp where productID=? and userid=?', [$productid, $userid]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function updateFabuTitle($content, $id, $userid)
    {
        $flag = DB::update("update hdb_product_temp set subject1 =? where  id=? and userid=? ", [$content, $id, $userid]);
        if ($flag) {
            return true;
        }
        return true;
    }

    public function updateTempData($json, $userid)
    {
        $flag = DB::update("update hdb_product_temp set json_data =? where userid=? ", [$json, $userid]);
        if ($flag) {
            return true;
        }
        return true;
    }

    public function updateTempImage($sql, $data)
    {
        $flag = DB::update("update hdb_product_temp " . $sql . "  where userid=? ", $data);
        if ($flag) {
            return true;
        }
        return true;
    }

    public function deleteAllSelectKey($userid)
    {
        $flag = DB::table('hdb_select_key_temp')->where('userid', $userid)->delete();
        if ($flag) {
            return true;
        }
        return false;
    }

}


