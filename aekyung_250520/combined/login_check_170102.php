<?php 
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_level']>0)					error_location("이미 로그인 되었습니다.","/main/index.php");
if((!$hero_id || !$hero_pw) && (!$snsId || !$snsType) && (!$hero_id || !$hero_m_pw))	error_historyBack("잘못된 접근입니다");
######################################################################################################################################################

$full_today = date("Y-m-d H:i:s");

$error = "LOGIN_CHECK_01";
if($hero_pw){
	/*
	
	$sql = "select hero_id from member where hero_id = '".$hero_id."'";
	$message = "일치하는 정보가 없습니다";
	*/
	
	$id_sql = "select hero_id from member where hero_id = '".$hero_id."'";
	$id_out_sql = new_sql($id_sql,$error,"on");
	$id_count = mysql_num_rows($id_out_sql);
	
	if($id_count == 0) {
		//20161228 문수영 수정 휴먼회원은 로그인 아이디가 존재하지 않아 진행못함
		//error_location("아이디를 확인해주세요.",'/main/index.php?board=login');
		
		$sql = "select hero_id from member where hero_id = '".$hero_id."'";
		
		//20161229 나아론 수정 휴면회원 체크
		$rest_sql = "select hero_id from member_backup where hero_id = '".$hero_id."'";
		$rest_out_sql = new_sql($rest_sql,$error,"on");
		$rest_out_sql = mysql_num_rows($rest_out_sql);
		if($rest_out_sql == 0) {//휴면테이블에 아이디가 없으면
			$message = "아이디를 확인해주세요.";
		}else { //있으면
			$message = "비밀번호를 확인해주세요.";
		}
	}else {
		$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = md5('".$hero_pw."') and hero_use=0";
		$message = "비밀번호를 확인해주세요.";
	}
	
//모바일 자동 로그인 기능으로 로그인 할 경우
}elseif($hero_m_pw){
	$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = '".$hero_m_pw."' and hero_use=0";
	$message = "일치하는 정보가 없습니다";
}else{
	$sql = "select * from member where hero_".$snsType." = md5('".$snsId."') and hero_use=0";
	$message = "이 계정은 AKLOVER와 연동되어있지 않습니다. 로그인 후 마이페이지>정보 수정에서 연동하실 수 있습니다.";
}

//md5로 변경시 아래 쿼리 사용
//$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = md5('".$hero_pw."')";

$out_sql = new_sql($sql,$error,"on");

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}

$count = mysql_num_rows($out_sql);
if($count==0){
	//########### 휴면정보 체크 ##############
	if($hero_pw || $hero_m_pw){
		$sql1 = "select hero_code from member_backup where hero_id = '".$hero_id."' and hero_pw = md5('".$hero_pw."')";
	}else{
		$sql1 = "select hero_code from member_backup where hero_".$snsType." = md5('".$snsId."')";
	}	
	$out_sql1 = new_sql($sql1,$error,"on");
	if((string)$out_sql1==$error){
		error_historyBack("");
		exit;
	}
	$count1 = mysql_num_rows($out_sql1);
	if($count1==0){
		setcookie("ak_cookie_01", "",  time()-3600);
		setcookie("ak_cookie_02", "",  time()-3600);
		if($_GET['board']=='login_check')		error_location($message,'/main/index.php?board=login&focus=pw');
		else									error_location($message,'/m');
		exit;
		
	}else{
		$list_dormancy  = @mysql_fetch_assoc($out_sql1);
		$member_backup_sql = "select hero_code,hero_name,hero_out_date,hero_id from member_backup where hero_code='".$list_dormancy['hero_code']."'";
		$result = new_sql($member_backup_sql,$error);
		if((string)$member_backup_sql==$error){
			error_historyBack("");
			exit;
		}

		$out_code = mysql_result($result,0,0);
		$out_name = mysql_result($result,0,1);
		$out_date = mysql_result($result,0,2);
		$out_id = mysql_result($result,0,3);
		$dir = getcwd(); // 현재 디렉토리명을 반환하는 PHP 함수이다.
		$temp = explode("/", $dir);
		$dirname = $temp[sizeof($temp)-1];
		if($dirname == "main"){
			$actionName = "/main/index.php";
		}elseif($dirname == "m"){
			$actionName = "/m/main.php";
		}
		ob_clean();	
		echo 
		"<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=euc-kr' />
		<title></title>
		</head>
		<body onload='document.frm.submit();'>
		<form name='frm' action='".$actionName."' method='post'>
		<input type='hidden' name='dormancy' value='yes' />
		<input type='hidden' name='hero_code' value='".$out_code."' />
		<input type='hidden' name='hero_name' value='".$out_name."' />
		<input type='hidden' name='hero_out_date' value='".$out_date."' />
		<input type='hidden' name='hero_id' value='".$out_id."' />
		</form>
		</body>
		</html>";
		exit;
	
	}	
	//########## 휴면정보 체크 ##############	
}//count==0

######################################################################################################################################################
$list_top                             = @mysql_fetch_assoc($out_sql);

$_SESSION['temp_code'] 		=	 $list_top['hero_code'];
$_SESSION['temp_id'] 		=	 $list_top['hero_id'];
$_SESSION['temp_name']		=	 $list_top['hero_name'];
$_SESSION['temp_nick'] 		=	 $list_top['hero_nick'];
$_SESSION['temp_level'] 	=	 $list_top['hero_level'];
$_SESSION['temp_write'] 	=	 $list_top['hero_write'];
$_SESSION['temp_view'] 		=	 $list_top['hero_view'];
$_SESSION['temp_update'] 	=	 $list_top['hero_update'];
$_SESSION['temp_rev'] 		=	 $list_top['hero_rev'];

$error = "LOGIN_CHECK_02";
$member_total_sql = "select SUM(hero_point) as member_total from point where hero_code='".$_SESSION['temp_code']."'";
$member_total_res = new_sql($member_total_sql,$error);
if((string)$member_total_res==$error){
	error_historyBack("");
	exit;
}

$member_total_point = mysql_result($member_total_res,0,0);






######## 매달 처음 로그인시에 생일자 포인트 제공
if(substr($list_top['hero_today'],0,7) != date("Y-m")){
	$error = "EVENT_CHECK_01";	
	//생일자 파악 
	$birth_sql = "select left(right(hero_jumin,4),2) from member where hero_code='".$_SESSION['temp_code']."' ";
	$birth_res = new_sql($birth_sql,$error);
	if((string)$birth_res==$error){
		error_historyBack("");
		exit;
	}

	$birth_day = mysql_result($birth_res,0,0);
	

	if($birth_day==date("m")){
		$error = "EVENT_CHECK_02";
		//올해 제공된 생일 포인트가 있는지?
		$event_sql = "select count(*) from point where hero_code='".$_SESSION['temp_code']."' and hero_type='birth' and left(hero_today,4)='".date("Y")."'";
		$event_res = new_sql($event_sql,$error);
		if((string)$event_res==$error){
			error_historyBack("");
			exit;
		}
		 
		$event_count = mysql_result($event_res,0,0);
				
		//생일 축하 포인트를 받은 적 없는 경우.
		if($event_count==0){
			$error = "EVENT_CHECK_03";
			$event_point_sql = "select hero_point from today where hero_type='hero_event'";
			$event_point_res = new_sql($event_point_sql,$error);
			if((string)$event_point_res==$error){
				error_historyBack("");
				exit;
			}
			$event_point = mysql_result($event_point_res,0,0);
			$error = "EVENT_CHECK_04";
			$member_total_point += $event_point;//회원 레벨 측정을 위한 값 더하기
			$point_sql = "INSERT INTO point (hero_code, hero_id, hero_name, hero_today, hero_title, hero_top_title, hero_type,hero_point, point_change_chk ,hero_ori_today) 
			VALUES ('".$_SESSION['temp_code']."', '".$_SESSION['temp_id']."', '".$_SESSION['temp_name']."', now(), '생일축하포인트', '생일축하포인트', 'birth','".$event_point."','Y', now())";
			$point_res = new_sql($point_sql,$error);
			if((string)$point_res==$error){
				error_historyBack("");
				exit;
			}
			message("생일 축하합니다.\\n축하 포인트가 적립 되었습니다.");
		}	
	}	
}









$error = "LOGIN_CHECK_03";
$temp_level_sql = "select hero_level from level where hero_point_01<='".$member_total_point."' and hero_point_02>='".$member_total_point."' ";
$temp_level_res = new_sql($temp_level_sql,$error);
if((string)$temp_level_res==$error){
	error_historyBack("");
	exit;
}
$temp_level_01 = mysql_result($temp_level_res,0,0);


######################################################################################################################################################
########      매달 처음 로그인시에 수퍼패스를 갱신//슈퍼패스를 처음갱신할 경우                       ###########################################################################################################################
if(substr($list_top['hero_today'],0,7) != date("Y-m")){
	$threeMonthAgo = date("Y-m-d",strtotime("-3 month"));
	$oneMonthAgo = date("Y-m-d",strtotime("-1 month"));
	 
	$error = "LOGIN_CHECK_04";
	$panelty_sql = "select count(*) from point where hero_code='".$_SESSION['temp_code']."' and hero_point<0 and (hero_type='' or hero_type='togetherPoint' or hero_type='personPoint')  and (hero_table='' or hero_table='user') and hero_today>='".$threeMonthAgo."'";
	$panelty_res = new_sql($panelty_sql,$error);
	if((string)$panelty_res==$error){
		error_historyBack("");
		exit;
	}
	 
	$panelty_count = mysql_result($panelty_res,0,0);
	if($panelty_count==0){

		$error = "LOGIN_CHECK_05";
		$vip_check_sql = "select * from ";
		$vip_check_sql .= "(select count(*) as vip_board_count from board where hero_code='".$list_top['hero_code']."' and left(hero_today,10)>='".$oneMonthAgo."') as A, ";
		$vip_check_sql .= "(select count(*) as vip_review_count from review where hero_code='".$list_top['hero_code']."' and left(hero_today,10)>='".$oneMonthAgo."') as B ";
		$vip_check_sql .= "where 1=1";

		$vip_check_res = new_sql($vip_check_sql,$error);
		if((string)$vip_check_res==$error){
			error_historyBack("");
			exit;
		}

		$vip_check_rs = mysql_fetch_assoc($vip_check_res);
		
		//블로그 컨텐츠 등급 + 방문자수 
		if($list_top['hero_memo']>2000 && $list_top['hero_memo_01']=='상')		$is_powerblog = "powerblog";

		//1개월 이내 접속 + 블로그 계정 有 + 1개월 이내 글(댓글) 작성 1회 이상
		if($list_top['hero_today']>=$oneMonthAgo && $list_top['hero_blog_00'] && ($vip_check_rs['vip_board_count']>0 || $vip_check_rs['vip_review_count']>0)) 	$is_vip = "vip";

		if($is_powerblog || $is_vip){
			$kind = $is_powerblog.":".$is_vip;
			 
			$error = "LOGIN_CHECK_06";
			$superpass_sql = "insert into superpass (hero_code, hero_kind, hero_superpass, hero_today, hero_endday) values ('".$_SESSION['temp_code']."','".$kind."', 1, '".$full_today."','".date("Y-m-t 23:59:59")."')";

			$superpass_res = new_sql($superpass_sql,$error);
			if((string)$superpass_res==$error){
				error_historyBack("");
				exit;
			}
		}
	}
}

$error = "LOGIN_CHECK_07";

/*********************************************
* 161130 작성
* 9개월 미로그인자 이벤트 (일시이벤트)
* 아래 if문 조건에 따라 이벤트기간 조정가능(2016년 12월 5일~ 2016년 12월 22일)
* 이벤트기간에 맞게 9month_event_mail.php 쿼리에서 휴면회원 빼줘야함
* 나아론(hide305@naver.com)
**********************************************/
if(mktime(23, 59, 59, 12, 01, 2016) < time() && mktime(00, 00, 00, 12, 22, 2016) > time()) {
	$login_9month_event = "SELECT count(*) FROM member_login_event_9month WHERE hero_code='".$_SESSION['temp_code']."' AND login_date is null";
	$login_9month_event_res = new_sql($login_9month_event,$error);
	$login_9month_event_rs = mysql_result($login_9month_event_res,0,0);
	
	// 9개월 이벤트 테이블에 데이터가 있으면 로직 수행
	if($login_9month_event_rs > 0) {
		$update_9month = "UPDATE member_login_event_9month SET login_date = now() WHERE hero_code='".$_SESSION['temp_code']."'";
		$update_9month_res = new_sql($update_9month,$error);
		if((string)$update_9month_res==$error){
			error_historyBack("9개월이상 미로그인 오류입니다. 관리자에게 문의해주세요.");
			exit;
		}
		
		$insertPoint_9month = "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
		$insertPoint_9month .= "values ('".$_SESSION['temp_code']."','member', 'member', '0', '".$_SESSION['temp_id']."','9개월 미사용자 이벤트','9개월 미사용자 이벤트','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','100','".$full_today."','N','0','Y','".$full_today."')";
		
		$insertPoint_9month_res = new_sql($insertPoint_9month,$error);
		//100포인트 지급
		if((string)$insertPoint_9month_res==$error){
			error_historyBack("9개월이상 미로그인 이벤트 오류입니다. 관리자에게 문의해주세요.");
			exit;
		}
		
		echo "<script>alert('9개월 이상 미사용자 이벤트 100포인트가 지급되었습니다');</script>";
	
	}
}
######################################################################################################################################################
########      휴면계정 이벤트        ###########################################################################################################################


$seventeenDaysAgo = date("Y-m-d", strtotime("-17 day"));
$error = "LOGIN_CHECK_07";
$ch_member_dormancy = "select count(*) from member_login_event where hero_code='".$_SESSION['temp_code']."' and login_date is null";
$ch_member_dormancy_res = new_sql($ch_member_dormancy,$error);
if((string)$ch_member_dormancy_res == $error){
	error_historyBack("");
	exit;
}

$count_member_dormancy = mysql_result($ch_member_dormancy_res,0,0);

if($count_member_dormancy>0){
	
	$update_login_event = "UPDATE member_login_event SET login_date = now() WHERE hero_code='".$_SESSION['temp_code']."'";
	$update_login_event_res = new_sql($update_login_event,$error);
	if((string)$update_login_event_res==$error){
		error_historyBack("장기 미사용자 로그인 이벤트 오류입니다. 관리자에게 문의해주세요.");
		exit;
	}

	$insertPoint = "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
	$insertPoint .= "values ('".$_SESSION['temp_code']."','member', 'member', '0', '".$_SESSION['temp_id']."','장기미사용자 이벤트','장기미사용자 이벤트','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','100','".$full_today."','N','0','Y','".$full_today."')";

	$insertPoint_res = new_sql($insertPoint,$error);
	
	//100포인트 지급
	if((string)$insertPoint_res==$error){
		error_historyBack("장기 미사용자 로그인 이벤트 오류입니다. 관리자에게 문의해주세요.");
		exit;
	}
	//수퍼패스 지급
	$kind = "member_login_event";
	$full_today = date("Y-m-d H:i:s");
	$full_endday = date("Y-m-t 23:59:59", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
	
	$error = "LOGIN_CHECK_08";
	
	
	$superpass_check_sql = "select count(*) from superpass where hero_code='".$_SESSION['temp_code']."' and hero_kind='member_login_event'";
	$superpass_check_res = new_sql($superpass_check_sql,$error);
	
	if((string)$superpass_check_res == $error){
		error_historyBack("");
		exit;
	}
	$superpass_check_rs = mysql_result($superpass_check_res,0,0);

	if($superpass_check_rs==0){				
		$error = "LOGIN_CHECK_09";
		$superpass_sql = "insert into superpass (hero_code, hero_kind, hero_superpass, hero_today, hero_endday) values ('".$_SESSION['temp_code']."','".$kind."', 1, '".$full_today."', '".$full_endday."')";
			
		$superpass_res = new_sql($superpass_sql,$error);
		if((string)$superpass_res==$error){
			error_historyBack("");
			exit;
		}else{
			echo "<script>alert('슈퍼패스가 지급 되었습니다~');</script>";
		}		
	}
	
	echo "<script>setCookie('member_login_event_03','1',10);</script>";
}


######################################################################################################################################################
########      update        ###########################################################################################################################
if($temp_level_01 > $_SESSION['temp_level'] && $temp_level_01<9998 ){
	$sql = 'UPDATE member SET
			hero_level=\''.$temp_level_01.'\',
	        hero_write=\''.$temp_level_01.'\',
	        hero_view=\''.$temp_level_01.'\',
	        hero_update=\''.$temp_level_01.'\',
	        hero_rev=\''.$temp_level_01.'\',
	        hero_today=\''.$full_today.'\',
	        hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
	$pf = mysql_query($sql);
	
	if(!$pf){
		logging_error($list_top['hero_nick'], "logIn-LOGIN_04", $full_today);
	   	error_historyBack("");
	   	exit;
	}
	$_SESSION['temp_level'] = $temp_level_01;
	$_SESSION['temp_write'] = $temp_level_01;
	$_SESSION['temp_view'] = $temp_level_01;
	$_SESSION['temp_update'] = $temp_level_01;
	$_SESSION['temp_rev'] = $temp_level_01;
}else{
    $sql = 'UPDATE member SET hero_today=\''.$full_today.'\', hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
     /* 
     if($_SESSION['temp_level']>=9999){
     echo $sql;
     exit;
     }
      */
	$pf = mysql_query($sql);

	if(!$pf){
		logging_error($list_top['hero_nick'], "logIn-LOGIN_05", $full_today);
		error_historyBack("");
		exit;
	}
}
?>