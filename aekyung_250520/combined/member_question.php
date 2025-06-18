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
	
	//추가입력사항 포인트 받았는지 여부 + 지금까지 받은 포인트
	$error = "MEMBER_QUESTION_02";
	$point_sql = "select * from (select sum(hero_point) from point where hero_code='".$code."') as A left outer join ";
	$point_sql .= "(select count(*) from point where hero_title like '회원가입추가입력' and hero_code='".$code."' and hero_old_idx='".$question_rs['hero_pid']."') as A on 1=1";
	//echo $point_sql."<br/>";
	$point_res = new_sql($point_sql,$error);
	if((string)$point_res==$error){
		error_historyBack("");
		exit;
	}

	$total_point = mysql_result($point_res,0,0);
	$getAddPoint = mysql_result($point_res,0,1);
	
	//추가 입력사항 포인트 받은 적이 있는지 확인
	if($getAddPoint==0){
	
		$question_idx = $_POST['question_idx'];
		
		//추가입력사항 체크
		$total_point .= $question_rs['hero_gift_point'];
			
		$point_insert_one = 'hero_old_idx, hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today ';
		$point_insert_two = '\''.$question_rs['hero_idx'].'\',\''.$hero_code.'\', \''.$_GET['board'].'\', \''.$user_list['hero_id'].'\', \'회원가입추가입력\', \'월출석개근\', \''.$user_list['hero_name'].'\', \''.$user_list['hero_nick'].'\', \''.$question_rs['hero_gift_point'].'\', \''.$hero_today.'\'';
		//point 테이블
		$error = "MEMBER_QUESTION_03";
		$sql = 'INSERT INTO point ('.$point_insert_one.') VALUES ('.$point_insert_two.');';
		$res = new_sql($sql,$error);
		if((string)$res==$error){
			error_historyBack("추가 입력 포인트 오류입니다. 1:1문의에 글을 남겨주세요.");
			exit;
		}
		
		//추가 입력 사항
		$member_question_insert_one = "hero_pid, hero_code, hero_gift_point, hero_today";
		$member_question_insert_two = "'".$question_idx."', '".$hero_code."', '".$question_rs['hero_gift_point']."', '".$hero_today."'";
		for ($i = 0; $i < $num_qestion; $i++) {
			if($_POST['hero_qs_0'.$i]){
				$member_question_insert_one 	.=	", hero_qs_0".$i."";
				$member_question_insert_two 	.=	", '".$_POST['hero_qs_0'.$i]."'";
			}
		}
			
		//member_question 테이블
		$error = "MEMBER_QUESTION_04";
		$sql = 'INSERT INTO member_question ('.$member_question_insert_one.') VALUES ('.$member_question_insert_two.');';
		$res = new_sql($sql,$error);
		if((string)$res==$error){
			$deletePoint = "delete from point where hero_old_idx='".$question_rs['hero_idx']."' and hero_code='".$hero_code."' and hero_top_title='회원가입추가입력'";
			@mysql_query($deletePoint);
			error_historyBack("추가 입력 오류입니다. 1:1문의에 글을 남겨주세요.");
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
//추가입력사항 포인트 받았는지 여부 + 지금까지 받은 포인트
$error = "MEMBER_QUESTION_02";
$point_sql = "select * from (select sum(hero_point) from point where hero_code='".$code."') as A left outer join ";
$point_sql .= "(select count(*) from point where hero_title like '회원가입추가입력' and hero_code='".$code."' and hero_old_idx='".$_POST['question_idx']."') as B on 1=1";
//echo $point_sql."<br/>";
$point_res = new_sql($point_sql,$error);
if((string)$point_res==$error){
	error_historyBack("");
	exit;
}

$total_point = mysql_result($point_res,0,0);
$getAddPoint = mysql_result($point_res,0,1);

//추가 입력사항 포인트 받은 적이 있는지 확인
if($getAddPoint==0){


	if($_POST['question_validation'] == "T"){//전부 작성한 경우 

		
		$question_idx = $_POST['question_idx'];
		
		
		//추가 입력 사항
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
			
		//member_question 테이블
		$error = "MEMBER_QUESTION_04";
		$sql = 'INSERT INTO member_question ('.$member_question_insert_one.') VALUES ('.$member_question_insert_two.');';

		$res = new_sql($sql,$error);
		if((string)$res==$error){
			$deletePoint = "delete from point where hero_old_idx='".$_POST['question_idx']."' and hero_code='".$code."' and hero_top_title='회원가입추가입력'";
			@mysql_query($deletePoint);
			error_historyBack("추가 입력 오류입니다. 1:1문의에 글을 남겨주세요.");
			exit;
		}
	
	
	
			
		$point_insert_one = 'hero_old_idx, hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today ';
		$point_insert_two = '\''.$_POST['question_idx'].'\',\''.$code.'\', \''.$_GET['board'].'\', \''.$user_list['hero_id'].'\', \'회원가입추가입력\', \'회원가입추가입력\', \''.$user_list['hero_name'].'\', \''.$user_list['hero_nick'].'\', \''.$gift_point.'\', \''.$hero_today.'\'';
		//point 테이블
		$error = "MEMBER_QUESTION_03";
		$sql = 'INSERT INTO point ('.$point_insert_one.') VALUES ('.$point_insert_two.');';
		$res = new_sql($sql,$error);
		if((string)$res==$error){
			error_historyBack("추가 입력 포인트 오류입니다. 1:1문의에 글을 남겨주세요.");
			exit;
		}
		
		//추가입력사항 체크
		$total_point += $gift_point;		
		$add_point_check ='Y';
		//echo "추가 입력 항목 저장 완료<br>";
		//echo "추가 입력 포인트 지급 완료<br>";
	}else{// 전부 작성하지 못한 경우 
		$add_point_check ='N';
		//echo "추가 입력 항목 저장 안함<br>";
		//echo "추가 입력 포인트 지급 안함<br>";		
	}
}	
?>