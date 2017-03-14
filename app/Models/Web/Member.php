<?php
namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use App\Models\Web\AppQuestion;
use App\Models\Web\AppAnswer;
use App\Models\Web\QuestionFocus;
use App\Models\Web\AnswerFocus;
use DB;
session_start();
class Member extends Model
{
	/**
	 * 表名
	 *
	 * @var string
	 */
	protected $table = 'bb_member';
	
	public $timestamps = false;
	
	protected $fillable = array("extend_qq","extend_weibo","extend_weixin");

	/**
	 * 可以被集体附值的表的字段
	 *
	 * @var string
	 */
	
	
	/*
	 * 我的提问
	 */
	
	public function myQuestion($member_id){
		/*
		$temp = DB::select('select q.title,q.add_time,m.nickname,m.avatar,q.answer_count 
							from bb_question q
							left join bb_member m on m.id = q.member_id 
							where q.member_id= ? and q.status=3',[$member_id])->paginate(1);
		*/
		$temp = DB::table('bb_question as q')
				->select('q.question_id','q.title','q.add_time','q.view_count','q.focus_count','q.answer_count','m.nickname','m.avatar_b','q.answer_count')
				->leftJoin('bb_member as m','m.id','=','q.member_id')
				->where('q.member_id','=',$member_id)
				->where('q.status','=','3')
				->orderBy('q.add_time','desc')
				->paginate(9);

		
		
		return $temp;
		
	}
	/*
	 * 我的提问      APP接口
	*/
	
	public function api_myQuestion($member_id,$page,$num){
		/*
			$temp = DB::select('select q.title,q.add_time,m.nickname,m.avatar,q.answer_count
					from bb_question q
					left join bb_member m on m.id = q.member_id
					where q.member_id= ? and q.status=3',[$member_id])->paginate(1);
		*/
		$temp = AppQuestion::select('question.question_id','question.title','question.add_time','question.view_count','question.focus_count','question.answer_count','m.nickname','m.avatar_b','question.answer_count')
		->leftJoin('bb_member as m','m.id','=','question.member_id')
		->where('question.member_id','=',$member_id)
		->where('question.status','=','3')
		->where('question.question_id','!=','null')
		->orderBy('question.add_time','desc')
		->paginate($num, ['*'],'page',$page);
	
	
	
		return $temp;
	
	}
	/*
	 * 我的提问---总数
	*/
	public function myQuestionCount($member_id){
	
		$temp = DB::select('select question_count from bb_member where id= ? and status=0',[$member_id]);
		$count = $temp[0]->question_count;
		return $count;	
	}
	
	/*
	 * 我的回答
	 */
	public function myAnswer($member_id){
	/*
		$temp = DB::select('select q.title,q.add_time,a.content,a.answer_id
							from bb_answer a
							left join bb_question q on q.question_id = a.question_id 
							where a.member_id= ? and a.status=3',[$member_id]);
	*/
		
		$temp = DB::table('bb_answer as a')
		->select('q.question_id','q.title','a.add_time','a.content','a.answer_id','a.agree_count','a.questiontitle','m.nickname','m.avatar_b','m.answer_count')
		->leftJoin('bb_question as q','q.question_id','=','a.question_id')
		->leftJoin('bb_member as m','m.id','=','a.member_id')
		->where('a.member_id','=',$member_id)
		->where('a.status','=','3')
		->orderBy('a.add_time','desc')
		->paginate(9);
		
		return $temp;
	
	}
	
	/*
	 * 我的回答---APP接口
	*/
	public function api_myAnswer($member_id,$page,$num){
		/*
			$temp = DB::select('select q.title,q.add_time,a.content,a.answer_id
					from bb_answer a
					left join bb_question q on q.question_id = a.question_id
					where a.member_id= ? and a.status=3',[$member_id]);
		*/
	
		
		$temp = AppAnswer::select('q.question_id','q.title','answer.add_time','answer.content','answer.answer_id','answer.agree_count','answer.questiontitle','m.nickname','m.avatar_b','m.answer_count')
		->leftJoin('bb_question as q','q.question_id','=','answer.question_id')
		->leftJoin('bb_member as m','m.id','=','answer.member_id')
		->where('answer.member_id','=',$member_id)
		->where('answer.status','=','3')
		->where('q.question_id','!=','null')
		->orderBy('answer.add_time','desc')
		->paginate($num, ['*'],'page',$page);
		
	
		
		
		return $temp;
	
	}
	
	/*
	 * 我的回答----总数
	*/

	public function myAnswerCount($member_id){
	
		
		$temp = DB::select('select answer_count from bb_member where id= ? and status=0',[$member_id]);
		$count = $temp[0]->answer_count;
		return $count;
	
	}
	
	public function specialFocus($member_id){
	
		$temp = DB::select('select a.special_id,a.member_id,a.status,b.short_title from bb_special_focus a left join bb_special b on b.id=a.special_id where a.member_id= ? and a.status=3',[$member_id]);
	
		return $temp;
	
	}
	/*
	 * 我关注的问题
	 */
	public function questionFocus($member_id){
	/*
		$temp = DB::select('select b.title,m.nickname,m.avatar,b.answer_count,q.id from 
							bb_question_focus q 
							left join bb_question b on b.question_id=q.question_id
							left join bb_member m on m.id = b.member_id 
							where q.member_id= ? and q.status=3',[$member_id]);
	*/
		
		$temp = DB::table('bb_question_focus as q')
		->select('b.title','m.nickname','m.avatar_b','b.view_count','b.focus_count','b.answer_count','q.question_id','b.add_time')
		->leftJoin('bb_question as b','b.question_id','=','q.question_id')
		->leftJoin('bb_member as m','m.id','=','b.member_id')
		->where('q.member_id','=',$member_id)
		->where('q.status','=','3')
		->where('b.question_id','!=','null')
		->orderBy('b.add_time','desc')
		->paginate(9);
		
		
		
		return $temp;
	
	}
	/*
	 * 我关注的问题(APP接口)
	*/
	public function AppQuestionFocus($member_id,$page,$num){
			/*
			$temp = DB::select('select b.title,b.question_id,b.add_time,b.answer_count,m.nickname,m.avatar_b from
					bb_question_focus q
					left join bb_question b on b.question_id=q.question_id
					left join bb_member m on m.id = b.member_id
					where q.member_id= ? and q.status=3 order by b.add_time desc limit 0,5',[$member_id]);
			*/
			
			
			$temp = QuestionFocus::select('b.title','b.question_id','b.add_time','b.answer_count','m.nickname','m.avatar_b')
			->leftJoin('bb_question as b','b.question_id','=','question_focus.question_id')
			->leftJoin('bb_member as m','m.id','=','b.member_id')
			->where('question_focus.member_id','=',$member_id)
			->where('question_focus.status','=','3')
			->where('b.question_id','!=','null')
			->orderBy('b.add_time','desc')
			->paginate($num, ['*'],'page',$page);
			
			
		
		return $temp;
	
	}
	/*
	 * 我关注的问题总数
	 */
	
	public function questionFocusCount($member_id){
	
		$temp = DB::select('select count(*) as count from bb_question_focus where member_id= ? and status=3',[$member_id]);
		$count = $temp[0]->count;
		return $count;
	
	}
	/*
	 * 我收藏的回答
	 */
	
	public function answerFocus($member_id){
	/*
		$temp = DB::select('select q.title,q.add_time,a.content,af.id 
				from bb_answer_focus af 
				left join bb_answer a on a.answer_id=af.answer_id
				left join bb_question q on q.question_id = a.question_id
				where af.member_id= ? and af.status=3',[$member_id]);
	*/
		
		$temp = DB::table('bb_answer_focus as af')
		->select('q.question_id','q.title','a.add_time','a.content','a.answer_id','a.agree_count','a.questiontitle','a.comment_count','af.id','m.nickname','m.avatar_b')
		->leftJoin('bb_answer as a','a.answer_id','=','af.answer_id')
		->leftJoin('bb_question as q','q.question_id','=','a.question_id')
		->leftJoin('bb_member as m','m.id','=','a.member_id')
		->where('af.member_id','=',$member_id)
		->where('af.status','=','3')
		->orderBy('a.add_time','desc')
		->paginate(9);

		return $temp;
	
	}
	/*
	 * 我收藏的回答接口
	*/
	
	public function api_answerFocus($member_id,$page,$num){
		/*
			$temp = DB::select('select q.title,q.add_time,a.content,af.id
					from bb_answer_focus af
					left join bb_answer a on a.answer_id=af.answer_id
					left join bb_question q on q.question_id = a.question_id
					where af.member_id= ? and af.status=3',[$member_id]);
		*/
	
		$temp = AnswerFocus::select('q.question_id','q.title','a.add_time','a.content','a.answer_id','a.agree_count','a.questiontitle','a.comment_count','answer_focus.id','m.nickname','m.avatar_b')
		->leftJoin('bb_answer as a','a.answer_id','=','answer_focus.answer_id')
		->leftJoin('bb_question as q','q.question_id','=','a.question_id')
		->leftJoin('bb_member as m','m.id','=','a.member_id')
		->where('answer_focus.member_id','=',$member_id)
		->where('answer_focus.status','=','3')
		->where('a.answer_id','!=','null')
		->orderBy('a.add_time','desc')
		->paginate($num, ['*'],'page',$page);
	
		return $temp;
	
	}
	/*
	 * 我收藏的回答总数
	 */
	public function answerFocusCount($member_id){
	
		$temp = DB::select('select count(*) as count from bb_answer_focus where member_id= ? and status=3',[$member_id]);
	
		$count = $temp[0]->count;
		return $count;
	
	}
	/*
	 * 我关注的专题列表
	 */
	public function specialFocusList($member_id){
	
		$temp = DB::select('SELECT sf.member_id,sf.special_id,sf.status,s.sid,s.title,ms.gestate,ms.name,
				(select count(*) from bb_special_focus as bs where sf.special_id=bs.special_id) as focusCount,
				(select count(*) from bb_question qt WHERE qt.special_id=sf.special_id) as questionCount FROM bb_special_focus sf  
				left join bb_special s on s.id=sf.special_id 
				LEFT JOIN bb_member_stage ms on ms.sid=s.sid 
				where sf.member_id= ?',[$member_id]);
	
		return $temp;
	
	}
	/*
	 * 我关注的专题总数
	*/
	public function specialFocusCount($member_id){
	
		$temp = DB::select('select count(*) as count from bb_special_focus where member_id= ? and status=3',[$member_id]);
	
		$count = $temp[0]->count;
		return $count;
	
	}


	/**
     * 获得数组格式的用户信息
     * @param  string  $ids 或 array id数组   专题id串如：id1,id2,id3
     * @return array  可通过专题id直接访问信息 如：$array[$id]['nickname']
     */
    public function getMemberArray($ids){
        $r=array();
        if(empty($ids) or $ids == ''){
            return $r;
        }
        //格式转化
        if(! is_array($ids)){
            $ids = explode(',',$ids);
        }

        $temp = $this->select('id','nickname','avatar_b')
            ->whereIn('id',$ids)
            ->where('status', 0)
            ->get();
        if(!empty($temp)){
            foreach ($temp as $v){
                $r[$v->id]=array(
                    'id' => $v->id,
                    'nickname' => $v->nickname,
                    'avatar' => $v->avatar_b,
                );
            }
        }

        return  $r;
    }  
	//更新用户阶段id
    public function updateStage($stage_id,$expectedDate,$member_id){
    	
    	$rs = DB::update('update bb_member set sid = ?,expected=? where id = ?', [$stage_id,$expectedDate,$member_id]);
    	$rs1 = DB::update('update bb_baby_member set sid = ? where mid = ?', [$stage_id,$member_id]);
    	return $rs;
    }
    //获取bb_stage表id
    public function getStageid($sid){
    
    	$temp = DB::select('select s.id from bb_member_stage ms left join bb_stage s on s.msid=ms.id where ms.id= ? and s.stauts=1',[$sid]);
    
    	return $temp;
    
    }
    
    //修改用户头像
    public function updateAvatar($avatar,$member_id){
    	 
    	$rs = DB::update('update bb_member set avatar_b = ? where id = ?', [$avatar,$member_id]);
    	return $rs;
    }
    //修改用户头像---APP
    public function api_updateAvatar($avatar,$member_id){
    
    	$rs = DB::update('update bb_member set avatar = ?,avatar_b = ?,avatar_m = ?,avatar_s = ? where id = ?', [$avatar,$avatar,$avatar,$avatar,$member_id]);
    	return $rs;
    }
    
    //修改用户密码
    public function updatePassword($password,$member_id){
    
    	$rs = DB::update('update bb_member set password = ? where id = ?', [$password,$member_id]);
    	return $rs;
    }
    //修改和宝宝关系
    public function updateRelation($relation,$member_id){
    
    	$rs = DB::update('update bb_member set relation = ? where id = ?', [$relation,$member_id]);
    	return $rs;
    }
    
    //修改用户昵称
    public function updateNickname($nickname,$member_id){
    
    	$rs = DB::update('update bb_member set nickname = ? where id = ?', [$nickname,$member_id]);
    	return $rs;
    }
    
    //修改宝宝生日(或者预产期)
    public function updateBbBirthday($birthday,$member_id){
    
    	$rs = DB::update('update bb_member set expected = ? where id = ?', [$birthday,$member_id]);
    	return $rs;
    }
    
	//修改宝宝昵称
    public function updateBbNickname($nickname,$bb_id){
    
    	$rs = DB::update('update bb_baby set name = ? where id = ?', [$nickname,$bb_id]);
    	return $rs;
    }
    
    //修改宝宝性别
    public function updateBbSex($sex,$bb_id){
    
    	$rs = DB::update('update bb_baby set sex = ? where id = ?', [$sex,$bb_id]);
    	return $rs;
    }
    
	//修改宝宝阶段
    public function updateBbStageid($sex,$bb_id,$member_id){
    
    	$rs = DB::update('update bb_baby_member set sid = ? where bid = ? and mid = ?', [$sex,$bb_id,$member_id]);
    	return $rs;
    }
    
    //修改用户所在地（城市id）
    public function updateHometown($Cityid,$member_id){
    
    	$rs = DB::update('update bb_member set Cityid = ? where id = ?', [$Cityid,$member_id]);
    	return $rs;
    }
    //修改用户所在地（城市id）
    public function api_updateHometown($hometown,$member_id){
    
    	$rs = DB::update('update bb_member set hometown = ? where id = ?', [$hometown,$member_id]);
    	return $rs;
    }
    //修改用户所在地（城市id和家乡）
    public function updateAddress($Cityid,$hometown,$member_id){
    
    	$rs = DB::update('update bb_member set Cityid = ?,hometown=? where id = ?', [$Cityid,$hometown,$member_id]);
    	return $rs;
    }
    //修改用户生日
    public function updateBirthday($birthday,$member_id){
    
    	$rs = DB::update('update bb_member set birthday = ? where id = ?', [$birthday,$member_id]);
    	return $rs;
    }
    //设置第三方登录
    public function setThirdLogin($apptype,$token,$member_id){
    	if($apptype == "qq"){
    		$rs = DB::update('update bb_member set extend_qq = ? where id = ?', [$token,$member_id]);
    	}else if($apptype == "weibo"){
    		$rs = DB::update('update bb_member set extend_weibo = ? where id = ?', [$token,$member_id]);
    	}else if($apptype == "weixin"){
    		$rs = DB::update('update bb_member set extend_weixin = ? where id = ?', [$token,$member_id]);
    	}
    	
    	return $rs;
    }
    
    
    //用户注册（第一步）
    public function api_register1($phone,$password,$apptype,$extend_token){
    	//1、首先插入到bb_baby表
    	$bbid = DB::table('bb_baby')->insertGetId(
    			array('name' => '', 'pointid' => '','sex' => '','mid' => '')
    	);//bb_baby表id
    	$nickname = substr_replace ( $phone, "****", 3, 4 );
    	//2、插入用户表（bb_member）
    	$memberIP = $_SERVER["REMOTE_ADDR"];//客户端IP
    	$addtime = date ( "Y-m-d H:i:s" );//注册时间
    	$checkpass = md5 ( $password . '^' . '057fe7ed0b7440e2');
    	 
    	if($apptype=="qq"){
    		$memberid = DB::table('bb_member')->insertGetId(
    				array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 1,'extend_qq'=>$extend_token)
    		);//bb_member表id
    	}else if($apptype=="weibo"){
    		$memberid = DB::table('bb_member')->insertGetId(
    				array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 1,'extend_weibo'=>$extend_token)
    		);//bb_member表id
    	}else if($apptype=="weixin"){
    		$memberid = DB::table('bb_member')->insertGetId(
    				array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 1,'extend_weixin'=>$extend_token)
    		);//bb_member表id
    	}else{
    		$memberid = DB::table('bb_member')->insertGetId(
    				array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 1)
    		);//bb_member表id
    	}
    	
    	
    	
    	
    	//3、插入用户和宝宝关联表(bb_baby_member)
    	DB::table('bb_baby_member')->insertGetId(array('mid' => $memberid, 'bid' => $bbid,'addtime' => $addtime));
    	 
    	$rs = DB::update('update bb_baby set mid = ? where id = ?', [$memberid,$bbid]);
    	 
    	$_SESSION['memid'] = $memberid;
    	return $memberid;
    }
    
    
    //用户注册（第一步）
    public function register1($phone,$password){
    	//1、首先插入到bb_baby表
    	$bbid = DB::table('bb_baby')->insertGetId(
    			array('name' => '', 'pointid' => '','sex' => '','mid' => '')
    	);//bb_baby表id
    	$nickname = substr_replace ( $phone, "****", 3, 4 );
    	//2、插入用户表（bb_member）
    	$memberIP = $_SERVER["REMOTE_ADDR"];//客户端IP
    	$addtime = date ( "Y-m-d H:i:s" );//注册时间
    	$checkpass = md5 ( $password . '^' . '057fe7ed0b7440e2');
    	
    	$memberid = DB::table('bb_member')->insertGetId(
    			array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 1)
    	);//bb_member表id
    	//3、插入用户和宝宝关联表(bb_baby_member)
    	DB::table('bb_baby_member')->insertGetId(array('mid' => $memberid, 'bid' => $bbid,'addtime' => $addtime));
    	
    	$rs = DB::update('update bb_baby set mid = ? where id = ?', [$memberid,$bbid]);
    	
    	$_SESSION['memid'] = $memberid;
    	return $memberid;
    }
    
    /*
     * string $stype   yun_b备孕    yun_h怀孕     yun_y有宝宝
     * string $expected   预产期或宝宝生日
     * string $relation   宝宝关系
     * string $bbsex      宝宝性别
     * string $bbname     宝宝昵称
     * string $member_id  用户id
     */
    
    
    //用户注册第二步
    public function register2($stype,$expected,$relation,$bbsex,$bbname,$member_id){
    	if(!empty($expected)){
    		$expectedDate = formatStage($expected);
    	}
    	
    	if($stype=="yun_b"){
    		DB::update('update bb_member set sid = 116,y_sid=116,step=2 where id = ?', [$member_id]);
    		DB::update('update bb_baby_member set sid = 116 where mid = ?', [$member_id]);
    	}else if($stype=="yun_h"){
    		DB::update('update bb_member set sid = ?,y_sid=?,expected=?,step=2 where id = ?', [$expectedDate['id'],$expectedDate['id'],$expected,$member_id]);
    		DB::update('update bb_baby_member set sid = ? where mid = ?', [$expectedDate['id'],$member_id]);
    	}else if($stype=="yun_y"){
    		DB::update('update bb_member set sid = ?,y_sid=?,bbname=?,expected=?,relation=?,step=2 where id = ?', [$expectedDate['id'],$expectedDate['id'],$bbname,$expected,$relation,$member_id]);
    		DB::update('update bb_baby_member set sid = ? where mid = ?', [$expectedDate['id'],$member_id]);
    		DB::update('update bb_baby set name = ?,sex=? where mid = ?', [$bbname,$bbsex,$member_id]);
    		
    	}
    	$rs = true;
    	
    	return $rs;
    }
    //用户注册
    
    public function register($stype,$phone,$password,$expected,$relation,$bbsex,$bbname,$nickname,$mail,$extendType,$extendToken,$avatar){
    	
    	
    	if($stype=="yun_b"){
    		$expectedDateName = 116;
    		$expected="";
    		$relation="";
    		$bbsex=0;
    		$bbname="";
    	}else if($stype=="yun_h"){
    		if(!empty($expected)){
    			$expectedDate = formatStage($expected);
    		}
    		$expectedDateName = $expectedDate['id'];
    		$bbsex=0;
    		$bbname="";
    	}else if($stype=="yun_y"){
    		if(!empty($expected)){
    			$expectedDate = formatStage($expected);
    			$expectedDateName = $expectedDate['id'];
    		}
    	}
    	
    	
    	//1、首先插入到bb_baby表
    	$bbid = DB::table('bb_baby')->insertGetId(
    			array('name' => $bbname, 'pointid' => '','sex' => $bbsex,'mid' => '')
    	);//bb_baby表id
    	if(empty($nickname)){
    		$nickname = substr_replace ( $phone, "****", 3, 4 );
    	}
    	//2、插入用户表（bb_member）
    	$memberIP = $_SERVER["REMOTE_ADDR"];//客户端IP
    	$addtime = date ( "Y-m-d H:i:s" );//注册时间
    	$checkpass = md5 ( $password . '^' . '057fe7ed0b7440e2');
    	if($extendType==""){
    		$memberid = DB::table('bb_member')->insertGetId(
    				array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'expected' => $expected,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 2,'relation'=>$relation,'bbname'=>$bbname,'sid'=>$expectedDateName,'y_sid'=>$expectedDateName,'mail'=>$mail)
    		);//bb_member表id
    	}else{
    		if($extendType=="qq"){
    			$memberid = DB::table('bb_member')->insertGetId(
    					array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'expected' => $expected,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 2,'relation'=>$relation,'bbname'=>$bbname,'sid'=>$expectedDateName,'y_sid'=>$expectedDateName,'mail'=>$mail,'extend_qq'=>$extendToken,'avatar'=>$avatar,'avatar_b'=>$avatar,'avatar_m'=>$avatar,'avatar_s'=>$avatar)
    			);//bb_member表id
    		}else if($extendType=="weibo"){
    			$memberid = DB::table('bb_member')->insertGetId(
    					array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'expected' => $expected,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 2,'relation'=>$relation,'bbname'=>$bbname,'sid'=>$expectedDateName,'y_sid'=>$expectedDateName,'mail'=>$mail,'extend_weibo'=>$extendToken,'avatar'=>$avatar,'avatar_b'=>$avatar,'avatar_m'=>$avatar,'avatar_s'=>$avatar)
    			);//bb_member表id
    		}else if($extendType=="wechat"){
    			$memberid = DB::table('bb_member')->insertGetId(
    					array('phone' => $phone, 'bbid' => $bbid,'password' => $checkpass,'nickname' => $nickname,'expected' => $expected,'mtype' => 0,'register_time' => $addtime,'register_ip' => $memberIP,'step' => 2,'relation'=>$relation,'bbname'=>$bbname,'sid'=>$expectedDateName,'y_sid'=>$expectedDateName,'mail'=>$mail,'extend_weixin'=>$extendToken,'avatar'=>$avatar,'avatar_b'=>$avatar,'avatar_m'=>$avatar,'avatar_s'=>$avatar)
    			);//bb_member表id
    		}
    		
    	} 
    	
    	//3、插入用户和宝宝关联表(bb_baby_member)
    	DB::table('bb_baby_member')->insertGetId(array('mid' => $memberid, 'bid' => $bbid,'addtime' => $addtime,'sid'=>$expectedDate['id']));
    	 
    	$rs = DB::update('update bb_baby set mid = ? where id = ?', [$memberid,$bbid]);
    	 
    	$_SESSION['memid'] = $memberid;
    	return $memberid;
    }
    
    /*
     * 发送验证码
     * 
     * $type 短信类型  0 注册 1找回密码
     */
    public function sendSms($phone,$type){
    	$temp = DB::select('select id from bb_member where phone= ? and status = 0 limit 1 ',[$phone]);
    	if($type == 0){
    		if($temp){
    			$return = array (
    					'success' => 0,
    					'code' => '1018',
    					'msg' => '该手机号已经注册'
    			);
    		}else{
    			
    			$todaydate = date ( "Y-m-d", time () );
    			$todaytime = strtotime ( $todaydate );
    			$todaytime_last = $todaytime + 3600 * 24;
    			$sendCount = DB::select('SELECT count(*) as zs FROM bb_verifycode WHERE addtime between ? and ? and  type = ? and phone = ?',[$todaytime,$todaytime_last,$type,$phone]);
    			$count = $sendCount[0]->zs;
    			if ($count >= 10) {
    				$return = array (
    						'success' => 0,
    						'code' => '1022',
    						'msg' => '您今天操作的次数已达到上限'
    				);
    			}else {
    				$vercode = rand ( 1000, 9999 );
    				$time = time ();
    				$time_last = $time + 300;
    			
    				$verifyid = DB::table('bb_verifycode')->insertGetId(
    						array('phone' => $phone, 'code' => $vercode,'addtime' => $time,'validtime' => $time_last,'type' => $type)
    				);
    			
    			
    				if ($verifyid) {
    					header ( "Content-Type: text/html; charset=UTF-8" );
    					$con = '您正在使用同龄圈，验证码为' . $vercode . '，请填写验证码并完成操作。(同龄圈客服绝不会索取此验证码，请勿将此验证码告知他人)【同龄圈】'; //短信内容
    					 
    					 
    					$flag = 0;
    					$params = '';
    					$argv = array (
    							'sn' => 'SDK-WSS-010-08794',  ////替换成您自己的序列号
    							'pwd' => strtoupper ( md5 ( 'SDK-WSS-010-08794' . '2d8F29-0' ) ),  //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
    							'mobile' => $phone,  //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
    							'content' => $con,  //iconv( "GB2312", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//'您好测试,短信测试[签名]',//短信内容
    							'ext' => '',
    							'stime' => '',  //定时时间 格式为2011-6-29 11:09:21
    							'msgfmt' => '',
    							'rrid' => ''
    					);
    					 
    					$gets = Post_sms ( $flag, $params, $argv );
    					$line = str_replace ( "<string xmlns=\"http://tempuri.org/\">", "", $gets );
    					$line = str_replace ( "</string>", "", $line );
    					$result = explode ( "-", $line );
    					 
    					if (count ( $result ) > 1) {
    						$rs = DB::update('UPDATE bb_verifycode SET stauts = 2,error = ?  WHERE id = ?',[$xml->message,$verifyid]);
    			
    						$return = array (
    								'success' => 0,
    								'code' => '1023',
    								'msg' => '短信平台系统发送失败'
    						);
    							
    					} else {
    							
    						$rs = DB::update('UPDATE bb_verifycode SET stauts = 1 WHERE id = ?',[$verifyid]);
    						$codearr['verifycode'] = $vercode;
    						$return = array (
    								'success' => 1,
    								'code' => '1025',
    								'msg' => '请在5分钟内使用该验证码',
    								'result'=>$codearr
    						);
    					}
    					 
    				} else {
    					$return = array (
    							'success' => 0,
    							'code' => '1024',
    							'msg' => '请求有误，请重新获取'
    					);
    				}
    			}
    			
    			
    			
    			
    			
    		}
    	}else if($type == 1){
    		
    		if($temp){
    			$todaydate = date ( "Y-m-d", time () );
    			$todaytime = strtotime ( $todaydate );
    			$todaytime_last = $todaytime + 3600 * 24;
    			$sendCount = DB::select('SELECT count(*) as zs FROM bb_verifycode WHERE addtime between ? and ? and  type = ? and phone = ?',[$todaytime,$todaytime_last,$type,$phone]);
    			$count = $sendCount[0]->zs;
    			if ($count >= 10) {
    				$return = array (
    						'success' => 0,
    						'code' => '1022',
    						'msg' => '您今天操作的次数已达到上限'
    				);
    			}else {
    				$vercode = rand ( 1000, 9999 );
    				$time = time ();
    				$time_last = $time + 300;
    			
    				$verifyid = DB::table('bb_verifycode')->insertGetId(
    						array('phone' => $phone, 'code' => $vercode,'addtime' => $time,'validtime' => $time_last,'type' => $type)
    				);
    			
    			
    				if ($verifyid) {
    					header ( "Content-Type: text/html; charset=UTF-8" );
    					$con = '您正在使用同龄圈，验证码为' . $vercode . '，请填写验证码并完成操作。(同龄圈客服绝不会索取此验证码，请勿将此验证码告知他人)【同龄圈】'; //短信内容
    					 
    					 
    					$flag = 0;
    					$params = '';
    					$argv = array (
    							'sn' => 'SDK-WSS-010-08794',  ////替换成您自己的序列号
    							'pwd' => strtoupper ( md5 ( 'SDK-WSS-010-08794' . '2d8F29-0' ) ),  //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
    							'mobile' => $phone,  //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
    							'content' => $con,  //iconv( "GB2312", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//'您好测试,短信测试[签名]',//短信内容
    							'ext' => '',
    							'stime' => '',  //定时时间 格式为2011-6-29 11:09:21
    							'msgfmt' => '',
    							'rrid' => ''
    					);
    					 
    					$gets = Post_sms ( $flag, $params, $argv );
    					$line = str_replace ( "<string xmlns=\"http://tempuri.org/\">", "", $gets );
    					$line = str_replace ( "</string>", "", $line );
    					$result = explode ( "-", $line );
    					 
    					if (count ( $result ) > 1) {
    						$rs = DB::update('UPDATE bb_verifycode SET stauts = 2,error = ?  WHERE id = ?',[$xml->message,$verifyid]);
    			
    						$return = array (
    								'success' => 0,
    								'code' => '1023',
    								'msg' => '短信平台系统发送失败'
    						);
    							
    					} else {
    							
    						$rs = DB::update('UPDATE bb_verifycode SET stauts = 1 WHERE id = ?',[$verifyid]);
    						$codearr['verifycode'] = $vercode;
    						$return = array (
    								'success' => 1,
    								'code' => '1025',
    								'msg' => '请在5分钟内使用该验证码',
    								'result'=>$codearr
    						);
    					}
    					 
    				} else {
    					$return = array (
    							'success' => 0,
    							'code' => '1024',
    							'msg' => '请求有误，请重新获取'
    					);
    				}
    			}
    		}else{
    			$return = array (
    					'success' => 0,
    					'code' => '1004',
    					'msg' => '该手机号不存在'
    			);
    		}
    		
    	}
    	
    	/*
    	$todaydate = date ( "Y-m-d", time () );
    	$todaytime = strtotime ( $todaydate );
    	$todaytime_last = $todaytime + 3600 * 24;
    	$sendCount = DB::select('SELECT count(*) as zs FROM bb_verifycode WHERE addtime between ? and ? and  type = ? and phone = ?',[$todaytime,$todaytime_last,$type,$phone]);
    	$count = $sendCount[0]->zs;
    	if ($count >= 10) {
    		$return = array (
    			'success' => 0,
				'code' => '1022', 
				'msg' => '您今天操作的次数已达到上限' 
		);
    	}else {
    		$vercode = rand ( 1000, 9999 );
    		$time = time ();
    		$time_last = $time + 300;
    		
    		$verifyid = DB::table('bb_verifycode')->insertGetId(
    				array('phone' => $phone, 'code' => $vercode,'addtime' => $time,'validtime' => $time_last,'type' => $type)
    				);
    		
    		
    		if ($verifyid) {
    			header ( "Content-Type: text/html; charset=UTF-8" );
    			$con = '您正在使用同龄圈，验证码为' . $vercode . '，请填写验证码并完成操作。(同龄圈客服绝不会索取此验证码，请勿将此验证码告知他人)【同龄圈】'; //短信内容
    	
    	
    			$flag = 0;
    			$params = '';
    			$argv = array (
    					'sn' => 'SDK-WSS-010-08794',  ////替换成您自己的序列号
    					'pwd' => strtoupper ( md5 ( 'SDK-WSS-010-08794' . '2d8F29-0' ) ),  //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
    					'mobile' => $phone,  //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
    					'content' => $con,  //iconv( "GB2312", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//'您好测试,短信测试[签名]',//短信内容
    					'ext' => '',
    					'stime' => '',  //定时时间 格式为2011-6-29 11:09:21
    					'msgfmt' => '',
    					'rrid' => ''
    			);
    	
    			$gets = Post_sms ( $flag, $params, $argv );
    			$line = str_replace ( "<string xmlns=\"http://tempuri.org/\">", "", $gets );
    			$line = str_replace ( "</string>", "", $line );
    			$result = explode ( "-", $line );
    	
    			if (count ( $result ) > 1) {
    				$rs = DB::update('UPDATE bb_verifycode SET stauts = 2,error = ?  WHERE id = ?',[$xml->message,$verifyid]);
    				
    				$return = array (
    				'success' => 0,
					'code' => '1023', 
					'msg' => '短信平台系统发送失败' 
					);
    					
    			} else {
    					
    				$rs = DB::update('UPDATE bb_verifycode SET stauts = 1 WHERE id = ?',[$verifyid]);
    				$codearr['verifycode'] = $vercode;
    				$return = array (
    				'success' => 1,
					'code' => '1025',
					'msg' => '请在5分钟内使用该验证码',
    				'result'=>$codearr
					);
    			}
    	
    		} else {
    			$return = array (
    			'success' => 0,
				'code' => '1024', 
				'msg' => '请求有误，请重新获取' 
				);
    		}
    	}
    	*/
    	return  $return;
    }
    /*
     * 校验验证码
     * $phone         手机号
     * $verifycode    验证码
     * $type      短信类型    0 注册 1找回密码
     */
    
    public function verifyCode($phone,$verifycode,$type){
    	$time = time ();
    	$temp = DB::select('SELECT validtime FROM bb_verifycode WHERE code = ? and type = ? and phone = ?',[$verifycode,$type,$phone]);
    	
    	if ($temp) {
    		$verify = $temp[0]->validtime;
    		if ($time > $verify) {
    			$return = array (
    					'success' => 0,
    					'code' => 1007,
    					'msg' => '验证码超时，请重新获取'
    			);
    		} else {
    			$return = array (
    					'success' => 1,
    					'code' => 1017,
    					'msg' => '验证成功'
    			);
    		}
    	} else {
    	
    		$return = array (
    				'success' => 0,
    				'code' => 1006,
    				'msg' => '验证码有误，请重新输入'
    		);
    	}
    	
    	return $return;
    }
    /*
     * 找回密码
     * $phone  手机号
     * $verifycode  验证码
     * $newpassword  新密码
     */
    public function backPassword($phone,$verifycode,$newpassword){
    	$time = time ();
    	$temp = DB::select('SELECT validtime FROM bb_verifycode WHERE code = ? and type = 1 and phone = ?',[$verifycode,$phone]);
    	if ($temp) {
    	$verify = $temp[0]->validtime;
    	if ($time > $verify) {
    		$return = array (
    				'success' => 0,
    				'code' => 1007,
    				'msg' => '验证码超时，请重新获取'
    		);
    	} else {
    		$temp = DB::select('select id from bb_member where phone= ? and status = 0 limit 1 ',[$phone]);
    		$rsid = $temp[0]->id;
    		$checkpass = md5 ( $newpassword . '^' . '057fe7ed0b7440e2');
    		if($rsid>0){
    			DB::update('update bb_member set password= ? where id= ? ',[$checkpass,$rsid]);
    			$msg = "找回密码成功";
    			$code = 1011;
    			$codearr['verifycode'] = $verifycode;
    			$return = array (
    					'success' => 1,'msg' => $msg, 'code' => $code,'result'=>$codearr
    			);
    		}else{
    			
    			$msg = "用户不存在";
    			$code = 1004;
    			$return = array (
    					'success' => 0,'msg' => $msg, 'code' => $code
    			);
    			
    		}
    		
    	}
    	}else{
    		$return = array (
    				'success' => 0,
    				'code' => 1006,
    				'msg' => '验证码有误，请重新输入'
    		);
    	}
    	return $return;
    }
    
    /*
     * 我的消息    接口
    */
    
    public function api_getNotification($member_id,$page,$num){
    	/*
    	$temp = DB::table('bb_notification as n')
    	->select('n.recipient_id','n.action_type','n.model_type','n.add_time','n.read_flag','n.content','n.model_view','n.view_id','n.question_id','n.answer_id','m.nickname','m.avatar_b')
    	->leftJoin('bb_member as m','m.id','=','n.action_member_id')
    	->where('n.recipient_id','=',$member_id)
    	->where('n.status','=','3')
    	->orderBy('n.add_time','desc')
    	->paginate($num, ['*'],'page',$page);
    	*/
    	
    	$temp = DB::table('bb_notification as n')
    	->select('n.recipient_id','n.action_type','n.model_type','n.add_time','n.read_flag','n.content','n.model_view','n.view_id','n.question_id as n_question_id','n.answer_id','m.nickname','m.avatar_b','q.view_count as q_view_count','q.focus_count as q_focus_count','q.answer_count as q_answer_count','a.content as a_content','a.agree_count as a_agree_count','q.question_id')
    	->leftJoin('bb_member as m','m.id','=','n.action_member_id')
    	->leftJoin('bb_question as q','q.question_id','=','n.question_id','n.model_type','=','question')
    	->leftJoin('bb_answer as a','a.answer_id','=','n.answer_id','n.model_type','=','answer')
    	->where('n.recipient_id','=',$member_id)
    	->where('n.status','=','3')
    	->where('q.question_id','!=','null')
    	->orderBy('n.add_time','desc')
    	->paginate($num, ['*'],'page',$page);
    	
    	return $temp;
    
    }
    
    
    
    /*
     * 我的消息
     */
    
    public function getNotification($member_id){
 
    	
    	$temp = DB::table('bb_notification as n')
    	->select('n.recipient_id','n.action_type','n.model_type','n.add_time','n.read_flag','n.content','n.model_view','n.view_id','n.question_id as n_question_id','n.answer_id','m.nickname','m.avatar_b','q.view_count as q_view_count','q.focus_count as q_focus_count','q.answer_count as q_answer_count','a.content as a_content','a.agree_count as a_agree_count','q.question_id')
    	->leftJoin('bb_member as m','m.id','=','n.action_member_id')
    	->leftJoin('bb_question as q','q.question_id','=','n.question_id','n.model_type','=','question')
    	->leftJoin('bb_answer as a','a.answer_id','=','n.answer_id','n.model_type','=','answer')
    	->where('n.recipient_id','=',$member_id)
    	->where('n.status','=','3')
    	->where('q.question_id','!=','null')
    	->orderBy('n.add_time','desc')
		->simplePaginate(9);
    
    	
    	return $temp;
    
    }
    /*
     * 举报
    */
    
    public function report($memberid,$targetid,$type,$content){
    	  $time =time();
    	  $url = '';
    	  //新建数据
          $temp =  DB::insert('insert into bb_report (member_id,type, target_id,reason,url,add_time,status) values (?,?,?,?,?,?,1)', [$memberid, $type, $targetid,$content,$url,$time]);
          return $temp;
    }
    /*
     * 我的消息更改阅读状态（read_flag 1 已读  2 未读）
    */
    
    public function updateRead($memberid){
    	
    	$rs = DB::update('update bb_notification set read_flag = 1 where read_flag = 2 and recipient_id=?',[$memberid]);
    	return $rs;
    }
    /*
     * 判断我的消息是否有新的
     */
    public function newCountMessage($memberid){
    	$temp = DB::select('select count(*) as count from bb_notification where recipient_id= ? and read_flag=2',[$memberid]);
    	$count = $temp[0]->count;
    	return $count;
    }
    
    public function getStageName($id){
    	$temp = DB::select('select name from bb_member_stage where id= ? and stauts=1',[$id]);
    	$name = $temp[0]->name;
    	return $name;
    }
    //获取所有城市
    public function getCity($pid){
    	$temp = DB::select('SELECT * FROM bb_wap_city where pid=?',[$pid]);
    	return $temp;
    }
    //获取用户所属的阶段
    public function getStageInfo($id){
    	$temp = DB::select('select * from bb_member_stage where id= ? and stauts=1',[$id]);
    	return $temp;
    }
    //获取用户关联的宝宝信息
    public function getBbInfo($memberid){
    	$temp = DB::select('select * from bb_baby where mid= ?',[$memberid]);
    	return $temp;
    }
    
    /*
     * 记录登录日志
    */
    
    public function member_log($memberid){
    	$time =date("Y-m-d H:i:s");
    	$memberIP = $_SERVER["REMOTE_ADDR"];//客户端IP
    	//新建数据
    	$temp =  DB::insert("insert into bb_member_log(relevance,rtype,mid,addtime,opetype,ip,stauts) values ('',5,?,?,10,?,0)", [$memberid,$time,$memberIP]);
    	return $temp;
    }
    
}
?>