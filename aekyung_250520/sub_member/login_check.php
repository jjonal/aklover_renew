<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

$full_today = date("Y-m-d H:i:s");
$hero_id = $_POST['hero_id'];
$hero_pw = $_POST['hero_pw'];
$snsType = $_POST['snsType'];
$snsId = $_POST['snsId'];

	if($hero_id=='test'){

		/* $select  = "select * from (select hero_code, hero_address_02, hero_oldday from member where hero_use=0 and left(hero_oldday,10)>='2015-08-24' and left(hero_oldday,10)<='2015-09-05' and hero_info_ci!='' and (hero_job_01!='Y' or hero_job_01 is null)) as A inner join (select * from mission_review where hero_code!='' and hero_code is not null and hero_old_idx!=437 group by hero_code) as B on A.hero_code=B.hero_code";
		$select_res = mysql_query($select) or die(mysql_error());
		while ($select_rs = mysql_fetch_assoc($select_res)){
			if($select_rs['hero_code']){
				$addr_update = "update member set hero_job_01='Y', hero_address_01='".$select_rs['hero_address_01']."', hero_address_02='".$select_rs['hero_address_02']."', hero_address_03='".$select_rs['hero_address_03']."' where hero_idx='".$select_rs['hero_code']."';";
				echo $addr_update."<br/>";
			}
		}
		exit;	 */
		/* $select_sql = "SELECT A.hero_code, B.hero_id, B.hero_name, B.hero_nick FROM (SELECT COUNT( * ) AS count, hero_code FROM point WHERE LEFT( hero_today, 10 ) > '2015-07-31' and LEFT( hero_today, 10 ) < '2015-08-24' AND hero_top_title =  '�⼮üũ' GROUP BY hero_code) AS A inner join member as B on A.hero_code=B.hero_code WHERE count >0 ";
			$select_res = mysql_query($select_sql) or die(mysql_error());
			while ($select_rs = mysql_fetch_assoc($select_res)){
			$code = $select_rs['hero_code'];

			$ch_point_sql = "select count(*) as count from point where hero_code='".$code."' and left(hero_today,10)='2015-08-24' and hero_type='attendance'";
			$ch_point_res = mysql_query($ch_point_sql) or die(mysql_error());
			$ch_point_rs = mysql_result($ch_point_res,0,0);

			if($ch_point_rs==0){
			//echo $ch_point_sql."<br/>";
			$sum_sql = "select ifnull(sum(hero_today),0) from point where hero_code='".$code."' and left(hero_today,10)='2015-08-24'";
			$sum_res = mysql_query($sum_sql) or die(mysql_error());
			$sum_rs = mysql_result($sum_res,0,0);
			if($sum_rs>29){
			$insert_point = 0;
			}else{
			$insert_point = 1;
			}

			$sql_one_write = "hero_old_idx, hero_mission_idx, hero_review_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint";
			$sql_two_write = "'0','0','0','".$code."','group_04_04','attendance', '".$select_rs['hero_id']."', '�⼮üũ', '�⼮üũ', '".$select_rs['hero_name']."', '".$select_rs['hero_nick']."', '".$insert_point."', '2015-08-24','Y'";

			$sql = "INSERT INTO point (".$sql_one_write.") VALUES (".$sql_two_write.");";
			echo $sql."<br/>";
			}
			}
			exit; */
	}

	if($hero_id=='test'){

		/* $select_sql = "SELECT A.hero_code, B.hero_id, B.hero_name, B.hero_nick FROM (SELECT COUNT( * ) AS count, hero_code FROM point WHERE LEFT( hero_today, 10 ) > '2015-07-31' and LEFT( hero_today, 10 ) < '2015-08-24' AND hero_top_title =  '�⼮üũ' GROUP BY hero_code) AS A inner join member as B on A.hero_code=B.hero_code WHERE count >0 ";
		$select_res = mysql_query($select_sql) or die(mysql_error());
		while ($select_rs = mysql_fetch_assoc($select_res)){
			$code = $select_rs['hero_code'];

			$ch_point_sql = "select count(*) as count from point where hero_code='".$code."' and left(hero_today,10)='2015-08-24' and hero_type='attendance'";
			$ch_point_res = mysql_query($ch_point_sql) or die(mysql_error());
			$ch_point_rs = mysql_result($ch_point_res,0,0);

			if($ch_point_rs==0){
				//echo $ch_point_sql."<br/>";
				$sum_sql = "select ifnull(sum(hero_today),0) from point where hero_code='".$code."' and left(hero_today,10)='2015-08-24'";
				$sum_res = mysql_query($sum_sql) or die(mysql_error());
				$sum_rs = mysql_result($sum_res,0,0);
				if($sum_rs>29){
					$insert_point = 0;
				}else{
					$insert_point = 1;
				}

				$sql_one_write = "hero_old_idx, hero_mission_idx, hero_review_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint";
				$sql_two_write = "'0','0','0','".$code."','group_04_04','attendance', '".$select_rs['hero_id']."', '�⼮üũ', '�⼮üũ', '".$select_rs['hero_name']."', '".$select_rs['hero_nick']."', '".$insert_point."', '2015-08-24','Y'";

				$sql = "INSERT INTO point (".$sql_one_write.") VALUES (".$sql_two_write.");";
				echo $sql."<br/>";
			}
		}
		exit; */
	}

include_once $_SERVER['DOCUMENT_ROOT'].'/combined/login_check.php';

    ######################################################################################################################################################
    ########      id���� ��ư Ŭ��  ---> ��Ű����                        ###########################################################################################################################
    $chk_id_cookie = $_POST['chk_id_cookie'];

    if($chk_id_cookie=="true"){
    	//�Ѵް� ���̵� ����
    	setcookie("cookie_hero_id",$_POST["hero_id"],time()+(29*24*60*60));
    }else{
    	//üũ�� ������ ����
    	setcookie("cookie_hero_id","",time()+(30*24*60*60));
    }
    
    
    if($_SESSION["temp_id"]=="test"){
    	/* 
    	$select_sql = "select A.hero_code, A.count_review, B.hero_id, B.hero_name, B.hero_nick from (select count(*) as count_review, hero_code from review where hero_today>='2015-08-21 16:18:44' and hero_today<'2015-08-21 23:59:59' group by hero_code) as A inner join member as B on A.hero_code= B.hero_code";
    	$select_res = mysql_query($select_sql) or die(mysql_error());
    
    	while ($select_rs = mysql_fetch_assoc($select_res)){
    		$code = $select_rs['hero_code'];
    		$id = $select_rs['hero_id'];
    		$name = $select_rs['hero_name'];
    		$nick = $select_rs['hero_nick'];
    		$count_review = $select_rs['count_review'];
    
    		$point_sql = "select sum(hero_point) from point where hero_code='".$code."' and left(hero_today,10)='2015-08-21'";
    		$point_res = mysql_query($point_sql) or die(mysql_error());
    		$sum_point = mysql_result($point_res,0,0);
    
    		if($sum_point<30){
    			//echo $count_review."<br/>";
    			if(($sum_point+$count_review)<=30){
    				$insert_point = $count_review;
    			}else{
    				$insert_point = 30-$sum_point;
    			}
    				
    			$sql_one_write = "hero_old_idx, hero_mission_idx, hero_review_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint";
    			$sql_two_write = "'0','0','0','".$code."','admin','admin', '".$id."', '�������Ʈ', '8��21�� �����������Ʈ', '".$name."', '".$nick."', '".$insert_point."', '2015-08-21','Y'";
    				
    			$sql = "INSERT INTO point (".$sql_one_write.") VALUES (".$sql_two_write.");";
    			echo $sql."<br/>";
    		}
    
    	}
    	exit;
 */
    }
    
    
    
    if($_SESSION["temp_id"]=="test"){
    	/*
    	 //������ �г��� ����
    	 $select_deleted_data = "select hero_idx from member where hero_code= '' and hero_use=1";
    	 $del_res = mysql_query($select_deleted_data);
    	 $del_arr = array();
    	 while ($del_rs = mysql_fetch_assoc($del_res)) {
    	 array_push($del_arr,$del_rs["hero_idx"]);
    	 }
    	  
    	 $select = "select hero_code, hero_nick from board group by hero_code ";
    	 $res = mysql_query($select);
    	  
    	 $i=0;
    	 while ($rs = mysql_fetch_assoc($res)) {
    	 $member_sql = "select count(*) from member where hero_code= '".$rs['hero_code']."'";
    	 $member_res = mysql_query($member_sql);
    	 $count = mysql_result($member_res,0,0);
    
    	 if($count==0){
    	 $nick = $rs["hero_nick"];
    	 $update_member = "update member set hero_nick='".$nick."' where hero_idx='".$del_arr[$i]."';<br/>";
    	 $i++;
    	 echo $update_member;
    	 mysql_query($update_review);
    	 }
    	 }
    	 exit;
    	 */
    	/*
    		//������ ������ ���� ����
    		$select = "select hero_code from board group by hero_code ";
    		$select .= "union ";
    		$select .= "select hero_code from review group by hero_code ";
    		$res = mysql_query($select);
    		 
    		while ($rs = mysql_fetch_assoc($res)) {
    		 
    		$member_sql = "select count(*) from member where hero_code= '".$rs['hero_code']."' and hero_use!=1";
    		$member_res = mysql_query($member_sql);
    		$count = mysql_result($member_res,0,0);
    		if($count==0){
    		$update_board = "update board set hero_name='', hero_ip='' where hero_code='".$rs["hero_code"]."';";
    		$update_review = "update review set hero_name='' where hero_code='".$rs["hero_code"]."';";
    		 
    		$mission_review_update = "update mission_review set hero_name='', hero_new_name='', hero_hp_01='', hero_hp_02='', hero_hp_03='', hero_ip='', hero_address_01='', hero_address_02='', hero_address_03='', hero_01='', hero_02='', hero_03='', hero_use=1 where hero_code='".$rs["hero_code"]."';";
    		 
    		$cookie_info_del = "delete from cookie_info where hero_code='".$rs["hero_code"]."';";
    		$member_question_del = "delete from member_question where hero_code='".$rs["hero_code"]."';";
    		$point_del = "delete from point where hero_code='".$rs["hero_code"]."';";
    		 
    		echo $update_board."<br/>";
    		echo $update_review."<br/>";
    		echo $mission_review_update."<br/>";
    		echo $cookie_info_del."<br/>";
    		echo $member_question_del."<br/>";
    		echo $point_del."<br/>";
    		}
    		 
    		}
    		exit;
    		*/
    	/*
    	 //Ż���� ������ ����
    	 $select = "select hero_idx, hero_code, hero_nick, hero_out, hero_out_date from member where hero_use =1 ";
    	 $res = mysql_query($select);
    	 while ($rs = mysql_fetch_assoc($res)) {
    	 if($rs["hero_code"]){
    	 $board_update = "update board set hero_name='', hero_ip='' where hero_code='".$rs["hero_code"]."';";
    	 $review_update = "update review set hero_name='' where hero_code='".$rs["hero_code"]."';";
    	 $mission_review_update = "update mission_review set hero_name='', hero_new_name='', hero_hp_01='', hero_hp_02='', hero_hp_03='', hero_ip='', hero_address_01='', hero_address_02='', hero_address_03='', hero_01='', hero_02='', hero_03='', hero_use=1 where hero_code='".$rs["hero_code"]."';";
    	  
    	 $cookie_info_del = "delete from cookie_info where hero_code='".$rs["hero_code"]."';";
    	 $member_question_del = "delete from member_question where hero_code='".$rs["hero_code"]."';";
    	 $point_del = "delete from point where hero_code='".$rs["hero_code"]."';";
    	  
    	 $insert_member = "insert into member (hero_code, hero_nick, hero_use, hero_out, hero_out_date) values ('".$rs['hero_code']."','".$rs['hero_nick']."','1','".$rs["hero_out"]."',".$rs["hero_out_date"].");";
    	 $del_member = "delete from member where hero_idx='".$rs['hero_idx']."';";
    	  
    	 echo $board_update."<br/>";
    	 echo $review_update."<br/>";
    	 echo $mission_review_update."<br/>";
    	 echo $cookie_info_del."<br/>";
    	 echo $member_question_del."<br/>";
    	 echo $point_del."<br/>";
    	 echo $insert_member."<br/>";
    	 echo $del_member."<br/>";
    	 }
    	 }
    	 exit;
    */
    	/*
    	 //md5�� ����
    	 $select_member = "select hero_code, hero_pw from member where hero_use=0 and hero_code is not null and hero_code!='' and hero_use=0";
    	 $select_res = mysql_query($select_member);
    		while ($rs = mysql_fetch_assoc($select_res)){
    		$pw = $rs['hero_pw'];
    		$code = $rs['hero_code'];
    			
    		if($pw && $code){
    		$update_member = "update member set hero_pw=md5('".$pw."') where hero_code='".$code."'";
    		mysql_query($update_member) or mysql_error();
    		echo $update_member.";<br/>";
    		}
    		}
    		exit;
    		*/
       
   }
    
    include_once $_SERVER['DOCUMENT_ROOT'].'/combined/chLastUpdatedPw.php';
    
    $goingToHome = array("board=result","board=login_check","board=login","board=idcheck","board=signup");

	// musign 07.16 ù �α��ν� �������� ��ó�� ȸ��(sns)�� �������� �������� �̵� ó�� ���� �߰�
	$member_sql = " SELECT hero_info_ci FROM member WHERE hero_use = 0  AND hero_code = '".$_SESSION["temp_code"]."' ";
	$member_res = sql($member_sql);
	$member_rs = mysql_fetch_assoc($member_res);

	if($first_login_check && !$member_rs["hero_info_ci"]) { // ù�α��� & �������� ��Ȯ�� ȸ��
		message("AK LOVER Ȩ������ ù �α����� ȯ���մϴ�.\\nü��� ��ǰ ��ۺ� ��ü�� �� �ִ� ����Ʈ ".$_DELIVERY_POINT."���� �����ص�Ƚ��ϴ�.");
		echo "<script>alert('AK Lover�� ������ �������� Ȱ���� ���� \\nSNS ���� �� �α��� ��, \\n���� 1ȸ ����Ȯ���� �ʿ��մϴ�.');</script>";
		echo "<script>location.href='/main/index.php?board=auth&returnUrl=y';</script>";
	} else if($first_login_check) {
    	message("AK Lover Ȩ������ ù �α����� ȯ���մϴ�.\\nü��� ��ǰ ��ۺ� ��ü�� �� �ִ� ����Ʈ ".$_DELIVERY_POINT."���� �����ص�Ƚ��ϴ�.");
    	location(DOMAIN."/main/index.php?board=mypoint");
    	exit;
    }

	if(!$member_rs["hero_info_ci"]) { // �������� ��Ȯ�� ȸ��
		echo "<script>alert('AK Lover�� ������ �������� Ȱ���� ���� \\nSNS ���� �� �α��� ��, \\n���� 1ȸ ����Ȯ���� �ʿ��մϴ�.');</script>";
		echo "<script>location.href='/main/index.php?board=auth&returnUrl=y';</script>";
	}

    if($_POST['referer'] && substr_in_array($_POST['referer'], $goingToHome)==false){
    	if(strpos($_POST['referer'],"/main/out.php")) {
			location(DOMAIN_HOME);
		}else {
			if($snsId && $snsType) {
				location(DOMAIN_HOME);
			} else {
				location($_POST['referer']);
			}
		}
    }else{
    	location(DOMAIN_HOME);
    }

    exit;
?>

