<?php 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head.php';

if($_SESSION["temp_code"]){
	
	$distanceOfChPw = "-3 months";
	
	$error = "CHLASTUPDATEDPW_01";
	$threeMonthAgo = date("Y-m-d", strtotime($distanceOfChPw));
	$chLastUpdatedPw_sql = "select * from logging_pw where hero_code='".$_SESSION['temp_code']."' order by hero_idx desc limit 0,1";
	$chLastUpdatedPw_res = new_sql($chLastUpdatedPw_sql,$error);
	if((string)$chLastUpdatedPw_res==$error){
		error_location("","/main/index.php");
		exit;
	}
	
	$count_loggedPw = mysql_num_rows($chLastUpdatedPw_res);

	if($count_loggedPw<1){
		$error = "CHLASTUPDATEDPW_02";
		$member_sql = "select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_oldday<'".$threeMonthAgo."'";
		$member_res = new_sql($member_sql,$error);
		if((string)$member_res==$error){
			error_location("","/main/index.php");
			exit;
		}
		$count_oldday = mysql_result($member_res,0,0);
		
		if($count_oldday>0){
			//echo "<script>setCookie('ch_password', 'needUpdatedPw', time()+(60*60*24));</script>";
			//setcookie('ch_password', 'need', time()+(60*60*24));
			$_SESSION['ch_password']=1;
		}
		
	}else{
		$chLastUpdatedPw_rs = mysql_fetch_assoc($chLastUpdatedPw_res);
		//연기되었을 경우
		if($chLastUpdatedPw_rs['hero_today']==date("Y-m-d")){
			//echo "<script>setCookie('ch_password', 'needUpdatedPw', time()+(60*60*24));</script>";
			//setcookie('ch_password', 'need', time()+(60*60*24));
			$_SESSION['ch_password']=1;
		//3개월이 경과했을 경우
		}elseif(!$chLastUpdatedPw_rs['hero_delay'] && $chLastUpdatedPw_rs['hero_pw'] && $chLastUpdatedPw_rs['hero_oldday']<= $threeMonthAgo){
			//echo "<script>setCookie('ch_password', 'needUpdatedPw', time()+(60*60*24));</script>";
			//setcookie('ch_password', 'need', time()+(60*60*24));
			$_SESSION['ch_password']=1;
		}
	}
	
}
?>