<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
$cookie_count=0;
	
if(isset($_COOKIE["ak_cookie_01"]) || isset($_COOKIE["ak_cookie_02"])){
	/* 2023.04.29 - 4/27 ��ȣȭ��� ���� �۾� �� ����� �α����� �ȵȴٴ� �������� �߻��ؼ� �ּ� ó��
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
		$message = "��ġ�ϴ� ������ �����ϴ�";
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

//�ڵ� �α��� ��� Ȱ��ȭ
//20190527 �ڵ� �α��� ������ ���̵� �������� ����
/*
if($_POST['hero_save']=="true" && (!isset($_COOKIE["ak_cookie_01"]) || !isset($_COOKIE["ak_cookie_02"]))){
   	$settime = time()+604800;
   	$error = "M_LOGIN_01";
   	$cookieSql = "insert into cookie_info (hero_code, hero_today, hero_temp_pw) values ('".$list_top['hero_code']."', '".$settime."', md5(concat('".$settime."','".$list_top['hero_code']."','".$list_top['hero_oldday']."','".$settime."')))";
        	//echo $cookieSql;
        	//exit;
   	$cookieRes = new_sql($cookieSql,$error);
   	if((string)$cookieRes==$error){
   		error_historyBack("�ڵ� �ϼ� ��� �����Դϴ�. �����Ϳ� ������ �ּ���.");
   		exit;
   	}
   	$error = "M_LOGIN_02";
   	$cookie_infoSql = "select hero_today, hero_temp_pw from cookie_info where hero_code='".$list_top['hero_code']."' order by hero_idx desc limit 0,1";
   	$cookie_infoRes = new_sql($cookie_infoSql,$error);
   	if($cookie_infoRes==$error){
   		error_historyBack("�ڵ� �ϼ� ��� �����Դϴ�. �����Ϳ� ������ �ּ���.");
   		exit;
   	}
   	setcookie("ak_cookie_01", mysql_result($cookie_infoRes,0,0), $settime);
   	setcookie("ak_cookie_02", mysql_result($cookie_infoRes,0,1), $settime);
   	message("�ڵ� �α��� ����� 7�� ���� �����˴ϴ�. ���� ��Ҹ� ���Ͻø� �α׾ƿ��Ͻø� �˴ϴ�.");
} 
*/ 

if($_POST["hero_save"] == "true") {
	setcookie("cookie_hero_id",$_POST["hero_id"],time()+(29*24*60*60));
} else {
	setcookie("cookie_hero_id","",time()+(30*24*60*60));
}

include_once $_SERVER['DOCUMENT_ROOT'].'/combined/chLastUpdatedPw.php';

// 24.07.16 musign ù �α��ν� �������� ���� �߰�
$member_sql = " SELECT hero_info_ci FROM member WHERE hero_use = 0  AND hero_code = '".$_SESSION["temp_code"]."' ";
$member_res = sql($member_sql);
$member_rs = mysql_fetch_assoc($member_res);

if($first_login_check && !$member_rs["hero_info_ci"]) { // ù�α��� & �������� ��Ȯ�� ȸ��
	message("AK Lover Ȩ������ ù �α����� ȯ���մϴ�.\\nü��� ��ǰ ��ۺ� ��ü�� �� �ִ� ����Ʈ ".$_DELIVERY_POINT."���� �����ص�Ƚ��ϴ�.");
	echo "<script>alert('AK Lover�� ������ �������� Ȱ���� ���� \\nSNS ���� �� �α��� ��, \\n���� 1ȸ ����Ȯ���� �ʿ��մϴ�.');</script>";
	echo "<script>location.href='/m/auth.php?board=auth&returnUrl=y';</script>";

} else if($first_login_check) {
	message("AK Lover Ȩ������ ù �α����� ȯ���մϴ�.\\nü��� ��ǰ ��ۺ� ��ü�� �� �ִ� ����Ʈ ".$_DELIVERY_POINT."���� �����ص�Ƚ��ϴ�.");
	location("/m/mypoint.php?board=mypoint");
}

if(!$member_rs["hero_info_ci"]) { // �������� ��Ȯ�� ȸ��
	echo "<script>alert('AK Lover�� ������ �������� Ȱ���� ���� \\nSNS ���� �� �α��� ��, \\n���� 1ȸ ����Ȯ���� �ʿ��մϴ�.');</script>";
	echo "<script>location.href='/m/auth.php?board=auth&returnUrl=y';</script>";
}

location("/m");

/*��������
if($first_login_check) {
	message("AK Lover Ȩ������ ù �α����� ȯ���մϴ�.\\nü��� ��ǰ ��ۺ� ��ü�� �� �ִ� ����Ʈ ".$_DELIVERY_POINT."���� �����ص�Ƚ��ϴ�.");
	location("/m/mypoint.php?board=mypoint");
} else {
	location("/m");
}*/
exit;
?>
