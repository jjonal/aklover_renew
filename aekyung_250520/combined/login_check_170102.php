<?php 
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_level']>0)					error_location("�̹� �α��� �Ǿ����ϴ�.","/main/index.php");
if((!$hero_id || !$hero_pw) && (!$snsId || !$snsType) && (!$hero_id || !$hero_m_pw))	error_historyBack("�߸��� �����Դϴ�");
######################################################################################################################################################

$full_today = date("Y-m-d H:i:s");

$error = "LOGIN_CHECK_01";
if($hero_pw){
	/*
	
	$sql = "select hero_id from member where hero_id = '".$hero_id."'";
	$message = "��ġ�ϴ� ������ �����ϴ�";
	*/
	
	$id_sql = "select hero_id from member where hero_id = '".$hero_id."'";
	$id_out_sql = new_sql($id_sql,$error,"on");
	$id_count = mysql_num_rows($id_out_sql);
	
	if($id_count == 0) {
		//20161228 ������ ���� �޸�ȸ���� �α��� ���̵� �������� �ʾ� �������
		//error_location("���̵� Ȯ�����ּ���.",'/main/index.php?board=login');
		
		$sql = "select hero_id from member where hero_id = '".$hero_id."'";
		
		//20161229 ���Ʒ� ���� �޸�ȸ�� üũ
		$rest_sql = "select hero_id from member_backup where hero_id = '".$hero_id."'";
		$rest_out_sql = new_sql($rest_sql,$error,"on");
		$rest_out_sql = mysql_num_rows($rest_out_sql);
		if($rest_out_sql == 0) {//�޸����̺� ���̵� ������
			$message = "���̵� Ȯ�����ּ���.";
		}else { //������
			$message = "��й�ȣ�� Ȯ�����ּ���.";
		}
	}else {
		$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = md5('".$hero_pw."') and hero_use=0";
		$message = "��й�ȣ�� Ȯ�����ּ���.";
	}
	
//����� �ڵ� �α��� ������� �α��� �� ���
}elseif($hero_m_pw){
	$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = '".$hero_m_pw."' and hero_use=0";
	$message = "��ġ�ϴ� ������ �����ϴ�";
}else{
	$sql = "select * from member where hero_".$snsType." = md5('".$snsId."') and hero_use=0";
	$message = "�� ������ AKLOVER�� �����Ǿ����� �ʽ��ϴ�. �α��� �� ����������>���� �������� �����Ͻ� �� �ֽ��ϴ�.";
}

//md5�� ����� �Ʒ� ���� ���
//$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = md5('".$hero_pw."')";

$out_sql = new_sql($sql,$error,"on");

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}

$count = mysql_num_rows($out_sql);
if($count==0){
	//########### �޸����� üũ ##############
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
		$dir = getcwd(); // ���� ���丮���� ��ȯ�ϴ� PHP �Լ��̴�.
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
	//########## �޸����� üũ ##############	
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






######## �Ŵ� ó�� �α��νÿ� ������ ����Ʈ ����
if(substr($list_top['hero_today'],0,7) != date("Y-m")){
	$error = "EVENT_CHECK_01";	
	//������ �ľ� 
	$birth_sql = "select left(right(hero_jumin,4),2) from member where hero_code='".$_SESSION['temp_code']."' ";
	$birth_res = new_sql($birth_sql,$error);
	if((string)$birth_res==$error){
		error_historyBack("");
		exit;
	}

	$birth_day = mysql_result($birth_res,0,0);
	

	if($birth_day==date("m")){
		$error = "EVENT_CHECK_02";
		//���� ������ ���� ����Ʈ�� �ִ���?
		$event_sql = "select count(*) from point where hero_code='".$_SESSION['temp_code']."' and hero_type='birth' and left(hero_today,4)='".date("Y")."'";
		$event_res = new_sql($event_sql,$error);
		if((string)$event_res==$error){
			error_historyBack("");
			exit;
		}
		 
		$event_count = mysql_result($event_res,0,0);
				
		//���� ���� ����Ʈ�� ���� �� ���� ���.
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
			$member_total_point += $event_point;//ȸ�� ���� ������ ���� �� ���ϱ�
			$point_sql = "INSERT INTO point (hero_code, hero_id, hero_name, hero_today, hero_title, hero_top_title, hero_type,hero_point, point_change_chk ,hero_ori_today) 
			VALUES ('".$_SESSION['temp_code']."', '".$_SESSION['temp_id']."', '".$_SESSION['temp_name']."', now(), '������������Ʈ', '������������Ʈ', 'birth','".$event_point."','Y', now())";
			$point_res = new_sql($point_sql,$error);
			if((string)$point_res==$error){
				error_historyBack("");
				exit;
			}
			message("���� �����մϴ�.\\n���� ����Ʈ�� ���� �Ǿ����ϴ�.");
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
########      �Ŵ� ó�� �α��νÿ� �����н��� ����//�����н��� ó�������� ���                       ###########################################################################################################################
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
		
		//��α� ������ ��� + �湮�ڼ� 
		if($list_top['hero_memo']>2000 && $list_top['hero_memo_01']=='��')		$is_powerblog = "powerblog";

		//1���� �̳� ���� + ��α� ���� �� + 1���� �̳� ��(���) �ۼ� 1ȸ �̻�
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
* 161130 �ۼ�
* 9���� �̷α����� �̺�Ʈ (�Ͻ��̺�Ʈ)
* �Ʒ� if�� ���ǿ� ���� �̺�Ʈ�Ⱓ ��������(2016�� 12�� 5��~ 2016�� 12�� 22��)
* �̺�Ʈ�Ⱓ�� �°� 9month_event_mail.php �������� �޸�ȸ�� �������
* ���Ʒ�(hide305@naver.com)
**********************************************/
if(mktime(23, 59, 59, 12, 01, 2016) < time() && mktime(00, 00, 00, 12, 22, 2016) > time()) {
	$login_9month_event = "SELECT count(*) FROM member_login_event_9month WHERE hero_code='".$_SESSION['temp_code']."' AND login_date is null";
	$login_9month_event_res = new_sql($login_9month_event,$error);
	$login_9month_event_rs = mysql_result($login_9month_event_res,0,0);
	
	// 9���� �̺�Ʈ ���̺� �����Ͱ� ������ ���� ����
	if($login_9month_event_rs > 0) {
		$update_9month = "UPDATE member_login_event_9month SET login_date = now() WHERE hero_code='".$_SESSION['temp_code']."'";
		$update_9month_res = new_sql($update_9month,$error);
		if((string)$update_9month_res==$error){
			error_historyBack("9�����̻� �̷α��� �����Դϴ�. �����ڿ��� �������ּ���.");
			exit;
		}
		
		$insertPoint_9month = "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
		$insertPoint_9month .= "values ('".$_SESSION['temp_code']."','member', 'member', '0', '".$_SESSION['temp_id']."','9���� �̻���� �̺�Ʈ','9���� �̻���� �̺�Ʈ','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','100','".$full_today."','N','0','Y','".$full_today."')";
		
		$insertPoint_9month_res = new_sql($insertPoint_9month,$error);
		//100����Ʈ ����
		if((string)$insertPoint_9month_res==$error){
			error_historyBack("9�����̻� �̷α��� �̺�Ʈ �����Դϴ�. �����ڿ��� �������ּ���.");
			exit;
		}
		
		echo "<script>alert('9���� �̻� �̻���� �̺�Ʈ 100����Ʈ�� ���޵Ǿ����ϴ�');</script>";
	
	}
}
######################################################################################################################################################
########      �޸���� �̺�Ʈ        ###########################################################################################################################


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
		error_historyBack("��� �̻���� �α��� �̺�Ʈ �����Դϴ�. �����ڿ��� �������ּ���.");
		exit;
	}

	$insertPoint = "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
	$insertPoint .= "values ('".$_SESSION['temp_code']."','member', 'member', '0', '".$_SESSION['temp_id']."','���̻���� �̺�Ʈ','���̻���� �̺�Ʈ','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','100','".$full_today."','N','0','Y','".$full_today."')";

	$insertPoint_res = new_sql($insertPoint,$error);
	
	//100����Ʈ ����
	if((string)$insertPoint_res==$error){
		error_historyBack("��� �̻���� �α��� �̺�Ʈ �����Դϴ�. �����ڿ��� �������ּ���.");
		exit;
	}
	//�����н� ����
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
			echo "<script>alert('�����н��� ���� �Ǿ����ϴ�~');</script>";
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