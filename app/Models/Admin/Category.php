<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    //
    protected $table = 'hdb_category';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function getCateinfoById($cateid)
    {
        $data = DB::table('hdb_category')
            ->select('categoryID', 'name', 'enName', 'level', 'isLeaf', 'parentIDs', 'childIDs')
            ->where('categoryID', $cateid)
            ->get();
        return $data;
    }
}
