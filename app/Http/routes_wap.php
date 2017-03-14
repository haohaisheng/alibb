<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
手机站路径
*/
Route::group(['domain' => 'm.sameboy.com'], function () {
    //用户登录
    Route::get('/login', ['as' => 'login', 'uses' => 'Web\LoginController@index']);
    //用户提交登录信息
    Route::post('/checkLogin', ['as' => 'checkLogin', 'uses' => 'Web\LoginController@login']);
    //校验用户是否存在
    Route::post('/checkPhone', ['as' => 'checkPhone', 'uses' => 'Web\LoginController@checkPhone']);
    //找回密码(第一步)
    Route::get('/backPassword1', ['as' => 'backPassword1', 'uses' => 'Web\LoginController@backPassword1']);
    //发送验证码
    Route::post('/SendSms', ['as' => 'SendSms', 'uses' => 'Web\LoginController@SendSms']);
    //校验验证码
    Route::post('/VerifyCode', ['as' => 'VerifyCode', 'uses' => 'Web\LoginController@VerifyCode']);
    //找回密码(第二步)
    Route::get('/backPassword2', ['as' => 'backPassword2', 'uses' => 'Web\LoginController@backPassword2']);
    //设置密码
    Route::post('/setPassword', ['as' => 'setPassword', 'uses' => 'Web\LoginController@setPassword']);
    //注册（第一步）
    Route::get('/register', ['as' => 'register', 'uses' => 'Web\LoginController@register1']);
    //保存注册（第一步）
    Route::post('/saveRegister1', ['as' => 'saveRegister1', 'uses' => 'Web\LoginController@saveRegister1']);
    //注册（第二步）
    Route::get('/register2', ['as' => 'register2', 'uses' => 'Web\LoginController@register2']);
    //注册校验验证码
    Route::post('/registerVerifyCode', ['as' => 'registerVerifyCode', 'uses' => 'Web\LoginController@registerVerifyCode']);
    //保存注册（第二步）
    Route::post('/saveRegister2', ['as' => 'saveRegister2', 'uses' => 'Web\LoginController@saveRegister2']);
    //注册---设置宝宝资料
    Route::get('/setBBinfo', ['as' => 'setBBinfo', 'uses' => 'Web\LoginController@setBBinfo']);
    //个人中心主页
    Route::get('/member', ['as' => 'member', 'uses' => 'Web\MemberController@index']);
    //个人中心分类信息
    Route::get('/member/{type?}', ['as' => '/member/{type?}', 'uses' => 'Web\MemberController@memberList']);
    //个人中心分类信息（ajax加载）
    Route::get('/memberListAjax/{type?}', ['as' => 'memberListAjax/{type?}', 'uses' => 'Web\MemberController@memberListAjax']);

    //个人中心----我的消息
    Route::get('/myMessage', ['as' => 'myMessage', 'uses' => 'Web\MemberController@GetMyMessage']);

    //个人中心----我的消息(ajax加载)
    Route::get('/myMessageAjax', ['as' => 'myMessageAjax', 'uses' => 'Web\MemberController@myMessageAjax']);


    //个人中心---资料设置
    Route::get('/setting', ['as' => 'setting', 'uses' => 'Web\MemberController@setting']);
    //个人中心---获取城市
    Route::post('/getCity', ['as' => '/getCity', 'uses' => 'Web\MemberController@getJiCity']);
    //个人中心--修改用户昵称
    Route::post('/updateNickname', ['as' => 'updateNickname', 'uses' => 'Web\MemberController@updateNickname']);
    //个人中心--修改用户所在地
    Route::post('/updateAddress', ['as' => 'updateAddress', 'uses' => 'Web\MemberController@updateAddress']);
    //个人中心--修改用户生日
    Route::post('/updateBirthday', ['as' => 'updateBirthday', 'uses' => 'Web\MemberController@updateBirthday']);
    //个人中心--修改宝宝性别
    Route::post('/updateBBsex', ['as' => 'updateBBsex', 'uses' => 'Web\MemberController@updateBBsex']);
    //个人中心--修改宝宝生日
    Route::post('/updateBBbirthday', ['as' => 'updateBBbirthday', 'uses' => 'Web\MemberController@updateBBbirthday']);
    //个人中心--修改宝宝昵称
    Route::post('/updateBbNickname', ['as' => 'updateBbNickname', 'uses' => 'Web\MemberController@updateBbNickname']);
    //个人中心--修改阶段（第一步）
    Route::get('/setting1', ['as' => 'setting1', 'uses' => 'Web\MemberController@setting1']);
    //个人中心--修改阶段（第二步）
    Route::get('/setting2', ['as' => 'setting2', 'uses' => 'Web\MemberController@setting2']);
    //保存------个人中心--修改阶段（第一步和第二步）
    Route::post('/saveSetting', ['as' => 'saveSetting', 'uses' => 'Web\MemberController@saveSetting']);

    //举报
    Route::post('/postReport', ['as' => 'postReport', 'uses' => 'Web\MemberController@PostReport']);

    //意见反馈
    Route::get('/feedback', ['as' => 'feedback', 'uses' => 'Web\MemberController@feedback']);
    //意见反馈保存
    Route::post('/saveFeedback', ['as' => 'saveFeedback', 'uses' => 'Web\MemberController@saveFeedback']);
    //退出登录

    Route::get('/logout', ['as' => 'logout', 'uses' => 'Web\LoginController@logout']);

    //Route::get('/test', ['as' => 'test', 'uses' => 'Web\LoginController@create_user']);

    //专题关注
    Route::get('/special/guanzhu/{special_id}', ['as' => 'special_focus', 'uses' => 'Web\SpecialController@guanzhu']);
    //专题关注取消
    Route::get('/special/quxiaoguanzhu/{special_id}', ['as' => 'special_unfocus', 'uses' => 'Web\SpecialController@quxiaoguanzhu']);
    //我的专题
    Route::get('/specials/my', ['as' => 'specials_my', 'uses' => 'Web\SpecialController@stagemy']);
    //热门专题
    Route::get('/specials/hotajax', ['as' => 'specials_hotajax', 'uses' => 'Web\SpecialController@stagehotajax']);
    Route::get('/specials/hot', ['as' => 'specials_hot', 'uses' => 'Web\SpecialController@stagehot']);
    //专题详情
    Route::get('/specialajax/{special_id}/{type?}', ['as' => 'special_mainajax', 'uses' => 'Web\SpecialController@mainajax']);
    Route::get('/special/{special_id}/{type?}', ['as' => 'special_main', 'uses' => 'Web\SpecialController@main']);
    //阶段专题
    Route::get('/specialsajax/{stage_id?}', ['as' => 'specials_stageajax', 'uses' => 'Web\SpecialController@stageajax']);
    Route::get('/specials/{stage_id?}', ['as' => 'specials_stage', 'uses' => 'Web\SpecialController@stage']);
    //提问详情
    Route::get('/questionajax/{question_id}', ['as' => 'question_showajax', 'uses' => 'Web\SpecialController@questionShowajax']);
    Route::get('/question/{question_id}', ['as' => 'question_show', 'uses' => 'Web\SpecialController@questionShow']);
    //提问关注
    Route::get('/question/guanzhu/{question_id}', ['as' => 'question_focus', 'uses' => 'Web\SpecialController@questionguanzhu']);
    //提问关注取消
    Route::get('/question/quxiaoguanzhu/{question_id}', ['as' => 'question_unfocus', 'uses' => 'Web\SpecialController@questionquxiaoguanzhu']);
    //回答详情
    Route::get('/answer/{answer_id}', ['as' => 'answer_show', 'uses' => 'Web\SpecialController@answerShow']);
    //回答评论列表
    Route::get('/answercommentajax/{answer_id}', ['as' => 'answer_commentajax', 'uses' => 'Web\SpecialController@answerCommentajax']);
    Route::get('/answercomment/{answer_id}', ['as' => 'answer_comment', 'uses' => 'Web\SpecialController@answerComment']);
    //回答关注
    Route::get('/answer/guanzhu/{answer_id}', ['as' => 'answer_focus', 'uses' => 'Web\SpecialController@answerguanzhu']);
    //回答关注取消
    Route::get('/answer/quxiaoguanzhu/{answer_id}', ['as' => 'answer_unfocus', 'uses' => 'Web\SpecialController@answerquxiaoguanzhu']);
    //回答赞同
    Route::get('/answer/zantong/{answer_id}', ['as' => 'answer_agree', 'uses' => 'Web\SpecialController@answerzantong']);
    //回答赞同取消
    Route::get('/answer/quxiaozantong/{answer_id}', ['as' => 'answer_unagree', 'uses' => 'Web\SpecialController@answerquxiaozantong']);
    //回答反对
    Route::get('/answer/fandui/{answer_id}', ['as' => 'answer_against', 'uses' => 'Web\SpecialController@answerfandui']);
    //回答反对取消
    Route::get('/answer/quxiaofandui/{answer_id}', ['as' => 'answer_unagainst', 'uses' => 'Web\SpecialController@answerquxiaofandui']);

    //发布问题页面（不从专题中进入）
    Route::get('/questioncreatebyindex', ['as' => 'questioncreatebyindex', 'uses' => 'Web\QuestionController@questionCreate']);
    //发布问题页面(从专题中直接进入)
    Route::get('/questioncreatebyspecial/{specialid}', ['as' => 'questioncreatebyspecial', 'uses' => 'Web\QuestionController@index']);
    //保存发布问题
    Route::post('/question_store', ['as' => 'question_store', 'uses' => 'Web\QuestionController@store']);
    //评论回答页面（参数：answerid 回答ID）
    Route::get('/comment_create', ['as' => 'comment_create', 'uses' => 'Web\QuestionController@commentCreate']);
    //保存评论
    Route::post('/comment_store', ['as' => 'comment_store', 'uses' => 'Web\QuestionController@commentStore']);
    //编辑回答页面（参数：answerid 回答ID）
    Route::get('/answer_edit', ['as' => 'answer_edit', 'uses' => 'Web\QuestionController@answerEdit']);
    //保存编辑
    Route::post('/answer_edit_store', ['as' => 'answer_edit_store', 'uses' => 'Web\QuestionController@answerEditStore']);
    //回答页面（参数：questionid 问题ID）
    Route::get('/answer_create', ['as' => 'answer_create', 'uses' => 'Web\QuestionController@answerCreate']);
    //保存回答
    Route::post('/answer_store', ['as' => 'answer_store', 'uses' => 'Web\QuestionController@answerStore']);
    //发布问题时搜索专题
    Route::get('/searchSpecialPage', ['as' => 'searchSpecialPage', 'uses' => 'Web\QuestionController@searchSpecialPage']);
    Route::post('/searchSpecialData', ['as' => 'searchSpecialData', 'uses' => 'Web\QuestionController@searchSpecial']);
    Route::post('/searchSpecialajax', ['as' => 'searchSpecialajax', 'uses' => 'Web\QuestionController@questionCreateAjax']);
    //申请专题页面
    Route::get('/special_create', ['as' => 'special_create', 'uses' => 'Web\QuestionController@specialCreate']);
    //专题保存
    Route::post('/specialstore', ['as' => 'special_store', 'uses' => 'Web\QuestionController@specialStore']);
    Route::get('/specials', ['as' => 'specials', 'uses' => 'Web\QuestionController@getSpecials']);
    //搜索页面（包含：专题和问题搜索）
    Route::get('/search', ['as' => 'search', 'uses' => 'Web\SearchController@index']);
    //搜索专题
    Route::post('/searchSpecials', ['as' => 'searchSpecials', 'uses' => 'Web\SearchController@searchSpecials']);
    //搜索问题
    Route::post('/searchQuestions', ['as' => 'searchQuestions', 'uses' => 'Web\SearchController@searchQuestions']);
    //检查是否已有相同问题
    Route::get('/checktitle', ['as' => 'checktitle', 'uses' => 'Web\QuestionController@checkTitle']);
    //首页
    Route::get('/indexajax/{type?}', ['as' => 'indexajax', 'uses' => 'Web\SpecialController@indexajax']);      //首页ajax列表
    Route::get('/{type?}', ['as' => 'index', 'uses' => 'Web\SpecialController@index']);      //首页，必须放最下面


});
