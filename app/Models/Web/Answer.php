<?php
namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Web\Notification;

class Answer extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'bb_answer';

    protected $primaryKey = 'answer_id';

    public $timestamps = false;
    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    //protected $fillable = array('id', 'phone', 'mail', 'sid', 'bbid', 'bbname', 'password');


    /**
     * 判断是否收藏
     * @param  int $member_id 用户id
     * @param  array $answer_id 问题id
     * @return boolean true收藏  false未收藏
     */
    public function focus_state($member_id, $answer_id)
    {
        //以后可引入cookie缓存机制，减少查询
        $r = false;

        if (intval($answer_id) == 0) {
            return $r;
        }


        $temp = DB::select('select count(*) as num from bb_answer_focus where status = 3 and answer_id = ?  and member_id = ?', [$answer_id, $member_id]);
        //转数组
        if ($temp[0]->num > 0) {
            $r = true;
        }
        return $r;
    }


    /**
     * 判断是否收藏
     * @param  int $member_id 用户id
     * @param  array $answer_ids 问题id数组集合
     * @return array 关注状态数组 array[$answer_id]=true收藏  false未收藏
     */
    public function focus_array($member_id, $answer_ids)
    {
        //以后可引入cookie缓存机制，减少查询
        $r = array();

        if (empty($answer_ids)) {
            return $r;
        }

        $answer_idstr = implode(',', $answer_ids);

        $temp = DB::select('select GROUP_CONCAT(answer_id) as id from bb_answer_focus where status = 3 and answer_id in (' . $answer_idstr . ') and member_id = ?', [$member_id]);
        //转数组
        $focus_answer = explode(',', $temp[0]->id);
        foreach ($answer_ids as $v) {
            if (in_array($v, $focus_answer)) {
                $r[$v] = true;
            } else {
                $r[$v] = false;
            }
        }
        return $r;
    }


    /**
     * 获得赞成反对状态
     * @param  int $member_id 用户id
     * @param  array $answer_id 问题id
     * @return int 1赞同  2反对 0无状态
     */
    public function praise_state($member_id, $answer_id)
    {
        //以后可引入cookie缓存机制，减少查询
        $r = 0;
        if (intval($answer_id) == 0) {
            return $r;
        }

        $praise_answer = DB::select('select answer_id,pa_type from bb_answer_praise where status = 3 and answer_id = ?  and member_id = ?', [$answer_id, $member_id]);

        if (!empty($praise_answer[0])) {
            $r = $praise_answer[0]->pa_type;
        }
        return $r;
    }


    /**
     * 获得赞成反对状态
     * @param  int $member_id 用户id
     * @param  array $answer_ids 问题id数组集合
     * @return array 赞成反对状态数组 array[$answer_id]=1赞同  2反对 0无状态
     */
    public function praise_array($member_id, $answer_ids)
    {
        //以后可引入cookie缓存机制，减少查询
        $r = array();
        if (empty($answer_ids)) {
            return $r;
        }

        $answer_idstr = implode(',', $answer_ids);
        $praise_answer = DB::select('select answer_id,pa_type from bb_answer_praise where status = 3 and answer_id in (' . $answer_idstr . ') and member_id = ?', [$member_id]);

        foreach ($answer_ids as $v) {
            $temp = 0;
            foreach ($praise_answer as $vv) {
                if ($v == $vv->answer_id) {
                    $temp = $vv->pa_type;
                    break;
                }
            }
            $r[$v] = $temp;
        }
        return $r;
    }


    //关注问题
    public function focus($member_id, $answer_id)
    {

        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);

        if (empty($temp)) {
            return array(false, '用户数据错误', 1004, '用户不存在');
        } else {
            $member = $temp[0];
        }
        //验证回答有效性
        $answer = DB::select('select answer_id from bb_answer where answer_id = :id and status=3', ['id' => $answer_id]);
        if (empty($answer)) {
            return array(false, '回答数据错误', 1012, '操作失败');
        } else {
            $answer = $answer[0];
        }


        //更新answer_focus：新建或更新对应记录
        $temp = DB::select('select id,status from bb_answer_focus where answer_id = :answer_id and member_id = :member_id', ['answer_id' => $answer_id, 'member_id' => $member_id]);
        if (empty($temp)) {
            //新建数据
            DB::insert('insert into bb_answer_focus (member_id,answer_id,status) values (?,?,?)', [$member_id, $answer_id, 3]);
        } else {
            if ($temp[0]->status == 3) {
                return array(false, '重复收藏', 1012, '操作失败');
            } else {
                //更新数据
                $r = DB::update('update bb_answer_focus set status = 3 where id = ?', [$temp[0]->id]);
                if ($r != 1) {
                    return array(false, '数据更新失败', 1014, '写入数据失败');
                }
            }
        }

        //更新answer：关注数字段focus_count +1
        $r = DB::update('update bb_answer set focus_count = focus_count + 1 where answer_id = ?', [$answer_id]);

        return array(true);

    }

    //取消关注问题
    public function unfocus($member_id, $answer_id)
    {

        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);
        if (empty($temp)) {
            return array(false, '用户数据错误', 1004, '用户不存在');
        } else {
            $member = $temp[0];
        }

        //验证回答有效性
        $answer = DB::select('select answer_id from bb_answer where answer_id = :id and status=3', ['id' => $answer_id]);
        if (empty($answer)) {
            return array(false, '回答数据错误', 1012, '操作失败');
        } else {
            $answer = $answer[0];
        }


        //更新bb_answer_focus：更新对应记录
        $temp = DB::select('select id,status from bb_answer_focus where answer_id = :answer_id and member_id = :member_id', ['answer_id' => $answer_id, 'member_id' => $member_id]);
        if (empty($temp)) {
            return array(false, '回答数据错误', 1012, '操作失败');
        } else {
            if ($temp[0]->status == 4) {
                return array(false, '重复取消收藏', 1012, '操作失败');
            } else {
                //更新数据
                $r = DB::update('update bb_answer_focus set status = 4 where id = ?', [$temp[0]->id]);
                if ($r != 1) {
                    return array(false, '数据更新失败', 1014, '写入数据失败');
                }
            }

        }


        //更新answer：关注数字段focus_count -1
        $r = DB::update('update bb_answer set focus_count = focus_count - 1 where answer_id = ?', [$answer_id]);

        return array(true);

    }


    //回答：赞同
    public function praise($member_id, $answer_id)
    {

        $r = $this->updateAnswerPraise($member_id, $answer_id, 1, 3);
        if ($r[0]) {
            $question_id = $r[1]['question_id'];
            $answer_member_id = $r[1]['member_id'];
            $question = DB::select('select title from bb_question where question_id = :id and status=3', ['id' => $question_id]);
            if (!empty($question)) {
                $question = $question[0];

                //插入消息提醒
                $notification = new Notification();
                $notification['sender_id'] = 0;                         //系统发送：默认id是0
                $notification['recipient_id'] = $answer_member_id;      //接收用户id
                $notification['action_member_id'] = $member_id;         //操作用户id
                $notification['action_type'] = 1;                       //点赞

                $notification['model_type'] = 'answer';                 //提醒相关的数据类型
                $notification['source_id'] = $answer_id;                //提醒相关的数据id
                $notification['model_view'] = 'answer';                 //显示相关的数据类型
                $notification['view_id'] = $answer_id;                  //显示相关的数据id

                $notification['content'] = $question->title;            //提示内容（问题标题）
                $notification['add_time'] = time();                     //发送时间戳
                $notification['read_flag'] = 2;                         //阅读状态    1：已读 2：未读
                $notification['status'] = 3;                            //状态标识位   3：正常 4：删除
                $notification['question_id'] = $question_id;                            //问题id
                $notification['answer_id'] = $answer_id;                            //回答id


                $nflag = $notification->save();

                //根据提示信息内容
                // $data = array(
                //     'sender_id' => 0 ,                      
                //     'recipient_id' =>  $answer_member_id,   
                //     'action_member_id' => $member_id,       
                //     'action_type' => 1,    


                //     'model_type' => 'answer' ,
                //     'source_id' => $answer_id ,         
                //     'model_view' => 'answer' ,          
                //     'view_id' => $answer_id ,           


                //     'content' => $question->title,                    
                //     'add_time' => time(),               
                //     'read_flag' => 1,                   
                //     'status' => 3,                      
                // );
                // //插入消息提醒
                // Notification::save($data);


            }
        }

        return $r;
    }

    //回答：取消赞同
    public function unpraise($member_id, $answer_id)
    {

        $r = $this->updateAnswerPraise($member_id, $answer_id, 1, 4);
        return $r;
    }

    //回答：反对
    public function against($member_id, $answer_id)
    {

        $r = $this->updateAnswerPraise($member_id, $answer_id, 2, 3);
        return $r;

    }

    //回答：取消反对
    public function unagainst($member_id, $answer_id)
    {

        $r = $this->updateAnswerPraise($member_id, $answer_id, 2, 4);
        return $r;

    }


    /**
     * 处理回答赞成反对操作
     * @param  int $member_id 用户id
     * @param  int $answer_id 回答id
     * @param  int $pa_type 赞同反对标志：1赞同  2反对
     * @param  int $status 记录状态：3正常  4取消删除
     * @return array
     * $pa_type , $status 组合意义
     * 赞同 1 , 3
     * 取消赞同 1 , 4
     * 反对 2 , 3
     * 取消反对 2 , 4
     */
    public function updateAnswerPraise($member_id, $answer_id, $pa_type, $status)
    {

        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);
        if (empty($temp)) {
            return array(false, '用户数据错误', 1004, '用户不存在');
        } else {
            $member = $temp[0];
        }

        //验证回答有效性
        $answer = DB::select('select answer_id,question_id,member_id from bb_answer where answer_id = :id and status=3', ['id' => $answer_id]);
        if (empty($answer)) {
            return array(false, '回答数据错误', 1012, '操作失败');
        } else {
            $answer = $answer[0];
        }

        //更新bb_answer_praise：新建或更新对应记录
        $temp = DB::select('select id,status from bb_answer_praise where answer_id = :answer_id and member_id = :member_id', ['answer_id' => $answer_id, 'member_id' => $member_id]);
        if (empty($temp)) {
            if ($status == 3) {
                //非取消操作，新建数据
                DB::insert('insert into bb_answer_praise (member_id,answer_id,pa_type,status,addtime) values (?,?,?,?,?)', [$member_id, $answer_id, $pa_type, $status, time()]);
            }
        } else {

            //更新数据
            $r = DB::update('update bb_answer_praise set pa_type = ? , status = ? where id = ?', [$pa_type, $status, $temp[0]->id]);
            if ($r != 1) {
                return array(false, '数据更新失败', 1014, '写入数据失败');
            }
        }


        //赞同数量
        $temp = DB::select('select count(*) as num from bb_answer_praise where answer_id = :answer_id and pa_type = :pa_type and status = 3', ['answer_id' => $answer_id, 'pa_type' => 1]);
        $agree_count = $temp[0]->num;
        //反对数量
        $temp = DB::select('select count(*) as num from bb_answer_praise where answer_id = :answer_id and pa_type = :pa_type and status = 3', ['answer_id' => $answer_id, 'pa_type' => 2]);
        $against_count = $temp[0]->num;
        //排序数
        $sort_count = $agree_count - $against_count;
        //更新answer 
        $r = DB::update('update bb_answer set agree_count = ? , against_count = ? , sort_count = ? where answer_id = ?', [$agree_count, $against_count, $sort_count, $answer_id]);

        return array(true, ['question_id' => $answer->question_id, 'member_id' => $answer->member_id]);

    }


    /**
     * 获得提问相关的用户id
     * （如果问题无人回答，则相关用户是提问用户；如果有人回答，则相关用户是最佳答案用户）
     * @param  object $questions 查询获得的结果集对象，查询字段必须包括：question_id,answer_count,member_id
     * @return object  追加过question_member_id的结果集对象
     */
    function getQuestionsMemberId($questions)
    {
        //问题id及用户id统计集合
        $question_ids = array();
        foreach ($questions as $v) {
            if ($v->answer_count > 0) {
                //有回答，显示回答者信息
                $question_ids[] = $v->question_id;
            }
        }

        if (!empty($question_ids)) {
            //查询问题对应最佳答案用户id
            $temp = DB::select('select question_id,member_id from bb_answer as tt where status=3 and question_id in (' . implode(',', array_unique($question_ids)) . ') group by question_id,agree_count having agree_count=(select max(agree_count) from bb_answer where question_id=tt.question_id)');
        } else {
            $temp = array();
        }


        foreach ($questions as $k => $v) {
            if ($v->answer_count <= 0) {
                //没有回答，显示提问者信息
                $questions[$k]->questions_member_id = $v->member_id;
            } else {
                //有回答，显示最佳回答者信息
                foreach ($temp as $vv) {
                    if ($vv->question_id == $v->question_id) {
                        $questions[$k]->questions_member_id = $vv->member_id;
                        break;
                    }
                }
                //防止意外没有匹配上，付默认值
                if ($questions[$k]->questions_member_id == '') {
                    $questions[$k]->questions_member_id = $v->member_id;
                }
            }
        }
        return $questions;
    }
}

//********************
//******page end******
//********************