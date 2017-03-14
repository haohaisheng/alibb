<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductBatch extends Model
{
    protected $table = 'hdb_product_batch';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * @return bool
     * 删除编辑的产品
     */
    public function deleteAllBatch()
    {
        $flag = DB::table('hdb_product_batch')->delete();
        if ($flag) {
            return true;
        }
        return false;
    }


    /**
     * @param $productId
     * @return array|static[]
     * 获取产品属性
     */
    public function getBatchProductAttributes($productId)
    {
        $attributes = DB::table('hdb_product_attribute_batch')
            ->where('productID', $productId)
            ->get();
        return $attributes;
    }


}


