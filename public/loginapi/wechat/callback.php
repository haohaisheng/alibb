<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 0);
session_start();

if(isset($_REQUEST['code'])){
	$code = $_REQUEST['code'];
	$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxc6624ff82f68b2e0&secret=babadd35d2e3e6193a32659037a40f10&code='.$code.'&grant_type=authorization_code';
	$r=https_request($url);
	$r=json_decode($r, true);

	// $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc6624ff82f68b2e0&secret=babadd35d2e3e6193a32659037a40f10";
 	// $res = https_request($url);
 	// $result = json_decode($res, true);
 	
}

if (isset($r['openid'])){
	// $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$result["access_token"]."&openid=".$r['openid']."&lang=zh_CN";
	// $res = https_request($url);
 	// $user = json_decode($res, true);
	// var_dump($user);

	$_SESSION['login']['uid'] = $r['openid'];
	$_SESSION['login']['type'] = 'wechat';
	$_SESSION['login']['nickname'] = '';
	$_SESSION['login']['img'] = '';

	echo '<br>uid:'.$_SESSION['login']['uid'];
	echo '<br>type:'.$_SESSION['login']['type'];
	echo '<br>nickname:'.$_SESSION['login']['nickname'];
	echo '<br>img:'.$_SESSION['login']['img'];
	?>
	<script language='javascript'>
	
		window.location.href = "http://www.sameboy.com/extendLogin";	

	</script>
	<?php
}else{
	?>
	<script language='javascript'>
	alert('授权失败，请稍后重试');
	window.history.go(-2);	
	</script>
	<?php
}

//https请求（支持GET和POST）
function https_request($url, $data = null)
{
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
}