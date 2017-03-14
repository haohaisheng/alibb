<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class keyMatchSet extends Model
{
    protected $table = 'hdb_key_matchingset';

    protected $primaryKey = 'id';

    public $timestamps = false;

}
