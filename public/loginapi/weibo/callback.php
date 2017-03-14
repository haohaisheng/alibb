<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,  $token['access_token'] );
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

	// var_dump($user_message);

	// echo '1<img src="'.$user_message['profile_image_url'].'">';
	// echo '2<img src="'.$user_message['thumbnail_pic'].'">';
	// echo '3<img src="'.$user_message['bmiddle_pic'].'">';
	// echo '4<img src="'.$user_message['original_pic'].'">';
	// echo '5<img src="'.$user_message['avatar_large'].'">';
	// echo '6<img src="'.$user_message['avatar_hd'].'">';
	

	$_SESSION['login']['uid'] = $token['uid'];
	$_SESSION['login']['type'] = 'weibo';
	$_SESSION['login']['nickname'] = $user_message['screen_name'];
	$_SESSION['login']['img'] = $user_message['avatar_large'];

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