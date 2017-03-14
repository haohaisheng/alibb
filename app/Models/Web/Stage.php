<?php

namespace App\Models\Web;
use Illuminate\Database\Eloquent\Model;


class Stage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bb_stage';


    /**
     * 按怀孕状态格式化阶段
     * @param  int  $stage_id   阶段高亮判断
     * @return array
     */
    public function getStagebyGestate($stage_id){
    	
    	$data=$this->select('id','name','gestate')
    		->where('stauts', 1)
            ->orderBy('gestate', 'asc')
            ->orderBy('rank', 'asc')
            ->get(); 

        $r=array(
        	1=>array('name'=>'备孕中~'),
        	2=>array('name'=>'怀孕ing~'),
        	3=>array('name'=>'有宝宝~'),
        );
        foreach ($data as $a) {
        	
        	if($a->id == $stage_id){
        		$r[$a->gestate]['data'][]=array(
	        		'id' => $a->id,
	        		'name' => $a->name,
	        		'focus' => true,
	        	);
	        	$r[$a->gestate]['focus'] = true;
        	}else{
        		$r[$a->gestate]['data'][]=array(
	        		'id' => $a->id,
	        		'name' => $a->name,
	        	);
        	}
        }

        return $r;
    }

}

//********************
//******page end******
//********************