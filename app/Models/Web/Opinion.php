<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{

    protected $table = 'bb_opinion';
    
    protected $fillable = array("phone","content","mid","ip","addtime","stauts","type");
    
    public $timestamps = false;

    //保存申请专题
    public function addSpecial($specialArray)
    {
        $opinion = new Opinion();
        $opinion['content'] = $specialArray['content'];
        $opinion['mid'] = $specialArray['mid'];
        $opinion['addtime'] = $specialArray['addtime'];
        $opinion['stauts'] = $specialArray['stauts'];
        $opinion['type'] = $specialArray['type'];
        $opinion['opinion_type'] = $specialArray['opinion_type'];
        $flag = $opinion->save();
        if ($flag) {
            return true;
        }
        return false;
    }

    /*
     * 保存反馈信息
     */
    public function saveOpinion($opinionArray)
    {
        $opinion = new Opinion();
        $opinion['softname'] = $opinionArray['softname'];
        $opinion['softversion'] = $opinionArray['softversion'];
        $opinion['systemtype'] = $opinionArray['systemtype'];
        $opinion['systemversion'] = $opinionArray['systemversion'];
        $opinion['systemfbl'] = $opinionArray['systemfbl'];
        $opinion['systempp'] = $opinionArray['systempp'];


        $opinion['phone'] = $opinionArray['phone'];
        $opinion['content'] = $opinionArray['content'];
        $opinion['mid'] = $opinionArray['mid'];
        $opinion['ip'] = $opinionArray['ip'];
        $opinion['addtime'] = $opinionArray['addtime'];
        $opinion['stauts'] = $opinionArray['stauts'];
        $opinion['type'] = $opinionArray['type'];
        $flag = $opinion->save();
        if ($flag) {
            return true;
        } else {
            return false;
        }
    }
}
