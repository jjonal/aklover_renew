<?php 
/*
$error = "MEMBER_QUESTION_01";
$question_sql = "select * from member_question where hero_idx='".$_POST['question_idx']."'";
$question_res = new_sql($question_sql,$error);
if((string)$question_res==$error){
	error_historyBack("");
	exit;
}
$question_rs = mysql_fetch_assoc($question_res);

if($question_rs['hero_idx']){

	$code 				= 	$_SESSION['temp_code'];
	$num_qestion 		=	mysql_num_fields($question_res)-6;
	
	//�߰��Է»��� ����Ʈ �޾Ҵ��� ���� + ���ݱ��� ���� ����Ʈ
	$error = "MEMBER_QUESTION_02";
	$point_sql = "select * from (select sum(hero_point) from point where hero_code='".$code."') as A left outer join ";
	$point_sql .= "(select count(*) from point where hero_title like 'ȸ�������߰��Է�' and hero_code='".$code."' and hero_old_idx='".$question_rs['hero_pid']."') as A on 1=1";
	//echo $point_sql."<br/>";
	$point_res = new_sql($point_sql,$error);
	if((string)$point_res==$error){
		error_historyBack("");
		exit;
	}

	$total_point = mysql_result($point_res,0,0);
	$getAddPoint = mysql_result($point_res,0,1);
	
	//�߰� �Է»��� ����Ʈ ���� ���� �ִ��� Ȯ��
	if($getAddPoint==0){
	
		$question_idx = $_POST['question_idx'];
		
		//�߰��Է»��� üũ
		$total_point .= $question_rs['hero_gift_point'];
			
		$point_insert_one = 'hero_old_idx, hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today ';
		$point_insert_two = '\''.$question_rs['hero_idx'].'\',\''.$hero_code.'\', \''.$_GET['board'].'\', \''.$user_list['hero_id'].'\', \'ȸ�������߰��Է�\', \'���⼮����\', \''.$user_list['hero_name'].'\', \''.$user_list['hero_nick'].'\', \''.$question_rs['hero_gift_point'].'\', \''.$hero_today.'\'';
		//point ���̺�
		$error = "MEMBER_QUESTION_03";
		$sql = 'INSERT INTO point ('.$point_insert_one.') VALUES ('.$point_insert_two.');';
		$res = new_sql($sql,$error);
		if((string)$res==$error){
			error_historyBack("�߰� �Է� ����Ʈ �����Դϴ�. 1:1���ǿ� ���� �����ּ���.");
			exit;
		}
		
		//�߰� �Է� ����
		$member_question_insert_one = "hero_pid, hero_code, hero_gift_point, hero_today";
		$member_question_insert_two = "'".$question_idx."', '".$hero_code."', '".$question_rs['hero_gift_point']."', '".$hero_today."'";
		for ($i = 0; $i < $num_qestion; $i++) {
			if($_POST['hero_qs_0'.$i]){
				$member_question_insert_one 	.=	", hero_qs_0".$i."";
				$member_question_insert_two 	.=	", '".$_POST['hero_qs_0'.$i]."'";
			}
		}
			
		//member_question ���̺�
		$error = "MEMBER_QUESTION_04";
		$sql = 'INSERT INTO member_question ('.$member_question_insert_one.') VALUES ('.$member_question_insert_two.');';
		$res = new_sql($sql,$error);
		if((string)$res==$error){
			$deletePoint = "delete from point where hero_old_idx='".$question_rs['hero_idx']."' and hero_code='".$hero_code."' and hero_top_title='ȸ�������߰��Է�'";
			@mysql_query($deletePoint);
			error_historyBack("�߰� �Է� �����Դϴ�. 1:1���ǿ� ���� �����ּ���.");
			exit;
		}
			
		$add_point_check ='Y';
	}
}*/
if($_POST['hero_code']){
	$code=$_POST['hero_code'];
}else{
	$code=$_SESSION['temp_code'];
}
$gift_point = 20;
$num_qestion = 17;
//�߰��Է»��� ����Ʈ �޾Ҵ��� ���� + ���ݱ��� ���� ����Ʈ
$error = "MEMBER_QUESTION_02";
$point_sql = "select * from (select sum(hero_point) from point where hero_code='".$code."') as A left outer join ";
$point_sql .= "(select count(*) from point where hero_title like 'ȸ�������߰��Է�' and hero_code='".$code."' and hero_old_idx='".$_POST['question_idx']."') as B on 1=1";
//echo $point_sql."<br/>";
$point_res = new_sql($point_sql,$error);
if((string)$point_res==$error){
	error_historyBack("");
	exit;
}

$total_point = mysql_result($point_res,0,0);
$getAddPoint = mysql_result($point_res,0,1);

//�߰� �Է»��� ����Ʈ ���� ���� �ִ��� Ȯ��
if($getAddPoint==0){


	if($_POST['question_validation'] == "T"){//���� �ۼ��� ��� 

		
		$question_idx = $_POST['question_idx'];
		
		
		//�߰� �Է� ����
		$member_question_insert_one = "hero_pid, hero_code, hero_gift_point, hero_today";
		$member_question_insert_two = "'".$question_idx."', '".$code."', '".$gift_point."', '".$hero_today."'";
		$unum = 0;
		for ($i = 1; $i <= $num_qestion; $i++) {
			if($i < 10){
				$unum = "0".$i;
			}else{
				$unum = $i;
			}
			//if($_POST['hero_qs_'.$unum]){
				$member_question_insert_one 	.=	", hero_qs_".$unum."";
				$member_question_insert_two 	.=	", '".$_POST['hero_qs_'.$unum]."'";
			//}
		}
			
		//member_question ���̺�
		$error = "MEMBER_QUESTION_04";
		$sql = 'INSERT INTO member_question ('.$member_question_insert_one.') VALUES ('.$member_question_insert_two.');';

		$res = new_sql($sql,$error);
		if((string)$res==$error){
			$deletePoint = "delete from point where hero_old_idx='".$_POST['question_idx']."' and hero_code='".$code."' and hero_top_title='ȸ�������߰��Է�'";
			@mysql_query($deletePoint);
			error_historyBack("�߰� �Է� �����Դϴ�. 1:1���ǿ� ���� �����ּ���.");
			exit;
		}
	
	
	
			
		$point_insert_one = 'hero_old_idx, hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today ';
		$point_insert_two = '\''.$_POST['question_idx'].'\',\''.$code.'\', \''.$_GET['board'].'\', \''.$user_list['hero_id'].'\', \'ȸ�������߰��Է�\', \'ȸ�������߰��Է�\', \''.$user_list['hero_name'].'\', \''.$user_list['hero_nick'].'\', \''.$gift_point.'\', \''.$hero_today.'\'';
		//point ���̺�
		$error = "MEMBER_QUESTION_03";
		$sql = 'INSERT INTO point ('.$point_insert_one.') VALUES ('.$point_insert_two.');';
		$res = new_sql($sql,$error);
		if((string)$res==$error){
			error_historyBack("�߰� �Է� ����Ʈ �����Դϴ�. 1:1���ǿ� ���� �����ּ���.");
			exit;
		}
		
		//�߰��Է»��� üũ
		$total_point += $gift_point;		
		$add_point_check ='Y';
		//echo "�߰� �Է� �׸� ���� �Ϸ�<br>";
		//echo "�߰� �Է� ����Ʈ ���� �Ϸ�<br>";
	}else{// ���� �ۼ����� ���� ��� 
		$add_point_check ='N';
		//echo "�߰� �Է� �׸� ���� ����<br>";
		//echo "�߰� �Է� ����Ʈ ���� ����<br>";		
	}
}	
?>