<?php
//后台新用户初始密码
define('SYS_USER_PWD', 'sys2015');
//define('WEB_DOMAIN','');				//网站域名
define('WEB_DOMAIN', '');
define('WAP_DOMAIN', 'm.' . WEB_DOMAIN);            //手机站域名
define('PIC_DOMAIN', 'pic.' . WEB_DOMAIN);            //图片域名
define('PIC_URL', 'http://' . PIC_DOMAIN . '/');        //图片域名地址

define('DEFAULT_MEMBER_IMG', '');    //默认头像地址
define('DEFAULT_MEMBER_NULL_IMG', '');        //默认头像地址
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
//********************
//******page end******
//********************