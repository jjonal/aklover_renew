<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(!$_SESSION['temp_code']){
	error_location("잘 못된 접근입니다.","/main/index.php?board=idcheck");
	exit;
}

if(((!$_POST['pastPw'] || !$_POST['newPw']) && !$_POST['hero_idx']) && !$_POST['chPwDelay']){
	error_location("잘 못된 접근입니다.","/main/index.php?board=idcheck");
	exit;	
}

####################################################################################################################################################

	$code = $_SESSION['temp_code'];
	$hero_today = date("Y-m-d H:i:s");
	
	unset($_SESSION['ch_password']);
	//setcookie('ch_password', '', time() - 3600, '/');
	
	if($_POST['chPwDelay']){

		include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chPwClass.php";
		$chAndInputPwClass = new chAndInputPwClass();
		$result_setChTimePw = $chAndInputPwClass->insertChNextTimetoLog($_POST['chPwDelay']);
		
		if($result_setChTimePw!=true){
			error_location("","/main/index.php");
			exit;
		}
		
		$location = "/main/index.php";
		
	}elseif($_POST['pastPw'] && $_POST['newPw']){
		include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chPwClass.php";
		
		$chAndInputPwClass = new chAndInputPwClass($_POST['pastPw'],$_POST['newPw']);
		$result_chAndInputPw = $chAndInputPwClass->progressChPw();
		if($result_chAndInputPw!=1){
			if(mb_substr($result_chAndInputPw,0,7)=="message"){
				error_historyBack(mb_substr($result_chAndInputPw,8));
				exit;
			}elseif($result_chAndInputPw){
				error_historyBack("");
				exit;
			}
		}
		
		$location = "/main/out.php?board=login";
		message("수정 되었습니다.");
		
	}elseif($_POST['hero_idx']){

		$error = "UPDATE_01";
		$member_sql = "select * from member where hero_idx='".$_POST['hero_idx']."' ;";
		$member_res = new_sql($member_sql,$error,"on");
		if((string)$member_res==$error){
			error_historyBack("");
			exit;
		}
		$user_list                             = mysql_fetch_assoc($member_res);
		
		$total_point		=	0;
		$hero_idx							=	$_POST['hero_idx'];
		$_POST['hero_mail'] 				= 	$_POST['hero_mail_01'].'@'.$_POST['hero_mail_02'];
		$_POST['hero_hp']					=	$_POST['hero_hp_01'].'-'.$_POST['hero_hp_02'].'-'.$_POST['hero_hp_03'];
		$_POST['hero_today_plus']			=	$hero_today;
		if($_POST['snsType'])					$_POST['hero_'.$_POST['snsType']]	=	$_POST['snsId'];
		
		//(s)160423 추가기입정보 수정 문수영
		$hero_qs_03 = "";
		for($z=0; $z<count($_POST["hero_qs_03"]); $z++) {
			if($z > 0)  {
				 $hero_qs_03 .= ",".$_POST["hero_qs_03"][$z];
			} else {
				$hero_qs_03 .= $_POST["hero_qs_03"][$z];
			}
		}
		$error = "UPDATE_MEMBER_QUESTION_02";
		$sql = " UPDATE member_question SET hero_qs_10 = '".$_POST["hero_qs_10"]."', hero_qs_09 = '".$_POST["hero_qs_09"]."', hero_qs_01 = '".$_POST["hero_qs_01"]."' , hero_qs_02 = '".$_POST["hero_qs_02"]."' ";
		$sql .= " , hero_qs_03 = '".$hero_qs_03."' , hero_qs_04 = '".$_POST["hero_qs_04"]."' , hero_qs_05 = '".$_POST["hero_qs_05"]."' , hero_qs_06 = '".$_POST["hero_qs_06"]."' , hero_qs_07 = '".$_POST["hero_qs_07"]."' ";
		$sql .= " , hero_qs_08 = '".$_POST["hero_qs_08"]."' WHERE hero_pid= '3' and hero_code ='".$_SESSION['temp_code']."' ";
		
		
		$res = new_sql($sql,$error);
	    if((string)$res==$error){
	    	error_historyBack("");
	    	exit;
	    }
		//(e)160423 추가기입정보 수정 문수영
		
	
		$sql_one = "hero_table='member', hero_job_01='Y'";
		
	####################################################################################################################################################
	//회원가입 추가 입력 포인트 지급
	//한번도 받지 않은 경우 1
		if($_POST['addPoint_check']=='N' && mktime(0,0,0,2,1,2016) <= time() && mktime(23,59,59,2,28,2016) >= time()){//이벤트 기간 중 
			//return 값 - total_point : 추가입력포인트가 더해진 포인트, $add_point_check - 추가포인트 부여 여부
			include_once $_SERVER['DOCUMENT_ROOT'].'/combined/member_question.php';
		}
		
		$remove_list = array('hero_idx','snsType','snsId','hero_hp_01','hero_hp_02','hero_hp_03','hero_pw_01','hero_pw_02','hero_drop','hero_mail_01','hero_mail_02','x','y','addPoint_check','question_idx','hero_qs_01','hero_qs_02','hero_qs_03','hero_qs_04','hero_qs_05','hero_qs_06','hero_qs_07','hero_qs_08','hero_qs_09','hero_qs_10','hero_qs_11','hero_qs_12','hero_qs_13','hero_qs_14','hero_qs_15','hero_qs_16','hero_qs_17','question_validation');
		foreach($remove_list as $drop_val){
			unset($_POST[$drop_val]);
		}
		
		if($total_point!=0)		$sql_one .= ", hero_point='".$total_point."' ";
		
		foreach ($_POST as $post_key => $post_val) {
			$sql_one .= ", ".$post_key."='".$post_val."'";
		}
		
		$error = "UPDATE_02";
	    $sql = "UPDATE member SET ".$sql_one." WHERE hero_idx = ".$hero_idx;

	    $res = new_sql($sql,$error);
	    if((string)$res==$error){
	    	error_historyBack("");
	    	exit;
	    }
	    
	    $location = PATH_HOME."?board=infoedit";
	    $msg = "회원 정보를 수정 하였습니다.";
	    if($add_point_check =='Y'){
	    			$msg .= "\\n추가정보입력 ".$gift_point."포인트가 부여 되었습니다.";
		}			
	    message($msg);
		
	}
	location($location);
	exit;
	
	//exit;
?>
