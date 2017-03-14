<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class KeyTemp extends Model
{
    protected $table = 'hdb_select_key_temp';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * @param $productid
     * @return bool
     * 删除临时关键词
     */
    public function deleteKeyTemp($fid, $id)
    {
        $flag = DB::delete('delete from hdb_select_key_temp where key_cateid=? and key_id=?', [$fid, $id]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function advancedsetInfo($userid)
    {
        $sets = DB::table('hdb_key_matchingset')
            ->select('id', 'matching_set', 'matching_model', 'matching_key', 'key_format')
            ->where('userid', $userid)
            ->get();
        return $sets;
    }

    public function updateAdvancedset($param, $userid)
    {

        $sets = DB::table('hdb_key_matchingset')
            ->where('userid', $userid)
            ->get();
        if (empty($sets)) {
            $key = new keyMatchSet();
            $key->matching_set = $param['matching_set'];
            $key->matching_model = $param['matching_model'];
            $key->matching_key = $param['matching_key'];
            $key->userid = $userid;
            $flag = $key->save();
        } else {
            $flag = DB::update('update hdb_key_matchingset set matching_set =?,matching_model=? ,matching_key=?  where id = ? and userid=?', [$param['matching_set'], $param['matching_model'], $param['matching_key'], $param['id'], $userid]);
        }
        return true;
    }

    /**
     * @param $cateId
     * @return array|static[]
     * 获取选中的临时关键词
     */
    public function getKeyTemp($cateId, $userid)
    {
        $keys = DB::table('hdb_select_key_temp')
            ->select('id', 'key_cate', 'key_cateid', 'key_name', 'key_id')
           // ->where('key_cateid', $cateId)
            ->where('userid', $userid)
            //->where('status', 2)
            ->get();
        return $keys;
    }

    /**
     * @return array|static[]
     * 获取要发布的临时产品列表
     */
    public function getTempProductList($userid)
    {
        $products = DB::table('hdb_product_temp')
            ->where('userid', $userid)
            ->get();
        return $products;
    }

    public function getTempProductByIdList($productid, $userid)
    {
        $products = DB::table('hdb_product_temp')
            ->where('productID', $productid)
            ->where('userid', $userid)
            ->get();
        return $products;
    }

    /**
     * @param $keyparam
     * @param $matchkey
     * @return bool
     * 自动生成关键词
     */
    public function updateTempProduct($id, $keyparam, $matchkey)
    {
        $colum = array('key', 'key1', 'key2', 'key3');
        $setkeys = explode(',', $matchkey);
        array_push($keyparam, $id);
        $sql = '';
        foreach ($setkeys as $val) {
            $sql = $sql . ',' . $colum[$val] . '=? ';
        }
        $sql = substr($sql, 1);
        $flag = DB::update('update hdb_product_temp set ' . $sql . ' where id = ?', $keyparam);
        if ($flag) {
            return true;
        }
        return false;
    }


    //更新标题
    public function updateTempTitle($id, $title, $userid)
    {
        $flag = DB::update('update hdb_product_temp set subject1= ? where id = ? and userid=?', [$title, $id, $userid]);
        if ($flag) {
            $list = DB::table('hdb_product_temp')
                ->where('userid', $userid)
                ->get();
            $pro = new Product();
            foreach ($list as $val) {
                $json = json_decode($val->json_data);
                $json->subject = $title;
                $pro->updateTempJsonData($val->productID, json_encode($json), $userid);
            }
            return true;
        }
        return false;
    }

    //标题格式
    public function titleFormat()
    {
        $format = DB::table('hdb_title_format')
            ->select('id', 'title')
            ->where('default', 1)
            ->get();
        return $format;
    }

    public function getAllKeyTemp($userid)
    {
        $keys = DB::table('hdb_select_key_temp')
            ->select('id', 'key_cate', 'key_cateid', 'key_name', 'key_id')
            ->where('userid', $userid)
            ->get();
        return $keys;
    }

    /**
     * @param $param
     * @param $id
     * @return bool
     * 匹配更新产品主图信息
     */
    public function updateImageProduct($param, $id, $userid, $json_data)
    {
        $sql = '';
        $data = array();
        $imgs = '';
        $images = array();
        foreach ($param as $key => $val) {
            $sql = $sql . ',' . $key . '=?';
            $data[] = $val;
            $images[] = $val;
            if ($imgs == '') {
                $imgs = $imgs . $val;
            } else {
                $imgs = $imgs . ',' . $val;
            }
        }
        $sql = $sql . ',images=?';
        array_push($data, $imgs);
        array_push($data, $id);
        array_push($data, $userid);
        $sql = substr($sql, 1);
        $pro = new Product();
        $flag = DB::update('update hdb_product_temp set ' . $sql . ' where id = ? and userid=?', $data);
        if ($flag) {
            $json_data->image->images = $images;
            $pro->updateTempJsonData($id, json_encode($json_data), $userid);
            return true;
        }
        return false;
    }

    public function updateImageBatchProduct($param, $id, $userid, $json_data)
    {
        $sql = '';
        $data = array();
        $imgs = '';
        $images = array();
        foreach ($param as $key => $val) {
            $sql = $sql . ',' . $key . '=?';
            $data[] = $val;
            $images[] = $val;
            if ($imgs == '') {
                $imgs = $imgs . $val;
            } else {
                $imgs = $imgs . ',' . $val;
            }
        }
        $sql = $sql . ',images=?';
        array_push($data, $imgs);
        array_push($data, $id);
        array_push($data, $userid);
        $sql = substr($sql, 1);
        $pro = new Product();
        $flag = DB::update('update hdb_product set ' . $sql . ' where type=2 and  id = ? and userid=?', $data);
        if ($flag) {
            $json_data->image->images = $images;
            $pro->updateTempJsonData($id, json_encode($json_data), $userid);
            return true;
        }
        return false;
    }

}
