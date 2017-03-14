<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoodOption extends Model
{
    //
    protected $table = 'hdb_good_option';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function saveGoodOption($parm = array())
    {
        $flag = DB::insert('insert into hdb_good_option (propName, thumb,offerId) values (?,?, ?)', [$parm['propName'], $parm['thumb'], $parm['offerId']]);
        if ($flag) {
            return true;
        }
        return false;
    }
}
