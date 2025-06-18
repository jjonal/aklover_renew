<?php
header("Content-Type: text/html; charset=EUC-KR");

	$sns = trim($_REQUEST["sns"]);
	$url = trim($_REQUEST["url"]);
	$msg = trim(mb_convert_encoding($_REQUEST["description"],"EUC-KR","UTF-8"));
	$img = trim($_REQUEST["img"]);

echo $_REQUEST["description"];
exit;
	
	switch($sns){
		case "TWITTER":
			$redirect = "http://twitter.com/share?url=".urlencode($url)."&text=".urlencode($msg);
		break;	
		case "FACEBOOK":
			$redirect = "https://www.facebook.com/dialog/feed?app_id=1398653377106374&link=".$url."&picture=".urlencode($img)."&name=".urlencode($msg)."&redirect_uri=".$url;
		break;
		case "ME2DAY":
			$redirect = "http://me2day.net/posts/new?new_post[body]=".urlencode($msg." ".$url);
		break;
	}
	header("Location:".$redirect);
	exit;
?>
