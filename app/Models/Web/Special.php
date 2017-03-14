<?php

namespace App\Models\Web;
use Illuminate\Database\Eloquent\Model;

use DB;


class Special extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bb_special';

    //获得指定阶段的专题信息数组
    public function getSpecialByStage($stage_id){
        if(intval($stage_id)==0){
            return array();
        }

        $r=getDataCache('array_SpecialByStage_'.$stage_id);

        if(empty($r)){

            $temp=$this->select('id','short_title','title_img','question_count','focus_count','answer_count')
                ->whereRaw('concat(",",stage_id,",") like "%,'.$stage_id.',%"')
                ->where('stauts', 0)
                ->orderBy('id', 'desc')
                ->get();

            if(!empty($temp)){
                foreach ($temp as $v){
                    $r[$v->id]=array(
                        'special_id' => $v->id,
                        'special_title' => $v->short_title,
                        'special_img' => PIC_URL.$v->title_img,
                        'question_count' => $v->question_count,
                        'answer_count' => $v->answer_count,
                    );
                }
            }
           

            putDataCache('array_SpecialByStage_'.$stage_id,$r,24*60);
        }
        return $r;

    }


    //获得用户关注的专题id数组
    public function getShowSpecialID($member_id){
        if(intval($member_id)==0){
            return array();
        }

        $r=getDataCache('array_ShowSpecialID_'.$member_id);

        if(empty($r)){

            $member_model = new Member;
            $member = $member_model->select('sid','special_focus','special_noshow')
                ->where('id',$member_id)
                ->where('status', 0)
                ->first();

           if ($member == null) {
                $noshow_specials = array();
                $focus_specials = array();
                $stage_specials = array();
            } else {
                $noshow_specials = explode(',', $member->special_noshow);        //用户设置不显示的专题id
                $focus_specials = explode(',', $member->special_focus);          //用户关注的专题id
                //查找所属阶段
                $stage_id = DB::select('select id from bb_stage where msid = :msid and stauts=1', ['msid' => $member->sid]);
                if (empty($stage_id)) {
                    $stage_specials = array();
                } else {
                    $stage_id = $stage_id[0]->id;
                    //根据阶段获得 按阶段推荐的专题id
                    $stage_specials = Special::selectRaw('GROUP_CONCAT(id) as id')
                        ->whereRaw('concat(",",stage_id,",") like "%,' . $stage_id . ',%"')
                        ->where('stauts', 0)
                        ->orderBy('id', 'desc')
                        ->first();
                    $stage_specials = explode(',', $stage_specials->id);
                }
            }

            //计算测试数据
            // $stage_specials = array(2,3,4,5,6,7,8,9);
            // $noshow_specials = array(4,5,6,7,8);
            // $focus_specials = array(9,10);

            
            $r = array_diff($stage_specials,$noshow_specials);  //过滤stage_specials数组中的$noshow_specials数组数值
            $r = array_merge($r,$focus_specials);   //合并关注数组 
            $r = array_unique($r);                  //删除重复专题id
            $r = array_filter($r);                  //删除空元素

            putDataCache('array_ShowSpecialID_'.$member_id,$r,24*60);
        }
        return $r;
    }


    //获得用户关注的专题的数量
    public function getShowSpecialCount($member_id){
        $p = $this->getShowSpecialID($member_id);
        return count($p);
    }



    //关注专题
    public function focus($member_id,$special_id){
        
        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);

        if(empty($temp)){
            return  array(false,'用户数据错误',1004,'用户不存在');
        }else{
            $member=$temp[0];
        }
        //验证专题有效性
        $temp = DB::select('select id,short_title from bb_special where id = :id and stauts=0', ['id' => $special_id]);
        if(empty($temp)){
            return  array(false,'专题数据错误',1012,'操作失败');
        }else{
            $special=$temp[0];
        }


        //更新special_focus：新建或更新对应记录
        $temp = DB::select('select id,status from bb_special_focus where special_id = :special_id and member_id = :member_id', ['special_id' => $special_id,'member_id' => $member_id]);
        if(empty($temp)){
            //新建数据
            DB::insert('insert into bb_special_focus (member_id, special_id,status) values (?,?,?)',[$member_id, $special_id,3]);
        }else{
            if($temp[0]->status == 3){
                return array(false,'重复关注',1012,'操作失败');
            }else{
                //更新数据
                $r = DB::update('update bb_special_focus set status = 3 where id = ?', [$temp[0]->id]);
                if($r!=1){
                    return array(false,'数据更新失败',1014,'写入数据失败');
                }
            }
        }

        //更新member：关注专题id字段special_focus更新
        $temp = DB::select('select GROUP_CONCAT(special_id) as id from bb_special_focus where status = 3 and member_id = :member_id', ['member_id' => $member_id]);     //获得关注专题
        $idstr = $temp[0]->id;
        $r = DB::update('update bb_member set special_focus = ? where id = ?', [$idstr,$member_id]);
        
        
        //更新special：关注数字段focus_count +1
        $r = DB::update('update bb_special set focus_count = focus_count + 1 where id = ?', [$special_id]);
        
        //更新record_specialfocus：新建关注记录
        DB::insert('insert into bb_record_specialfocus (member_id, membername,birthday,stage_id,action_type,model_type,special_id,specialtitle,add_time,add_ip) values (?,?,?,?,?,?,?,?,?,?)',
          [$member->id, $member->nickname,(is_null($member->expected)?0:strtotime($member->expected)),$member->sid,1,'focus',$special->id,$special->short_title,time(),GetIp()]);

        //让缓存失效，以更新数据重新生成
        forgetDataCache('array_ShowSpecialID_'.$member_id);

        return array(true);

    }

    //取消关注
    public function unfocus($member_id,$special_id){
        
        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);
        if(empty($temp)){
            return  array(false,'用户数据错误',1004,'用户不存在');
        }else{
            $member=$temp[0];
        }
        //验证专题有效性
        $temp = DB::select('select id,short_title from bb_special where id = :id and stauts=0', ['id' => $special_id]);
        if(empty($temp)){
            return  array(false,'专题数据错误',1012,'操作失败');
        }else{
            $special=$temp[0];
        }


        //取消关注标识：true 取消自己的关注，false 取消系统默认的关注
        $guanzhuflag=false;
        //更新special_focus：更新对应记录
        $temp = DB::select('select id,status from bb_special_focus where special_id = :special_id and member_id = :member_id', ['special_id' => $special_id,'member_id' => $member_id]);
        if(empty($temp)){
            //系统关注
            $guanzhuflag=false;
        }else{
            //更新数据
            $r = DB::update('update bb_special_focus set status = 4 where status = 3 and id = ?', [$temp[0]->id]);
            if($r==1){
                $guanzhuflag=true;
            }
        }


        //更新special_noshow：新建或更新对应记录
        $temp = DB::select('select id,status from bb_special_noshow where special_id = :special_id and member_id = :member_id', ['special_id' => $special_id,'member_id' => $member_id]);
        if(empty($temp)){
            //新建数据
            DB::insert('insert into bb_special_noshow (member_id, special_id,status) values (?,?,?)',[$member_id, $special_id,3]);
        }else{
            if($temp[0]->status != 3){
                //更新数据
                $r = DB::update('update bb_special_noshow set status = 3 where id = ?', [$temp[0]->id]);
            }
        }


        //更新member：关注专题id字段special_focus、special_noshow更新
        $temp = DB::select('select GROUP_CONCAT(special_id) as id from bb_special_focus where status = 3 and member_id = :member_id', ['member_id' => $member_id]);     //获得关注专题
        $focusidstr = $temp[0]->id;
        $temp = DB::select('select GROUP_CONCAT(special_id) as id from bb_special_noshow where status = 3 and member_id = :member_id', ['member_id' => $member_id]);     //获得不显示专题
        $noshowidstr = $temp[0]->id;
        $r = DB::update('update bb_member set special_focus = ?,special_noshow = ? where id = ?', [$focusidstr,$noshowidstr,$member_id]);
        
        //取消自己的关注才减关注数
        if($guanzhuflag){
            //更新special：关注数字段focus_count -1
            $r = DB::update('update bb_special set focus_count = focus_count - 1 where id = ?', [$special_id]);
        }
       
        
        //更新record_specialfocus：新建关注记录
        DB::insert('insert into bb_record_specialfocus (member_id, membername,birthday,stage_id,action_type,model_type,special_id,specialtitle,add_time,add_ip) values (?,?,?,?,?,?,?,?,?,?)',
          [$member->id, $member->nickname,(is_null($member->expected)?0:strtotime($member->expected)),$member->sid,2,'focus',$special->id,$special->short_title,time(),GetIp()]);

        //让缓存失效，以更新数据重新生成
        forgetDataCache('array_ShowSpecialID_'.$member_id);

        return array(true);

    }


    /**
     * 获得数组格式的专题信息
     * @param  string  $ids 或 array id数组   专题id串如：id1,id2,id3
     * @return array  可通过专题id直接访问信息 如：$array[$id]['short_title']
     */
    public function getSpecialArray($ids){
        $r=array();
        if(empty($ids) or $ids == ''){
            return $r;
        }
        //格式转化
        if(is_array($ids)){
            $ids = implode(',',$ids);
        }
        //$temp = DB::select('select id,short_title from bb_special where id in (?) and stauts=0', [$ids]);         //无法正常in查询
        $temp = DB::select('select id,short_title,title_img,question_count,answer_count from bb_special where id in ('.$ids.') and stauts=0');
        if(!empty($temp)){
            foreach ($temp as $v){
                $r[$v->id]=array(
                    'special_id' => $v->id,
                    'special_title' => $v->short_title,
                    'special_img' => PIC_URL.$v->title_img,
                    'question_count' => $v->question_count,
                    'answer_count' => $v->answer_count,
                );
            }
        }
        return  $r;
    }


}

//********************
//******page end******
//********************
