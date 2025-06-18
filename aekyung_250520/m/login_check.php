<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
$cookie_count=0;
	
if(isset($_COOKIE["ak_cookie_01"]) || isset($_COOKIE["ak_cookie_02"])){
	/* 2023.04.29 - 4/27 암호화방식 변경 작업 후 모바일 로그인이 안된다는 유저들이 발생해서 주석 처리
    $error="M_LOGIN_CHECK_01";
	$cookieSql = "select B.hero_id,B.hero_pw from cookie_info as A inner join member as B on A.hero_code=B.hero_code where A.hero_today='".$_COOKIE["ak_cookie_01"]."' and A.hero_temp_pw=md5(concat('".$_COOKIE["ak_cookie_01"]."',B.hero_code,B.hero_oldday,'".$_COOKIE["ak_cookie_01"]."'))";
	$cookieRes = new_sql($cookieSql,$error,"on");
	if($cookieRes==$error){
		error_historyBack("");
		exit;
	}
	$cookie_count = mysql_num_rows($cookieRes);
	if($cookie_count>0){
		$hero_id = mysql_result($cookieRes,0,0);
		$hero_m_pw = mysql_result($cookieRes,0,1);
	}else{
		$message = "일치하는 정보가 없습니다";
		setcookie("ak_cookie_01", "",  time()-3600);
		setcookie("ak_cookie_02", "",  time()-3600);
		error_location($message,'/m');
		exit;
	}
	*/
}else{
	if($snsType) {
		$snsId = $_POST['snsId'];
		$snsType = $_POST['snsType'];
		$hero_id = "";
		$hero_pw = "";
	} else {
		$snsId = $_POST['snsId'];
		$snsType = $_POST['snsType'];
		$hero_id = $_POST['hero_id'];
		$hero_pw = $_POST['hero_pw'];
	}
}
include_once $_SERVER['DOCUMENT_ROOT'].'/combined/login_check.php';

//자동 로그인 기능 활성화
//20190527 자동 로그인 사용안함 아이디 저장으로 변경
/*
if($_POST['hero_save']=="true" && (!isset($_COOKIE["ak_cookie_01"]) || !isset($_COOKIE["ak_cookie_02"]))){
   	$settime = time()+604800;
   	$error = "M_LOGIN_01";
   	$cookieSql = "insert into cookie_info (hero_code, hero_today, hero_temp_pw) values ('".$list_top['hero_code']."', '".$settime."', md5(concat('".$settime."','".$list_top['hero_code']."','".$list_top['hero_oldday']."','".$settime."')))";
        	//echo $cookieSql;
        	//exit;
   	$cookieRes = new_sql($cookieSql,$error);
   	if((string)$cookieRes==$error){
   		error_historyBack("자동 완성 기능 오류입니다. 고객센터에 문의해 주세요.");
   		exit;
   	}
   	$error = "M_LOGIN_02";
   	$cookie_infoSql = "select hero_today, hero_temp_pw from cookie_info where hero_code='".$list_top['hero_code']."' order by hero_idx desc limit 0,1";
   	$cookie_infoRes = new_sql($cookie_infoSql,$error);
   	if($cookie_infoRes==$error){
   		error_historyBack("자동 완성 기능 오류입니다. 고객센터에 문의해 주세요.");
   		exit;
   	}
   	setcookie("ak_cookie_01", mysql_result($cookie_infoRes,0,0), $settime);
   	setcookie("ak_cookie_02", mysql_result($cookie_infoRes,0,1), $settime);
   	message("자동 로그인 기능은 7일 동안 유지됩니다. 만약 취소를 원하시면 로그아웃하시면 됩니다.");
} 
*/ 

if($_POST["hero_save"] == "true") {
	setcookie("cookie_hero_id",$_POST["hero_id"],time()+(29*24*60*60));
} else {
	setcookie("cookie_hero_id","",time()+(30*24*60*60));
}

include_once $_SERVER['DOCUMENT_ROOT'].'/combined/chLastUpdatedPw.php';

// 24.07.16 musign 첫 로그인시 본인인증 로직 추가
$member_sql = " SELECT hero_info_ci FROM member WHERE hero_use = 0  AND hero_code = '".$_SESSION["temp_code"]."' ";
$member_res = sql($member_sql);
$member_rs = mysql_fetch_assoc($member_res);

if($first_login_check && !$member_rs["hero_info_ci"]) { // 첫로그인 & 본인인증 미확인 회원
	message("AK Lover 홈페이지 첫 로그인을 환영합니다.\\n체험단 제품 배송비를 대체할 수 있는 포인트 ".$_DELIVERY_POINT."점을 지급해드렸습니다.");
	echo "<script>alert('AK Lover는 공정한 서포터즈 활동을 위해 \\nSNS 가입 후 로그인 시, \\n최초 1회 본인확인이 필요합니다.');</script>";
	echo "<script>location.href='/m/auth.php?board=auth&returnUrl=y';</script>";

} else if($first_login_check) {
	message("AK Lover 홈페이지 첫 로그인을 환영합니다.\\n체험단 제품 배송비를 대체할 수 있는 포인트 ".$_DELIVERY_POINT."점을 지급해드렸습니다.");
	location("/m/mypoint.php?board=mypoint");
}

if(!$member_rs["hero_info_ci"]) { // 본인인증 미확인 회원
	echo "<script>alert('AK Lover는 공정한 서포터즈 활동을 위해 \\nSNS 가입 후 로그인 시, \\n최초 1회 본인확인이 필요합니다.');</script>";
	echo "<script>location.href='/m/auth.php?board=auth&returnUrl=y';</script>";
}

location("/m");

/*기존로직
if($first_login_check) {
	message("AK Lover 홈페이지 첫 로그인을 환영합니다.\\n체험단 제품 배송비를 대체할 수 있는 포인트 ".$_DELIVERY_POINT."점을 지급해드렸습니다.");
	location("/m/mypoint.php?board=mypoint");
} else {
	location("/m");
}*/
exit;
?>
