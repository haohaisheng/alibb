<?php
namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppQuestion extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'bb_question as question';

    public $timestamps = false;


    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    //protected $fillable = array('id', 'phone', 'mail', 'sid', 'bbid', 'bbname', 'password');

    
}