<?php
namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Log;

class Question extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'bb_question';

    public $timestamps = false;


    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    //protected $fillable = array('id', 'phone', 'mail', 'sid', 'bbid', 'bbname', 'password');

    //是否关注
    public function is_focus($member_id, $question_id)
    {
        //以后可引入cookie缓存机制，减少查询
        if (intval($member_id) == 0 or intval($question_id) == 0) {
            return false;
        }

        $temp = DB::select('select id,status from bb_question_focus where status = 3 and question_id = :question_id and member_id = :member_id', ['question_id' => $question_id, 'member_id' => $member_id]);
        if (empty($temp)) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * 判断是否收藏
     * @param  int $member_id 用户id
     * @param  array $question_ids 问题id数组集合
     * @return array 关注$question_id数组
     */
    public function focus_array($member_id, $question_ids)
    {
        //以后可引入cookie缓存机制，减少查询
        $r = array();

        if (empty($question_ids)) {
            return $r;
        }

        $question_idstr = implode(',', $question_ids);

        $temp = DB::select('select GROUP_CONCAT(question_id) as id from bb_question_focus where status = 3 and question_id in (' . $question_idstr . ') and member_id = ?', [$member_id]);
        //转数组
        $r = explode(',', $temp[0]->id);

        return $r;
    }


    //关注问题
    public function focus($member_id, $question_id)
    {
        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);

        if (empty($temp)) {
            return array(false, '用户数据错误', 1004, '用户不存在');
        } else {
            $member = $temp[0];
        }
        //验证提问有效性
        $question = DB::select('select question_id,special_id from bb_question where question_id = :id and status=3', ['id' => $question_id]);
        if (empty($question)) {
            return array(false, '问题数据错误', 1012, '操作失败');
        } else {
            $question = $question[0];
        }


        //更新question_focus：新建或更新对应记录
        $temp = DB::select('select id,status from bb_question_focus where question_id = :question_id and member_id = :member_id', ['question_id' => $question_id, 'member_id' => $member_id]);
        if (empty($temp)) {
            //新建数据
            DB::insert('insert into bb_question_focus (member_id,question_id, special_id,status) values (?,?,?,?)', [$member_id, $question_id, $question->special_id, 3]);
        } else {
            if ($temp[0]->status == 3) {
                return array(false, '重复关注', 1012, '操作失败');
            } else {
                //更新数据
                $r = DB::update('update bb_question_focus set status = 3 where id = ?', [$temp[0]->id]);
                if ($r != 1) {
                    return array(false, '数据更新失败', 1014, '写入数据失败');
                }
            }
        }
        //更新question：关注数字段focus_count +1
        $r = DB::update('update bb_question set focus_count = focus_count + 1 where question_id = ?', [$question_id]);

        return array(true);

    }

    //取消关注问题
    public function unfocus($member_id, $question_id)
    {

        //验证用户有效性
        $temp = DB::select('select id,nickname,sid,expected from bb_member where id = :id and status=0', ['id' => $member_id]);
        if (empty($temp)) {
            return array(false, '用户数据错误', 1004, '用户不存在');
        } else {
            $member = $temp[0];
        }

        //验证提问有效性
        $question = DB::select('select question_id,special_id from bb_question where question_id = :id and status=3', ['id' => $question_id]);
        if (empty($question)) {
            return array(false, '问题数据错误', 1012, '操作失败');
        } else {
            $question = $question[0];
        }


        //更新bb_question_focus：更新对应记录
        $temp = DB::select('select id,status from bb_question_focus where question_id = :question_id and member_id = :member_id', ['question_id' => $question_id, 'member_id' => $member_id]);
        if (empty($temp)) {
            return array(false, '问题数据错误', 1012, '操作失败');
        } else {
            if ($temp[0]->status == 4) {
                return array(false, '重复取消关注', 1012, '操作失败');
            } else {
                //更新数据
                $r = DB::update('update bb_question_focus set status = 4 where id = ?', [$temp[0]->id]);
                if ($r != 1) {
                    return array(false, '数据更新失败', 1014, '写入数据失败');
                }
            }

        }


        //更新question：关注数字段focus_count -1
        $r = DB::update('update bb_question set focus_count = focus_count - 1 where question_id = ?', [$question_id]);

        return array(true);

    }

    /**
     * 获取用户关注的专题
     */
    public function getSpecial($mid)
    {
        $specials = DB::table('bb_special_focus')
            ->join('bb_special', 'bb_special_focus.special_id', '=', 'bb_special.id')
            ->select('bb_special.id', 'bb_special.short_title')
            ->get();
        return $specials;
    }

    //更新回复数
    public function updateAnswerCount($id)
    {
        $flag = DB::update('update bb_question set answer_count = answer_count+1 where question_id = ?', [$id]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    //用户表中的回答数
    public function updateMemberAnswerCount($id)
    {
        $count = DB::table('bb_answer')->where('member_id', $id)->count();
        $flag = DB::update('update bb_member set answer_count =?  where id = ?', [$count, $id]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    //更新专题表中的回复数
    public function updateSpecialAnswerCount($id)
    {
        $question = DB::table('bb_question')
            ->select('question_id')
            ->where('special_id', $id)
            ->get();
        if (!empty($question)) {
            $collection = collect($question);
            $value = $collection->implode('question_id', ', ');
            $id_arr = explode(',', $value);
            $count = DB::table('bb_answer')->whereIn('question_id', $id_arr)->count();
            $flag = DB::update('update bb_special set answer_count = ? where id = ?', [$count, $id]);
            if (!$flag) {
                return false;
            }
            return true;
        }
        return false;

    }

    //更新专题表中的问题数
    public function updateQuestionCount($id)
    {
        $count = DB::table('bb_question')->where('special_id', $id)->count();
        $flag = DB::update('update bb_special set question_count = ? where id = ?', [$count, $id]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    //搜索专题
    public function searchSpecials($spname, $page, $num)
    {
        $word = '%' . $spname . '%';
        $specials = DB::table('bb_special')->select('id', 'short_title', 'question_count', 'answer_count', 'title_img')
            ->where('short_title', 'like', $word)
            ->orderBy('id', 'asc')
            ->skip($page)->take($num)
            ->get();
        return $specials;
    }

    //搜索问题_备份
    public function searchQuestions_ajax($spname, $page, $num)
    {
        $word = '%' . $spname . '%';
        $specials = DB::table('bb_question')
            ->join('bb_member', 'bb_question.member_id', '=', 'bb_member.id')
            ->select('bb_question.question_id', 'bb_question.title', 'bb_question.content', 'bb_question.answer_count',
                'bb_question.focus_count', 'bb_question.add_time', 'bb_member.nickname', 'bb_question.member_id', 'bb_question.view_count', 'bb_member.nickname',
                'bb_member.avatar_b', 'bb_question.special_id')
            ->where('bb_question.title', 'like', $word)
            ->orderBy('bb_question.add_time', 'desc')
            ->skip($page)->take($num)
            ->get();
        return $specials;
    }

    //搜索问题
    public function searchQuestions($spname, $num)
    {
        $word = '%' . $spname . '%';
        $specials = DB::table('bb_question')
            ->join('bb_member', 'bb_question.member_id', '=', 'bb_member.id')
            ->select('bb_question.question_id', 'bb_question.title', 'bb_question.content', 'bb_question.answer_count',
                'bb_question.focus_count', 'bb_question.add_time', 'bb_member.nickname', 'bb_question.member_id', 'bb_question.view_count', 'bb_member.nickname',
                'bb_member.avatar_b', 'bb_question.special_id')
            ->where('bb_question.title', 'like', $word)
            ->orderBy('bb_question.add_time', 'desc')
            ->paginate($num);
        return $specials;
    }

    //记录用户搜索内容
    public function saveSearch($search)
    {
        DB::insert('insert into bb_record_specialsearch(keyword,member_id, membername,birthday,add_time,add_ip) values (?,?,?,?,?,?)',
            [$search['keyword'], $search['member_id'], $search['membername'], $search['birthday'], $search['add_time'], $search['add_ip']]);
    }

    //更新用户表中的发帖个数
    public function updateMemberQuestionCount($id)
    {
        $count = DB::table('bb_question')->where('member_id', $id)->count();
        $flag = DB::update('update bb_member set question_count = ? where id = ?', [$count, $id]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    //获取用户预产期或宝宝生日
    public function getUserExpected($mid)
    {
        $userinfo = DB::table('bb_member')->select('id', 'expected')
            ->where('id', 'like', $mid)
            ->get();
        return $userinfo;
    }

    //判断是否已经回复过该问题
    public function ifReply($memberid, $questionid)
    {
        $count = DB::table('bb_answer')->where('question_id', $questionid)->where('member_id', $memberid)->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }

    //判断是否已经对该回复进行评论
    public function ifComment($memberid, $answer_id)
    {
        $count = DB::table('bb_answer_comment')->where('answer_id', $answer_id)->where('member_id', $memberid)->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }

    //更新回答的评论数
    public function updateCommentCount($id)
    {
        $count = DB::table('bb_answer_comment')->where('answer_id', $id)->count();
        $flag = DB::update('update bb_answer set comment_count =? where answer_id = ?', [$count, $id]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    //分页回去回答列表
    public function answerdata($questionid, $page, $num)
    {
        $answers = DB::table('bb_answer')
            ->join('bb_member', 'bb_answer.member_id', '=', 'bb_member.id')
            ->select('bb_answer.answer_id', 'bb_answer.question_id', 'bb_answer.questiontitle', 'bb_answer.content', 'bb_answer.member_id',
                'bb_answer.add_time', 'bb_answer.against_count', 'bb_answer.agree_count', 'bb_answer.comment_count', 'bb_answer.focus_count', 'bb_member.avatar_b', 'bb_member.nickname')
            ->where('bb_answer.question_id', $questionid)
            ->orderBy('bb_answer.add_time', 'asc')
            ->skip($page)->take($num)
            ->get();
        return $answers;
    }

    //分页获取评论列表
    public function commentData($answerid, $page, $num)
    {
        $comments = DB::table('bb_answer_comment')
            ->join('bb_member', 'bb_answer_comment.member_id', '=', 'bb_member.id')
            ->select('bb_answer_comment.id', 'bb_answer_comment.answer_id', 'bb_answer_comment.content', 'bb_answer_comment.addtime', 'bb_answer_comment.status', 'bb_member.avatar_b', 'bb_member.nickname')
            ->where('bb_answer_comment.answer_id', $answerid)
            ->orderBy('bb_answer_comment.addtime', 'asc')
            // ->skip($page)->take($num)
            ->get();
        return $comments;
    }

    public function updateViewCount($question_id)
    {
        $flag = DB::update('update bb_question set view_count = view_count+1 where question_id = ?', [$question_id]);
        if (!$flag) {
            return false;
        }
        return true;
    }

    //查询所有专题
    public function getAllSpecials()
    {
        $specials = DB::table('bb_special')
            ->select('id', 'short_title')
            ->get();
        $arr = array();
        if ($specials != null) {
            foreach ($specials as $key => $value) {
                $arr [$specials[$key]->id] = $specials[$key]->short_title;
            }
        }
        return $arr;
    }

    //获取用户关注的问题集合
    public function getQuestionFocus($memberid)
    {
        $focus = DB::table('bb_question_focus')
            ->select('question_id', 'member_id', 'special_id', 'status')
            ->where('member_id', $memberid)
            ->where('status', 4)
            ->get();
        $arr = array();
        if ($focus != null) {
            foreach ($focus as $key => $value) {
                Array_push($arr, $focus[$key]->question_id);
            }
        }
        return $arr;
    }

    //分页获取关注专题
    public function getSpecialListByPage($spec_arr, $page, $num)
    {
        $specials = DB::table('bb_special')
            ->select('id', 'short_title', 'title_img', 'question_count', 'answer_count')
            ->whereIn('id', $spec_arr)
            ->orderBy('addtime', 'asc')
            ->skip($page)->take($num)
            ->get();
        return $specials;
    }

    //专家列表
    public function getExperts($num)
    {
        $experts = DB::table('bb_member')
            ->select('id', 'nickname', 'avatar_b', 'job_title',
                'work_unit', 'work_number', 'work_experience', 'special_skill', 'video_url', 'expert_type')
            ->where('status', 0)
            ->where('expert_type', 3)
            ->orderBy('register_time', 'desc')
            ->paginate($num);
        return $experts;
    }

    //根据ID获取专家信息
    public function getExpertsById($id)
    {
        $expert = DB::table('bb_member')
            ->select('id', 'nickname', 'avatar_b', 'job_title',
                'work_unit', 'work_number', 'work_experience', 'special_skill', 'video_url', 'expert_type', 'sex')
            ->where('status', 0)
            ->where('expert_type', 3)
            ->where('id', $id)
            ->get();
        return $expert;
    }

    //发帖时查看该问题是否已存在
    public function  checkTitle($title)
    {
        $question = Question:: where('title', $title)
            ->select('question_id', 'title')
            ->get();
        if ($question->isEmpty()) {
            return response()->json(array(
                'flag' => false
            ));
        } else {
            return response()->json(array(
                'flag' => true
            ));
        }
    }



}