<?
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){
	$hero_name 		= $_SESSION["auth"]["hero_name"];   
	$hero_jumin 	= $_SESSION["auth"]["hero_jumin"];  
	$hero_sex 		= $_SESSION["auth"]["hero_sex"];    
	$hero_info_type = $_SESSION["auth"]["hero_info_type"];   
	$hero_info_di 	= $_SESSION["auth"]["hero_info_di"];   
	$hero_info_ci 	= $_SESSION["auth"]["hero_info_ci"]; 
	
	$snsId 			= $_SESSION["auth"]["snsId"];
	$snsType 		= $_SESSION["auth"]["snsType"];
	//���� ����
	$hero_id =  preg_replace("/\s+/", "", $_POST['hero_id']);
	$hero_nick =  preg_replace("/\s+/", "", $_POST['hero_nick']);

	if($_SESSION["auth"]["hero_name"]) {
		$hero_name 		= $_SESSION["auth"]["hero_name"];
		$hero_jumin 	= $_SESSION["auth"]["hero_jumin"];

		if($_POST["tempNoAuth"] == "Y") {
			$hero_jumin 	=  $_POST["year"].$_POST["month"].$_POST["date"];
		}
	} else if($_SESSION["auth"]["snsId"]) {
		$hero_name = $_POST["hero_name"];
		$hero_jumin = $_POST["year"].$_POST["month"].$_POST["date"];
	}

	if((!$hero_info_di || !$hero_info_ci) && (!$snsId || !$snsType)){
		error_location("�߸��� �����Դϴ�.","/main/index.php?board=idcheck");
		exit;
	}

	$error = "RESULT_01";
	//���̵�, �г��� �ߺ� üũ
	$ch_member_query = "select * from (select count(*) from member where hero_id='".$hero_id."' or hero_nick='".$hero_nick."') as A, ";

	//���� ���� üũ
	if($hero_info_di && $hero_info_ci){
		$ch_member_query .= "(select count(*) from member where hero_info_di='".$hero_info_di."' and hero_info_ci='".$hero_info_ci."' and hero_use=0) as B ";
	}elseif($snsId && $snsType){
		$ch_member_query .= "(select count(*) from member where hero_".$snsType."='".$snsId."' and hero_use=0) as B ";
	}

	$ch_member_res = new_sql($ch_member_query,$error,"on");
	if((string)$ch_member_res==$error){
		error_historyBack("");
		exit;
	}

	$ch_member_rs_01 = mysql_result($ch_member_res,0,0); //���̵� üũ
	$ch_member_rs_02 = mysql_result($ch_member_res,0,1); //���� ���� üũ

	if($ch_member_rs_01>0){
		error_historyBack("�̹� ��ϵ� ���̵� Ȥ�� �г����Դϴ�. �ٸ� ���̵� Ȥ�� �г������� �������ֽñ� �ٶ��ϴ�.");
		exit;
	}

	if($ch_member_rs_02>0){
		error_location("�̹� �����ϼ̽��ϴ�.","/main/index.php");
		exit;
	}
    
}

	$error = "RESULT_02";
	$ch_idx_sql = "SHOW TABLE STATUS LIKE 'member'";
	$ch_idx_res = new_sql($ch_idx_sql,$error);
	if((string)$ch_idx_res==$error){
		error_historyBack("");
		exit;
	}
	$ch_idx_rs = mysql_fetch_assoc($ch_idx_res);
	
	$time =	date("Y-m-d H:i:s");
	$hero_table	= "member"; 	
	$hero_code	= $ch_idx_rs['Auto_increment']; 	
	$hero_mail = $_POST['hero_mail_01'].'@'.$_POST['hero_mail_02'];
	$hero_hp = $_POST['hero_hp_01'].'-'.$_POST['hero_hp_02'].'-'.$_POST['hero_hp_03'];
	
	$pw_01 = $_POST["hero_pw_01"];
	$pw_md5 = md5($pw_01);
	$temp = $pw_md5.$hero_id;
	$pw_sha3_256 = sha3_hash('sha3-256', $temp);
	$hero_pw = $pw_sha3_256;
	
	$hero_login_ip = $_SERVER['REMOTE_ADDR'];

    //�������� �����̿뵿�� �����׸�
    if(!isset($_POST["hero_terms_03"]) || empty($_POST["hero_terms_03"])) {
        $hero_terms_03 = "1";
    } else {
        $hero_terms_03 = $_POST["hero_terms_03"];
    }

    //SMS ���� ����
    if(!isset($_POST["hero_terms_04"]) || empty($_POST["hero_terms_04"])) {
        $hero_terms_04 = "1";
    } else {
        $hero_terms_04 = $_POST["hero_terms_04"];
    }

    //�̸��� ���� ����
    if(!isset($_POST["hero_terms_05"]) || empty($_POST["hero_terms_05"])) {
        $hero_terms_05 = "1";
    } else {
        $hero_terms_05 = $_POST["hero_terms_05"];
    }

    //�ΰ����� �������̿� ����
    if(!isset($_POST["hero_terms_06"]) || empty($_POST["hero_terms_06"])) {
        $hero_terms_06 = "1";
    } else {
        $hero_terms_06 = $_POST["hero_terms_06"];
    }
    
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
	
	
	$hero_user_type = $_POST["hero_user_type"];
	if($hero_user_type == "hero_id") {
	    $hero_user = $_POST["hero_user_r_id"];
	} else if($hero_user_type == "hero_nick") {
	    $hero_user = $_POST["hero_user_r_nick"];
	}
	
	
//	$member_sql  = " INSERT INTO member ";
//	$member_sql .= "( hero_code, hero_table ";
//	if($_SESSION["auth"]["hero_name"]) {
//		$member_sql .= " , hero_info_type, hero_info_di, hero_info_ci, hero_sex ";
//	} else if($_SESSION["auth"]["snsId"]) {
//		$member_sql .= " , hero_".$snsType;
//	}
//	$member_sql .= " , hero_id, hero_pw, hero_name, hero_nick, hero_jumin ";
//	$member_sql .= " , hero_mail, hero_hp, hero_address_01, hero_address_02 ";
//	$member_sql .= " , hero_address_03, hero_blog_00,  hero_blog_03, hero_blog_04, hero_blog_05 ";
//	$member_sql .= " , hero_blog_06, hero_blog_07, hero_blog_08 ";
//	$member_sql .= " , hero_oldday, hero_today_plus, hero_user_type ";
//	$member_sql .= " , hero_user , hero_chk_phone, hero_chk_email, area, area_etc_text ";
//	$member_sql .= " , hero_login_ip, hero_terms_01, hero_terms_02, hero_terms_03, hero_terms_04 ";
//	$member_sql .= " , hero_terms_05, hero_naver_influencer, hero_naver_influencer_name, hero_naver_influencer_category ";
//	$member_sql .= " ) ";
//	$member_sql .= " VALUES ";
//	$member_sql .= " ('".$hero_code."', 'member' ";
//	if($_SESSION["auth"]["hero_name"]) {
//		$member_sql .= " , '".$hero_info_type."','".$hero_info_di."' ,'".$hero_info_ci."' ,'".$hero_sex."' ";
//	} else if($_SESSION["auth"]["snsId"]) {
//		$member_sql .= " , md5('".$snsId."') ";
//	}
//	$member_sql .= " ,'".$hero_id."', ".$hero_pw.", '".$hero_name."','".$hero_nick."' ,'".$hero_jumin."' ";
//	$member_sql .= " , '".$hero_mail."', '".$hero_hp."','".$_POST["hero_address_01"]."' ,'".$_POST["hero_address_02"]."' ";
//	$member_sql .= " ,'".$_POST["hero_address_03"]."', '".$blog_00."', '".$_POST["hero_blog_03"]."','".$blog_04."','".$_POST["hero_blog_05"]."' ";
//	$member_sql .= " , '".$_POST["hero_blog_06"]."','".$_POST["hero_blog_07"]."' ,'".$_POST["hero_blog_08"]."' ";
//	$member_sql .= " , '".$time."','".$time."' ,'".$hero_user_type."' ";
//	$member_sql .= " ,'".$hero_user."' ,'".$_POST["hero_chk_phone"]."', '".$_POST["hero_chk_email"]."', '".$_POST["area"]."','".$_POST["area_etc_text"]."' ";
//	$member_sql .= " ,'".$hero_login_ip."','".$_POST["hero_terms_01"]."','".$_POST["hero_terms_02"]."','".$_POST["hero_terms_03"]."','".$_POST["hero_terms_04"]."' ";
//	$member_sql .= " ,'".$_POST["hero_terms_05"]."','".$naver_influencer."','".$_POST["hero_naver_influencer_name"]."','".$_POST["hero_naver_influencer_category"]."' ";
//	$member_sql .= ")";

    //�������� ���̱� ���ؼ� ����
    $member_sql = "INSERT INTO member SET ";
    $member_sql .= "hero_code = '".$hero_code."', ";
    $member_sql .= "hero_table = 'member', ";
    
    if($_SESSION["auth"]["hero_name"]) {
        $member_sql .= "hero_info_type = '".$hero_info_type."', ";
        $member_sql .= "hero_info_di = '".$hero_info_di."', ";
        $member_sql .= "hero_info_ci = '".$hero_info_ci."', ";
        $member_sql .= "hero_sex = '".$hero_sex."', ";
    } else if($_SESSION["auth"]["snsId"]) {
        $member_sql .= "hero_".$snsType." = md5('".$snsId."'), ";
    }
    
    $member_sql .= "hero_id = '".$hero_id."', ";
    $member_sql .= "hero_pw = '".$hero_pw."', ";
    $member_sql .= "hero_name = '".$hero_name."', ";
    $member_sql .= "hero_nick = '".$hero_nick."', ";
    $member_sql .= "hero_jumin = '".$hero_jumin."', ";
    $member_sql .= "hero_mail = '".$hero_mail."', ";
    $member_sql .= "hero_hp = '".$hero_hp."', ";
    $member_sql .= "hero_address_01 = '".$_POST["hero_address_01"]."', ";
    $member_sql .= "hero_address_02 = '".$_POST["hero_address_02"]."', ";
    $member_sql .= "hero_address_03 = '".$_POST["hero_address_03"]."', ";
    $member_sql .= "hero_blog_00 = '".$blog_00."', ";
    $member_sql .= "hero_blog_03 = '".$_POST["hero_blog_03"]."', ";
    $member_sql .= "hero_blog_04 = '".$blog_04."', ";
    $member_sql .= "hero_blog_05 = '".$_POST["hero_blog_05"]."', ";
    $member_sql .= "hero_blog_06 = '".$_POST["hero_blog_06"]."', ";
    $member_sql .= "hero_blog_07 = '".$_POST["hero_blog_07"]."', ";
    $member_sql .= "hero_blog_08 = '".$_POST["hero_blog_08"]."', ";
    $member_sql .= "hero_oldday = '".$time."', ";
    $member_sql .= "hero_today_plus = '".$time."', ";
    $member_sql .= "hero_user_type = '".$hero_user_type."', ";
    $member_sql .= "hero_user = '".$hero_user."', ";
//    $member_sql .= "hero_chk_phone = '".$_POST["hero_chk_phone"]."', "; //����
//    $member_sql .= "hero_chk_email = '".$_POST["hero_chk_email"]."', "; //����
    $member_sql .= "area = '".$_POST["area"]."', ";
    $member_sql .= "area_etc_text = '".$_POST["area_etc_text"]."', ";
    $member_sql .= "hero_activity = '".$_POST["hero_activity"]."', "; //�����ִ� Ȱ�� �߰�
    $member_sql .= "hero_login_ip = '".$hero_login_ip."', ";
    $member_sql .= "hero_terms_01 = '".$_POST["hero_terms_01"]."', ";
    $member_sql .= "hero_terms_02 = '".$_POST["hero_terms_02"]."', ";
    $member_sql .= "hero_terms_03 = '".$hero_terms_03."', ";
    $member_sql .= "hero_terms_04 = '".$hero_terms_04."', ";
    $member_sql .= "hero_terms_05 = '".$hero_terms_05."', ";
    $member_sql .= "hero_terms_06 = '".$hero_terms_06."', ";
    $member_sql .= "hero_naver_influencer = '".$naver_influencer."', ";
    $member_sql .= "hero_naver_influencer_name = '".$_POST["hero_naver_influencer_name"]."', ";
    $member_sql .= "hero_naver_influencer_category = '".$_POST["hero_naver_influencer_category"]."' ";
	
	$result = sql($member_sql);

	if(!$result) {
		error_location("ȸ������ �� �����߽��ϴ�.","/main/index.php");
		exit;
	} else {
		$msg .= $hero_nick." ��, AK Loverȸ���� �ǽ� ���� �������� ���ϵ帳�ϴ�.\\nȸ������ �Ϸ� ��, �ٽ� �α����� �ʿ��մϴ�";
	}

    /* �߰����� ����
	//�߰�����(����)
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
	
//	$question_sql  = " INSERT INTO member_question ";
//	$question_sql .= "(";
//	$question_sql .= " hero_pid, hero_code, hero_qs_01, hero_qs_02, hero_qs_03 ";
//	$question_sql .= " ,hero_qs_04, hero_qs_05, hero_qs_06, hero_qs_07, hero_qs_08 ";
//	$question_sql .= " ,hero_qs_18, hero_qs_19, hero_qs_20, hero_qs_21, hero_qs_22, hero_qs_23 ";
//	$question_sql .= " ,hero_today ";
//	if($gift_point_check) {
//		$question_sql .= " , hero_gift_point, hero_give_point_today ";
//	}
//	$question_sql .= ") VALUES ";
//	$question_sql .= " ( ";
//	$question_sql .= " '".$hero_pid."','".$hero_code."','".$_POST["hero_qs_01"]."','".$_POST["hero_qs_02"]."','".$_POST["hero_qs_03"]."' ";
//	$question_sql .= " ,'".$_POST["hero_qs_04"]."' ,'".$hero_qs_05."' ,'".$_POST["hero_qs_06"]."' ,'".$_POST["hero_qs_07"]."' ,'".$_POST["hero_qs_08"]."' ";
//	$question_sql .= " ,'".$_POST["hero_qs_18"]."','".$_POST["hero_qs_19"]."','".$_POST["hero_qs_20"]."','".$_POST["hero_qs_21"]."','".$_POST["hero_qs_22"]."','".$_POST["hero_qs_23"]."'";
//	$question_sql .= " ,now() ";
//	if($gift_point_check) {
//		$question_sql .= " , '".$gift_point."' ,now() ";
//	}
//	$question_sql .= " ) ";

    //�������� ���̱� ���ؼ� ����
    $question_sql = "INSERT INTO member_question SET ";
    $question_sql .= "hero_pid = '".$hero_pid."', ";
    $question_sql .= "hero_code = '".$hero_code."', ";
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
    $question_sql .= "hero_today = now()";

    if($gift_point_check) {
        $question_sql .= ", hero_gift_point = '".$gift_point."', ";
        $question_sql .= "hero_give_point_today = now()";
    }

	$result = sql($question_sql);
	
	if(!$result) {
		error_location("�߰����� �Է� �� �����߽��ϴ�.","/m/main.php");
		exit;
	}

	if($gift_point_check) {
		$_SESSION["temp_code"] = $hero_code;
		$_SESSION["temp_id"] = $hero_id;
		$_SESSION["temp_nick"] = $hero_nick;
		$_SESSION["temp_name"] = $hero_name;
		$_SESSION["temp_level"] = '1';
		
		pointAdd("signup", 'addInfo', 0, 0, 0, "�߰������Է�", 'N'); //�߰����� ����Ʈ
		
		$msg .= "\\n�߰������̺�Ʈ 30POINT �ο��ƽ��ϴ�.";
		
		unset($_SESSION["temp_code"]);
		unset($_SESSION["temp_id"]);
		unset($_SESSION["temp_nick"]);
		unset($_SESSION["temp_name"]);
		unset($_SESSION["temp_level"]);
	}
    �߰����� ����	*/

	//��õ�� ����Ʈ
	if($_POST["hero_user_point_check"] == "ok" && $hero_user && $_POST["hero_user_type"]) {
		$user_sql  = " SELECT hero_code, hero_id, hero_name, hero_nick FROM member ";
		$user_sql .= " WHERE hero_use = 0 AND ".$_POST["hero_user_type"]." = '".$hero_user."' ";
		$user_res = sql($user_sql);
		$user_rs = mysql_fetch_assoc($user_res);
	
		if($user_rs["hero_code"]) {
//			$user_point_sql  = " INSERT INTO point ";
//			$user_point_sql .= " (hero_recommand, hero_code, hero_table, hero_type, hero_old_idx ";
//			$user_point_sql .= " , hero_id, hero_top_title, hero_title, hero_name, hero_nick ";
//			$user_point_sql .= " , hero_point, hero_today, point_change_chk ";
//			$user_point_sql .= " ) VALUES ";
//			$user_point_sql .= " ('".$hero_code."', '".$user_rs["hero_code"]."', 'member','member','0' ";
//			$user_point_sql .= " , '".$user_rs["hero_id"]."', 'ȸ������', '��õ������Ʈ' , '".$user_rs["hero_name"]."', '".$user_rs["hero_nick"]."' ";
//			$user_point_sql .= " , '500', '".$time."', 'Y' ";
//			$user_point_sql .= " ) ";

            //�������� ���̱� ���ؼ� ����
            $user_point_sql = "INSERT INTO point SET ";
            $user_point_sql .= "hero_recommand = '".$hero_code."', ";
            $user_point_sql .= "hero_code = '".$user_rs["hero_code"]."', ";
            $user_point_sql .= "hero_table = 'member', ";
            $user_point_sql .= "hero_type = 'member', ";
            $user_point_sql .= "hero_old_idx = '0', ";
            $user_point_sql .= "hero_id = '".$user_rs["hero_id"]."', ";
            $user_point_sql .= "hero_top_title = 'ȸ������', ";
            $user_point_sql .= "hero_title = '��õ������Ʈ', ";
            $user_point_sql .= "hero_name = '".$user_rs["hero_name"]."', ";
            $user_point_sql .= "hero_nick = '".$user_rs["hero_nick"]."', ";
            $user_point_sql .= "hero_point = '500', ";
            $user_point_sql .= "hero_today = '".$time."', ";
            $user_point_sql .= "point_change_chk = 'Y'";
			$result = sql($user_point_sql);

			if($result) {
				$user_total_point = " SELECT SUM(hero_point) as point FROM point WHERE hero_code='".$user_rs['hero_code']."' ";
				$user_total_point_res = sql($user_total_point);
				$user_total_point_rs = mysql_fetch_assoc($user_total_point_res);
	
				$total_point = $user_total_point_rs["point"];
	
				$user_point_edit_sql = " UPDATE member SET hero_point = ".$total_point." WHERE hero_code = '".$user_rs['hero_code']."' ";
	
				$result = sql($user_point_edit_sql);
			}
		}
	}
	
//�˸��� �߰� 190607 (������ ������� �ۼ� �ʿ�)
$message = "�ȳ��ϼ���. ".$_POST["hero_nick"]."��!
�ְ� �������� AK Lover ȸ�������� �������� ����帳�ϴ�.
	
<ȸ������ ����>
���̵� : ".$_POST["hero_id"]."
	
�ְ� �������� AK Lover ���� �� ������ Ȱ���Ͻ� �� ������, �پ��� �ְ� ��ǰ ü��� Ư���� ������ ������ �� �ֽ��ϴ�.
	
AK Lover Ȩ������ ù �α��� ��, ü��� ��ۺ� ��ü�� �� �ִ� ����Ʈ ".$_DELIVERY_POINT."���� �����ص帳�ϴ�.";

$alrim_mobile = str_replace("-","",$hero_hp);

memberJoinAlrimTalk($message,$alrim_mobile,"10009");
	
	unset($_SESSION["auth"]);
	
	if($result) {
		message($msg);
//        location("/main/index.php?board=group_04_01");
        location("/main/index.php?board=join_ok&id=".$_POST["hero_id"]); //ȸ�����ԿϷ�� ���ԿϷ������� ����
		exit;
	}
	
####################################################################################################################################################
?>
    <div class="contents_area"> 
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="ȸ����������" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li>MY PAGE</li>
                <li>&gt;</li>
                <li class="current">ȸ������</li>
            </ul>
        </div>
        <div class="contents">
            <div class="resbox">
                <span class="restxt"><?=$_POST['hero_nick']?> ��</span>
            </div>
            <div class="btngroup tc" >
                <a href="<?=PATH_HOME?>"><img src="../image/member/btn_gomain.gif" /></a>
            </div>
        </div>
    </div>
