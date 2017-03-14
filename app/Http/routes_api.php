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
APP接口路径
*/

Route::group(['domain' => 'OWBGgkf65nNnrMzOfg.sameboy.com', 'prefix' => 'api'], function () {
    //用户登录
    Route::post('/UserLogin', ['as' => 'api_UserLogin', 'uses' => 'Api\MemberController@login']);
    //用户注册（第一步）
    Route::post('/UserRegister', ['as' => 'api_UserRegister', 'uses' => 'Api\MemberController@register1']);
    //用户注册（第二步）
    Route::post('/UserSet', ['as' => 'api_UserSet', 'uses' => 'Api\MemberController@register2']);
    //发送短信
    Route::post('/SendSms', ['as' => 'api_apiSendSms', 'uses' => 'Api\MemberController@SendSms']);
    //找回密码
    Route::post('/BackPassword', ['as' => 'api_BackPassword', 'uses' => 'Api\MemberController@BackPassword']);
    //验证验证码
    Route::post('/VerifyCode', ['as' => 'api_VerifyCode', 'uses' => 'Api\MemberController@VerifyCode']);
    //获取用户详细信息
    Route::get('/GetUserInfo/{memberid?}/{code?}', ['as' => 'api_GetUserInfo', 'uses' => 'Api\MemberController@info']);
    //获取用户相关信息
    Route::get('/GetUserExtend/{memberid?}/{code?}', ['as' => 'api_GetUserExtend', 'uses' => 'Api\MemberController@GetUserExtend']);
    //发布问题
    Route::post('/SaveQuestion', ['as' => 'api_SaveQuestion', 'uses' => 'Api\QuestionController@saveQuestion']);
    //回答问题
    Route::post('/CommentTopic', ['as' => 'api_CommentTopic', 'uses' => 'Api\QuestionController@commentTopic']);
    //回答编辑
    Route::post('/CommentEdit', ['as' => 'api_CommentEdit', 'uses' => 'Api\QuestionController@commentEdit']);
    //回答评论
    Route::post('/AnswerComment', ['as' => 'api_AnswerComment', 'uses' => 'Api\QuestionController@answerComment']);
    //申请新专题
    Route::post('/ApplySpecial', ['as' => 'api_ApplySpecial', 'uses' => 'Api\QuestionController@applySpecial']);
    //获取token
    Route::get('/GetToken', ['as' => 'api_GetToken', 'uses' => 'Api\MemberController@getToken']);
    //修改宝宝关系
    Route::post('/SaveBBRelation', ['as' => 'api_SaveBBRelation', 'uses' => 'Api\MemberController@SaveBBRelation']);
    //修改用户昵称
    Route::post('/SaveUserNickName', ['as' => 'api_SaveUserNickName', 'uses' => 'Api\MemberController@SaveUserNickName']);
    //修改用户生日
    Route::post('/SaveUserBirthday', ['as' => 'api_SaveUserBirthday', 'uses' => 'Api\MemberController@SaveUserBirthday']);
    //修改用户所在地（城市id）
    Route::post('/SaveUserCity', ['as' => 'api_SaveUserCity', 'uses' => 'Api\MemberController@SaveUserCity']);
    //修改用户所处阶段
    Route::post('/SaveUserStage', ['as' => 'api_SaveUserStage', 'uses' => 'Api\MemberController@SaveUserStage']);
    //修改宝宝性别
    Route::post('/SaveBBSex', ['as' => 'api_SaveBBSex', 'uses' => 'Api\MemberController@SaveBBSex']);
    //获取用户收藏的问题
    Route::get('/GetUserCollectQuestion/{memberid?}/{page?}/{num?}/{code?}', ['as' => 'api_GetUserCollectQuestion', 'uses' => 'Api\MemberController@GetUserCollectQuestion']);
    //获取用户收藏的回答
    Route::get('/GetUserCollectAnswer/{memberid?}/{page?}/{num?}/{code?}', ['as' => 'api_GetUserCollectAnswer', 'uses' => 'Api\MemberController@GetUserCollectAnswer']);
    //获取用户发布的问题
    Route::get('/GetMyQuestion/{memberid?}/{page?}/{num?}/{code?}', ['as' => 'api_GetMyQuestion', 'uses' => 'Api\MemberController@GetMyQuestion']);
    //获取用户发布的回答
    Route::get('/GetUserComment/{memberid?}/{page?}/{num?}/{code?}', ['as' => 'api_GetUserComment', 'uses' => 'Api\MemberController@GetUserComment']);
    //举报
    Route::post('/PostReport', ['as' => 'api_PostReport', 'uses' => 'Api\MemberController@PostReport']);
    //意见反馈
    Route::post('/FeedBack', ['as' => 'api_FeedBack', 'uses' => 'Api\MemberController@FeedBack']);
    //判断我的消息是否有新的
    Route::get('/IfNewMessage/{memberid?}/{code?}', ['as' => 'api_IfNewMessage', 'uses' => 'Api\MemberController@IfNewMessage']);
    //第三方登录
    Route::post('/ExtendLogin', ['as' => 'api_ExtendLogin', 'uses' => 'Api\MemberController@ExtendLogin']);
    //设置第三方登录
    Route::post('/SetExtendLogin', ['as' => 'api_SetExtendLogin', 'uses' => 'Api\MemberController@SetExtendLogin']);
    //修改用户头像
    Route::post('/SaveUserPic', ['as' => 'api_SaveUserPic', 'uses' => 'Api\MemberController@SaveUserPic']);

    //个人中心----我的消息
    Route::get('/myMessage/{memberid?}/{page?}/{num?}/{code?}', ['as' => 'api_myMessage', 'uses' => 'Api\MemberController@GetMyMessage']);

    //修改宝宝生日（或者预产期）
    Route::post('/SaveBBextend', ['as' => 'api_SaveBBextend', 'uses' => 'Api\MemberController@SaveBBextend']);
    //11.获取指定阶段下的专题列表
    Route::get('/GetStageSpecialList/{member_id}/{stage_id}/{page}/{num}/{code}', ['as' => 'api_GetStageSpecialList', 'uses' => 'Api\SpecialController@GetStageSpecialList']);
    //12.获取指定专题信息
    Route::get('/GetSpecialInfo/{member_id}/{special_id}/{code}', ['as' => 'api_GetSpecialInfo', 'uses' => 'Api\SpecialController@GetSpecialInfo']);
    //36.获取用户关注的专题
    Route::get('/GetUserFocusSpecial/{member_id}/{page}/{num}/{code}', ['as' => 'api_GetUserFocusSpecial', 'uses' => 'Api\SpecialController@GetUserFocusSpecial']);
    //42.回答赞同反对
    Route::get('/AnswerPraise/{member_id}/{question_id}/{answer_id}/{type}/{code}', ['as' => 'api_AnswerPraise', 'uses' => 'Api\SpecialController@AnswerPraise']);
    //13.关注专题
    Route::get('FocusSpecial/{member_id}/{special_id}/{type}/{code}', ['as' => 'api_FocusSpecial', 'uses' => 'Api\SpecialController@FocusSpecial']);

    //16.关注提问
    Route::get('FocusQuestion/{member_id}/{question_id}/{type}/{code}', ['as' => 'api_FocusQuestion', 'uses' => 'Api\SpecialController@FocusQuestion']);
    //45.收藏回答
    Route::get('FocusAnswer/{member_id}/{answer_id}/{type}/{code}', ['as' => 'api_FocusAnswer', 'uses' => 'Api\SpecialController@FocusAnswer']);
    //14.获取指定专题下的问题列表
    Route::get('GetQuestionList/{special_id}/{page}/{num}/{order}/{code}', ['as' => 'api_GetQuestionList', 'uses' => 'Api\SpecialController@GetQuestionList']);
    //17.获取指定问题下的回答
    Route::get('GetAnswerList/{question_id}/{page}/{num}/{code}', ['as' => 'api_GetAnswerList', 'uses' => 'Api\SpecialController@GetAnswerList']);
    //44.获取指定问题信息
    Route::get('GetQuestionInfo/{question_id}/{member_id}/{code}', ['as' => 'api_GetQuestionInfo', 'uses' => 'Api\SpecialController@GetQuestionInfo']);
    //搜索
    Route::post('Search', ['as' => 'api_Search', 'uses' => 'Api\QuestionController@seach']);
    //图片上传
    Route::post('/UploadImg', ['as' => 'api_UploadImg', 'uses' => 'Api\UploadController@uploadImg']);
    //图片上传修改
    Route::post('/uploadSaveImg', ['as' => 'api_uploadSaveImg', 'uses' => 'Api\UploadController@uploadSaveImg']);
    //50.获取所有阶段
    Route::get('/GetAllStage/{code}', ['as' => 'api_GetAllStage', 'uses' => 'Api\SpecialController@GetAllStage']);
    //51.获取指定回答信息
    Route::get('GetAnswerInfo/{answer_id}/{member_id}/{code}', ['as' => 'api_GetAnswerInfo', 'uses' => 'Api\SpecialController@GetAnswerInfo']);
    //52.获取指定回答下的评论
    Route::get('GetAnswerComments/{answer_id}/{page}/{num}/{code}', ['as' => 'api_GetAnswerComments', 'uses' => 'Api\SpecialController@GetAnswerComments']);
    //53.获取专题排行的专题
    Route::get('/GetHotSpecial/{member_id}/{page}/{num}/{code}', ['as' => 'api_GetUserFocusSpecial', 'uses' => 'Api\SpecialController@GetHotSpecial']);
    //54.获取用户关注专题下的问题列表
    Route::get('GetQuestionByMember/{member_id}/{page}/{num}/{order}/{code}', ['as' => 'api_GetQuestionByMember', 'uses' => 'Api\SpecialController@GetQuestionByMember']);
    //xx.获取安卓最新版本信息
    Route::get('/GetLastAndroidVersion/{version}/{code}', ['as' => 'api_GetLastAndroidVersion', 'uses' => 'Api\SpecialController@GetLastAndroidVersion']);

});
