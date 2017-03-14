<?php
namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use DB;

class AnswerFocus extends Model
{
	/**
	 * 表名
	 *
	 * @var string
	 */
	protected $table = 'bb_answer_focus as answer_focus';

    protected $primaryKey ='id';

    public $timestamps = false;
	/**
	 * 可以被集体附值的表的字段
	 *
	 * @var string
	 */
	//protected $fillable = array('id', 'phone', 'mail', 'sid', 'bbid', 'bbname', 'password');
	
}
   