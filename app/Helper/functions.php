<?php

/*
|--------------------------------------------------------------------------
| 自定义公共函数库Helper
|--------------------------------------------------------------------------
|
*/

/**
 * 格式化表单校验消息
 *
 * @param  array $messages 未格式化之前数组
 * @return string 格式化之后字符串
 */
function format_message($messages)
{
    $reason = ' ';
    foreach ($messages->all('<span class="text_error">:message</span>') as $message) {
        $reason .= $message . ' ';
    }
    return $reason;
}

/**
 * 格式化表单校验消息，并进行json数组化预处理
 *
 * @param  array $messages 未格式化之前数组
 * @param array $json 原始json数组数据
 * @return array
 */
function format_json_message($messages, $json)
{
    $reason = format_message($messages);
    $info = '失败原因为：' . $reason;
    $json = array_replace($json, ['info' => $info]);
    return $json;
}

/**
 * 文章推荐位 flag html标签化
 *
 * @param string $flag_str
 * @param array $flags
 * @return string
 */
function flag_tag($flag_str, $flags)
{
    if (empty ($flag_str)) {
        return '';
    } else {
        $flags_array = explode(',', rtrim($flag_str, ','));
        $str = '';
        foreach ($flags_array as $flag) {
            $str .= '<span class="label label-danger article-flag" title="' . $flags [$flag] . '" data-toggle="tooltip" data-placement="bottom">' . $flag . '</span>  ';
        }
        return $str;
    }
}

/**
 * 中文摘要算法
 *
 * @param string $content 正文
 * @return string
 */
function chinese_excerpt($content, $length = 200, $code = '...')
{
    return mb_strimwidth(strip_tags($content), 0, $length, $code);
}

/**
 * 检查 特定数组 特定键名的键值 是否与待比较的值一致
 * 此helper主要用于角色权限特征判断
 *
 * @param array $array 传入的数组
 * @param string $key 待比较的数组键名
 * @param string $value 待比较的值
 * @return boolean 一致则返回true，否则返回false
 */
function check_array($array, $key, $value)
{
    $status = false;

    foreach ($array as $arr) {
        if ($arr [$key] === $value) {
            $status = true;
            break;
        } else {
            continue;
        }
    }

    return $status;
}

/**
 * 检查 特殊字符串（如逗号分隔值字符串） 是否与待比较的值一致
 * 此helper主要用于文章推荐位特征判断
 *
 * @param string $string 逗号分隔值字符串
 * @param string $value 待比较的值
 * @return boolean 一致则返回true，否则返回false
 */
function check_string($string, $value)
{
    $status = false;
    $csv_array = explode(',', rtrim($string, ',')); //逗号分割值字符串转成数组


    foreach ($csv_array as $csv) {
        if ($csv === $value) {
            $status = true;
            break;
        } else {
            continue;
        }
    }

    return $status;
}

/**
 * 获取登录用户信息，用于登录之后页面显示或验证
 *
 * @param string $ret 限定返回的字段
 * @return string|object 返回登录用户相关字段信息或其ORM对象
 */
function user($ret = 'nickname')
{
    if (Auth::check()) {
        switch ($ret) {
            case 'nickname' :
                return Auth::user()->nickname; //返回昵称
                break;
            case 'username' :
                return Auth::user()->username; //返回登录名
                break;
            case 'realname' :
                return Auth::user()->realname; //返回真实姓名
                break;
            case 'id' :
                return Auth::user()->id; //返回用户id
                break;
            case 'user_type' :
                return Auth::user()->user_type; //返回用户类型
                break;
            case 'object' :
                return Auth::user(); //返回User对象
                break;
            default :
                return Auth::user()->nickname; //默认返回昵称
                break;
        }
    } else {
        if ($ret === 'object') {
            $user = app()->make('Douyasi\Repositories\UserRepository');
            return $user->manager(1); //主要为了修正 `php artisan route:list` 命令出错问题
        } else {
            return 'No Auth::check()';
        }
    }
}

if (!function_exists('cur_nav')) {
    /**
     * 根据路由$route处理当前导航URL，用于匹配导航高亮
     * $route当前必须满足 三段以上点分 诸如 route('admin.article.index')
     *
     * @param string $route 点分式路由别名
     * @return string 返回经过处理之后路径
     */
    function cur_nav($route = '')
    {
        //explode切分法
        $routeArray = explode('.', $route);
        if ((is_array($routeArray)) && (count($routeArray) >= 2)) {
            $route1 = $routeArray [0] . '.' . $routeArray [1] . '.index';
            $route2 = $routeArray [0] . '.' . $routeArray [1];
            if (Route::getRoutes()->hasNamedRoute($route1)) { //优先判断是否存在尾缀名为'.index'的路由
                return route($route1);
            } else {
                return route($route2);
            }
        } else {
            return route($route);
        }
    }
}

if (!function_exists('fragment')) {
    /**
     * 根据碎片slug获取碎片模型内容
     * 如果$slug真实存在，则默认返回该碎片内容,
     * 否则返回空HTML注释字符串'<!--不存在该碎片-->'
     *
     * @param string $slug 碎片slug（URL SEO化别名）
     * @param string $ret 限定返回的字段
     * @return string 返回碎片相关字段信息
     */
    function fragment($slug, $ret = '')
    {
        $content = app()->make('Douyasi\Repositories\ContentRepository');
        $fragment = $content->fragment($slug);
        if (is_null($fragment)) {
            return '<!--no this fragment-->';
        } //返回空HTML注释字符串
        else {
            switch ($ret) {
                case 'content' :
                    return htmlspecialchars_decode($fragment->content); //返回碎片
                    break;
                case 'thumb' :
                    return $fragment->thumb; //返回碎片缩略图地址
                    break;
                case 'title' :
                    return $fragment->title; //返回碎片标题
                    break;
                default :
                    return htmlspecialchars_decode($fragment->content); //默认返回碎片内容
                    break;
            }
        }
    }
}
/**
 * 获取客户端ip
 * Enter description here ...
 */
function GetIp()
{
    $realip = '';
    $unknown = 'unknown';
    if (isset ($_SERVER)) {
        if (isset ($_SERVER ['HTTP_X_FORWARDED_FOR']) && !empty ($_SERVER ['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER ['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $arr = explode(',', $_SERVER ['HTTP_X_FORWARDED_FOR']);
            foreach ($arr as $ip) {
                $ip = trim($ip);
                if ($ip != 'unknown') {
                    $realip = $ip;
                    break;
                }
            }
        } else if (isset ($_SERVER ['HTTP_CLIENT_IP']) && !empty ($_SERVER ['HTTP_CLIENT_IP']) && strcasecmp($_SERVER ['HTTP_CLIENT_IP'], $unknown)) {
            $realip = $_SERVER ['HTTP_CLIENT_IP'];
        } else if (isset ($_SERVER ['REMOTE_ADDR']) && !empty ($_SERVER ['REMOTE_ADDR']) && strcasecmp($_SERVER ['REMOTE_ADDR'], $unknown)) {
            $realip = $_SERVER ['REMOTE_ADDR'];
        } else {
            $realip = $unknown;
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
            $realip = getenv("REMOTE_ADDR");
        } else {
            $realip = $unknown;
        }
    }
    $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches [0] : $unknown;
    return $realip;
}

/**
 * 格式化时间
 */
function formatDate($time)
{
    //判断是否为时间戳
    if (!is_int($time)) {
        $time = strtotime($time);
    }
    $rtime = date("y-m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ';
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ';
        else
            $str = '前天 ';
    } elseif ($time < 60 * 60 * 24 * 5) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 3)
            $str = '3天前 ';
        elseif ($d == 4)
            $str = '4天前';
    } else {
        $str = $rtime;
    }
    return $str;
}

/**
 * 获取数据缓存
 * @param string $key 数据缓存索引
 * @return any 返回数据缓存
 */
function getDataCache($key)
{
    return Cache::store('file')->get($key);
}

/**
 * 设置数据缓存
 * @param string $key 数据缓存索引
 * @param string /array $value 数据缓存内容
 * @param int $key 数据缓存有效分钟，默认60分钟
 * @return
 */
function putDataCache($key, $value, $minutes = 60)
{
    return Cache::store('file')->put($key, $value, $minutes);
}

/**
 * 清除数据缓存
 * @param string $key 数据缓存索引
 * @return
 */
function forgetDataCache($key)
{
    return Cache::store('file')->forget($key);
}

//发送短信
function Post_sms($flag, $params, $argv)
{
    foreach ($argv as $key => $value) {
        if ($flag != 0) {
            $params .= "&";
            $flag = 1;
        }
        $params .= $key . "=";
        $params .= urlencode($value); // urlencode($value);
        $flag = 1;
    }
    $length = strlen($params);
    //创建socket连接
    $fp = fsockopen("sdk.entinfo.cn", 8061, $errno, $errstr, 10) or exit ($errstr . "--->" . $errno);
    //构造post请求的头
    $header = "POST /webservice.asmx/mdsmssend HTTP/1.1\r\n";
    $header .= "Host:sdk.entinfo.cn\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . $length . "\r\n";
    $header .= "Connection: Close\r\n\r\n";
    //添加post的字符串
    $header .= $params . "\r\n";
    //发送post的数据
    //echo $header;
    //exit;
    fputs($fp, $header);
    $inheader = 1;
    while (!feof($fp)) {
        $line = fgets($fp, 1024); //去除请求包的头只显示页面的返回数据
        if ($inheader && ($line == "\n" || $line == "\r\n")) {
            $inheader = 0;
        }
        if ($inheader == 0) {

            // echo $line;
        }
    }
    return $line;
}

/*********************************************************************
 * 函数名称:encrypt
 * 函数作用:加密解密字符串
 * 使用方法:
 * 加密     :encrypt('str','E','nowamagic');
 * 解密     :encrypt('被加密过的字符串','D','nowamagic');
 * 参数说明:
 * $string   :需要加密解密的字符串
 * $operation:判断是加密还是解密:E:加密   D:解密
 * $key      :加密的钥匙(密匙);
 *********************************************************************/
function encrypt($str, $operation, $key = 'SameboyChina8808')
{
    if ($operation == 'D') {
        $cipher = 'rijndael-128';
        $mode = 'ecb';
        $size = mcrypt_get_iv_size($cipher, $mode);
        $vect = mcrypt_create_iv($size, MCRYPT_RAND);

        $crypttexttb = safe_b64decode($str);
        return rtrim(mcrypt_decrypt($cipher, $key, base64_decode($crypttexttb), $mode, $vect), "\0");
    } else {
        $cipher = 'rijndael-128';
        $mode = 'ecb';
        $size = mcrypt_get_iv_size($cipher, $mode);
        $vect = mcrypt_create_iv($size, MCRYPT_RAND);
        $crypttext = base64_encode(mcrypt_encrypt($cipher, $key, $str, $mode, $vect));
        return trim(safe_b64encode($crypttext));
    }
}

//处理特殊字符
function safe_b64encode($string)
{
    $data = base64_encode($string);
    $data = str_replace(array(
        '+',
        '/',
        '='
    ), array(
        '-',
        '_',
        ''
    ), $data);
    return $data;
}

function safe_b64decode($string)
{
    $data = str_replace(array(
        '-',
        '_'
    ), array(
        '+',
        '/'
    ), $string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

//替换数组null值 为'' (移动端)
function arrContentReplact($array)
{
    if (is_array($array)) {
        foreach ($array as $k => $v) {
            $array [$k] = arrContentReplact($array [$k]);
        }
    } else {
        $array = str_replace(null, '', $array);
    }
    return $array;
}

//根据ip获取地理位置
function GetIpLookup($ip = '')
{
    if (empty ($ip)) {
        $ip = GetIp();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if (empty ($res)) {
        return false;
    }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if (!isset ($jsonMatches [0])) {
        return false;
    }
    $json = json_decode($jsonMatches [0], true);
    if (isset ($json ['ret']) && $json ['ret'] == 1) {
        $json ['ip'] = $ip;
        unset ($json ['ret']);
    } else {
        return false;
    }
    return $json;
}

function CheckNum($str)
{
    if (preg_match('/^[0-9]+$/u', $str)) { //^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u
        return true;
    } else {
        return false;
    }
}

/*
 *判断手机号是否合法
*/
function CheckMobile($mobile)
{
    if (preg_match("/1[34578]{1}\d{9}$/", $mobile)) {
        return true;
    } else {
        return false;
    }
}

/*
 *判断IP是否合法
*/
function CheckIp($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return true;
    } else {
        return false;
    }
}

//上传文件到图片服务器
function upload_pic($pic)
{
    $bucketName = 'sameboy';
    $operatorName = 'lilinxin';
    $operatorPwd = 'llx111111';

    //被上传的文件路径
    $filePath = $pic;
    $fileSize = filesize($filePath);
    //文件上传到服务器的服务端路径
    $serverPath = str_replace(base_path('public'), '', $pic);
    $uri = "/$bucketName/$serverPath";

    //生成签名时间。得到的日期格式如：Thu, 11 Jul 2014 05:34:12 GMT
    $date = gmdate('D, d M Y H:i:s \G\M\T');
    $sign = md5("PUT&{$uri}&{$date}&{$fileSize}&" . md5($operatorPwd));

    $ch = curl_init('http://v0.api.upyun.com' . $uri);
    $headers = array(
        "Expect:",
        "Date: " . $date,  // header 中需要使用生成签名的时间
        "Authorization: UpYun $operatorName:" . $sign
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_PUT, true);

    $fh = fopen($filePath, 'rb');
    curl_setopt($ch, CURLOPT_INFILE, $fh);
    curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
        return '1';
    } else {
        $errorMessage = sprintf("UPYUN API ERROR:%s", $result);
        return '2';
    }
    curl_close($ch);
}

function CheckStr($str)
{
    if (preg_match('/^[0-9a-zA-Z_]+$/u', $str)) { //^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u
        return true;
    } else {
        return false;
    }
}

function CheckIdStr($str)
{
    if (preg_match('/^[0-9a-z,]+$/u', $str)) { //^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u
        return true;
    } else {
        return false;
    }
}

function checkemail($email)
{
    $pregEmail = "/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i";
    return preg_match($pregEmail, $email);
}

//js脚本跳转页面
//$url：跳转地址
//$msg：提示信息
function js_go($url, $msg = '')
{
    if ($msg == '') {
        echo "<script language='javascript'>";
        echo "document.location='" . $url . "';";
        echo "</script>";
    } else {
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="<?php echo URL::asset('web/js/artDialog/ui-dialog.css'); ?>"/>
        <script type="text/javascript" src="<?php echo URL::asset('web/js/jquery-1.8.3.min.js'); ?>"></script>
        <script src="<?php echo URL::asset('web/js/artDialog/dialog-plus.js'); ?>"></script>
        <script language='javascript'>
            $(function () {
                var d = dialog({
                    content: '<?php echo $msg;?>'
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                    window.location.href = "<?php echo $url;?>";
                }, 2000);
            });
        </script>
        <?php
    }
    exit ();
}

//js脚本回跳
//$num：跳转页数
//$msg：提示信息
function js_back($msg = '', $num = 1)
{
    if (!isset ($num)) {
        $num = "-1";
    } else {
        $num = "-" . $num;
    }
    if ($msg == '') {
        echo "<script language='javascript'>";
        echo "window.history.go(" . $num . ")";
        echo "</script>";
    } else {
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="<?php echo URL::asset('web/js/artDialog/ui-dialog.css'); ?>"/>
        <script type="text/javascript" src="<?php echo URL::asset('web/js/jquery-1.8.3.min.js'); ?>"></script>
        <script src="<?php echo URL::asset('web/js/artDialog/dialog-plus.js'); ?>"></script>
        <script language='javascript'>
            $(function () {
                var d = dialog({
                    content: '<?php echo $msg;?>'
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                    window.history.go(<?php echo $num;?>);
                }, 2000);
            });
        </script>
        <?php
    }
    exit ();
}

//js脚本关闭窗口
//$num：跳转页数
//$msg：提示信息
function js_close($msg = '')
{
    if ($msg == '') {
        echo "<script language='javascript'>";
        echo "window.close();";
        echo "</script>";
    } else {
        echo "<script language='javascript'>";
        echo "alert('", $msg, "');";
        echo "window.close();";
        echo "</script>";
    }
    exit ();
}

/*
 * 退出登录
*/
function logout()
{
    setcookie('cookie_id', '', time() - 3600, '/', WEB_DOMAIN); //清除建立的cookie (用户id)
    setcookie('cookie_phone', '', time() - 3600, '/', WEB_DOMAIN); //清除建立的cookie（用户帐号）
    setcookie('cookie_ysid', '', time() - 3600, '/', WEB_DOMAIN); //清除建立的cookie（用户原始阶段id）
    setcookie('cookie_nickname', '', time() - 3600, '/', WEB_DOMAIN); //清除建立的cookie（用户昵称）
    setcookie('cookie_sid', '', time() - 3600, '/', WEB_DOMAIN); //清除建立的cookie（用户阶段id）
    setcookie('cookie_stageid', '', time() - 3600, '/', WEB_DOMAIN); //清除建立的cookie（用户阶段表id）
    setcookie('cookie_avatar', '', time() - 3600, '/', WEB_DOMAIN);

    setcookie('cookie_id', '', time() - 3600, '/', ""); //清除建立的cookie (用户id)
    setcookie('cookie_phone', '', time() - 3600, '/', ""); //清除建立的cookie（用户帐号）
    setcookie('cookie_ysid', '', time() - 3600, '/', ""); //清除建立的cookie（用户原始阶段id）
    setcookie('cookie_nickname', '', time() - 3600, '/', ""); //清除建立的cookie（用户昵称）
    setcookie('cookie_sid', '', time() - 3600, '/', ""); //清除建立的cookie（用户阶段id）
    setcookie('cookie_stageid', '', time() - 3600, '/', ""); //清除建立的cookie（用户阶段表id）
    setcookie('cookie_avatar', '', time() - 3600, '/', "");


//return view('Web/Member/login');
}

//友盟单推
function sendUnicast($mess_id, $userid, $ticker, $title, $text)
{

    require_once(app_path() . '/' . 'Providers/UmengServiceProvider.php');
    //推送给被添加人
    //$Umeng_Android = new UmengServiceProvider( Android_AppKey, Android_App_Master_Secret );
    $Umeng_IOS = new UmengServiceProvider (IOS_AppKey, IOS_App_Master_Secret);

    $value = array(
        'id' => $mess_id,
        'title' => $title,
        'content' => $text
    );
    return $Umeng_IOS->sendIOSUnicast($userid, $ticker, $title, $text, $value);

    //return $Umeng_Android->sendAndroidUnicast ( $fuserid, $ticker, $title, $text, $value );
}

/* 
 * param ori_img 原图像的名称和路径
 * param new_img 生成图像的名称
 * param percent 表示按照原图的百分比进行缩略，此项为空时默认按50%
 * param width 指定缩略后的宽度
 * param height 指定缩略后的高度	* 
 * 注：当 percent width height 都传入值的时候，且percent>0时，优先按照百分比进行缩略
 *
 **/
function makeThumb($ori_img, $new_img, $percent = 0, $width = 200, $height = 150)
{

    $original = getimagesize($ori_img); //得到图片的信息，可以print_r($original)发现它就是一个数组
    //$original[2]是图片类型，其中1表示gif、2表示jpg、3表示png
    switch ($original [2]) {
        case 1 :
            $s_original = imagecreatefromgif($ori_img);
            break;
        case 2 :
            $s_original = imagecreatefromjpeg($ori_img);
            break;
        case 3 :
            $s_original = imagecreatefrompng($ori_img);
            break;
    }

    if ($percent > 0) {
        $width = $original [0] * $percent / 100;
        $width = ($width > 0) ? $width : 1;
        $height = $original [1] * $percent / 100;
        $height = ($height > 0) ? $height : 1;
    }
    //创建一个真彩的画布
    $canvas = imagecreatetruecolor($width, $height);
    imageCopyreSampled($canvas, $s_original, 0, 0, 0, 0, $width, $height, $original [0], $original [1]);
    //header("Content-type:image/jpeg");
    //imagejpeg($canvas);	//向浏览器输出图片
    $loop = imagejpeg($canvas, $new_img, 90); //生成新的图片
    if ($loop)
        return true;
    else
        return false;
}

/**
 * 前台生成三种格式头像
 */
function makeAvatar($ori_img, $top, $left, $right, $bottom, $scale = 1)
{
    $big_size = AVATAR_BIG;
    $middle_size = AVATAR_MIDDLE;
    $small_size = AVATAR_SMALL;
    $original = getimagesize($ori_img); //得到图片的信息，可以print_r($original)发现它就是一个数组
    $info = pathinfo($ori_img);
    //$original[2]是图片类型，其中1表示gif、2表示jpg、3表示png
    switch ($original [2]) {
        case 1 :
            $s_original = imagecreatefromgif($ori_img);
            break;
        case 2 :
            $s_original = imagecreatefromjpeg($ori_img);
            break;
        case 3 :
            $s_original = imagecreatefrompng($ori_img);
            break;
    }

    $canvas = imagecreatetruecolor($original [0], $original [1]);
    if ($scale != 1) {
        imageCopyreSampled($canvas, $s_original, 0, 0, 0, 0, $original [0], $original [1], $original [0], $original [1]);
        //imagecopyresampled (  $dst_image ,  $src_image ,  $dst_x ,  $dst_y ,  $src_x ,  $src_y ,  $dst_w ,  $dst_h ,  $src_w ,  $src_h )
        //$dst_image：新建的图片
        //$src_image：需要载入的图片
        //$dst_x：设定需要载入的图片在新图中的x坐标
        //$dst_y：设定需要载入的图片在新图中的y坐标
        //$src_x：设定载入图片要载入的区域x坐标
        //$src_y：设定载入图片要载入的区域y坐标
        //$dst_w：设定载入的原图的宽度（在此设置缩放）
        //$dst_h：设定载入的原图的高度（在此设置缩放）
        //$src_w：原图要载入的宽度
        //$src_h：原图要载入的高度


        $new_img_scale = $info ['dirname'] . '/' . $info ['filename'] . '_scale.' . $info ['extension'];
        $img_scale = imagejpeg($canvas, $new_img_scale, 90);
        if ($img_scale) {
            $original_s = imagecreatefromjpeg($new_img_scale);
            //创建一个真彩的画布
            $canvas_big = imagecreatetruecolor($big_size, $big_size);
            $canvas_middle = imagecreatetruecolor($middle_size, $middle_size);
            $canvas_small = imagecreatetruecolor($small_size, $small_size);

            $width = ($right - $left) * $scale;
            $height = ($bottom - $top) * $scale;

            //指定缩放出来的最大的宽度（也有可能是高度）
            $w = $original [0];
            $h = $original [1];
            //根据最大值，算出另一个边的长度，得到缩放后的图片宽度和高度
            if ($w > $h) {
                $h_b = $big_size;
                $h_m = $middle_size;
                $h_s = $small_size;
                $w_b = $w * ($big_size / ($original [0]));
                $w_m = $w * ($middle_size / ($original [0]));
                $w_s = $w * ($small_size / ($original [0]));
            } else {
                $w_b = $big_size;
                $w_m = $middle_size;
                $w_s = $small_size;
                $h_b = $h * ($big_size / ($original [1]));
                $h_m = $h * ($middle_size / ($original [1]));
                $h_s = $h * ($small_size / ($original [1]));
            }

            imageCopyreSampled($canvas_big, $original_s, 0, 0, $left * $scale, $top * $scale, $w_b, $h_b, $width, $height);
            imageCopyreSampled($canvas_middle, $original_s, 0, 0, $left * $scale, $top * $scale, $w_m, $h_m, $width, $height);
            imageCopyreSampled($canvas_small, $original_s, 0, 0, $left * $scale, $top * $scale, $w_s, $h_s, $width, $height);
            //header("Content-type:image/jpeg");
            //imagejpeg($canvas);	//向浏览器输出图片


            $new_img_big = $info ['dirname'] . '/' . $info ['filename'] . '_big.' . $info ['extension'];
            $new_img_middle = $info ['dirname'] . '/' . $info ['filename'] . '_middle.' . $info ['extension'];
            $new_img_small = $info ['dirname'] . '/' . $info ['filename'] . '_small.' . $info ['extension'];

            $loop = imagejpeg($canvas_big, $new_img_big, 90); //生成新的图片
            imagejpeg($canvas_middle, $new_img_middle, 90);
            imagejpeg($canvas_small, $new_img_small, 90);

            if ($loop) {
                upload_pic($new_img_big);
                upload_pic($new_img_middle);
                upload_pic($new_img_small);
                echo "succeed";
            } else {
                echo "error";
            }

        } else {
            echo "error";
        }
    } else {
        //创建一个真彩的画布
        $canvas_big = imagecreatetruecolor($big_size, $big_size);
        $canvas_middle = imagecreatetruecolor($middle_size, $middle_size);
        $canvas_small = imagecreatetruecolor($small_size, $small_size);

        $width = $right - $left;
        $height = $bottom - $top;

        //指定缩放出来的最大的宽度（也有可能是高度）
        $w = $original [0];
        $h = $original [1];
        //根据最大值，算出另一个边的长度，得到缩放后的图片宽度和高度
        if ($w > $h) {
            $h_b = $big_size;
            $h_m = $middle_size;
            $h_s = $small_size;
            $w_b = $w * ($big_size / $original [0]);
            $w_m = $w * ($middle_size / $original [0]);
            $w_s = $w * ($small_size / $original [0]);
        } else {
            $w_b = $big_size;
            $w_m = $middle_size;
            $w_s = $small_size;
            $h_b = $h * ($big_size / $original [1]);
            $h_m = $h * ($middle_size / $original [1]);
            $h_s = $h * ($small_size / $original [1]);
        }

        imageCopyreSampled($canvas_big, $s_original, 0, 0, $left, $top, $w_b, $h_b, $width, $height);
        imageCopyreSampled($canvas_middle, $s_original, 0, 0, $left, $top, $w_m, $h_m, $width, $height);
        imageCopyreSampled($canvas_small, $s_original, 0, 0, $left, $top, $w_s, $h_s, $width, $height);
        //header("Content-type:image/jpeg");
        //imagejpeg($canvas);	//向浏览器输出图片


        $new_img_big = $info ['dirname'] . '/' . $info ['filename'] . '_big.' . $info ['extension'];
        $new_img_middle = $info ['dirname'] . '/' . $info ['filename'] . '_middle.' . $info ['extension'];
        $new_img_small = $info ['dirname'] . '/' . $info ['filename'] . '_small.' . $info ['extension'];

        $loop = imagejpeg($canvas_big, $new_img_big, 90); //生成新的图片
        imagejpeg($canvas_middle, $new_img_middle, 90);
        imagejpeg($canvas_small, $new_img_small, 90);

        if ($loop) {
            upload_pic($new_img_big);
            upload_pic($new_img_middle);
            upload_pic($new_img_small);
            echo "succeed";
        } else {
            echo "error";
        }
    }
}

function formatCityId($hometown)
{
    if (empty ($hometown)) {
        return;
    } else {
        $types = array(
            '市',
            '省'
        );
        $hometowns = explode('-', $hometown);
        $c = count($hometowns);
        for ($i = $c - 1; $i >= 0; $i--) {
            $v = $hometowns [$i];
            $len = mb_strlen($v);
            if (in_array(mb_substr($v, $len - 1), $types)) {
                $v = mb_substr($v, 0, $len - 1);
            }
            $rs = DB::select("select id,pid,type from bb_wap_city where cname like '%$v%' ;");
            foreach ($rs as $k1 => $v1) {
                if ($v1->type == 3) {
                    $pid = $v1->pid;
                    $rs1 = DB::selectOne("select cname from bb_wap_city where id= '$pid' ;");

                    $c1 = $hometowns [$i - 1];
                    $len1 = mb_strlen($c1);
                    if (in_array(mb_substr($c1, $len1 - 1), $types)) {
                        $c1 = mb_substr($c1, 0, $len1 - 1);
                    }
                    if ($rs1->cname == $c1) {
                        return $v1->id;
                    }
                }
            }
        }
        return 1;
    }
}

//获得底部信息
function getBottomInfo()
{
    $key = 'array_BottomInfo';
    $r = getDataCache($key);
    if (empty($r)) {
        $r = DB::table('bb_bottom')->get();
        //$r = collect($r)->toArray();
        putDataCache($key, $r, 24 * 60);//24*60
    }
    return $r;
}

function userTextEncode($str)
{
    if (!is_string($str)) return $str;
    if (!$str || $str == 'undefined') return '';
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($str) {
        return addslashes($str[0]);
    }, $text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
    return json_decode($text);
}

/**
 * 解码上面的转义
 */
function userTextDecode($str)
{
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/\\\\\\\\/i', function ($str) {
        return '\\';
    }, $text); //将两条斜杠变成一条，其他不动
    return json_decode($text);
}

/**
 * 获得图像的全部地址
 */
function makeImgUrl($url)
{
    if ($url == '') {
        $url = DEFAULT_MEMBER_IMG;
    } else {
        if (strtolower(substr($url, 0, 4)) != 'http') {
            $url = PIC_URL . $url;
        }
    }
    return $url;
}


function resizeImage($im, $maxwidth, $maxheight, $name, $filetype, $src)
{
    $pic_width = imagesx($im);
    $pic_height = imagesy($im);

    if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
        if ($maxwidth && $pic_width > $maxwidth) {
            $widthratio = $maxwidth / $pic_width;
            $resizewidth_tag = true;
        }

        if ($maxheight && $pic_height > $maxheight) {
            $heightratio = $maxheight / $pic_height;
            $resizeheight_tag = true;
        }
        if ($resizewidth_tag && $resizeheight_tag) {
            if ($widthratio < $heightratio)
                $ratio = $widthratio;
            else
                $ratio = $heightratio;
        }

        if ($resizewidth_tag && !$resizeheight_tag)
            $ratio = $widthratio;
        if ($resizeheight_tag && !$resizewidth_tag)
            $ratio = $heightratio;

        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;

        if (function_exists("imagecopyresampled")) {
            $newim = imagecreatetruecolor($newwidth, $newheight); //PHP系统函数
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height); //PHP系统函数
        } else {
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
        }
        //$name = $name . $filetype;
        $name = $src;
        imagejpeg($newim, $name);
        imagedestroy($newim);
    } else {
        $name = $name . $filetype;
        imagejpeg($im, $name);
    }
}


/**
 * 获取上一步操作的action
 * @return string
 */
function getLastStepAction()
{
    $http_ref = $_SERVER['HTTP_REFERER'];
    return substr($http_ref, strrpos($http_ref, "/"));
}

function getSign($url = '', $param = array())
{
    $aliParams = array();
    foreach ($param as $key => $val) {
        $aliParams[] = $key . $val;
    }
    sort($aliParams);
    $sign_str = join('', $aliParams);
    $sign_str = $url . $sign_str;
    $code_sign = strtoupper(bin2hex(hash_hmac("sha1", $sign_str, APP_SECRET, true)));
    return $code_sign;
}


/*$aliParams = array();
foreach ($param as $key => $val) {
    if(is_array($val)){
        $aliParams[] = $key.getArrSign($val);
    }else{
        $aliParams[] = $key . $val;
    }
}
sort($aliParams);
$sign_str = join('', $aliParams);
$sign_str = $url . $sign_str;
$code_sign = strtoupper(bin2hex(hash_hmac("sha1", $sign_str, APP_SECRET, true)));
return $code_sign;*/

function getArrSign($array = array())
{
    $str = '';//实际运行中需要增加一个key用来防止加密方法被破解，我认为这个key可以根据时间戳动态生成
    $aliParams = array();
    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $v = getArrSign($v); //递归调用，并把返回值作为当前的key对应的value
        }
        $aliParams[] = $k . $v;
        //  $str .= $k . '=' . $v . '&';
    }
    sort($aliParams);
    $sign_str = join('', $aliParams);
    $code_sign = strtoupper(bin2hex(hash_hmac("sha1", $sign_str, APP_SECRET, true)));
    return $code_sign;
}

/**
 * 模拟post进行url请求
 * @param string $url
 * @param array $post_data
 */
function request_post($url = '', $post_data = array())
{
    if (empty($url) || empty($post_data)) {
        return false;
    }
    $o = "";
    foreach ($post_data as $k => $v) {
        $o .= "$k=" . urlencode($v) . "&";
    }
    $post_data = substr($o, 0, -1);
    $curlPost = $post_data;
    $curl = curl_init();//初始化curl
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $data = curl_exec($curl);//运行curl
    curl_close($curl);
    return $data;
}

/*******post使用方法**************/
function testAction()
{
    $url = 'http://mobile.jschina.com.cn/jschina/register.php';
    $post_data['appid'] = '10';
    $post_data['appkey'] = 'cmbohpffXVR03nIpkkQXaAA1Vf5nO4nQ';
    $post_data['member_name'] = 'zsjs124';
    $post_data['password'] = '123456';
    $post_data['email'] = 'zsjs124@126.com';
    //$post_data = array();
    $res = request_post($url, $post_data);
    print_r($res);

}


/**
 * @param null $code
 * @return null
 * 获取阿里巴巴web版授权token
 */
/*function get_token($code = null)
{
    $tokens = DB::table('hdb_token_alibaba')
        ->select('expires_in', 'access_token')
        ->get();
    if (!empty($tokens[0]->expires_in) && $tokens[0]->expires_in > time()) {
        return $tokens[0]->access_token;
    } else {
        if (!empty($code)) {
            $token_url = "https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/getToken/" . APP_KEY . "?";
            $post_data['grant_type'] = 'authorization_code';
            $post_data['need_refresh_token'] = true;
            $post_data['client_id'] = APP_KEY;
            $post_data['client_secret'] = APP_SECRET;
            $post_data['redirect_uri'] = REDIRECT_URL;
            $post_data['code'] = $code;
            $o = "";
            foreach ($post_data as $k => $v) {
                $o .= "$k=" . urlencode($v) . "&";
            }
            $post_data = substr($o, 0, -1);
            $curlPost = $post_data;
            $curl = curl_init();//初始化curl
            curl_setopt($curl, CURLOPT_URL, $token_url); // 要访问的地址
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost); // Post提交的数据包
            curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
            curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
            $data = curl_exec($curl);//运行curl
            curl_close($curl);
            $result = json_decode($data);
            if (!empty($result->access_token)) {
                $nowtime = time() + $result->expires_in;
                $tokens = DB::table('hdb_token_alibaba')
                    ->where('resource_owner', $result->resource_owner)
                    ->first();
                Session::put('login_alibaba', $result->resource_owner);
                if (!empty($tokens->id)) {
                    DB::update("update hdb_token_alibaba set expires_in =?,access_token=? where resource_owner = ?", [$nowtime, $result->access_token, $result->resource_owner]);
                } else {
                    DB::insert('insert into hdb_token_alibaba (aliid, resource_owner,expires_in,access_token) values (?,?,?,?)', [$result->aliId, $result->resource_owner, $nowtime, $result->access_token]);
                    return $result->access_token;
                }
            }
        }
        return null;
    }
}*/


/**
 * @param null $code
 * @return null
 * 获取阿里巴巴web版授权token
 */
function get_token($owner = null)
{
    $tokens = DB::table('hdb_token_alibaba')
        ->select('expires_in', 'access_token')
        ->where('resource_owner', $owner)
        ->get();
    if (!empty($tokens[0]->expires_in) && $tokens[0]->expires_in > time()) {
        return $tokens[0]->access_token;
    }
}

/**
 * @param null $code
 * @return null
 * 设置登录账号token
 */
function set_token($code = null)
{
    if (!empty($code)) {
        $token_url = "https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/getToken/" . APP_KEY . "?";
        $post_data['grant_type'] = 'authorization_code';
        $post_data['need_refresh_token'] = true;
        $post_data['client_id'] = APP_KEY;
        $post_data['client_secret'] = APP_SECRET;
        $post_data['redirect_uri'] = REDIRECT_URL;
        $post_data['code'] = $code;
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);
        $curlPost = $post_data;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL, $token_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $data = curl_exec($curl);//运行curl
        curl_close($curl);
        $result = json_decode($data);
        if (!empty($result->access_token)) {
            $nowtime = time() + intval($result->expires_in);
            $tokens = DB::table('hdb_token_alibaba')
                ->where('resource_owner', $result->resource_owner)
                ->first();
            Session::put('login_alibaba', $result->resource_owner);
            if (!empty($tokens->id)) {
                DB::update("update hdb_token_alibaba set expires_in =?,access_token=? where resource_owner = ?", [$nowtime, $result->access_token, $result->resource_owner]);
            } else {
                DB::insert('insert into hdb_token_alibaba (aliid, resource_owner,expires_in,access_token) values (?,?,?,?)', [$result->aliId, $result->resource_owner, $nowtime, $result->access_token]);
                return $result->access_token;
            }
            return $result->access_token;
        }
    }
    return null;
}


/**
 * @param null $code
 * @return null
 * 是否授权成功
 */
function is_token()
{
    $tokens = DB::table('hdb_token')
        ->select('expires_in', 'access_token')
        ->where('status', 1)
        ->get();
    if (!empty($tokens[0]->expires_in) && $tokens[0]->expires_in > time()) {
        return $tokens[0]->access_token;
    } else {
        return null;
    }
}

/**
 * @param $url
 * @return mixed
 * 模拟get请求
 */
function request_get($url)
{
    $ch = curl_init();
    /* $this_header = array(
         "content-type: application/x-www-form-urlencoded;charset=UTF-8"
     );
     curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);*/
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURL_SSLVERSION_SSL, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($ch);
    return $data;
}

/**
 * @param $url
 * 根据图片链接地址下载图片到本地
 */
function load_img($url)
{
    if (strpos($url, ',')) {
        $arry = explode(',', $url);
        foreach ($arry as $val) {
            getImage($val);
        }
    } else {
        getImage($url);
    }
}

/**
 * @param $path
 * 创建多层级目录
 */
function createdir($path)
{
    $mode = 0755;
    if (!is_dir($path)) {
        $re = mkdir($path, $mode, true); //第三个参数为true即可以创建多极目录
        if ($re) {
            return true;
        }
        return false;
    }
}

/**
 * @param $url
 * 下载图片
 */
function getImage($url)
{
    if (!empty($url)) {
        $pathUrl = parse_url($url);
        $filepath = $pathUrl['path'];
        $len = strrpos($filepath, '/');
        $path = PIC_PATH . substr($filepath, 0, $len + 1);
        createdir($path);
        $opts = array(
            'http' => array(
                'method' => "GET",
                'timeout' => 60,
            ));
        //解决file_get_contents函数超时问题
        $context = stream_context_create($opts);
        $img = file_get_contents($url, false, $context);
        file_put_contents(PIC_PATH . $filepath, $img);
    }
}

function get_img_socket($url, $savepath = "img/")
{
    date_default_timezone_set('PRC');
    $pattern = '/((http:\/\/)|(https:\/\/))?([^\/]+)(.+)/';
    $res = preg_match($pattern, $url, $matches);
    if ($res == 0) {
        return false;
    }
    $host = "";//主机名
    $file = "";//请求的文件
    $ext = strrchr($url, '.');
    if (count($matches) == 5) {
        $host = $matches[3];
        $file = $matches[4];
    } else if (count($matches) == 6) {
        $host = $matches[4];
        $file = $matches[5];
    } else {
        return false;
    }
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    $res = socket_connect($socket, gethostbyname($host), 80);
    if (!$res) {
        //echo socket_strerror(socket_last_error($socket));
        socket_close($socket);
        return false;
    }
    $request = "";
    $request .= "GET $file HTTP/1.1\r\n";
    $request .= "Host: $host\r\n";
    $request .= "Connection: close\r\n\r\n";
    $len = socket_write($socket, $request);

    $response = "";
    while ($buf = socket_read($socket, 512)) {
        if (strlen($buf) == 0) {
            break;
        }
        $response .= $buf;
    }
    if (strpos($response, "\r\n\r\n")) {
        $arr = explode("\r\n\r\n", $response);
        return $arr[1];
    } else {
        socket_close($socket);
        return false;
    }
    socket_close($socket);
    return true;
}