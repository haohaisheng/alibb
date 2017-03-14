<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductAttribute extends Model
{
    //
    protected $table = 'hdb_product_attribute';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /*  //保持商品属性
      public function saveAttributes($parm = array())
      {
          $flag = DB::insert('insert into hdb_product_attribute (productID,attributeID, attributeName,value,isCustom) values (?,?,?,?, ?)', [$parm['productID'], $parm['attributeID'], $parm['attributeName'], $parm['value'], $parm['value']]);
          if ($flag) {
              return true;
          }
          return false;
      }*/


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

    /**
     * 获取所有商品列表
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductList($num, $para)
    {
        if (!empty($para)) {
            if ($para == 'online') {
                $products = DB::table('hdb_product')
                    ->where('status', 'online')
                    ->orWhere('status', 'published ')
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            } else {
                $products = DB::table('hdb_product')
                    ->where('status', $para)
                    ->orderBy('createTime', 'desc')
                    ->paginate($num);
            }
        }
        return $products;
    }
}
