<link rel="stylesheet" href="../css/front/member.css">
<?
if (!defined('_HEROBOARD_')) exit();

if(!strcmp($_SESSION['temp_level'], '')){
	$my_level = '0';
	$my_write = '0';
	$my_view = '0';
	$my_update = '0';
	$my_rev = '0';
}else{
	$my_level = $_SESSION['temp_level'];
	$my_write = $_SESSION['temp_write'];
	$my_view = $_SESSION['temp_view'];
	$my_update = $_SESSION['temp_update'];
	$my_rev = $_SESSION['temp_rev'];
}
	
$temp_nick 	=	$_SESSION['temp_nick'];
$temp_id 	=	$_SESSION['temp_id'];
$temp_code 	=	$_SESSION['temp_code'];

$idx 		=	$_GET ['idx'];
$board 		=	$_GET['board'];

$today 		=	date('Y-m-d');
$full_today = 	date('Y-m-d H:i:s');

$temp_idx = "1288"; //20180831 �ش� ü���  Ÿ��Ʋ �� �� �׸� ����
	
if(!$board || !$idx){ //���ٱ���
	error_historyBack("�߸��� �����Դϴ�.");
	exit;
}
if(!$temp_code){  
	error_location("�α��� �Ŀ� �����Ͻ� �� �ֽ��ϴ�.","/main/index.php?board=login");
	exit;
}
//�ߺ����� üũ
$mission_check = " SELECT count(*) cnt FROM mission_review WHERE hero_old_idx = '".$idx."' AND hero_code = '".$temp_code."' ";
$mission_check_res = sql($mission_check);
$mission_check_rs = mysql_fetch_assoc($mission_check_res);


if($mission_check_rs["cnt"] > 0) {
	error_historyBack("�̹� ��û�ϼ̽��ϴ�.");
	exit;
}
	
$group_sql = " SELECT * FROM hero_group WHERE hero_board ='".$board."' "; //�޴� ����
$out_right_sql = @mysql_query($group_sql);
$right_list = @mysql_fetch_assoc($out_right_sql);

//�̼� ���� �� �����н� ��û��
$sql  = " SELECT * ,(select count(*) from mission_review where hero_superpass='Y' and hero_old_idx='".$_GET['idx']."') AS enrolled_superpass ";
$sql .= " FROM mission ";
$sql .= " WHERE hero_table = '".$_GET ['board']."' AND hero_idx='". $_GET ['idx']."' ";
if($my_level < 9999) $sql .= " AND hero_use = 1 ";
$sql_res = mysql_query($sql);
if(!$sql_res){
	logging_error($temp_nick, $board."-STEP_01_02", $full_today);
	error_historyBack("");
}
$out_row = mysql_fetch_assoc($sql_res);

$mission_board_type = false; //�ҹ�����, �̼� �����ϱ� Ÿ��
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

//210209 �������簡 �ִ��� Ȯ��
$survey_cnt = 0;
$sql_cnt_survey = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$out_row["hero_idx"]."' ";
$sql_cnt_res = sql($sql_cnt_survey);
$sql_cnt_rs = mysql_fetch_assoc($sql_cnt_res);
$survey_cnt = $sql_cnt_rs["cnt"];

$sql_survey  = " SELECT hero_idx, title, cont, image_cont, questionType, necessary, op1, op2 ";
$sql_survey .= " ,op3 ,op4 ,op5 ,op6 ,op7 ,op8 ,op9 ,op10 ";
$sql_survey .= " ,op11 ,op12 ,op13 ,op14 ,op15 ,op16 ,op17 ,op18, op19, op20 ";
$sql_survey .= " FROM mission_survey WHERE mission_idx = '".$out_row["hero_idx"]."' ORDER BY order_num ASC ";
$rs_survey = sql($sql_survey);

if($_GET ['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET ['board'] == 'group_04_28'){
	if($my_view < 9999){
		if($_GET['board'] == 'group_04_06'){
			if($out_row["hero_type"] == "7") {//�����̼�
				if($right_list['hero_view'] != $my_view && $_SESSION["before_beauty_auth"] != "Y") {
					error_historyBack("�˼��մϴ�. �� �̼��� ��ƼŬ�� ����� ������ �� �ֽ��ϴ�.");
					exit;
				}	
			} else {
				if($right_list['hero_view'] != $my_view) {
					error_historyBack("�˼��մϴ�. �� �̼��� ��ƼŬ�� ������� ������ �� �ֽ��ϴ�.");
					exit;
				}
			}
		}
		
		if($_GET['board'] == 'group_04_27'){
			if($out_row["hero_type"] == "7") {//�����̼�
				if($out_row["hero_movie_group"] == "group_04_27") {
					if($_SESSION["before_beautymovie_auth"] != "Y" && $my_view != "9995" ) {
						error_historyBack("�˼��մϴ�. �� �̼��� ��ƼŬ������ ����� ������ �� �ֽ��ϴ�.");
						exit;
					}
				} else if($out_row["hero_movie_group"] == "group_04_31") {
					if($_SESSION["before_lifemovie_auth"] != "Y" && $my_view != "9993") {
						error_historyBack("�˼��մϴ�. �� �̼��� ������Ŭ������ ����� ������ �� �ֽ��ϴ�.");
						exit;
					}
				}
			} else {
				if($right_list['hero_view'] != $my_view) {
					error_historyBack("�˼��մϴ�. �� �̼��� ü��� ��û�� ������ �� �����ϴ�.");
					exit;
				}
			}
		}
		
		if($_GET['board'] == 'group_04_28'){
			if($out_row["hero_type"] == "7") {//�����̼�
				if($right_list['hero_view'] != $my_view && $_SESSION["before_life_auth"] != "Y") {
					error_historyBack("�˼��մϴ�. �� �̼��� ������Ŭ�� ����� ������ �� �ֽ��ϴ�.");
					exit;
				}
			} else {
				if($right_list['hero_view'] != $my_view) {
					error_historyBack("�˼��մϴ�. �� �̼��� ������Ŭ�� ������� ������ �� �ֽ��ϴ�.");
					exit;
				}
			}
		}
	}
}
	
$hero_today_04_02 = substr($out_row["hero_today_04_02"],0,10);
$hero_today_03_02 = substr($out_row["hero_today_03_02"],0,10);
$last_today = $hero_today_04_02;
if($hero_today_04_02=="0000-00-00") {
	$last_today = $hero_today_03_02;
}

if($last_today < $today) {
	error_historyBack("�˼��մϴ�. ������ ü����Դϴ�.");
	exit;
} 

//�����н� ���� üũ �� ȸ������
$member_sql  = " SELECT *, (SELECT count(*) FROM superpass WHERE hero_code='".$_SESSION ['temp_code']."'  ";
$member_sql .= " AND hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as superpass_count ";
$member_sql .= " , (SELECT sum(hero_point) from point WHERE hero_code='".$_SESSION['temp_code']."') as total_user_point ";
$member_sql .= " , (SELECT sum(hero_order_point) FROM order_main WHERE hero_code='".$_SESSION['temp_code']."' AND hero_process!='".$_PROCESS_CANCEL."') as total_use_point";
$member_sql .= " FROM member WHERE hero_use = 0 AND hero_code = '".$_SESSION ['temp_code']."' ";

$member_res = sql($member_sql);
$member_rs = mysql_fetch_assoc($member_res);

if(!$member_rs["hero_info_ci"]){
	error_location("ü��ܿ� �����ϱ� ���ؼ��� ���������� �ʿ��մϴ�","/main/index.php?board=auth");
	exit;
}

//����������
$search_ftc_naver = $out_row["hero_ftc_naver"];
$search_ftc_naver = preg_replace("/\s+/","",$search_ftc_naver);
$search_ftc_naver = strtolower($search_ftc_naver);
$search_ftc_naver = urlEncode($search_ftc_naver);

$search_ftc_insta = $out_row["hero_ftc_insta"];
$search_ftc_insta = preg_replace("/\s+/","",$search_ftc_insta);
$search_ftc_insta = strtolower($search_ftc_insta);
$search_ftc_insta = urlEncode($search_ftc_insta);
	
if(!strcmp($_GET['type'], 'edit' )) { //������μ���
	
	$hero_address_save = $_POST['hero_address_save']; //�⺻ ����� ���� ����
	$delivery_point_yn = $_POST['delivery_point_yn']; //��ۺ� ������ ����
	
	//�ߺ� ��û Ȯ��
	$sql_ch  = " SELECT * FROM (select count(*) as count_registered from mission_review WHERE ";
	$sql_ch .= " hero_old_idx='".$idx."' and hero_code='" . $temp_code . "') as A ";
	$sql_ch .= ", (select hero_number from mission_review where hero_old_idx='".$idx."' order by hero_number desc limit 0,1) as B";
	$sql_ch_res = mysql_query ($sql_ch);

	if(!$sql_ch_res){
		logging_error($temp_nick, $board."-STEP_01_02", $full_today);
		error_historyBack("�����Դϴ�.");
		exit;
	}
	
	$sql_ch_rs = mysql_fetch_assoc($sql_ch_res);
	if ($sql_ch_rs ['count_registered'] != 0) {
		echo "<script>alert('ü��ܿ� �̹� �����ϼ̽��ϴ�');location.href='" . PATH_HOME . "?board=" . $_GET ['board'] . "&view=view&idx=" . $_GET ['idx'] . "';</script>";
		exit();
	}
	
	## drop_check
	#####################################################################################################################################################
	$drop_check = explode ( '||', $_POST ['hero_drop'] );
	foreach($drop_check as $drop_key => $drop_val) {
		unset ( $_POST [$drop_val] );
	}
	
	unset ($_POST["hero_blog_00"]);
	unset ($_POST["hero_blog_01"]);
	unset ($_POST["hero_blog_02"]);
	unset ($_POST["hero_blog_03"]);
	unset ($_POST["hero_blog_04"]);
	unset ($_POST["hero_blog_06"]);

	## auto increase check
	######################################################################################################################################################
	
	//(s)160321 ������ ���� �����н� ������� �߰�
	if($_POST['hero_superpass'] == 'Y') {
		$superpass_use_sql = " select hero_idx from superpass where ";
		$superpass_use_sql .= " hero_code = '".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00') ";
		$superpass_use_sql .= " order by hero_endday asc limit 0,1 ";

		$superpass_use_sql_res = mysql_query ($superpass_use_sql);
		
		if(!$superpass_use_sql_res){
			logging_error($temp_nick, $board."-STEP_01_02_01", $full_today);
			error_historyBack("");
			exit;
		}
		
		$superpass_use_sql_rs = mysql_fetch_assoc($superpass_use_sql_res);

		$update_superpass_use_sql = " update superpass set hero_use_yn = 'Y' where hero_idx = '".$superpass_use_sql_rs['hero_idx']."' ";
		$update_superpass_use_pf = mysql_query ($update_superpass_use_sql);
		
		if(!$update_superpass_use_pf){
			
			logging_error($temp_nick, $board."-STEP_01_02_02", $full_today);
			error_historyBack("");
			exit;
			
		}
	}
	//(e)160321 ������ ���� �����н� ������� �߰�		
	
	
	$idx_sql = "SHOW TABLE STATUS LIKE 'mission_review'";
	
	$out_idx_sql = mysql_query($idx_sql);
	if(!$out_idx_sql){
		logging_error($temp_nick, $board."-STEP_01_03", $full_today);
		error_historyBack("");
	}
	
	$idx_list                             = @mysql_fetch_assoc($out_idx_sql);
	
	$good_idx = $idx_list['Auto_increment'];
	
	
	## ���� ����
	#####################################################################################################################################################

	//�̼� ��û ���� ��ȣ ����
	if($sql_ch_rs['hero_number']==0)	$hero_number = 1;
	else								$hero_number = $sql_ch_rs['hero_number']+1;
			
	
			
	//�ҹ������϶� �ٸ� ���μ��� Ž
	//21-09-06 �̼������ϱ� �߰�
	if($mission_board_type) {
		$hero_code = $_POST['hero_code'];
		$hero_old_idx = $_POST['hero_old_idx'];
		$hero_table = $_POST['hero_table'];
		$hero_id = $_POST['hero_id'];
		$hero_name = $_POST['hero_name'];
		$hero_new_name = $_POST['hero_new_name'];
		$hero_nick = $_POST['hero_nick'];
		$hero_hp_01 = $_POST['hero_hp_01'];
		$hero_hp_02 = $_POST['hero_hp_02'];
		$hero_hp_03 = $_POST['hero_hp_03'];
		$hero_ip = $_POST['hero_ip'];
		$hero_03 = $_POST['hero_03'];
		$hero_address_01 = $_POST['hero_address_01'];
		$hero_address_02 = $_POST['hero_address_02'];
		$hero_address_03 = $_POST['hero_address_03'];
		$hero_superpass = $_POST['hero_superpass'] == ''?'N':$_POST['hero_superpass'];
		$hero_agree = $_POST['hero_agree'];
		$hero_title = $_POST['hero_title'];
		$hero_review = $_POST['hero_review'];
		$hero_group = $_POST['hero_group'];
		$hero_01 = $_POST['hero_01'];
		$hero_04 = $_POST['hero_04'];
		$hero_thumb = $_POST['hero_thumb'];
		
		$url = array();
		$gubun = array();
		$member_check = array();
		$admin_check = array();
		
		if($_POST["naver_url"]) {
			$url[] = $_POST["naver_url"];
			$gubun[] = "naver";
			$member_check[] = $_POST["naver_member_check"];
			$admin_check[] = !$_POST["naver_admin_check"] ? "N":$_POST["naver_admin_check"];
		}
		
		
		if($_POST["insta_url"]) {
			$url[] = $_POST["insta_url"];
			$gubun[] = "insta";
			$member_check[] = $_POST["insta_member_check"];
			$admin_check[] = !$_POST["insta_admin_check"] ? "N":$_POST["insta_admin_check"];
		}
		
		$movie_member_check_idx = 1;
		foreach($_POST["movie_url"] as $val) {
			if($val) {
				$url[] = $val;
				$gubun[] = "movie";
				$member_check[] = $_POST["movie_member_check".$movie_member_check_idx];
				$admin_check[] = "N";
			}
			$movie_member_check_idx++;
		}
		
		$cafe_member_check_idx = 1;
		foreach($_POST["cafe_url"] as $val) {
			if($val) {
				$url[] = $val;
				$gubun[] = "cafe";
				$member_check[] = $_POST["cafe_member_check".$cafe_member_check_idx];
				$admin_check[] = "N";
			}
			$cafe_member_check_idx++;
		}
		
		$etc_member_check_idx = 1;
		foreach($_POST["etc_url"] as $val) {
			if($val) {
				$url[] = $val;
				$gubun[] = "etc";
				$member_check[] = $_POST["etc_member_check".$etc_member_check_idx];
				$admin_check[] = "N";
			}
			$etc_member_check_idx++;
		}
		
		//�ҹ������ �ڵ����� ��÷����
		$sql = "INSERT INTO mission_review (hero_idx, hero_code, hero_old_idx, hero_table, hero_number, hero_id, hero_name, hero_new_name, hero_nick, hero_write_date";
		$sql .= ", hero_hp_01, hero_hp_02, hero_hp_03, hero_today, hero_ip, hero_03,  hero_address_01, hero_address_02, hero_address_03, hero_superpass, hero_agree, delivery_point_yn ";
		$sql .=	", lot_01)";
		$sql .= "VALUES (".$good_idx.", '".$hero_code."', '".$hero_old_idx."', '".$hero_table."',".$hero_number.", '".$hero_id."', '".$hero_name."'";
		$sql .= ",'".$hero_new_name."', '".$hero_nick."',now(), '".$hero_hp_01."', '".$hero_hp_02."', '".$hero_hp_03."', now(), '".$hero_ip."'";
		$sql .= ", '".$hero_03."', '".$hero_address_01."', '".$hero_address_02."', '".$hero_address_03."', '".$hero_superpass."', '".$hero_agree."', '".$delivery_point_yn."' ";
		$sql .= ",1) ";
		
		$mission_review_pf = mysql_query ( $sql );
		$mission_review_idx = 0;
		
		if(!$mission_review_pf){
			
			logging_error($temp_nick, $board."-STEP_01_04", $full_today);
			error_historyBack("");
			exit;
			
		} else {
			$mission_review_idx = mysql_insert_id();
		}
		

		// ���������
		$idx_sql = "SHOW TABLE STATUS LIKE 'board'";
		$out_idx_sql = mysql_query($idx_sql);
		if(!$out_idx_sql){
			logging_error($temp_nick, $board."-MISSION_ACTION_03_07", $full_today);
			error_historyBack("");
		}
	
		$idx_list                             = @mysql_fetch_assoc($out_idx_sql);
		$idx = $idx_list['Auto_increment'];

		if($hero_thumb_img){
			$sql_one_write .= ", hero_thumb";
			$sql_two_write .= ", '".$hero_thumb_img."'";
		}


		$sql  = " INSERT INTO board (hero_idx, hero_code, hero_table, hero_title, hero_name ";
		$sql .= " , hero_nick, hero_today, hero_ip, hero_review, hero_01 ";
		$sql .= " , hero_03, hero_04, hero_thumb, hero_agree ) VALUES ";
		$sql .= " ('".$idx."', '".$hero_code."', '".$hero_table."', '".$hero_title."', '".$hero_name."' ";
		$sql .= " , '".$hero_nick."', now(), '".$hero_ip."', '".$hero_review."', '".$hero_01."' ";
		$sql .= " , '".$hero_group."', '".$hero_04."', '".$hero_thumb."', '".$hero_agree."') ";

		$pf = mysql_query($sql);
		if(!$pf){
			logging_error($temp_nick, $board."-MISSION_ACTION_03_08", $full_today);
			error_historyBack("");
			exit;
		}
		
		//SNS ���
		for($i=0; $i<count($url); $i++) {
			$gubun_val = $gubun[$i];
			$url_val = $url[$i];
			$member_check_val = $member_check[$i];
			$admin_check_val = $admin_check[$i];
				
			$url_sql  = " INSERT INTO mission_url (board_hero_idx, gubun, url, member_check, admin_check) VALUES ";
			$url_sql .= " ('".$idx."','".$gubun_val."','".$url_val."','".$member_check_val."','".$admin_check_val."') ";
			sql($url_sql);
		}
		
	} else {
		$sql_one = "hero_idx, hero_number ";
		$sql_two = $good_idx.", ".$hero_number;
		
		foreach($_POST as $post_key => $post_val) {
			if($post_key != "survey_idx" && strpos($post_key, "answer_") === false) { //�������� ���� ����
				$sql_one .= ", ".$post_key;
				$sql_two .= ", '".$_POST [$post_key]."'";
			}
		}
		
		$sql = "INSERT INTO mission_review (" . $sql_one . ",hero_write_date) VALUES (" . $sql_two . ",now())";
					
		$mission_review_pf = mysql_query ( $sql );
		$mission_review_idx = 0;
		
		if(!$mission_review_pf){
			
			logging_error($temp_nick, $board."-STEP_01_04", $full_today);
			error_historyBack("");
			exit;
		} else {
			$mission_review_idx = mysql_insert_id();
		}
	
	}
	

	//����Ʈ �ο� �� ������//���̺�, Ÿ��, �۹�ȣ, �����ȣ, ����, �ִ�����Ʈ ���Կ���, ��¥
	######################################################################################################################################################
	// " ' "���� ���� 160912
	
	if($mission_review_idx > 0) {
		$title01 = str_replace("'", "`", $out_row['hero_title']);
		//�Խ��Ǹ�, ����ƮŸ��, �Խñ۹�ȣ, ��۹�ȣ, ����, ����Ʈ���ѿ���
		$point_rs = pointAdd($board, "mission_application", 0, $idx, $good_idx, $title01, "Y" );
		
		//��ۺ����� 2021-03-26
		if($delivery_point_yn == "Y") {
			deliveryPoint($_POST["hero_old_idx"], $member_rs["hero_id"], $member_rs["hero_code"], $member_rs["hero_name"], $member_rs["hero_nick"], $_DELIVERY_POINT);
		}
		
		/* 210818 �ʿ���� ���� �ӵ� ������ ������� �ʾ����� ������ ����
		if($point_rs!=1){
		
			$rollback_query = "delete from mission_review where hero_idx='".$good_idx."'";
			//echo $rollback_query;
			$pf_rollback = mysql_query($rollback_query);
			if(!$pf_rollback){
				logging_error($temp_nick, $board."-STEP_01_05", $full_today);
			}
			error_historyBack("");
			//
			exit;
		}
		*/
		
		//�⺻ �ּ� ����
		######################################################################################################################################################
		if(!$member_rs["hero_address_02"] || $hero_address_save=='1'){
			$infoedit_sql = "UPDATE member SET hero_address_01='".$_POST['hero_address_01']."', hero_address_02='".$_POST['hero_address_02']."', hero_address_03='".$_POST['hero_address_03']."', hero_hp='".$_POST['hero_hp_01']."-".$_POST['hero_hp_02']."-".$_POST['hero_hp_03']."' WHERE hero_code='".$_SESSION['temp_code']."'";
			@mysql_query($infoedit_sql);
		}
		
		//�������� 210215
		$survey_idx = $_POST["survey_idx"];
		if(count($survey_idx) > 0) {
			for($i = 0; $i < count($survey_idx); $i++) {
				
				$answer_arr = $_POST["answer_".$survey_idx[$i]];
				$answer = "";
                
				if(count($answer_arr) > 0) {
					for($k = 0; $k < count($answer_arr); $k++) {
						if($k > 0) $answer .= ",";
						$answer .= $answer_arr[$k];
					}
				} else {
					$answer = $answer_arr[0];
				}
				
				$sql_survey = " INSERT into mission_survey_answer (mission_review_idx, survey_idx, answer, hero_code) VALUES ('".$mission_review_idx."','".$survey_idx[$i]."','".$answer."','".$_SESSION["temp_code"]."') ";
				@mysql_query($sql_survey);
			}
		}
		
		location(PATH_HOME . '?board='.$_GET ['board'] . '&view=view&idx=' . $_GET ['idx']);
		exit;
	}
}//��� ���μ���
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<div class="contents" id="write_mode">
	<? if($idx == $temp_idx) {?>
		<p class="titleText fw500 main_c">�̺�Ʈ ��û�ϱ�</p>
	<? } else { ?>
		<p class="titleText fw500 main_c">ü��� ��û�ϱ�</p>
	<? } ?>
	<div class="bread">
		<ul class="f_sc">
			<? if( $mission_board_type || ($mission_board_type == false && $out_row["hero_question_url_yn"] != "N") ){?>
			<li class="joinstep on">Step.</li>
			<li class="join_arr arr on"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
			<? } ?>
			<li class="joinstep">Step.</li>
			<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
			<li class="joinstep">Step.</li>
		</ul>
	</div>
	<form name="form_next" action="<?=PATH_HOME_HTTPS.'?'.get('','type=edit');?>" method="post"	enctype="multipart/form-data" onsubmit="return false;">
	<input type="hidden" name="hero_drop" value="hero_drop||hero_address_save" /> 
	<input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>"> 
	<input type="hidden" name="hero_old_idx" value="<?=$_GET['idx'];?>"> 
	<input type="hidden" name="hero_table" value="<?=$_GET['board'];?>"> 
	<input type="hidden" name="hero_name" value="<?=$_SESSION['temp_name'];?>">
	<input type="hidden" name="hero_nick" value="<?=$_SESSION['temp_nick'];?>"> 
	<input type="hidden" name="hero_id" value="<?=$_SESSION['temp_id'];?>"> 
	<input type="hidden" name="hero_today" value="<?=Ymdhis?>"> 
	<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
	<input type="hidden" name="hero_03" id="hero_03" value="">
	<input type="hidden" name="hero_multiple" id="hero_multiple" value="">
	<input type="hidden" name="hero_single" id="hero_single" value="">
	<? if($mission_board_type) { ?>
		<input type="hidden" name="hero_review" value="<?=$_SESSION['temp_code'];?>">
		<input type="hidden" name="hero_review_count" value="0">
		<input type="hidden" name="hero_notice" value="1">
		<input type="hidden" name="hero_type" value="<?=$out_row['hero_type']?>" />
		<input type="hidden" name="hero_01" value="<?=$_GET['idx']?>" />
		<input type="hidden" name="hero_group" value="<?=$_GET['board']?>" />
	<? }else { ?>
		<input type="hidden" name="hero_01" id="hero_representative_blog" value="" />
	<? } ?>
	<div class="stepbox">
	<? if( $mission_board_type || ($mission_board_type == false && $out_row["hero_question_url_yn"] != "N") ){?>
	<div class="step step01">
		<p class="fz15 fw600 main_c step_count">step.</p>
		<?
		$number=1;
		if($mission_board_type == false && $out_row["hero_question_url_yn"] != "N"){ //Ÿ��(�ҹ�����) �ƴѰ��
		?>
		<dl class="sns_input_bx">  
			<dt></dt>
			<dd>
				<? if($idx != $temp_idx) {?>
				<ul>
					<li>
						<span class="fz19 fw600 li_tit">SNS ������ �Է����ּ���.</span>
						<? if($out_row['hero_question_url_check'] == "1") {?>
							<span class=txt_emphasis_12>* ���̹� ��α� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
						<? } else if($out_row['hero_question_url_check'] == "2") {?>
							<span class="txt_emphasis_12">* �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
						<? } else if($out_row['hero_question_url_check'] == "3") {?>
							<span class="txt_emphasis_12">* ���̹� ��α�/�ν�Ÿ�׷� URL �� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
						<? } else if($out_row['hero_question_url_check'] == "4") {?>
							<span class="txt_emphasis_12">* ���̹� ��α�, �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
						<? } else if($out_row['hero_question_url_check'] == "5") {?>
							<span class="txt_emphasis_12">* ���� ä��(��Ʃ��, ���̹�TV, ƽ��, ��Ÿ ��) URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
						<? } else if($out_row['hero_question_url_check'] == "6") {?>
							<span class="txt_emphasis_12">* ���̹� ��α�/�ν�Ÿ�׷�/���� ä��(��Ʃ��, ���̹�TV, ƽ��, ��Ÿ ��)<br /> URL �� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.</span>
						<? } ?>
					</li>
				</ul>
				<ul class="sns_input">
				<?
					$hero_question_url_list = explode("/////",$out_row['hero_question_url_list']);
					$i = 0;
					foreach($hero_question_url_list as $key => $value) {
						$blog_id = "";
						switch ($value) {
						case "��α�":
							$blog_id = "hero_blog_00";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL : </span>
								<div>&nbsp;&nbsp;https://blog.naver.com/<input type="text" maxlength="25" id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=str_replace("https://blog.naver.com/", "", $member_rs["{$blog_id}"]);?>" placeholder="���̹� ID �Ǵ� ��α� ID�� �Է����ּ���."></div>
							</li>
							<? 
						break;
						
						case "�ν�Ÿ�׷�":
							$blog_id = "hero_blog_04";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL :</span>
								<div>&nbsp;&nbsp;https://www.instagram.com/<input type="text" maxlength="25" id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=str_replace("https://www.instagram.com/", "", $member_rs["{$blog_id}"]);?>" placeholder="�ν�Ÿ�׷� ID�� �Է����ּ���."></div>
							</li>
							<? 
						break;
						
						case "���̽���":
							$blog_id = "hero_blog_01";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL :</span>
								<div><input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)"></div>
							</li>
							<? 
						break;
						
						case "Ʈ����":
							$blog_id = "hero_blog_02";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL :</span>
								<div><input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)"></div>
							</li>
							<? 
						break;
						
						case "īī�����丮":
							$blog_id = "hero_blog_06";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL :</span>
								<div><input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)"></div>
							</li>
							<? 
						break;
						
						case "�� ��":
							$blog_id = "hero_blog_05";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL :</span>
								<div><input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)"></div>
							</li>
							<? 
						break;
						
						case "���� ä��":
							$blog_id = "hero_blog_03";
							?>
							<li>
								<span><?=$value=="��α�" ? "���̹� ��α�":$value?> URL :</span>
								<div><input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="SNS URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)"></div>
							</li>
							<? 
						break;
						}
					$i++;
					} 
				?>
				</table>
				<? } else { ?>
					<ul>
						<li class="fz26 fw500">�� �Ʒ� ������ �Է��� �ּ���.</li>
					</ul>
				<? } ?>         
			</dd>
		</dl>		
		<div class="btn_bx f_c">
			<div class="btn_submit btn_black" onClick="stepOneChk(document.form_next)">��������</div>
		</div>
		<? } ?>
		<!------------------- �ҹ����� �� ------------------------------>
		<? if($mission_board_type){?>

			<!-- 250219 �ҹ����� ������ ���� -->
			<div class="sns_input_bx rumor_box">
				<ul class="sns_input">
					<li>
						<span class="required">����</span>
						<div><input type="text" name="hero_title" id="hero_title" title="����" style="width:480px"/></div>
					</li>
					<li>
						<span>�ۼ���</span>
						<div><?=$_SESSION['temp_nick'];?></div>
					</li>
					<li>
						<span class="required">��ǥ�̹���</span>
						<div>
							<div id="present_image_area">
								<? if($hero_thumb){ ?>
									<img src="<?=$hero_thumb?>" style="width:200px;margin-top:10px;"><br/>
								<? } ?>
							</div>
							<label for="write_hero_thumb" id="link" class="btnUpload">���� ���ε�</label>
							<input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$hero_thumb?>"/>
							<span style="color:#ff0000">* 10MB ���Ϸ� ���ε��� �ּ���.</span>
						</div>
					</li>
					<!-- 250224 ���� ���� �߰� -->
                    <li class="sns_tit">
                        <p class="fz19 fw600 li_tit">SNS ������ �Է����ּ���.</p>
                        <span class="txt_emphasis_12">
                            <?php
                                $message = '';

                                if ($out_row['hero_question_url_check'] == '1') { // ���̹���α�
                                    $message = '* ���̹���α� URL�� �ʼ��� �Է��ϼž� �մϴ�.';
                                } elseif ($out_row['hero_question_url_check'] == '2') {  // �ν�Ÿ�׷�
                                    $message .= '* �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.';
                                } /*elseif ($out_row['hero_question_url_check'] == '5') { // �ı�(����)
                                    $message .= '* ����ä��(��Ʃ��, ���̹�TV, ƽ��, ��Ÿ ��) URL�� �ʼ��� �Է��ϼž� �մϴ�.';
                                }*/ elseif ($out_row['hero_question_url_check'] == '3') {  // ���̹� ��α� or �ν�Ÿ�׷�
                                    $message = '* ���̹���α�/�ν�Ÿ�׷� URL�� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.';
                                } elseif ($out_row['hero_question_url_check'] == '4') {  // ���̹� ��α� and �ν�Ÿ�׷�
                                    $message = '* ���̹���α�/�ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.';
                                } /*elseif ($out_row['hero_question_url_check'] == '6') {  // ���̹� ��α� or �ν�Ÿ�׷� or �ı�(����)
                                    $message = '* ���̹���α�/�ν�Ÿ�׷�/����ä��(��Ʃ��, ���̹�TV, ƽ��, ��Ÿ ��) URL�� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.';
                                }*/

                                if ($message) { echo $message; }
                            ?>
                        </span>
                    </li>
					<li>
						<!-- <span class="">
							<? if(strpos($out_row["hero_question_url_list"],"��α�") !== false) { ?>
								<span class="txt_emphasis">*</span>
							<? } ?>
							���̹� ��α�
						</span> -->

                        <!--<span class="<?php /*= (strpos($out_row["hero_question_url_list"], "��α�") !== false) ? 'required' : '' */?>">
							���̹� ��α�
						</span>-->
                        <span>
							���̹� ��α�
						</span>
						<div>
							<input type="text" name="naver_url" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl2"/>
							<input type="hidden" name="naver_admin_check" id="naver_admin_check" />
							<? if($out_row["hero_ftc"] == "1") {?>
								<a href="javascript:;" onClick="fnAdminCheck('naver')" class="btnUrlCheck">����������Ȯ��</a> 	
								<p class="txt_url_check" id="txt_naver_url_check"></p>
							<? } ?>
							<dl class="urlAgreeBox urlAgreeBoxType2">
								<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
								<dd><div class="input_radio"><input type="radio" name="naver_member_check" id="naver_member_check_Y" value="Y"/><label for="naver_member_check_Y">��</label></div>
									<div class="input_radio"><input type="radio" name="naver_member_check" id="naver_member_check_N" value="N"/><label for="naver_member_check_N">�ƴϿ�</label></div>
								</dd>
							</dl>
							<p class="txt_agree_info mgb5">
								�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK Lover Ȱ���� �������� ���� �� �ֽ��ϴ�.
							</p>
						</div>
					</li>
					<li>
						<!--<span class="<?php /*= (strpos($out_row["hero_question_url_list"], "�ν�Ÿ�׷�") !== false) ? 'required' : '' */?>">
							�ν�Ÿ�׷�
						</span>-->
                        <span>
							�ν�Ÿ�׷�
						</span>
						<div>
							<input type="text" name="insta_url" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl2"/>
							<input type="hidden" name="insta_admin_check" id="insta_admin_check" />
							<? if($out_row["hero_ftc"] == "1") {?>
								<a href="javascript:;" onClick="fnAdminCheck('insta')" class="btnUrlCheck">����������Ȯ��</a> 	
								<p class="txt_url_check" id="txt_insta_url_check"></p>
							<? } ?>	
							<dl class="urlAgreeBox urlAgreeBoxType2">
								<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
								<dd><div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_Y" value="Y"/><label for="insta_member_check_Y">��</label></div>
									<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_N" value="N"/><label for="insta_member_check_N">�ƴϿ�</label></div>
								</dd>
							</dl>
							<p class="txt_agree_info mgb5">
								�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK Lover Ȱ���� �������� ���� �� �ֽ��ϴ�.
							</p>
						</div>
					</li>
					<? if($_GET['board'] == 'group_04_27'){ //������ ���������� ���X ?>
						<li>
							<span>�ı�(����)</span>
							<div>
								<div class="ui_urlBox">
									<div class="ui_url">
										<input type="text" name="movie_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4"/>
										<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 	
										<dl class="urlAgreeBox urlAgreeBoxType2">
											<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
											<dd><div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_Y" value="Y"/><label for="movie_member_check1_Y">��</label></div>
												<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check2_N" value="N"/><label for="movie_member_check2_N">�ƴϿ�</label></div>
											</dd>
										</dl>
										<p class="txt_agree_info mgb5">
											�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK Lover Ȱ���� �������� ���� �� �ֽ��ϴ�.
										</p>
									</div>
								</div>
							</div>
						</li>
					<? } ?>
					<li>
						<span>ī��</span>
						<div>
							<div class="ui_urlBox">
								<div class="ui_url">
									<input type="text" name="cafe_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4"/>
									<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 	
									<dl class="urlAgreeBox urlAgreeBoxType2">
										<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
										<dd><div class="input_radio"><input type="radio" name="cafe_member_check1" id="cafe_member_check1_Y" value="Y"/><label for="cafe_member_check1_Y">��</label></div>
											<div class="input_radio"><input type="radio" name="cafe_member_check1" id="cafe_member_check1_N" value="N"/><label for="cafe_member_check1_N">�ƴϿ�</label></div>
										</dd>
									</dl>
									<p class="txt_agree_info mgb5">
										�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK Lover Ȱ���� �������� ���� �� �ֽ��ϴ�.
									</p>
								</div>
							</div>
						</div>
					</li>
					<li>
						<span>��Ÿ</span>
						<div>
							<div class="ui_urlBox">
								<div class="ui_url">
									<input type="text" name="etc_url[]" placeholder="�ݵ�� ������ URL�� �Է����ּ���.(http:// �Ǵ� https://�ʼ� �Է�)" class="inputUrl4"/>
									<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 	
									<dl class="urlAgreeBox urlAgreeBoxType2">
										<dt>�� �����ŷ�����ȸ ������ �ۼ��Ͽ����ϱ�?</dt>
										<dd><div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_Y" value="Y"/><label for="etc_member_check1_Y">��</label></div>
											<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_N" value="N"/><label for="etc_member_check1_N">�ƴϿ�</label></div>
										</dd>
									</dl>
									<p class="txt_agree_info mgb5">
										�� �����ŷ�����ȸ�� ����õ���� � ���� ǥ�ñ��� �ɻ���ħ�� �Ǵ� �����ڻ�ŷ� ����� �Һ��ں�ȣ�� ���� �������� ���� �ʼ� �����������, �ۼ����� ���� ��� AK Lover Ȱ���� �������� ���� �� �ֽ��ϴ�.
									</p>
								</div>
							</div>
						</div>
					</li>
				</ul>		
				<div class="infoBox">
					<p class="txt_info">
					�� AK Lover���� ����Ǵ� ��� ü����� �����ŷ�����ȸ ǥ�ñ���� ��ħ�� ���� ��ǰ�� �����޾� �ı⸦ �ۼ��Ͻ� ���, �밡�� ���θ� ǥ���ϴ� ���� ������ ��Ģ���� �ϰ� �ֽ��ϴ�.<br/>
					<span class="txt_subInfo">
					�� ���̹� ��α�, �ν�Ÿ�׷� URL�� 1���� ��� �����ϸ�, �ı�(����), ī��, ��Ÿ URL�� �ִ� 5������ ����� �����մϴ�.<br/>
					�� ��Ÿ����  Ʈ����, īī�����丮, ���̽��� �� URL�� �Է��մϴ�.
					</span>
					</p>
				</div>
			</div>

		<!-- //���ø� ���� -->
		<script src="/js/jquery.form.js"></script>
		<script type="text/javascript">
			var clipboard_naver = new Clipboard('.btn_clip_naver');
			clipboard_naver.on('success', function(e) {
				alert("���̹���α� ������������ ���� �Ǿ����ϴ�.");
			});
			
			clipboard_naver.on('error', function(e) {
				console.log(e);
			});
			
			var clipboard_insta = new Clipboard('.btn_clip_insta');
			clipboard_insta.on('success', function(e) {
				alert("�ν�Ÿ�׷� ������������ ���� �Ǿ����ϴ�.");
			});
			
			clipboard_insta.on('error', function(e) {
				console.log(e);
			});

			// �ʼ� URL radio �ڽ� ���õ� �ɼ� active
			function checkRadio() {
				var value = document.querySelector('input[name="required_check"]:checked').value;
				const radioContents = document.querySelectorAll(".urlRadioItem");

				// ��� �׸��� notSelected ���·� �ʱ�ȭ
				radioContents.forEach(item => item.classList.add("notSelected"));

				const selectedContent = document.querySelector(`.urlRadioItem[data-required="${value}"]`);
				if (selectedContent) {
					selectedContent.classList.remove("notSelected");
				}
			}
			
			$(document).ready(function(){
				<? if($out_row["hero_ftc"]=="1") {?>
					$("input[name='naver_url']").on("keyup",function(){
						fnAdminCheckCancel("naver");
					})
					
					$("input[name='insta_url']").on("keyup",function(){
						fnAdminCheckCancel("insta");
					})
				<? } ?>

				fnAdminCheckCancel = function(gubun) {
					if(gubun == "naver") {
						$("#naver_admin_check").val("N");
						$("#txt_naver_url_check").html("");
					} else if(gubun == "insta") {
						$("#insta_admin_check").val("N");
						$("#txt_insta_url_check").html("");
					}
				}

				fnAdminCheck = function(gubun) {
					var search_keyword = "";
					
					if(gubun == "naver") {
						var param = "mode=naver_url_check&naver_url="+$("input[name='naver_url']").val()+"&search_keyword=<?=$search_ftc_naver?>";
						if(!$("input[name='naver_url']").val()) {
							alert("���̹� ��α׸� �Է����ּ���.");
							$("input[name='naver_url']").focus();
							return;
						}
					} else if(gubun == "insta") {
						var param = "mode=insta_url_check&insta_url="+$("input[name='insta_url']").val()+"&search_keyword=<?=$search_ftc_insta?>";
						if(!$("input[name='insta_url']").val()) {
							alert("�ν�Ÿ�׷�  URL�� �Է����ּ���.");
							$("input[name='insta_url']").focus();
							return;
						}
					}

					$.ajax({
						url:"/main/sns_url_check.php"
						,data:param
						,type:"POST"
						,dataType:"html"
						,success:function(d){
							if(d=="success") {
								if(gubun == "naver") {
									$("#naver_admin_check").val("Y");
									$("#txt_naver_url_check").addClass("txt_success");
									$("#txt_naver_url_check").html("������������ Ȯ�εǾ����ϴ�.");
								} else if(gubun == "insta") {
									$("#insta_admin_check").val("Y");
									$("#txt_insta_url_check").addClass("txt_success");
									$("#txt_insta_url_check").html("������������ Ȯ�εǾ����ϴ�.");
								}
							} else {
								if(gubun == "naver") {
									var html  = "������ ���� ���ۼ��� �ı� ����� �Ұ��մϴ�.";
									html += "<br/>�ݵ��, �Ʒ� ���� �״�� ������ �ϴܿ� ���� ��Ź�帳�ϴ�.<br/>";
									html += '<span style="color:#000; line-height:24px;"><?=$out_row["hero_ftc_naver"]?> <a href="javascript:;" class="btn_copy btn_clip_naver" data-clipboard-text="<?=$out_row['hero_ftc_naver']?>">���������� �����ϱ�</a></span>';
									
									$("#naver_admin_check").val("N");
									$("#txt_naver_url_check").removeClass("txt_success");
									$("#txt_naver_url_check").html(html);
								} else if(gubun == "insta") {
									var html  = "������ ���� ���ۼ��� �ı� ����� �Ұ��մϴ�.";
										html += "<br/>�ݵ��, �Ʒ� ���� �״�� ������ ��ܿ� ���� ��Ź�帳�ϴ�.<br/>";
										html += '<span style="color:#000; line-height:24px;"><?=$out_row["hero_ftc_insta"]?> <a href="javascript:;" class="btn_copy btn_clip_insta" data-clipboard-text="<?=$out_row['hero_ftc_insta']?>">���������� �����ϱ�</a></span>';
									
									$("#insta_admin_check").val("N");
									$("#txt_insta_url_check").removeClass("txt_success");
									$("#txt_insta_url_check").html(html);
								}
							}
						},error:function(e) {
							console.log(e);
						}
					})
				}
				
				fnUrl = function(t,type) {
					if(type == "add"){
						var html = "<div class='ui_url'>"+$(t).parents(".ui_url").html()+"</div>";
						var ui_urlBox = $(t).parents(".ui_urlBox");
						var idx = ui_urlBox.children("div").length+1;
						html = html.replace("+","-");
						html = html.replace(/add/gi,"minus");
						html = html.replace(/member_check1/gi,"member_check"+idx);
						var ui_url_limit_ea = 5;
						if(ui_urlBox.children("div").length < ui_url_limit_ea) {
							ui_urlBox.append(html);
						} else {
							alert("�ִ� 5������ ��� �����մϴ�.");
							return;
						}
					} else if(type == "minus"){
						var ui_urlBox = $(t).parents(".ui_url");
						ui_urlBox.remove();
					}
				}
				
				$("#write_hero_thumb").change(function(){
					var file = this;
					var filename = $(this).val();
					var maxSize  = 10 * 1024 * 1024    //10MB
					var fileSize = 0;
					var browser=navigator.appName;
					var tf_extension = extension_check(filename,"image");

					if(tf_extension==false){
						$(this).val("");
						return false;
					}

					// �ͽ��÷η��� ���
					if (browser=="Microsoft Internet Explorer") {
						var oas = new ActiveXObject("Scripting.FileSystemObject");
						fileSize = oas.getFile( filename ).size;
					} else {
						fileSize = file.files[0].size;
					}

					if(maxSize < fileSize) {
						alert("�̹��� �뷮�ʰ��Դϴ�.\n10MB���Ϸ� ���ε带 ������ �ּ���.");
						return false;
					}
						
					var options = {
									success: function(data){
										if(data=='0'){
											alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
											return false;
										} else {
											$("#present_image_area").html("<img src='"+data+"' style='margin:10px 0;'/>");
											data = trim(data);
											$("#hero_thumb").val(data);
										}
									},beforeSend:function(){
										$('.img-loading').css('display','block');
									},complete:function(){
										$('.img-loading').css('display','none');
									},error:function(e){  
										alert("�˼��մϴ�. �̹��� ���ε� �����Դϴ�. �ٽ� �õ����ּ���. ���� ������ �ݺ��� ��� �����Ϳ� �������ּ���.");
										return false;
									} 
								};
					$('#write2_file_upload').ajaxForm(options).submit();
				});                        
			});
			</script>			
			<div class="btn_bx f_c">
				<div class="btn_submit btn_black" onClick="stepAlertChk(document.form_next)">��������</div>
			</div>
		<? } ?>
		<!-------------------------- �ҹ����� �� �� --------------------------->
	</div>		
	<? } ?>
	<div class="step step02" style="">		
		<p class="fz15 fw600 main_c step_count">step.</p>
		<ul class="sns_input_bx">
			<li><span class="fz19 fw600 li_tit">�ʼ� Ȯ�� ������ üũ���ּ���.</span></li>
		</ul>
		<ul class="sns_input_bx require_box">
		<? if($survey_cnt > 0) {?>
			<li>
				<?
					$survey_num = 1;
					while($row_survey = mysql_fetch_assoc($rs_survey)){ ?>
					<input type="hidden" name="survey_idx[]" value="<?=$row_survey['hero_idx']?>">
					<div class="survey">
						<p class="title">
							<?if($row_survey["necessary"] == "Y") {?>[�ʼ�]<?}?>
							<span class="number">0<?=$survey_num?>.<?=$row_survey["title"]?></span>
						</p>
						
						<div class="exBox">
							<p><?=nl2br($row_survey["cont"])?></p>
							<? if($row_survey["image_cont"]) {?>
								<p class="img"><img src="/user/survey/<?=$out_row["hero_idx"]?>/<?=$row_survey["image_cont"]?>" /></p>
							<? } ?>
						</div>						
						<div class="answerBox">
							<? if($row_survey["questionType"] == "1") {?>
							<textarea name="answer_<?=$row_survey['hero_idx']?>[]" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>����"<?}?>></textarea>
							<? } else if($row_survey["questionType"] == "2") {?>
								<? for($z=1; $z<=20; $z++) {?>
									<? if($row_survey["op".$z]) { 
										if($z > 1) echo "<br/>";
									?>
									<div class="input_radio"><input type="radio" name="answer_<?=$row_survey['hero_idx']?>[]" id="answer_<?=$survey_num?>_<?=$z?>" value="<?=$row_survey["op".$z]?>" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>����"<?}?> /> <label for="answer_<?=$survey_num?>_<?=$z?>"><?=$row_survey["op".$z]?></label></div>
									<? } ?>
								<? } ?>
							<? } else if($row_survey["questionType"] == "3") {?>
								<? for($z=1; $z<=20; $z++) {?>
									<? if($row_survey["op".$z]) { 
										if($z > 1) echo "<br/>";
									?>
									<div class="input_chk"><input type="checkbox" name="answer_<?=$row_survey['hero_idx']?>[]" id="answer_<?=$survey_num?>_<?=$z?>" value="<?=$row_survey["op".$z]?>" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>����"<?}?>/> <label for="answer_<?=$survey_num?>_<?=$z?>" class="input_chk_label"><?=$row_survey["op".$z]?></label></div>
									<? } ?>
								<? } ?>	
							<? } ?>
						</div>
					</div>
				<? 
					$survey_num++;
					} 
				?>
			</li>
		<? } ?>	
		<? if($out_row['hero_type'] != 1) { ?>
			<li>
				<div class="agree">
					<div class="title">[�ʼ�] <span class="number">������ Ȱ�� ����</span></div>
					<ul>
						<li class="agree_cont fz13 fw500">
							AK Lover Ȱ���� ��ȯ���� �ۼ��� ��� ������(���۹�)�� ���õ� �Ǹ�(���۱�, �ʻ�� ��)�� AK Lover
							Ȱ������ ������ ��/���� ������ǰ �� �귣�� ������Ʈ, Ȩ���� ���, �¶���/�������� ����, ��Ÿ ����, ȫ�� �� ������ �ڷ�� AK Lover Ȱ�� ��,
							Ȱ���� ����� �Ŀ��� ������ ���� öȸ �ǻ縦 ������ ������ �������� �����Ӱ� �̿��� �Ǹ� �� 2���� ���۹� �ۼ����� �ְ����߿� ����ϸ� �̿� �����մϴ�.<br/>
						</li>
						<li class="agreechk">
							<div>
								<p class="fz15 fw600">�� ���뿡 �����Ͻʴϱ�?</p>
								<p class="fz14 fw500">
									<? if($out_row['hero_type'] == 2) { ?>
										* ������ Ȱ�� �� ���� �� �ҹ����� ������ �Ұ��մϴ�.
									<? } else if($out_row['hero_type'] == 10) { ?>
										* ������ Ȱ�� �� ���� �� ü��� ������ �Ұ��մϴ�.
									<? } else { ?>
										* ������ Ȱ�� �� ���� �� ü��� ��û�� �Ұ��մϴ�.
									<? } ?>
								</p>
							</div>
							<div class="input_chk"><input type="checkbox" name="hero_agree" id="hero_agree" value='Y'><label for="hero_agree" class="input_chk_label">Ȯ��</label></div>
						</li>
					</ul>
				</div>
			</li>
		<? } ?>			
		</ul>
		<div class="btn_bx f_c">
			<? if( $mission_board_type || ($mission_board_type == false && $out_row["hero_question_url_yn"] != "N") ){?>
			<div class="btn_submit btn_gray btn_prv">��������</div>
			<? } ?>
			<div class="btn_submit btn_black" onClick="stepTwoChk(document.form_next)">��������</div>
		</div>
	</div>		
	<div class="step step03 mu_support" style="">		
		<p class="fz15 fw600 main_c step_count">step.</p>		
		<ul class="sns_input_bx">
			<li><span class="fz19 fw600 li_tit">�ʼ� �׸��� �Է����ּ���.</span></li>
		</ul>						
		<dl class="address_box">
			<dt>�����ô� �� ���� �Է�</dt>
			<dd>
				<ul>
					<!-- <? if($idx == $temp_idx) {
						if($out_row['hero_type'] != 8) {?>
						<li class="c_orange">(�ʼ�) �̺�Ʈ ��ǰ�� ��� ���� �ּҸ� �Է����ּ���.</li>
					<? } else { ?>
						<li class="c_orange">(�ʼ�) ����Ʈ ü��� ������ �����Ͻ� �޴��� ��ȣ�� �Է����ּ���.</li>
					<? } ?>
					<? } else { 
						if($out_row['hero_type'] != 8) {?>
						<li class="c_orange">(�ʼ�) ü��� ��ǰ�� ��� ���� �ּҸ� �Է����ּ���.</li>
					<? } else { ?>
						<li class="c_orange">(�ʼ�) ����Ʈ ü��� ������ �����Ͻ� �޴��� ��ȣ�� �Է����ּ���.</li>
					<? } ?>
					<? } ?> -->
					<li><label for="hero_new_name">�����ôº�</label> 
						<input type="text" name="hero_new_name" id="hero_new_name" value="<?=$member_rs['hero_name']?>">
					</li>
					<? if($out_row['hero_type'] != 8) { ?>
						<li>
							<label for="hero_address_01">�ּ�</label>
							<input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_rs['hero_address_01']?>"  style="width:380px;" onclick="javascript:btnAddressGet()" readonly /> <a href="javascript:btnAddressGet()" class="btn_post">�����ȣ</a><br />
							<input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_rs['hero_address_02']?>" style="width:260px; margin:1.2rem 0 0 0;" onclick="javascript:btnAddressGet()" readonly />
							<input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_rs['hero_address_03']?>" style="width:260px; margin:1.2rem 0 0 0;">
						</li>
					<? } else { ?>
						<input type="hidden" name="hero_address_01" value="<?=$member_rs['hero_address_01'];?>"> 
						<input type="hidden" name="hero_address_02" value="<?=$member_rs['hero_address_02'];?>"> 
						<input type="hidden" name="hero_address_03" value="<?=$member_rs['hero_address_03'];?>"> 
					<? }?>
					<?
						$next = str_ireplace ( '-', '', $member_rs["hero_hp"]);
						$next = str_ireplace ( '~', '', $next );
						$next = str_ireplace ( '_', '', $next );
						$next = str_ireplace ( '/', '', $next );
					?>
					<li><label for="hero_hp_01">����ó</label> 
						<div class="f_b phone">
							<input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode: disabled;" /> - 
							<input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode: disabled;" /> - 
							<input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" style="ime-mode: disabled;" />
						</div>
					</li>
					<? if($out_row['hero_type'] == 8) { ?>
						<li style="margin-bottom: 0;">
							<label>����Ʈ ü��� ���� ���� Ȯ��</label> 
							<span class="fz14 op05">����Ʈ ü����� ���� �ȳ��� ���� URL�� ���� ���� �Ⱓ �� ���� ��÷�� ��ǰ�� �����Ͻþ� �ʼ� �̼��� �������ּž� �Ǹ�, �ʼ� �̼� �����ڸ� ������� ���� ��� ȯ���� �ƴ� �ȳ� �� �������� ���޵˴ϴ�. (���� ü��� �� ���� ������)</span>
							<div class="c_orange f_b" style="margin-top: 3rem;">
								<p class="fz16 fw500">�� ������ Ȯ���ϼ̽��ϱ�?</p>
								<div class="input_chk confirm_chk"><input type="checkbox" name="hero_confirm" id="hero_confirm" value='Y'><label for="hero_confirm"  class="input_chk_label">Ȯ��</label><br/>
							</div>
						</li>
					<? } else {?>							
						<li class="f_cs" style="margin-bottom: 0;">
							<div class="input_chk"><input type="checkbox" name="hero_address_save" id="hero_address_save" value="1"/><label for="hero_address_save" class="input_chk_label">�⺻ �ּҷ� ����</label></div>
							<span class="fz14  op05" style="margin-left: 1rem;">* ���� �� ȸ������ �޴�����ȣ, �ּҰ� ����˴ϴ�.</span>
						</li>
					<? } ?>						
				</ul>
			</dd>
		</dl>		
		<? if($out_row['delivery_point_yn']=="Y") { 
				$use_point = $member_rs['total_user_point']-$member_rs['total_use_point'];
		?>		
		<script>
			var use_point		= <?=$use_point?>;
			var delivery_point	= <?=$_DELIVERY_POINT?>;
			$(document).ready(function(){
				$("input[name=delivery_point_yn]").on('click', function(){
					if($(this).val() == "Y") {
						if( use_point < delivery_point ) {
							alert("��������Ʈ�� �����մϴ�.");
							$('input[name=delivery_point_yn]:input[value="N"]').prop("checked", true);
						}
					}
				})
			})
		</script>
		<dl class="delivery">
			<dt>��ۺ� ����Ʈ ���� ����</dt>
			<dd>
				<ul>
					<li class="point_radio">
						<div class="f_cs"> 
							<span class="fz15 bold"><?=$_DELIVERY_POINT?>����Ʈ�� �����Ͻðڽ��ϱ�?</span>
							<div class="input_radio"><input type="radio" name="delivery_point_yn" id="delivery_point_yn1" value='Y' style="width: 20px;"><label for="delivery_point_yn1" style="width: 20px;">��</label></div>
							<div class="input_radio"><input type="radio" name="delivery_point_yn" id="delivery_point_yn2" value='N' style="width: 20px;" checked><label for="delivery_point_yn2" style="width: 50px;">�ƴϿ�</label></div>
						</div>
						<span class="fz14 500">* <?=$_DELIVERY_POINT?>����Ʈ �������� ���� �� ü��� ��ǰ�� ���ҷ� ��۵˴ϴ�.</span>
					</li>
					<li class="desc fz13 fw500">					
						�ش� �׸� ������ üũ�ϸ� ü��� ��û �� ��������Ʈ <?=$_DELIVERY_POINT?>����Ʈ�� ������ �˴ϴ�.<br/>
						ü��� ��÷ �� ��ǰ�� ����� ��۵˴ϴ�.<br/> ü��� �� ��÷ �� ���� �� ����Ʈ�� ȯ���� �帳�ϴ�.<br/>
						(��������Ʈ�� ������ ���, üũ �Ұ�)
					</li>					
				</ul>
			</dd>
		</dl>
		<? }//��ۺ� ����Ʈ ���� ���� ?>
		<?  if($out_row['hero_superpass']=='Y'){ ?>
		<dl>
			<dt><span class="question_num">�����н� ��� ����</dt>
			<dd>
				<ul class="superpassBox">
					<? if($member_rs["superpass_count"]==0){ ?>
						<li class="fz15 bold">����� �� �ִ� �����н��� �����ϴ�.</li>						
					<? } else if(countSuperpass($out_row['hero_select_count'])<=$out_row['enrolled_superpass']){ ?>
						<li class="fz15 bold">�� ü����� �����н��� ���������� �����Ǿ����ϴ�.</li>
					<? } else if($member_rs["superpass_count"] > 0){ ?> 
						<li class="point_radio">
							<div class="f_b">
								<span class="fz15 bold">�����н��� ����Ͻðڽ��ϱ�?</span>
								<div class="input_chk"><input type="checkbox" name="hero_superpass" id="hero_superpass" value="Y" style="width:20px;"><label for="hero_superpass" class="input_chk_label">Ȯ��</label></div>
							</div>
							<span class="fz14 500">*�����н��� ��û�� �Ϸ�� �Ŀ� ������ �� ������ ������ ������ �ֽñ� �ٶ��ϴ�.</span>
						</li>
					<? } ?>
				</ul>
			</dd>
		</dl>
		<? }//superpasss ���� ?>
		<div class="btn_bx f_c">
			<div class="btn_submit btn_gray btn_prv">��������</div>
			<input type="button" class="btn_submit btn_color" onClick="go_submit(this.form)" value="�������� ��û �ϱ�"/>
		</div>
	</div>
	</div>
</form>
</div>
</div>
<form action="/main/zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
    <input type="file" name="thumbImage" id="write_hero_thumb" title="�̹���" style="position: absolute; left: -9999em;"/>
</form>
<script type="text/javascript">
	/*	
		musign start
	*/
	//step �극��ũ���� ù��° Ȱ��ȭ
	$(document).ready(function(){	
		$('.joinstep:first-child ,.join_arr:first-child ').addClass('on');		
		//step�ڽ� - ȸ������ �ܰ躰 ���� ��ư ����		
		var prev_idx = $('.btn_prv');
		var stepDiv = $('.step');
		var breadLi = $('.bread li');
		var breadStep = $('.bread .joinstep');
		var breadArr = $('.bread .join_arr');
		$.each(prev_idx, function(idx, item){
			$(this).click(function(){
				console.log(idx);
				stepDiv.hide();
				stepDiv.eq(idx).show();
				breadLi.removeClass('on');
				breadStep.eq(idx).addClass('on');
				breadArr.eq(idx).addClass('on');
				$(window).scrollTop(0);	
			});
		});
	});
	//step�ڽ� - ȸ������ �ܰ躰 ���� ��ư ����
	function nextStep(index){		
		var stepDiv = $('.step');
		var breadLi = $('.bread li');
		var breadStep = $('.bread .joinstep');
		var breadArr = $('.bread .join_arr');
		stepDiv.hide();
		stepDiv.eq(index).show();	
		breadLi.removeClass('on');
		breadStep.eq(index).addClass('on');
		breadArr.eq(index).addClass('on');
		$(window).scrollTop(0);
	}
	//step1 ��ȿ�� �˻�
	function stepOneChk(form){

    	var expUrl = /^http[s]?\:\/\//i; //url üũ

		var hero_question_url_check = "<?=$out_row["hero_question_url_check"]?>"; //URL �ʼ� �� üũ
        var hero_type = "<?=$out_row["hero_type"]?>";
		
	
		var hero_blog = "";
		var val_chk = true;

		var mission_board_type = false;
		if(hero_type == "2" || hero_type == "10") {
			mission_board_type = true;
		}

		//URL �ʼ��� üũ �߰�
		if(mission_board_type == false) {
			if(hero_question_url_check == "1") {
				if(!$("input[name='hero_blog_00']").val()) {
					alert("���̹� ��α� URL�� �Է��� �ּ���.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "2") {
				if(!$("input[name='hero_blog_04']").val()) {
					alert("�ν�Ÿ�׷� URL�� �Է��� �ּ���.");
					$("input[nam='hero_blog_04']").focus();
					return false;
				}
			} else if(hero_question_url_check == "3") {
				if(!$("input[name='hero_blog_00']").val() && !$("input[name='hero_blog_04']").val()) {
					alert("���̹� ��α�/�ν�Ÿ�׷� URL ��  �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "4") {
				if(!$("input[name='hero_blog_00']").val() || !$("input[name='hero_blog_04']").val()) {
					alert("���̹� ��α�, �ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "5") {
				if(!$("input[name='hero_blog_03']").val()) {
					alert("���� ä�� URL�� �Է��� �ּ���.");
					$("input[nam='hero_blog_03']").focus();
					return false;
				}
			} else if(hero_question_url_check == "6") {
				if(!$("input[name='hero_blog_00']").val() && !$("input[name='hero_blog_04']").val() && !$("input[name='hero_blog_03']").val()) {
					alert("���̹� ��α�/�ν�Ÿ�׷�/���� ä�� URL �� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			}
		}

		$('.hero_blog').each(function(index) {
			blog_value = ""
			if(this.name == "hero_blog_00") {
				blog_value = "https://blog.naver.com/" + this.value;
			} else if(this.name == "hero_blog_04") {
				blog_value = "https://www.instagram.com/" + this.value;
			} else {
    			if(!expUrl.test(this.value) && this.value) {
    				alert("SNS URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�." + this.name);
    				this.focus();
    				val_chk = false;
    				return false;
    			} else {
    				blog_value = this.value
    			}
			}
	
			if(index == 0) hero_blog += blog_value;
			else hero_blog += ","+blog_value;
		});
			
		if(!val_chk) return false;
		
		hero_blog = $.trim(hero_blog);
		$("#hero_representative_blog").val(hero_blog);
		
		
		nextStep(1);
		return true;
	}

    //�ҹ����� Step1. ����
	function stepAlertChk(form){
		<? if($mission_board_type){ //�ҹ����� ��?>
        //������ ��ȿ���˻� ����
        var thumb 			= form.hero_thumb;
        var board_title     = form.hero_title;
        var expUrl = /^http[s]?\:\/\//i; //url üũ
        var hero_question_url_check = "<?=$out_row["hero_question_url_check"]?>"; //URL �ʼ� �� üũ

        //����
		if(board_title.value == "") {
			alert('������ �Է����ּ���.');
			board_title.style.border = '1px solid red';
			board_title.focus();
			return false;
		}

        //��ǥ�̹���(�����)
		if(thumb.value == ""){
            alert("��ǥ �̹����� ������ּ���.");
            return false;
        }else{
        	thumb.style.border = '';
        }

        if(hero_question_url_check == "1"){ //URL�ʼ��� ���̹�
            if(!$("input[name='naver_url']").val()) { //���̹�
                alert("���̹���α� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
                $("input[name='naver_url']").focus();
                return;
            }
        } else if (hero_question_url_check == "2"){ //URL�ʼ��� �ν�Ÿ
            if(!$("input[name='insta_url']").val()) { //�ν�Ÿ
                alert("�ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
                $("input[name='insta_url']").focus();
                return;
            }
        } else if(hero_question_url_check == "3" || hero_question_url_check == "6"){ //URL�ʼ��� ���̹� or �ν�Ÿ
            if(!$("input[name='naver_url']").val() && !$("input[name='insta_url']").val()){ //���̹� or �ν�Ÿ
                alert("���̹���α�/�ν�Ÿ�׷� URL�� �Ѱ��� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
                $("input[name='naver_url']").focus();
                return;
            }
        } else if(hero_question_url_check == "4"){ //URL�ʼ��� ���̹� and �ν�Ÿ
            if(!$("input[name='naver_url']").val()) { //���̹���α�
                alert("���̹���α� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
                $("input[name='naver_url']").focus();
                return;
            }

            if(!$("input[name='insta_url']").val()) { //�ν�Ÿ�׷�
                alert("�ν�Ÿ�׷� URL�� �ʼ��� �Է��ϼž� �մϴ�.");
                $("input[name='insta_url']").focus();
                return;
            }
        }

        //���̹���α� url���� üũ
		if($("input[name='naver_url']").val()) {
			if(!expUrl.test($("input[name='naver_url']").val())) {
				alert("���̹� ��α� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
				$("input[name='naver_url']").focus();
				return;
			}
			<? if($out_row["hero_ftc"] == "1") {?>
            //(������) ���������� Ȯ���϶�
			if($("input[name='naver_admin_check']").val() != "Y") {
				alert("���̹� ��α� ������ ���� Ȯ�� �� ������ �ּ���.");
				return;
			}
			<? } ?>
            //���̹� �����ŷ�����ȸ ���� �ۼ� üũ����
			if($("input:radio[name='naver_member_check']:checked").val() != "Y") {
				alert("���̹� ��α� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
				return;
			}
		}

        //�ν�Ÿ url���� üũ
		if($("input[name='insta_url']").val()) {
			if(!expUrl.test($("input[name='insta_url']").val())) {
				alert("�ν�Ÿ�׷� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
				return;
			}

			<? if($out_row["hero_ftc"] == "1") {?>
            //(������) ���������� Ȯ���϶�
			if($("input[name='insta_admin_check']").val() != "Y") {
				alert("�ν�Ÿ�׷� ������ ���� Ȯ�� �� ������ �ּ���.");
				return;
			}
			<? } ?>
            //�ν�Ÿ �����ŷ�����ȸ ���� �ۼ� üũ����
			if($("input:radio[name='insta_member_check']:checked").val() != "Y") {
				alert("�ν�Ÿ�׷� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
				return;
			}

		}

		<? if($_GET ['board'] == 'group_04_27') { ?>
        //������ ������ �� group_04_27 ���X
		var movieUrlCheck = true;
		var movieMemberCheck = true;
       	$("input[name='movie_url[]']").each(function(i){
           	if($(this).val()) {
           		if(!expUrl.test($(this).val())) {
	           		alert("�ı�(���) URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
	           		movieUrlCheck = false;
					return false;
           		}

           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                    alert("�ı�(����) �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
             	   movieMemberCheck = false;
             	   return false;
                }
            }
        })
        if(!movieUrlCheck) return;
        if(!movieMemberCheck) return;
        <? } ?>
        //ī�� ��ȿ�� üũ
        var cafeUrlCheck = true;
		var cafeMemberCheck = true;
       	$("input[name='cafe_url[]']").each(function(i){
           	if($(this).val()) {
                //ī�� url���� üũ
           		if(!expUrl.test($(this).val())) {
                   alert("ī�� URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
	           		cafeUrlCheck = false;
					return false;
           		}
                //ī�� �����ŷ�����ȸ ���� �ۼ� üũ����
           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                    alert("ī�� �����ŷ�����ȸ ���� �ۼ��� �������ּ���.");
                    cafeMemberCheck = false;
                    return false;
                }
            }
        })
        if(!cafeUrlCheck) return; //ī�� url���� üũ
        if(!cafeMemberCheck) return; //ī�� �����ŷ�����ȸ ���� �ۼ� üũ����

        //��Ÿ ��ȿ�� üũ
        var etcUrlCheck = true;
		var etcMemberCheck = true;
       	$("input[name='etc_url[]']").each(function(i){
           	if($(this).val()) {
                //��Ÿ url���� üũ
           		if(!expUrl.test($(this).val())) {
	           		alert("��Ÿ URL http:// �Ǵ� https:// �ʼ��� �Է��� �ʿ��մϴ�.");
	           		etcUrlCheck = false;
					return false;
           		}

                //��Ÿ �����ŷ�����ȸ ���� �ۼ� üũ����
           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                   alert("��Ÿ �����ŷ�����ȸ ���� �ۼ��� �������ּ���.")
             	   etcMemberCheck = false;
             	   return false;
                }
            }
        })
        if(!etcUrlCheck) return; //��Ÿ url���� üũ
        if(!etcMemberCheck) return; //��Ÿ �����ŷ�����ȸ ���� �ۼ� üũ����

        var url_value_check = false; //������ URL 1���� �ݵ�� ����� �ʿ���
    	$(".inputUrl2").each(function(i){
    		if($(this).val()) url_value_check = true;
    	})
    	
    	if(!url_value_check) {
    		alert("������ URL�� 1�� �̻� ����� �ʿ��մϴ�.");
    		return;
    	}        
				
		nextStep(1);
		return true;

	<? } //�ҹ����� ?>
	}

	function stepTwoChk(form){
		var surveyCheck = true;
		$(".survey").each(function(index, item){
			var _textarea = $(this).find("textarea");
			var _checkbox = $(this).find("input[type='checkbox']:checked");
			var _checkbox_necessary = $(this).find("input[type='checkbox']");
			var _radio = $(this).find("input[type='radio']:checked");
			var _radio_necessary = $(this).find("input[type='radio']");
			if(!_textarea.val() && _textarea.attr("title")) {
				alert("�ʼ����� ������� ü��� ��û�� �Ұ��մϴ�.\n"+_textarea.attr("title")+"�� Ȯ���� �ּ���");
				_textarea.focus();
				surveyCheck = false;
				return false;
			}

			if(_checkbox_necessary.attr("title") && !_checkbox.val()) {
				alert("�ʼ����� ������� ü��� ��û�� �Ұ��մϴ�.\n"+_checkbox_necessary.attr("title")+"�� Ȯ���� �ּ���");
				_checkbox.focus();
				surveyCheck = false;
				return false;
			}

			if(_radio_necessary.attr("title") && !_radio.val()) {
				alert("�ʼ����� ������� ü��� ��û�� �Ұ��մϴ�.\n"+_radio_necessary.attr("title")+"�� Ȯ���� �ּ���");
				_radio.focus();
				surveyCheck = false;
				return false;
			}
		})
		
		if(!surveyCheck) return;	

		<? if($out_row['hero_type'] != 1) { ?>
		//�������� Ȱ�� ����
		if(!form.hero_agree.checked){
			alert("������ Ȱ�뿡 �����ؾ� ü��� ��û�� �����մϴ�");
        	form.hero_agree.focus();
            return false;				
		}
		<? } ?>

		const _idx = $('.step').length; 				
		nextStep(_idx - 1);

		return true;

	}


	var hero_blog = []; //hero_blog.length; 20140410 ������ �� �ִ� ��α��� ���� 
	function ch_disabled(value_item){ //20140410 ������ ��α� ���� ����� disabled ����
		for (var i=0; i<hero_blog.length ;i++ ){
			$('#hero_blog_0'+i).attr('disabled','disabled');
		}
		var sel_number = $("#hero_01_01 option:selected").attr('id');

		$('#hero_blog_'+sel_number).removeAttr("disabled"); 
	}
    
	function go_submit(form) {
        var new_name    	= form.hero_new_name;
		var thumb 			= form.hero_thumb;
		var board_title     = form.hero_title;
		var hero_04			= form.hero_04;
        var address_01 		= form.hero_address_01;
        var address_02 		= form.hero_address_02;
        var hero_superpass	= form.hero_superpass;
		
		var hero_01_01 		= document.getElementById('hero_01_01');
		var hero_blog_00	= form.hero_blog_00;
		var hero_blog_01 	= form.hero_blog_01;
		var hero_blog_02 	= form.hero_blog_02;
		var hero_blog_03 	= form.hero_blog_03;
		var hero_blog_04	= form.hero_blog_04;
		var hero_blog_05 	= form.hero_blog_05;
		var hero_blog_06 	= form.hero_blog_06;
       
		var hp_01 			= form.hero_hp_01;
        var hp_02 			= form.hero_hp_02;
        var hp_03 			= form.hero_hp_03;

		



	


        if(new_name.value == ""){
            alert("�����ôº� �̸��� �Է����ּ���.");
            new_name.style.border = '1px solid red';
            new_name.focus();
            return false;
        }else{
            new_name.style.border = '1px solid #e4e4e4';
        }
        
        <? if($out_row['hero_type'] != 8) { ?>
            if(address_01.value == "") {
                alert("����� �ּ� �Է����ּ���.");
                address_01.style.border = '1px solid red';
                address_01.focus();
                return false;
            } else {
                address_01.style.border = '1px solid #e4e4e4';
            }
            
            if(address_02.value == "") {
                alert("����� �ּ� �Է����ּ���.");
                address_02.style.border = '1px solid red';
                address_02.focus();
                return false;
            } else {
                address_02.style.border = '1px solid #e4e4e4';
            }
        <? }?>
        
       if(hp_01.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_01.style.border = '1px solid red';
            hp_01.focus();
            return false;
        }else{
            hp_01.style.border = '1px solid #e4e4e4';
        }
        if(hp_02.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_02.style.border = '1px solid red';
            hp_02.focus();
            return false;
        }else{
            hp_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_03.value == ""){
            alert("����ó�� �Է����ּ���.");
            hp_03.style.border = '1px solid red';
            hp_03.focus();
            return false;
        }else{
            hp_03.style.border = '1px solid #e4e4e4';
        }

				
	   <? if($out_row['hero_type'] == 8) { ?>
		if(!form.hero_confirm.checked){
			alert("����Ʈ ü��� ���� ������ Ȯ���ؾ� ��û�� �����մϴ�");
        	form.hero_confirm.focus();
            return false;				
		}
	   <? } ?>
			
	  
		var r = true;	 // 160311 �߰� ajax���� �ٷ� return false ��� �� ��� �ȵ� �׷��� �������� �߰�
		if(typeof hero_superpass != "undefined" && hero_superpass.checked==true){
			
			if(confirm("�����н��� ����Ͻðڽ��ϱ�?")){

				    var url="/board/thumbnail_02/getSuperpassData.php";  
				    var params="idx="+<?=$_GET['idx']?>;  
				  
				    $.ajax({      
				        type:"POST",  
				        url:url,      
				        data:params,
						async: false,  // 160311 ajax���� ���������� ���� ������ؼ� async: false �ʿ�
				        success:function(args){   
				            if(args==0){
								if(confirm("�� ü����� �����н��� �̹� ���������� �����Ǿ����ϴ�. �����н� ���� ü��ܿ� �����Ͻðڽ��ϱ�?")){
									hero_superpass.checked=false;
									r=true;
								}else{
									hero_superpass.checked=false;
									r=false;
								}	
									
					        }else if(args==9)	alert("�ý��� �����Դϴ�2. �ٽ� �õ��� �ּ���.");
				        }   
				          
				    });  
				    if(!r) return false;  
				
			}else{
				hero_superpass.checked=false;
				return false;
			}
		}

        form.submit();
        return true;
    }
</script>

