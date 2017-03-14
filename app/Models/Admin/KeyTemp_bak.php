<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class KeyTemp extends Model
{
    protected $table = 'hdb_select_key_temp';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * @param $productid
     * @return bool
     * ɾ����ʱ�ؼ���
     */
    public function deleteKeyTemp($fid, $id)
    {
        $flag = DB::delete('delete from hdb_select_key_temp where key_cateid=? and key_id=?', [$fid, $id]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function advancedsetInfo()
    {
        $sets = DB::table('hdb_key_matchingset')
            ->select('id', 'matching_set', 'matching_model', 'matching_key', 'key_format')
            ->get();
        return $sets;
    }

    public function updateAdvancedset($param)
    {
        $flag = DB::update('update hdb_key_matchingset set matching_set =?,matching_model=? ,matching_key=?  where id = ?', [$param['matching_set'], $param['matching_model'], $param['matching_key'], $param['id']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    /**
     * @param $cateId
     * @return array|static[]
     * ��ȡѡ�е���ʱ�ؼ���
     */
    public function getKeyTemp($cateId)
    {
        $keys = DB::table('hdb_select_key_temp')
            ->select('id', 'key_cate', 'key_cateid', 'key_name', 'key_id')
            ->where('key_cateid', $cateId)
            ->where('status', 2)
            ->get();
        return $keys;
    }

    /**
     * @return array|static[]
     * ��ȡҪ��������ʱ��Ʒ�б�
     */
    public function getTempProductList()
    {
        $products = DB::table('hdb_product_temp')
            ->select('id', 'subject', 'key1', 'key2', 'key3', 'subject1', 'status')
            ->get();
        return $products;
    }

    /**
     * @param $keyparam
     * @param $matchkey
     * @return bool
     * �Զ����ɹؼ���
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


    public function updateTempTitle($id, $title,$userid)
    {
        $flag = DB::update('update hdb_product_temp set subject1= ? where id = ? and userid=?', [$title, $id,$userid]);
        if ($flag) {



            return true;
        }
        return false;
    }

    public function titleFormat()
    {
        $format = DB::table('hdb_title_format')
            ->select('id', 'title')
            ->where('default', 1)
            ->get();
        return $format;
    }

    public function getAllKeyTemp()
    {
       /* echo '-----';
        $keys = DB::table('hdb_select_key_temp')
            ->select('id', 'key_cate', 'key_cateid', 'key_name', 'key_id')
            ->get();
        return $keys;*/

        $format = DB::table('hdb_title_format')
            ->select('id', 'title')
            ->where('default', 1)
            ->get();
        return $format;
    }

}
