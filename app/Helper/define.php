<?php
//后台新用户初始密码
define('SYS_USER_PWD', 'sys2015');
//define('WEB_DOMAIN','sameboy.com');				//网站域名
define('WEB_DOMAIN', '');
define('WAP_DOMAIN', 'm.' . WEB_DOMAIN);            //手机站域名
define('PIC_DOMAIN', 'pic.' . WEB_DOMAIN);            //图片域名
define('PIC_URL', 'http://' . PIC_DOMAIN . '/');        //图片域名地址

define('DEFAULT_MEMBER_IMG', 'http://pic.sameboy.com/touxiang.jpg');    //默认头像地址
define('DEFAULT_MEMBER_NULL_IMG', 'http://pic.sameboy.com/nulltouxiang.png');        //默认头像地址
define('ADMIN_PASSWORD_ENCRYPT', '057fe7ed0b7440e2');    //后台密码密匙
define("MD5_ENCODE_KEY", '5LmrdjazdO5BOIDAoVDt');            //app传输数据校验，加密字符串


define('ADMIN_LOG', false);            //网站操作日志开关
define('COOKIENAME', 'hnbtdata');    //网站使用cookie名，应注意网站前后台重名问题

define('SESSION_TIMEOUT', 36000);                //登录超时时间，单位秒
define('BAD_WORD', 3);
define('IMG_URL', '/www/wenda/');

//头像尺寸
define('AVATAR_BIG', 150);
define('AVATAR_MIDDLE', 100);
define('AVATAR_SMALL', 50);

//网站图片宽度
define('PIC_WIDTH', 800);
//帖子上传图片宽度
define("IMG_WIDTH", 800);
//头像上传图片宽度
define("HEAD_IMG_WIDTH", 200);

//企业应用开发平台应用数据
/*define("APP_KEY", '2993483');
define("APP_SECRET", 'c8LTvW8EnFe');
define("REDIRECT_URL", 'localhost/home');
define("ALIBB_PIC_URL", 'https://cbu01.alicdn.com/');
define("PIC_PATH", 'D:/wamp64/www/alibb/public/uploads/img/product/');*/

//应用服务
define("APP_KEY", '1512858');
define("APP_SECRET", 'sWDK10SauN');
//define("REDIRECT_URL", 'localhost/home');
define("REDIRECT_URL", '139.129.167.119/home');
define("ALIBB_PIC_URL", 'https://cbu01.alicdn.com/');
define("PIC_PATH", 'E:/SameboyWorkSpace/alibb/public/uploads/img/product');
define("PARAM_NULL", '参数为空');
define("SUCESS", '操作成功');