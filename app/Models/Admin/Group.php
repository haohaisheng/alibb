<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Group extends Model
{
    //
    protected $table = 'hdb_product_group';

    protected $primaryKey = 'id';

    public $timestamps = false;

    //������Ʒ����
    public function saveAttributes($parm = array())
    {
        $flag = DB::insert('insert into hdb_product_attribute (productID,attributeID, attributeName,value,isCustom) values (?,?,?,?, ?)', [$parm['productID'], $parm['attributeID'], $parm['attributeName'], $parm['value'], $parm['value']]);
        if ($flag) {
            return true;
        }
        return false;
    }

    public function getGroupList()
    {
        $data = DB::table('hdb_product_group')
            ->select('name', 'groupid', 'parentID')
            ->where('parentID', '-1')
            ->get();
        return $data;
    }

    public function getGroupInfo($name)
    {
        $info = DB::table('hdb_product_group')
             ->useWritePdo()
            ->where('name', $name)
            ->get();
        return $info;
    }
}
