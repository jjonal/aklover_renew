<?
if(!defined('_HEROBOARD_'))exit;
include_once '../freebest/function.php';

if($_SESSION['temp_level'] > 0) error_location("�̹� �α��� �Ǿ����ϴ�.","/main/index.php");
if((!$hero_id || !$hero_pw) && (!$snsId || !$snsType) && (!$hero_id || !$hero_m_pw))	error_historyBack("�߸��� �����Դϴ�");


$full_today = date("Y-m-d H:i:s");
$first_login_check = false;

$error = "LOGIN_CHECK_01";
if($hero_pw && (!$snsId && !$snsType)){ //��й�ȣ�� �α���

	$id_sql = " SELECT hero_id FROM member where hero_use = 0 AND hero_id = '".$hero_id."' ";
	$id_out_sql = new_sql($id_sql,$error,"on");
	$id_count = mysql_num_rows($id_out_sql);

	if($id_count == 0) {//�޸�ȸ�� üũ
		$sql = " SELECT hero_id FROM member WHERE hero_use = 0 AND hero_id = '".$hero_id."'";

		$rest_sql = " SELECT hero_id FROM member_backup WHERE hero_id = '".$hero_id."' ";
		$rest_out_sql = new_sql($rest_sql,$error,"on");
		$rest_out_sql = mysql_num_rows($rest_out_sql);
		if($rest_out_sql == 0) {//�޸����̺� ���̵� ������
			$message = "���̵� Ȯ�����ּ���.";
		}else { //������
			$message = "��й�ȣ�� Ȯ�����ּ���.";
		}
	}else {
	    $pw_md5 = md5($hero_pw);
	    $temp = $pw_md5.$hero_id;
	    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
        
	    $sql = " SELECT * FROM member WHERE hero_id = '".$hero_id."' AND hero_pw = '".$pw_sha3_256."' AND hero_use=0 ";
        $message = "��й�ȣ�� Ȯ�����ּ���.";
	}
} else if($hero_m_pw){ //����� �ڵ� �α��� ������� �α��� �� ���
	$sql = "select * from member where hero_id = '".$hero_id."' and hero_pw = '".$hero_m_pw."' and hero_use=0";
	$message = "��ġ�ϴ� ������ �����ϴ�";
}else{ //SNS�� �α���
	$sql = "select * from member where hero_".$snsType." = md5('".$snsId."') and hero_use=0";
	$message = "�� ������ AK Lover�� �����Ǿ����� �ʽ��ϴ�. �α��� �� ����������>���� �������� �����Ͻ� �� �ֽ��ϴ�.";
}

$out_sql = new_sql($sql,$error,"on");

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}

$count = mysql_num_rows($out_sql);

if($count==0){
	//########### �޸����� üũ ##############
	if($hero_pw || $hero_m_pw){
	    $pw_md5 = md5($hero_pw);
	    $temp = $pw_md5.$hero_id;
	    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
	    
	    $sql1 = "select hero_code from member_backup where hero_id = '".$hero_id."' and hero_pw = '".$pw_sha3_256."'";
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
		
		//�α��� ���� �ð� ���
		$sql100 = "select hero_code from member where hero_id = '".$hero_id."'";
		$code_res = sql($sql100,"on");
		$code_view = mysql_fetch_assoc($code_res);
		
		if($_GET['board']=='login_check') {
		    //�α��� ���� �ð� ���
		    $sql_log = " INSERT INTO member_login (hero_code, hero_yn, hero_channel, hero_today) values ('".$code_view['hero_code']."', 'F', 'P', now()) ";
		    mysql_query($sql_log);
		    error_location($message,'/main/index.php?board=login&focus=pw');
		} else {
		    //�α��� ���� �ð� ���
		    $sql_log = " INSERT INTO member_login (hero_code, hero_yn, hero_channel, hero_today) values ('".$code_view['hero_code']."', 'F', 'M', now()) ";
		    mysql_query($sql_log);
		    error_location($message,'/m');
		}
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
		if(strpos($dir,":")) {
			$temp = explode("\\", $dir);
		} else {
			$temp = explode("/", $dir);
		}
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
$_SESSION["temp_loginTime"] =    date("YmdHis");

//�۷ι� ����
if($_SESSION['temp_level'] == "9999") {
	$_SESSION["global_code"] = $list_top['hero_code'];
	$_SESSION["global_admin_yn"] = "Y";
}

//(s) ù �α��� ����Ʈ ���� 190607 �߰�
if($list_top["hero_code"]) {
	$join_date = date("Ymd",strtotime($list_top["hero_oldday"]));

	if($join_date >= 20190618) { //20190618

		$firstLoginSql = " SELECT count(*) loginCnt FROM member_login WHERE hero_code = '".$list_top["hero_code"]."' ";

		$firstLogin_res 	= new_sql($firstLoginSql,$error);
		if((string)$event_res==$error){
			error_historyBack("");
			exit;
		}
		$firstLogin_cnt = mysql_result($firstLogin_res,0,0);

		if($firstLogin_cnt == 0) {
			pointAdd("member","firstLogin","","","","ù�α���","N");
			$first_login_check = true;
		}
	}
}//(e) ù �α���

$error = "LOGIN_CHECK_02";
//musign ���� null�� 447L���� ISNULL �߰�
$member_total_sql = "select IFNULL(SUM(hero_point),0) as member_total from point where hero_code='".$_SESSION['temp_code']."'";
$member_total_res = new_sql($member_total_sql,$error);
if((string)$member_total_res==$error){
	error_historyBack("");
	exit;
}

$member_total_point = mysql_result($member_total_res,0,0);

/*
 * �Ŵ� ù �α��ν� ���� ����Ʈ ���� ���� 
 */
if( substr($list_top['hero_today'],0,7) != date("Y-m") ) {
	$birth_day	= substr($list_top['hero_jumin'],4,2);

	if( $birth_day == date("m") ) {
		//���� ������ ���� ����Ʈ�� �ִ��� Ȯ��
		$error 		= "EVENT_CHECK_02";
		$event_sql 	= "SELECT COUNT(*) FROM point WHERE hero_code='".$_SESSION['temp_code']."' AND hero_type='birth' AND LEFT(hero_today,4)='".date("Y")."'";
		$event_res 	= new_sql($event_sql,$error);
		if((string)$event_res==$error){
			error_historyBack("");
			exit;
		}
		$event_count = mysql_result($event_res,0,0);
				
		//���� ���� ����Ʈ�� ���� �� ���� ���.
		if( $event_count == 0 ) {
			$error 				= "EVENT_CHECK_03";
			$event_point_sql 	= "SELECT hero_point FROM today WHERE hero_type='hero_event'";
			$event_point_res 	= new_sql($event_point_sql,$error);
			if((string)$event_point_res==$error){
				error_historyBack("");
				exit;
			}
			$event_point 		= mysql_result($event_point_res,0,0);
			$member_total_point += $event_point;//ȸ�� ���� ������ ���� �� ���ϱ�
			
			$error 		= "EVENT_CHECK_04";
			$point_sql 	= "INSERT INTO point (hero_code, hero_id, hero_name, hero_nick, hero_today, hero_title, hero_top_title, hero_type,hero_point, point_change_chk ,hero_ori_today) 
			VALUES ('".$_SESSION['temp_code']."', '".$_SESSION['temp_id']."', '".$_SESSION['temp_name']."', '".$_SESSION['temp_nick']."', now(), '������������Ʈ', '������������Ʈ', 'birth','".$event_point."','Y', now())";
			$point_res 	= new_sql($point_sql,$error);
			if((string)$point_res==$error){
				error_historyBack("");
				exit;
			}
			message("ȸ������ ������ �������� ���ϵ帳�ϴ�.\\n���� ����Ʈ�� ���� �Ǿ����ϴ�.");
		}	
	}	
}

/**********************************
22-05-12
�����н� ����
1. �Ŵ� ó�� �α����� �� ���� ����
2. �α��� ������ 3���� ������ �г�Ƽ�� ����� ��
3. �α��� ������ �Ѵ� ���� �α����� ����� �־���� + (��α�+���� url ����) + (�Ѵ������� ����� �� �Ǵ� ��� ����)
1,2,3 ���� ���� �� ����
***********************************/

#�Ŵ� ó�� �α��νÿ� �����н��� ����//�����н��� ó�������� ���      
if(substr($list_top['hero_today'],0,7) != date("Y-m")){
	$threeMonthAgo = date("Y-m-d",strtotime("-3 month"));
	$oneMonthAgo = date("Y-m-d",strtotime("-1 month"));
	
	$panelty_check = "Y";
	$login_a_month_ago_check = "Y";
	$blog_check = "Y";
	$write_check = "Y";
	$superpass_check = "Y";
    
	$error = "LOGIN_CHECK_04";
	//$panelty_sql = "select count(*) from point where hero_code='".$_SESSION['temp_code']."' and hero_point<0 and (hero_type='' or hero_type='togetherPoint' or hero_type='personPoint')  and (hero_table='' or hero_table='user') and hero_today>='".$threeMonthAgo."'";
	$panelty_sql = " SELECT count(*) FROM member_penalty WHERE hero_code='".$_SESSION['temp_code']."' AND hero_use_yn ='Y' and hero_today>='".$threeMonthAgo."' ";
	
	$panelty_res = new_sql($panelty_sql,$error);
	if((string)$panelty_res==$error){
		error_historyBack("");
		exit;
	}
	
	$panelty_count = mysql_result($panelty_res,0,0);
	
	if($panelty_count > 0) $panelty_check = "N";
	
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
	
	if($list_top['hero_today'] < $oneMonthAgo) $login_a_month_ago_check = "N";
		
	if(!$list_top['hero_blog_00'] && !$list_top['hero_blog_04'] && !$list_top['hero_blog_05'] && !$list_top['hero_blog_03'] && !$list_top['hero_blog_06'] && !$list_top['hero_blog_07'] && !$list_top['hero_blog_08']) {
		$blog_check = "N";
	}
	
	if($vip_check_rs['vip_board_count'] == 0 && $vip_check_rs['vip_review_count'] == 0) $write_check = "N";
	
	if($panelty_check == "Y" && $login_a_month_ago_check == "Y" && $blog_check == "Y" && $write_check == "Y"){
		
		$kind = ":vip";
		 
		$error = "LOGIN_CHECK_06";
		$superpass_sql = "insert into superpass (hero_code, hero_kind, hero_superpass, hero_today, hero_endday) values ('".$_SESSION['temp_code']."','".$kind."', 1, '".$full_today."','".date("Y-m-t 23:59:59")."')";

		$superpass_res = new_sql($superpass_sql,$error);
		if((string)$superpass_res==$error){
			error_historyBack("");
			exit;
		}
	} else {
		$superpass_check = "N";
	}
	
	$superpass_history_sql  = " INSERT INTO superpass_history (hero_code, panelty_check, login_a_month_ago_check, blog_check, write_check, superpass_check, hero_today) values ";
	$superpass_history_sql .= " ('".$_SESSION['temp_code']."','".$panelty_check."','".$login_a_month_ago_check."','".$blog_check."','".$write_check."','".$superpass_check."',now())";
	
	$superpass_history_res = new_sql($superpass_history_sql,$error);
}

$error = "LOGIN_CHECK_07";

/*********************************************
* 161130 �ۼ�
* 9���� �̷α����� �̺�Ʈ (�Ͻ��̺�Ʈ)
* �Ʒ� if�� ���ǿ� ���� �̺�Ʈ�Ⱓ ��������(2016�� 12�� 5��~ 2016�� 12�� 22��)
* �̺�Ʈ�Ⱓ�� �°� 9month_event_mail.php �������� �޸�ȸ�� �������
* ���Ʒ�(hide305@naver.com)
*
* 170102 ����
* �ſ� 5�� ~ ���� ����ǵ��� �����̺�Ʈ�� ����
**********************************************/
$yy = date("Y");
$mm = date("m");
$dd = date("d");
$end_day = date("t", mktime(0, 0, 0, $mm, 1, $yy));

//�ſ� 5�� ~ ���� ����ǵ���
if(mktime(00, 00, 00, $mm, 05, $yy) < time() && mktime(23, 59, 59, $mm, $end_day, $yy) > time()) {
	$login_9month_event = "SELECT count(*) as cnt, in_date, idx FROM member_login_event_9month 
	                       WHERE hero_code='".$_SESSION['temp_code']."' AND login_date is null
						   AND date_format(in_date, '%Y-%m') = date_format(now(), '%Y-%m')";
						   
	$login_9month_event_res = new_sql($login_9month_event,$error,"on");
	$login_9month_event_rs  = @mysql_fetch_assoc($login_9month_event_res);
	
	// 9���� �̺�Ʈ ���̺� �����Ͱ� ������ ���� ����
	if($login_9month_event_rs['cnt'] > 0) {
		$update_9month = "UPDATE member_login_event_9month SET login_date = now() WHERE idx='".$login_9month_event_rs['idx']."' AND date_format(in_date, '%Y-%m') = date_format(now(), '%Y-%m')";
		$update_9month_res = new_sql($update_9month,$error);
		if((string)$update_9month_res==$error){
			error_historyBack("9�����̻� �̷α��� �����Դϴ�. �����ڿ��� �������ּ���.");
			exit;
		}
		
		$insertPoint_9month = "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
		$insertPoint_9month .= "values ('".$_SESSION['temp_code']."','member', 'member', '0', '".$_SESSION['temp_id']."','9���� �̻���� �̺�Ʈ','9���� �̻���� �̺�Ʈ','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','100','".$full_today."','N','0','Y','".$full_today."')";
		
		//100����Ʈ ����
		$insertPoint_9month_res = new_sql($insertPoint_9month,$error);
		if((string)$insertPoint_9month_res==$error){
			error_historyBack("9�����̻� �̷α��� �̺�Ʈ �����Դϴ�. �����ڿ��� �������ּ���.");
			exit;
		}
		
		echo "<script>alert('9���� �̻� �̻���� �̺�Ʈ 100����Ʈ�� ���޵Ǿ����ϴ�.');</script>";
	}
}
######################################################################################################################################################
########      �޸���� �̺�Ʈ        ###########################################################################################################################
$seventeenDaysAgo = date("Y-m-d", strtotime("-17 day"));
$error = "LOGIN_CHECK_07";
//170104 ��ü������ ��������
// 1. ���ϼ������� 1�����̳����� ����
// 2. �޸�ȸ�� �ߺ� ����(�ѹ�Ǯ�� �� �޸������)
$ch_member_dormancy = "select count(*) from member_login_event where hero_code='".$_SESSION['temp_code']."' and login_date is null and hero_today >= date(subdate(now(), interval 1 month))";
$ch_member_dormancy_res = new_sql($ch_member_dormancy,$error);
if((string)$ch_member_dormancy_res == $error){
	error_historyBack("");
	exit;
}

$count_member_dormancy = mysql_result($ch_member_dormancy_res,0,0);

if($count_member_dormancy>0){
	
	$update_login_event = "UPDATE member_login_event SET login_date = now() WHERE hero_code='".$_SESSION['temp_code']."' and hero_today >= date(subdate(now(), interval 1 month))";
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
	
	$error = "LOGIN_CHECK_09";
	$superpass_sql = "insert into superpass (hero_code, hero_kind, hero_superpass, hero_today, hero_endday) values ('".$_SESSION['temp_code']."','".$kind."', 1, '".$full_today."', '".$full_endday."')";
		
	$superpass_res = new_sql($superpass_sql,$error);
	if((string)$superpass_res==$error){
		error_historyBack("");
		exit;
	}else{
		echo "<script>alert('�����н��� ���� �Ǿ����ϴ�~');</script>";
	}		

	echo "<script>setCookie('member_login_event_03','1',10);</script>";
}

//�̺�Ʈ 10�ֳ� 500����Ʈ ����
if(date("Ymd") >= date("Ymd",strtotime($list_top["hero_oldday"]." +10years"))) {
	$member_event_join_10year_check_sql = " SELECT count(*) FROM member_event_join_10year WHERE hero_code = '".$list_top["hero_code"]."' ";
	$join_10year_res = new_sql($member_event_join_10year_check_sql);
	
	$count_join_10year = mysql_result($join_10year_res,0,0);
	
	if($count_join_10year == 0) {//����Ʈ ����
		$ins_10year = " insert into member_event_join_10year (hero_code, hero_today) values ('".$list_top["hero_code"]."',now()) ";
		mysql_query($ins_10year);
		
		$insert10yearPoint = "insert into point (hero_code, hero_table, hero_type, hero_old_idx, hero_id ";
		$insert10yearPoint .= " , hero_top_title, hero_title, hero_name, hero_nick, hero_point ";
		$insert10yearPoint .= " , hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
		$insert10yearPoint .= " values ('".$_SESSION['temp_code']."','member', 'member', '0', '".$_SESSION['temp_id']."' ";
		$insert10yearPoint .= " ,'10�ֳ�ȸ�� �̺�Ʈ','10�ֳ�ȸ�� �̺�Ʈ','".$_SESSION['temp_name']."','".$_SESSION['temp_nick']."','500' ";
		$insert10yearPoint .= " ,'".$full_today."','N','0','Y','".$full_today."')";
		
		mysql_query($insert10yearPoint);
		
		echo "<script>alert('10�ֳ� ȸ�� 500����Ʈ�� ���޵Ǿ����ϴ�.');</script>";
	}
}

$sql = 'UPDATE member SET hero_today=\''.$full_today.'\', hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
$pf = mysql_query($sql);

if(!$pf){
	logging_error($list_top['hero_nick'], "logIn-LOGIN_05", $full_today);
	error_historyBack("");
	exit;
}

//�α��� �ð� ���
$channel = "P";
if($_GET['board']=='login_check') {
    $channel = "P";
} else {
    $channel = "M";
}
$sql_log = " INSERT INTO member_login (hero_code, hero_yn, hero_channel, hero_today) values ('".$_SESSION['temp_code']."','S', '".$channel."', now()) ";
mysql_query($sql_log);

?>