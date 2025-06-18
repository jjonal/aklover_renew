<?php 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
if(!$_SESSION['temp_code'] && !$_POST['snsId']){
	//echo "message:잘못된 접근입니다.";
	//echo iconv('CP949', 'UTF-8', "message:잘못된 접근입니다.");
	echo getIconv("message:잘못된 접근입니다.");
	exit;
}
$time = time();

if($_POST['snsWhere']=='infoedit'){
	$error = "ZIP_SNS_01";
	$member_sql = "select * from (select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_use=0) as A, ";
	$member_sql .= "(select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_".$_POST['snsType']."=md5('".$_POST['snsId']."') and hero_use=0) as B, ";
	$member_sql .= "(select count(*) from member where hero_code!='".$_SESSION['temp_code']."' and hero_".$_POST['snsType']."=md5('".$_POST['snsId']."') and hero_use=0) as C";
	$member_res = new_sql($member_sql,$error,"on");
	if((string)$memeber_res==$error){
		logging_error($_SESSION['temp_code'], $error."_".$member_sql, $time);
		echo $error;
		exit;
	}
	
	$member_tf = mysql_result($member_res,0,0);
	$sns_tf = mysql_result($member_res,0,1);
	$duplecate_tf = mysql_result($member_res,0,2);
	
	if($member_tf!=1 && $_POST['snsWhere']!='idcheck'){
		logging_error($_SESSION['temp_code'], "ZIP_SNS_02_code_is_not_exist_".$member_sql, $time);
		echo "ZIP_SNS_02";
		exit;
	}	
	if($sns_tf>0){
		//echo "message:이 ".$_POST['snsType']." 계정은 이미 ".$_SESSION['temp_nick']."님과 연동되어 있습니다.";
		//echo iconv('CP949', 'UTF-8', "message:이 ".$_POST['snsType']." 계정은 이미 ".$_SESSION['temp_nick']."님과 연동되어 있습니다.");
		echo getIconv("message:이 ".$_POST['snsType']." 계정은 이미 ".$_SESSION['temp_nick']."님과 연동되어 있습니다.");
		exit;
	}
	if($duplecate_tf>0){
		logging_error($_SESSION['temp_code'], "ZIP_SNS_02_duplecate_sns_id_".$member_sql, $time);
		//echo "message:이 ".$_POST['snsType']." 계정은 AKLOVER의 다른 계정과 연동되어 있습니다.";
		//echo iconv('CP949', 'UTF-8', "message:이 ".$_POST['snsType']." 계정은 AKLOVER의 다른 계정과 연동되어 있습니다.");
		echo getIconv("message:이 ".$_POST['snsType']." 계정은 AK Lover의 다른 계정과 연동되어 있습니다.");
		exit;
	}
	
	$error = "ZIP_SNS_03";
	$sql_one = "hero_".$_POST['snsType']."=md5('".$_POST['snsId']."')";
	$sql = "UPDATE member SET ".$sql_one." WHERE hero_code = '".$_SESSION['temp_code']."'";
	$res = new_sql($sql,$error);
	if((string)$res == $error){
		logging_error($_SESSION['temp_code'], $error."_".$sql, $time);
		echo $error;
		exit;
	}
}

else if($_POST['snsWhere']=='idcheck'){
	$error = "ZIP_SNS_04";
	$member_sql = "select count(*) from member where hero_".$_POST['snsType']."=md5('".$_POST['snsId']."') and hero_use=0";
	//echo $member_sql;
	$member_res = new_sql($member_sql,$error,"on");
	if((string)$memeber_res==$error){
		echo $error;
		exit;
	}
	
	$member_tf = mysql_result($member_res,0,0);
	
	if($member_tf>0){
		logging_error($_SESSION['temp_code'], "ZIP_SNS_02_duplecate_sns_id_".$member_sql, $time);
		//echo "message:이 ".$_POST['snsType']." 계정은 AKLOVER의 다른 계정과 연동되어 있습니다.";
		//echo iconv('CP949', 'UTF-8', "message:이 ".$_POST['snsType']." 계정은 AKLOVER의 다른 계정과 연동되어 있습니다.");
		echo getIconv("message:이 ".$_POST['snsType']." 계정은 AK Lover의 다른 계정과 연동되어 있습니다.");
		exit;
	}
}
echo 1;
?>