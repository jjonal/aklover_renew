<?
if(!defined('_HEROBOARD_')) exit;
if(!$_SESSION['temp_code']){
	error_location("�߸��� �����Դϴ�.","/main/index.php?board=idcheck");
	exit;
}

if(((!$_POST['pastPw'] || !$_POST['newPw']) && !$_POST['hero_idx']) && !$_POST['chPwDelay']){
	error_location("�߸��� �����Դϴ�.","/main/index.php?board=idcheck");
	exit;	
}

$code = $_SESSION['temp_code'];
$hero_today = date("Y-m-d H:i:s");
	
unset($_SESSION['ch_password']);
	
if($_POST['chPwDelay']) {
	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chPwClass.php";
	$chAndInputPwClass = new chAndInputPwClass();
	$result_setChTimePw = $chAndInputPwClass->insertChNextTimetoLog($_POST['chPwDelay']);
	
	if($result_setChTimePw!=true){
		error_location("","/main/index.php");
		exit;
	}
	
	$location = "/main/index.php";
		
}else if($_POST['pastPw'] && $_POST['newPw']){ //��й�ȣ ����
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
	message("���� �Ǿ����ϴ�.");
		
} else if($_POST['hero_idx']) { //�⺻���� ����?
	$hero_pid = "4"; //210414 ����� 4��°
	$qs_cnt = "";//�߰��Է� �����Ͱ� �ִ��� üũ

	$hero_file = imageUploader($_FILES['hero_profile'],"/aklover/photo/", true); //������ ������Ʈ

	$memberQuestion_sql = " SELECT count(*) as cnt FROM member_question WHERE hero_code='".$_SESSION["temp_code"]."' AND hero_pid='".$hero_pid."' ";
	$memberQuestion_res = sql($memberQuestion_sql,"on");
	if((string)$memberQuestion_res==$error){
		error_historyBack("");
		exit;
	}
	$memberQuestion_list = mysql_fetch_assoc($memberQuestion_res);
	$qs_cnt = $memberQuestion_list["cnt"];
	
	$member_sql  = " SELECT hero_chk_phone, hero_chk_email FROM member ";
	$member_sql .= " WHERE hero_use = 0 AND hero_code = '".$_SESSION["temp_code"]."' ";
	$member_res = sql($member_sql,"on");
	
	$member_rs = mysql_fetch_assoc($member_res);
	
	$hero_chk_phone_past = $member_rs["hero_chk_phone"];
	$hero_chk_email_past = $member_rs["hero_chk_email"];
		
	$total_point = 0;
	$hero_idx =	$_POST['hero_idx'];
	$hero_mail = $_POST['hero_mail_01'].'@'.$_POST['hero_mail_02'];
	$hero_hp =	$_POST['hero_hp_01'].'-'.$_POST['hero_hp_02'].'-'.$_POST['hero_hp_03'];
	$hero_chk_phone = $_POST["hero_chk_phone"] == "1" ? "1":"0";
	$hero_chk_email = $_POST["hero_chk_email"] == "1" ? "1":"0";
	$hero_today_plus =	$hero_today;
	if($_POST['snsType']) $_POST['hero_'.$_POST['snsType']]	= $_POST['snsId'];
	
	if(!isset($_POST["hero_blog_00"]) || empty($_POST["hero_blog_00"])) {
	    $blog_00 = $_POST["hero_blog_00"];
	} else {
	    $blog_00 = "https://blog.naver.com/".$_POST["hero_blog_00"];
	}
	
	if(!isset($_POST["hero_blog_04"]) || empty($_POST["hero_blog_04"])) {
	    $blog_04 = $_POST["hero_blog_04"];
	} else {
	    $blog_04 = "https://www.instagram.com/".$_POST["hero_blog_04"];
	}
	
	if(!isset($_POST["hero_naver_influencer"]) || empty($_POST["hero_naver_influencer"])) {
	    $naver_influencer = $_POST["hero_naver_influencer"];
	} else {
	    $naver_influencer = "https://in.naver.com/".$_POST["hero_naver_influencer"];
	}
	
	//ȸ������ ����
	//�������� ���̱� ���ؼ� ����
//	$member_sql  = " UPDATE member SET ";
//	$member_sql .= " hero_mail = '".$hero_mail."', hero_hp = '".$hero_hp."' , hero_address_01 = '".$_POST["hero_address_01"]."' , hero_address_02 = '".$_POST["hero_address_02"]."' , hero_address_03 = '".$_POST["hero_address_03"]."' ";
//	$member_sql .= " , area = '".$_POST["area"]."' , area_etc_text = '".$_POST["area_etc_text"]."', hero_chk_phone = '".$hero_chk_phone."', hero_chk_email = '".$hero_chk_email."' ";
//	$member_sql .= " , hero_blog_00 = '".$blog_00."', hero_blog_04 = '".$blog_04."', hero_blog_03 = '".$_POST["hero_blog_03"]."', hero_blog_05 = '".$_POST["hero_blog_05"]."' ";
//	$member_sql .= " , hero_blog_06 = '".$_POST["hero_blog_06"]."' , hero_blog_07 = '".$_POST["hero_blog_07"]."' , hero_blog_08 = '".$_POST["hero_blog_08"]."'";
//	$member_sql .= " , hero_naver_influencer = '".$naver_influencer."' , hero_naver_influencer_name = '".$_POST["hero_naver_influencer_name"]."' , hero_naver_influencer_category = '".$_POST["hero_naver_influencer_category"]."'";
//	$member_sql .= " , hero_today_plus = '".$hero_today."' ";
//	$member_sql .= " WHERE hero_idx = '".$hero_idx."' ";

	$member_sql  = "UPDATE member SET ";
	$member_sql .= "hero_mail = '".$hero_mail."', ";
	$member_sql .= "hero_hp = '".$hero_hp."', ";
	$member_sql .= "hero_address_01 = '".$_POST["hero_address_01"]."', ";
	$member_sql .= "hero_address_02 = '".$_POST["hero_address_02"]."', ";
	$member_sql .= "hero_address_03 = '".$_POST["hero_address_03"]."', ";
	$member_sql .= "area = '".$_POST["area"]."', ";
	$member_sql .= "area_etc_text = '".$_POST["area_etc_text"]."', ";
	$member_sql .= "hero_activity = '".$_POST["hero_activity"]."', ";
	$member_sql .= "hero_chk_phone = '".$hero_chk_phone."', ";
	$member_sql .= "hero_chk_email = '".$hero_chk_email."', ";
	$member_sql .= "hero_blog_00 = '".$blog_00."', ";
	$member_sql .= "hero_blog_04 = '".$blog_04."', ";
	$member_sql .= "hero_blog_03 = '".$_POST["hero_blog_03"]."', ";
	$member_sql .= "hero_blog_05 = '".$_POST["hero_blog_05"]."', ";
	$member_sql .= "hero_blog_06 = '".$_POST["hero_blog_06"]."', ";
	$member_sql .= "hero_blog_07 = '".$_POST["hero_blog_07"]."', ";
	$member_sql .= "hero_blog_08 = '".$_POST["hero_blog_08"]."', ";
	$member_sql .= "hero_naver_influencer = '".$naver_influencer."', ";
	$member_sql .= "hero_naver_influencer_name = '".$_POST["hero_naver_influencer_name"]."', ";
	$member_sql .= "hero_naver_influencer_category = '".$_POST["hero_naver_influencer_category"]."', ";
	$member_sql .= "hero_today_plus = '".$hero_today."' ";

	if (strpos($hero_file, "message:���õ� ������ �����ϴ�") === false) {
		$member_sql .= ",hero_profile = '/aklover/photo/" . $hero_file . "' ";
	}
	$member_sql .= "WHERE hero_idx = '".$hero_idx."' ";
	
	$result = sql($member_sql);

	//�������� ���̱� ���ؼ� ����
//	$ins_history_sql  = " INSERT INTO member_agree_history ";
//	$ins_history_sql .= " (hero_today, hero_chk_phone_past, hero_chk_email_past, hero_chk_phone, hero_chk_email, route, hero_code, edit_hero_code) VALUES ";
//	$ins_history_sql .= " (now(),'".$hero_chk_phone_past."','".$hero_chk_email_past."','".$hero_chk_phone."','".$hero_chk_email."','H','".$_SESSION["temp_code"]."','".$_SESSION["temp_code"]."') ";

	$ins_history_sql  = "INSERT INTO member_agree_history SET ";
	$ins_history_sql .= "hero_today = now(), ";
	$ins_history_sql .= "hero_chk_phone_past = '".$hero_chk_phone_past."', ";
	$ins_history_sql .= "hero_chk_email_past = '".$hero_chk_email_past."', ";
	$ins_history_sql .= "hero_chk_phone = '".$hero_chk_phone."', ";
	$ins_history_sql .= "hero_chk_email = '".$hero_chk_email."', ";
	$ins_history_sql .= "route = 'H', ";
	$ins_history_sql .= "hero_code = '".$_SESSION["temp_code"]."', ";
	$ins_history_sql .= "edit_hero_code = '".$_SESSION["temp_code"]."'";

	$result = sql($ins_history_sql);

	if(!$result) {
		error_historyBack("ȸ���������� �� ������ �߻��߽��ϴ�.");
		exit;
	}
	
	$msg = "ȸ�������� �����Ͽ����ϴ�.";
	
	//�߰�����
	$gift_point = 30;
	$gift_point_check = true;
	$hero_pid = 4;
	$hero_qs_05 = "";//�ڳ� �¾ �⵵
	
	if($_POST["hero_qs_01"] == "Y") { //��α� ���翩��
		if(!$_POST["hero_blog_00"] && !$_POST["hero_blog_03"] && !$_POST["hero_blog_04"] && !$_POST["hero_blog_05"]
		    && !$_POST["hero_blog_06"] && !$_POST["hero_blog_07"] && !$_POST["hero_blog_08"] && !$_POST["hero_naver_influencer"]) {
			$gift_point_check = false;
		}
	}
	
	if($_POST["hero_qs_03"] == "Y") { //�ڳ�/�¾ �⵵
		$k = 0;
		for($i=0; $i<count($_POST["hero_qs_05"]); $i++) {
			if($hero_qs_05 && $_POST["hero_qs_05"][$i]) $hero_qs_05 .= ",";
			if($_POST["hero_qs_05"][$i]) {
				$hero_qs_05 .= $_POST["hero_qs_05"][$i];
				$k++;
			}
		}
	
		if($_POST["hero_qs_04"] != $k) {
			$gift_point_check = false;
		}
	}
	
	if(!$_POST["hero_qs_06"]) { //���� ����
		$gift_point_check = false;
	}
	
	if($_POST["hero_qs_07"] == "Y") { //�ٸ� ü��� ä�� ���Կ���
		if(!$_POST["hero_qs_08"]) $gift_point_check = false;
	}
	
	if($qs_cnt > 0) { //�߰����� ����
		$sel_qs_sql  = " SELECT q.hero_gift_point, q.hero_give_point_today, q.hero_qs_01, q.hero_qs_02, q.hero_qs_03 ";
		$sel_qs_sql .= " , q.hero_qs_04, q.hero_qs_05, q.hero_qs_06, q.hero_qs_07, q.hero_qs_08 ";
		$sel_qs_sql .= " , q.hero_qs_18, q.hero_qs_19, q.hero_qs_20, q.hero_qs_21, q.hero_qs_22, q.hero_qs_23 ";
		$sel_qs_sql .= " , m.hero_blog_00, m.hero_blog_04, m.hero_blog_03, m.hero_blog_05 ";
		$sel_qs_sql .= " , m.hero_blog_06, m.hero_blog_07, m.hero_blog_08, m.hero_naver_influencer ";
		$sel_qs_sql .= " FROM member_question q INNER JOIN member m ON q.hero_code = m.hero_code ";
		$sel_qs_sql .= " WHERE q.hero_code = '".$_SESSION["temp_code"]."' AND q.hero_pid = '".$hero_pid."' "; 
		$sel_qs_res = sql($sel_qs_sql);
		$sel_qs_rs = mysql_fetch_assoc($sel_qs_res);
		
		if(substr($sel_qs_rs['hero_give_point_today'],0,4) ==  date("Y") && $sel_qs_rs["hero_gift_point"] > 0){ //���� �ٲ� �� ������ ������ �ִ� ��� 
			$gift_point_check = false;
		} else if(substr($sel_qs_rs['hero_give_point_today'],0,4) !=  date("Y") && $sel_qs_rs["hero_gift_point"] > 0) {
			
			if($gift_point_check) {//���������� ������Ʈ ������ �� ����� �����Ͱ� �Ѱ��� �ִ� ���
				$data_change = false; //������ ���� ����
				if($sel_qs_rs["hero_qs_01"] != $_POST["hero_qs_01"]) {
					$data_change = true;
				} else {
					if($sel_qs_rs["hero_qs_01"] == "Y") {
						if($sel_qs_rs["hero_blog_00"] != $_POST["hero_blog_00"]) $data_change = true;
						
						if($sel_qs_rs["hero_blog_04"] != $_POST["hero_blog_04"]) $data_change = true;
						
						if($sel_qs_rs["hero_blog_03"] != $_POST["hero_blog_03"]) $data_change = true;
						
						if($sel_qs_rs["hero_blog_05"] != $_POST["hero_blog_05"]) $data_change = true;
						
						if($sel_qs_rs["hero_blog_06"] != $_POST["hero_blog_06"]) $data_change = true;
						
						if($sel_qs_rs["hero_blog_07"] != $_POST["hero_blog_07"]) $data_change = true;
						
						if($sel_qs_rs["hero_blog_08"] != $_POST["hero_blog_08"]) $data_change = true;
						
						if($sel_qs_rs["hero_naver_influencer"] != $_POST["hero_naver_influencer"]) $data_change = true;
					}
				}
				
				if($sel_qs_rs["hero_qs_02"] != $_POST["hero_qs_02"]) {
					$data_change = true;
				}
				
				if($sel_qs_rs["hero_qs_03"] != $_POST["hero_qs_03"]) {
					$data_change = true;
				} else {
					if($_POST["hero_qs_03"]=="Y") {
						if($sel_qs_rs["hero_qs_04"] != $_POST["hero_qs_04"])  $data_change = true;
					}
				}
				
				if($sel_qs_rs["hero_qs_06"] != $_POST["hero_qs_06"]) $data_change = true;
				
				if($sel_qs_rs["hero_qs_07"] != $_POST["hero_qs_07"]) {
					$data_change = true;
				} else {
					if($sel_qs_rs["hero_qs_07"]=="Y") {
						if($sel_qs_rs["hero_qs_08"] != $_POST["hero_qs_08"])  $data_change = true;
					}
				}
				
				if($data_change == false) $gift_point_check =  false; //������ �����Ͱ� ������ ����Ʈ �������� �ʴ´�.
			}
		}
		
//		$question_update_sql  = " UPDATE member_question SET ";
//		$question_update_sql .= " hero_qs_01 = '".$_POST["hero_qs_01"]."', hero_qs_02 = '".$_POST["hero_qs_02"]."', hero_qs_03 = '".$_POST["hero_qs_03"]."', hero_qs_04 = '".$_POST["hero_qs_04"]."' ";
//		$question_update_sql .= " , hero_qs_05 = '".$hero_qs_05."', hero_qs_06 = '".$_POST["hero_qs_06"]."', hero_qs_07 = '".$_POST["hero_qs_07"]."', hero_qs_08 = '".$_POST["hero_qs_08"]."' ";
//		$question_update_sql .= " , hero_qs_18 = '".$_POST["hero_qs_18"]."', hero_qs_19 = '".$_POST["hero_qs_19"]."', hero_qs_20 = '".$_POST["hero_qs_20"]."' , hero_qs_21 = '".$_POST["hero_qs_21"]."'";
//		$question_update_sql .= " , hero_qs_22 = '".$_POST["hero_qs_22"]."', hero_qs_23 = '".$_POST["hero_qs_23"]."'";
//		$question_update_sql .= " , hero_modi_today = now() ";
//		if($gift_point_check) {
//			$question_update_sql .= ", hero_gift_point = '".$gift_point."', hero_give_point_today = now() ";
//		}
//		$question_update_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND hero_pid = '".$hero_pid."' ";
		//�������� ���̱� ���ؼ� ����
		$question_update_sql  = "UPDATE member_question SET ";
		$question_update_sql .= "hero_qs_01 = '".$_POST["hero_qs_01"]."', ";
		$question_update_sql .= "hero_qs_02 = '".$_POST["hero_qs_02"]."', ";
		$question_update_sql .= "hero_qs_03 = '".$_POST["hero_qs_03"]."', ";
		$question_update_sql .= "hero_qs_04 = '".$_POST["hero_qs_04"]."', ";
		$question_update_sql .= "hero_qs_05 = '".$hero_qs_05."', ";
		$question_update_sql .= "hero_qs_06 = '".$_POST["hero_qs_06"]."', ";
		$question_update_sql .= "hero_qs_07 = '".$_POST["hero_qs_07"]."', ";
		$question_update_sql .= "hero_qs_08 = '".$_POST["hero_qs_08"]."', ";
		$question_update_sql .= "hero_qs_18 = '".$_POST["hero_qs_18"]."', ";
		$question_update_sql .= "hero_qs_19 = '".$_POST["hero_qs_19"]."', ";
		$question_update_sql .= "hero_qs_20 = '".$_POST["hero_qs_20"]."', ";
		$question_update_sql .= "hero_qs_21 = '".$_POST["hero_qs_21"]."', ";
		$question_update_sql .= "hero_qs_22 = '".$_POST["hero_qs_22"]."', ";
		$question_update_sql .= "hero_qs_23 = '".$_POST["hero_qs_23"]."', ";
		$question_update_sql .= "hero_modi_today = now() ";

		if($gift_point_check) {
			$question_update_sql .= ", hero_gift_point = '".$gift_point."', ";
			$question_update_sql .= "hero_give_point_today = now() ";
		}

		$question_update_sql .= "WHERE hero_code = '".$_SESSION["temp_code"]."' AND hero_pid = '".$hero_pid."'";

		$result = sql($question_update_sql);
		if(!$result) {
			error_historyBack("�߰�����  ���� �� �����߽��ϴ�.");
			exit;
		}
		
	} else { //�߰� ���� ���
		//�������� ���̱� ���ؼ� ����
//		$question_sql  = " INSERT INTO member_question ";
//		$question_sql .= "(";
//		$question_sql .= " hero_pid, hero_code, hero_qs_01, hero_qs_02, hero_qs_03 ";
//		$question_sql .= " ,hero_qs_04, hero_qs_05, hero_qs_06, hero_qs_07, hero_qs_08 ";
//		$question_sql .= " ,hero_qs_18, hero_qs_19, hero_qs_20, hero_qs_21, hero_qs_22, hero_qs_23 ";
//		$question_sql .= " ,hero_today ";
//		if($gift_point_check) {
//			$question_sql .= " , hero_gift_point, hero_give_point_today ";
//		}
//		$question_sql .= ") VALUES ";
//		$question_sql .= " ( ";
//		$question_sql .= " '".$hero_pid."','".$_SESSION["temp_code"]."','".$_POST["hero_qs_01"]."','".$_POST["hero_qs_02"]."','".$_POST["hero_qs_03"]."' ";
//		$question_sql .= " ,'".$_POST["hero_qs_04"]."' ,'".$hero_qs_05."' ,'".$_POST["hero_qs_06"]."' ,'".$_POST["hero_qs_07"]."' ,'".$_POST["hero_qs_08"]."' ";
//		$question_sql .= " ,'".$_POST["hero_qs_18"]."','".$_POST["hero_qs_19"]."','".$_POST["hero_qs_20"]."','".$_POST["hero_qs_21"]."','".$_POST["hero_qs_22"]."','".$_POST["hero_qs_23"]."'";
//		$question_sql .= " ,now() ";
//		if($gift_point_check) {
//			$question_sql .= " , '".$gift_point."' ,now() ";
//		}
//		$question_sql .= " ) ";

		$question_sql  = "INSERT INTO member_question SET ";
		$question_sql .= "hero_pid = '".$hero_pid."', ";
		$question_sql .= "hero_code = '".$_SESSION["temp_code"]."', ";
		$question_sql .= "hero_qs_01 = '".$_POST["hero_qs_01"]."', ";
		$question_sql .= "hero_qs_02 = '".$_POST["hero_qs_02"]."', ";
		$question_sql .= "hero_qs_03 = '".$_POST["hero_qs_03"]."', ";
		$question_sql .= "hero_qs_04 = '".$_POST["hero_qs_04"]."', ";
		$question_sql .= "hero_qs_05 = '".$hero_qs_05."', ";
		$question_sql .= "hero_qs_06 = '".$_POST["hero_qs_06"]."', ";
		$question_sql .= "hero_qs_07 = '".$_POST["hero_qs_07"]."', ";
		$question_sql .= "hero_qs_08 = '".$_POST["hero_qs_08"]."', ";
		$question_sql .= "hero_qs_18 = '".$_POST["hero_qs_18"]."', ";
		$question_sql .= "hero_qs_19 = '".$_POST["hero_qs_19"]."', ";
		$question_sql .= "hero_qs_20 = '".$_POST["hero_qs_20"]."', ";
		$question_sql .= "hero_qs_21 = '".$_POST["hero_qs_21"]."', ";
		$question_sql .= "hero_qs_22 = '".$_POST["hero_qs_22"]."', ";
		$question_sql .= "hero_qs_23 = '".$_POST["hero_qs_23"]."', ";
		$question_sql .= "hero_today = now() ";

		if ($gift_point_check) {
			$question_sql .= ", hero_gift_point = '".$gift_point."', ";
			$question_sql .= "hero_give_point_today = now() ";
		}

		$result = sql($question_sql);
		
		if(!$result) {
			error_historyBack("�߰����� �Է� �� �����߽��ϴ�.");
			exit;
		}
	}

	//�߰����� ����Ʈ ����
	if($gift_point_check) {
		pointAdd("infoedit", 'addInfo', 0, 0, 0, "�߰������Է�", 'N');
		$msg .= "\\n�߰������̺�Ʈ 30POINT �ο��ƽ��ϴ�.";
	}
	
    $location = PATH_HOME_HTTPS."?board=infoedit";
    message($msg);

}
location($location);
exit;
?>
