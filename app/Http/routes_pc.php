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
 * pc站路径
 */
//Route::group(['domain' => 'www.sameboy.com'], function () {
//会员中心-----首页
Route::get('/member', ['as' => 'pc_member', 'uses' => 'Pc\MemberController@index']);
//个人中心分类信息
Route::get('/member/{type?}', ['as' => 'pc_member', 'uses' => 'Pc\MemberController@memberList']);
//用户登录
Route::get('/login', ['as' => 'pc_login', 'uses' => 'Pc\LoginController@index']);
//验证用户登录
Route::post('/saveLogin', ['as' => 'pc_saveLogin', 'uses' => 'Pc\LoginController@login']);
//验证用户是否存在
Route::post('/checkPhone', ['as' => 'pc_checkPhone', 'uses' => 'Pc\LoginController@checkPhone']);
//找回密码第一步
Route::get('/backPassword1', ['as' => 'pc_backPassword1', 'uses' => 'Pc\LoginController@backPassword1']);
//发送验证码
Route::post('/SendSms', ['as' => 'pc_SendSms', 'uses' => 'Pc\LoginController@SendSms']);
//验证验证码
Route::post('/VerifyCode', ['as' => 'pc_VerifyCode', 'uses' => 'Pc\LoginController@VerifyCode']);

//找回密码---保存手机号
Route::post('/setPhone', ['as' => 'pc_setPhone', 'uses' => 'Pc\LoginController@setPhone']);
//找回密码第二步
Route::get('/backPassword2', ['as' => 'pc_backPassword2', 'uses' => 'Pc\LoginController@backPassword2']);
//找回密码---保存第二步----设置新密码
Route::post('/setPassword', ['as' => 'pc_setPassword', 'uses' => 'Pc\LoginController@setPassword']);
//注册
Route::get('/register', ['as' => 'pc_register', 'uses' => 'Pc\LoginController@register']);
//注册保存
Route::post('/saveRegister', ['as' => 'pc_saveRegister', 'uses' => 'Pc\LoginController@saveRegister']);
//第三方登录
Route::get('/extendLogin', ['as' => 'extendLogin', 'uses' => 'Pc\LoginController@extendLogin']);
//最新动态----ajax加载
Route::get('/memberAjax', ['as' => 'pc_memberAjax', 'uses' => 'Pc\MemberController@memberAjax']);
//个人中心--我关注的专题
Route::get('/mySpecial/{order?}', ['as' => 'pc_mySpecial', 'uses' => 'Pc\MemberController@mySpecial']);
//网站底部、其他信息
Route::get('/info/{id?}', ['as' => 'pc_info', 'uses' => 'Pc\MemberController@otherInfo']);
//意见反馈保存
Route::post('/saveFeedback', ['as' => 'pc_saveFeedback', 'uses' => 'Pc\MemberController@saveFeedback']);
//申请认证
Route::get('/applyExpert', ['as' => 'pc_applyExpert', 'uses' => 'Pc\MemberController@applyExpert']);
//申请认证保存
Route::post('/saveApplyExpert', ['as' => 'pc_saveApplyExpert', 'uses' => 'Pc\MemberController@saveApplyExpert']);
//申请认证   上传附件
Route::post('/uploadFile', ['as' => 'pc_uploadFile', 'uses' => 'Pc\UploadController@uploadFile']);
//退出登录

Route::get('/logout', ['as' => 'pc_logout', 'uses' => 'Pc\LoginController@logout']);

//Route::get('/test', ['as' => 'pc_test', 'uses' => 'Pc\LoginController@create_user']);

//发布问题
Route::get('/questioncreate/{specialid?}/{type?}', ['as' => 'pc_question_create', 'uses' => 'Pc\QuestionController@index']);
//图片上传
Route::post('/imageupload', ['as' => 'pc_upload', 'uses' => 'Pc\UploadController@uploadImg']);
//发布问题保存
Route::post('/questionStore', ['as' => 'pc_questionStore', 'uses' => 'Pc\QuestionController@questionStore']);
//搜索问题
Route::get('/searchquestions', ['as' => 'pc_searchquestions', 'uses' => 'Pc\SearchController@searchQuestions']);
//搜索专题
Route::get('/searchspecials', ['as' => 'pc_searchspecials', 'uses' => 'Pc\SearchController@searchSpecials']);
//顶部搜索 参数：q关键词，
Route::get('/search', ['as' => 'pc_search', 'uses' => 'Pc\SearchController@searchQuestionsResult']);
//顶部搜索(用于Ajax) 参数：q关键词，
Route::get('/searchajax', ['as' => 'pc_search_ajax', 'uses' => 'Pc\SearchController@searchQuestionsResultAjax']);
//申请专题页面
Route::get('/special_create', ['as' => 'pc_specical_create', 'uses' => 'Pc\QuestionController@applySpecial']);
//申请专题保存
Route::post('/special_store', ['as' => 'pc_specical_store', 'uses' => 'Pc\QuestionController@specialStore']);
//获取回答列表
Route::post('/getcommentdata', ['as' => 'pc_commentdata', 'uses' => 'Pc\CommentController@getCommentData']);
//回答保存
Route::post('/answerstore', ['as' => 'pc_answerstore', 'uses' => 'Pc\CommentController@answerStore']);
//评论保存
Route::post('/commentstore', ['as' => 'pc_commentstore', 'uses' => 'Pc\CommentController@commentStore']);
//跳转到回答编辑页面
Route::get('/answeredit/{answerid}', ['as' => 'pc_answeredit', 'uses' => 'Pc\QuestionController@answerEdit']);
//回答编辑保存
Route::post('/answereditstore', ['as' => 'pc_answereditstore', 'uses' => 'Pc\QuestionController@answerEditStore']);
//专家列表
Route::get('/experts', ['as' => 'pc_experts', 'uses' => 'Pc\ExpertController@expertList']);
//专家详情
Route::get('/expert/{id}', ['as' => 'pc_expert', 'uses' => 'Pc\ExpertController@expertInfo']);
//检查是否已有相同问题
Route::get('/checktitle', ['as' => 'pc_checktitle', 'uses' => 'Pc\QuestionController@checkTitle']);

//专题关注
Route::get('/special/guanzhu/{special_id}', ['as' => 'pc_special_focus', 'uses' => 'Pc\SpecialController@guanzhu']);
//专题关注取消
Route::get('/special/quxiaoguanzhu/{special_id}', ['as' => 'pc_special_unfocus', 'uses' => 'Pc\SpecialController@quxiaoguanzhu']);
//我的专题
Route::get('/specials/my', ['as' => 'pc_specials_my', 'uses' => 'Pc\SpecialController@my']);
//热门专题
Route::get('/specials/hotajax', ['as' => 'pc_specials_hotajax', 'uses' => 'Pc\SpecialController@hotajax']);
Route::get('/specials/hot', ['as' => 'pc_specials_hot', 'uses' => 'Pc\SpecialController@hot']);
//专题详情
Route::get('/specialajax/{special_id}/{type?}', ['as' => 'pc_special_mainajax', 'uses' => 'Pc\SpecialController@mainajax']);
Route::get('/special/{special_id}/{type?}', ['as' => 'pc_special_main', 'uses' => 'Pc\SpecialController@main']);
//阶段专题
Route::get('/specialsajax/{stage_id?}', ['as' => 'pc_specials_stageajax', 'uses' => 'Pc\SpecialController@stageajax']);
Route::get('/specials/{stage_id?}', ['as' => 'pc_specials_stage', 'uses' => 'Pc\SpecialController@stage']);

//提问详情
Route::get('/questionajax/{question_id}', ['as' => 'pc_question_showajax', 'uses' => 'Pc\AnswerController@questionShowajax']);
Route::get('/question/{question_id}', ['as' => 'pc_question_show', 'uses' => 'Pc\AnswerController@questionShow']);
//提问关注
Route::get('/question/guanzhu/{question_id}', ['as' => 'pc_question_focus', 'uses' => 'Pc\AnswerController@questionguanzhu']);
//提问关注取消
Route::get('/question/quxiaoguanzhu/{question_id}', ['as' => 'pc_question_unfocus', 'uses' => 'Pc\AnswerController@questionquxiaoguanzhu']);
//举报
Route::get('/ajaxjubao/{targetid}/{type}/{content?}', ['as' => 'pc_ajax_jubao', 'uses' => 'Pc\AnswerController@ajaxPostReport']);


//-回答详情
Route::get('/answer/{answer_id}', ['as' => 'pc_answer_show', 'uses' => 'Pc\AnswerController@answerShow']);
//-回答评论列表
Route::get('/answercommentajax/{answer_id}', ['as' => 'pc_answer_commentajax', 'uses' => 'Pc\AnswerController@answerCommentajax']);
Route::get('/answercomment/{answer_id}', ['as' => 'pc_answer_comment', 'uses' => 'Pc\AnswerController@answerComment']);
//-回答关注
Route::get('/answer/guanzhu/{answer_id}', ['as' => 'pc_answer_focus', 'uses' => 'Pc\AnswerController@answerguanzhu']);
//-回答关注取消
Route::get('/answer/quxiaoguanzhu/{answer_id}', ['as' => 'pc_answer_unfocus', 'uses' => 'Pc\AnswerController@answerquxiaoguanzhu']);
//-回答赞同
Route::get('/answer/zantong/{answer_id}', ['as' => 'pc_answer_agree', 'uses' => 'Pc\AnswerController@answerzantong']);
//-回答赞同取消
Route::get('/answer/quxiaozantong/{answer_id}', ['as' => 'pc_answer_unagree', 'uses' => 'Pc\AnswerController@answerquxiaozantong']);
//-回答反对
Route::get('/answer/fandui/{answer_id}', ['as' => 'pc_answer_against', 'uses' => 'Pc\AnswerController@answerfandui']);
//-回答反对取消
Route::get('/answer/quxiaofandui/{answer_id}', ['as' => 'pc_answer_unagainst', 'uses' => 'Pc\AnswerController@answerquxiaofandui']);


//会员设置-----首页
Route::get('/setting', ['as' => 'pc_setting', 'uses' => 'Pc\SettingController@index']);
//会员设置--上传图像
Route::post('/pc_setting_upload', ['as' => 'pc_setting_upload', 'uses' => 'Pc\SettingController@upload']);
//会员设置--保存图像
Route::post('/pc_setting_saveAvatar', ['as' => 'pc_setting_saveAvatar', 'uses' => 'Pc\SettingController@saveAvatar']);
//会员设置--校验原密码
Route::post('/pc_setting_checkPass', ['as' => 'pc_setting_checkPass', 'uses' => 'Pc\SettingController@checkPass']);
//会员设置--修改密码
Route::post('/pc_setting_editPass', ['as' => 'pc_setting_editPass', 'uses' => 'Pc\SettingController@editPass']);
//会员设置--保存设置
Route::post('/pc_setting_save', ['as' => 'pc_setting_save', 'uses' => 'Pc\SettingController@save']);

//测试的路由
Route::get('/demo', ['as' => 'demo', 'uses' => 'Pc\DemoController@index']);
//测试的路由
Route::get('/demoList', ['as' => 'demoList', 'uses' => 'Pc\DemoController@searchQuestionsResult']);
//测试的路由
Route::post('/demoupdate1', ['as' => 'demoupdate1', 'uses' => 'Pc\DemoController@update1']);


Route::get('/create_user', ['as' => 'pc_index', 'uses' => 'Web\LoginController@create_user']);      //首页，必须放最下面

Route::get('/create_user', ['as' => 'pc_index', 'uses' => 'Web\LoginController@create_user']);      //首页，必须放最下面

//首页
Route::get('/{type?}', ['as' => 'pc_index', 'uses' => 'Pc\ShowController@index']);      //首页，必须放最下面
//});