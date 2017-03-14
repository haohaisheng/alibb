<?php
header('Content-Type: text/html; charset=UTF-8');
require_once("API/qqConnectAPI.php");
$qc = new QC();
$acs = $qc->qq_callback();
$_SESSION['login']['uid']=$qc->get_openid();
$qc = new QC($acs,$_SESSION['login']['uid']);
$arr = $qc->get_user_info();
$_SESSION['login']['type']="qq";
$_SESSION['login']['nickname']=$arr["nickname"];
$_SESSION['login']['img']=$arr['figureurl_2'];


if ($arr) {
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
