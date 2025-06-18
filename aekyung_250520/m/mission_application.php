<?php
include_once "head.php";
if (! defined ( '_HEROBOARD_' ))	exit ();

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

$temp_nick 	=	$_SESSION ['temp_nick'];
$temp_id 	=	$_SESSION ['temp_id'];
$temp_code 	=	$_SESSION ['temp_code'];

$idx 		=	$_GET ['mission_idx'];
$board 		=	$_GET['board'];
$today 		=	date('Y-m-d');
$full_today = 	date('Y-m-d H:i:s');

## 접근권한
#####################################################################################################################################################
if(!$board || !$idx) 	error_historyBack("잘못된 접근입니다.");

if(!$temp_code) error_historyBack("로그인 후에 참여하실 수 있습니다.");

//중복참여 체크
$mission_check = " SELECT count(*) cnt FROM mission_review WHERE hero_old_idx = '".$idx."' AND hero_code = '".$temp_code."' ";
$mission_check_res = sql($mission_check);
$mission_check_rs = mysql_fetch_assoc($mission_check_res);

if($mission_check_rs["cnt"] > 0 && $my_level < 9999) {
	error_historyBack("이미 신청하셨습니다.");
	exit;
}

$group_sql = " SELECT * FROM hero_group WHERE hero_board ='".$board."' ";
$out_right_sql = @mysql_query($group_sql);
$right_list = @mysql_fetch_assoc($out_right_sql);

//미션 정보 및 슈퍼패스 신청자
$sql  = " SELECT * ,(select count(*) from mission_review where hero_superpass='Y' and hero_old_idx='".$idx."') AS enrolled_superpass ";
$sql .= " FROM mission ";
$sql .= " WHERE hero_table = '".$_GET ['board']."' AND hero_idx='".$idx."' ";
if($my_level < 9999) $sql .= " AND hero_use = 1 ";
$sql_res = mysql_query($sql);
if(!$sql_res){
	logging_error($temp_nick, $board."-STEP_01_02", $full_today);
	error_historyBack("");
}

$out_row = mysql_fetch_assoc($sql_res);

$mission_board_type = false; //소문내기, 미션 인증하기 타입
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

//210209 설문조사가 있는지 확인
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

if($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28'){
	if($my_view < 9999){
		if($_GET['board'] == 'group_04_06'){
			if($out_row["hero_type"] == "7") {//자율미션
				if($right_list['hero_view'] != $my_view && $_SESSION["before_beauty_auth"] != "Y") {
					error_historyBack("죄송합니다. 이 미션은 뷰티클럽 기수만 참여할 수 있습니다.");
					exit;
				}
			} else {
				if($right_list['hero_view'] != $my_view) {
					error_historyBack("죄송합니다. 이 미션은 뷰티클럽 현기수만 참여할 수 있습니다.");
					exit;
				}
			}
		}
		
		if($_GET['board'] == 'group_04_27'){
			if($out_row["hero_type"] == "7") {//자율미션
				if($out_row["hero_movie_group"] == "group_04_27") {
					if($_SESSION["before_beautymovie_auth"] != "Y" && $my_view != "9995" ) {
						error_historyBack("죄송합니다. 이 미션은 뷰티클럽영상 기수만 참여할 수 있습니다.");
						exit;
					}
				} else if($out_row["hero_movie_group"] == "group_04_31") {
					if($_SESSION["before_lifemovie_auth"] != "Y" && $my_view != "9993") {
						error_historyBack("죄송합니다. 이 미션은 라이프클럽영상 기수만 참여할 수 있습니다.");
						exit;
					}
				}
			
			} else {
				if($right_list['hero_view'] != $my_view) {
					error_historyBack("죄송합니다. 이 미션은 체험단 신청을 참여할 수 없습니다.");
					exit;
				}
			}
		}
		
		if($_GET['board'] == 'group_04_28'){
			if($out_row["hero_type"] == "7") {//자율미션
				if($right_list['hero_view'] != $my_view && $_SESSION["before_life_auth"] != "Y") {
					error_historyBack("죄송합니다. 이 미션은 라이프클럽 기수만 참여할 수 있습니다.");
					exit;
				}
			} else {
				if($right_list['hero_view'] != $my_view) {
					error_historyBack("죄송합니다. 이 미션은 라이프클럽 현기수만 참여할 수 있습니다.");
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
	error_historyBack("죄송합니다. 마감된 체험단입니다.");
	exit;
} 

//슈퍼패스 권한 체크 및 회원정보
$member_sql  = " SELECT *, (SELECT count(*) FROM superpass WHERE hero_code='".$_SESSION ['temp_code']."'  ";
$member_sql .= " AND hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as superpass_count ";
$member_sql .= " , (SELECT sum(hero_point) from point WHERE hero_code='".$_SESSION['temp_code']."') as total_user_point ";
$member_sql .= " , (SELECT sum(hero_order_point) FROM order_main WHERE hero_code='".$_SESSION['temp_code']."' AND hero_process!='".$_PROCESS_CANCEL."') as total_use_point";
$member_sql .= " FROM member WHERE hero_use = 0 AND hero_code = '".$_SESSION ['temp_code']."' ";

$member_res = sql($member_sql);
$member_rs = mysql_fetch_assoc($member_res);

if(!$member_rs["hero_info_ci"]){
	message("체험단에 참여하기 위해서는 본인인증이 필요합니다");
	location("/m/auth.php?board=auth");
	exit;
}

//공정위문구
$search_ftc_naver = $out_row["hero_ftc_naver"];
$search_ftc_naver = preg_replace("/\s+/","",$search_ftc_naver);
$search_ftc_naver = strtolower($search_ftc_naver);
$search_ftc_naver = urlEncode($search_ftc_naver);

$search_ftc_insta = $out_row["hero_ftc_insta"];
$search_ftc_insta = preg_replace("/\s+/","",$search_ftc_insta);
$search_ftc_insta = strtolower($search_ftc_insta);
$search_ftc_insta = urlEncode($search_ftc_insta);

if(!strcmp($_GET['type'], 'edit')){ //등록 프로세스
	
	$hero_address_save = $_POST['hero_address_save']; //기본 배송지 저장 여부
	$delivery_point_yn = $_POST['delivery_point_yn']; //배송비 선차감 여부
	
	//중복 신청 확인
	$sql_ch  = " SELECT * FROM (select count(*) as count_registered from mission_review WHERE ";
	$sql_ch .= " hero_old_idx='".$idx."' and hero_code='" . $temp_code . "') as A ";
	$sql_ch .= ", (select hero_number from mission_review where hero_old_idx='".$idx."' order by hero_number desc limit 0,1) as B";
	$sql_ch_res = mysql_query ($sql_ch);

	if(!$sql_ch_res){
		logging_error($temp_nick, $board."-M_MISSION_APPLICATION_02", $full_today);
		error_historyBack("");
		exit;
	}

	$sql_ch_rs = mysql_fetch_assoc ($sql_ch_res);
	if ($sql_ch_rs ['count_registered'] > 0) {
		echo "test11";
		error_location("체험단에 이미 참여하셨습니다","/m/mission.php?board=".$board);
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

	//(s)160321 문수영 수정 슈퍼패스 사용유무 추가
	if($_POST['hero_superpass'] == 'Y') {
		$superpass_use_sql = " select hero_idx from superpass where ";
		$superpass_use_sql .= " hero_code = '".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00') ";
		$superpass_use_sql .= " order by hero_endday asc limit 0,1 ";

		$superpass_use_sql_res = mysql_query ($superpass_use_sql);

		if(!$superpass_use_sql_res){
			logging_error($temp_nick, $board."-M_MISSION_APPLICATION_02_1", $full_today);
			error_historyBack("");
			exit;
		}

		$superpass_use_sql_rs = mysql_fetch_assoc($superpass_use_sql_res);

		$update_superpass_use_sql = " update superpass set hero_use_yn = 'Y' where hero_idx = '".$superpass_use_sql_rs['hero_idx']."' ";
		$update_superpass_use_pf = mysql_query ($update_superpass_use_sql);

		if(!$update_superpass_use_pf){
			logging_error($temp_nick, $board."-M_MISSION_APPLICATION_02_2", $full_today);
			error_historyBack("");
			exit;
		}
	}
	//(e)160321 문수영 수정 슈퍼패스 사용유무 추가

	$idx_sql = "SHOW TABLE STATUS LIKE 'mission_review'";

	$out_idx_sql = mysql_query($idx_sql);
	if(!$out_idx_sql){
		logging_error($temp_nick, $board."-M_MISSION_APPLICATION_03", $full_today);
		error_historyBack("");
	}

	$idx_list                             = @mysql_fetch_assoc($out_idx_sql);

	$good_idx = $idx_list['Auto_increment'];

	## 쿼리 셋팅
	#####################################################################################################################################################

	//미션 신청 고유 번호 생성
	if(!$sql_ch_rs['hero_number'])	$hero_number = 1;
	else							$hero_number = $sql_ch_rs['hero_number']+1;

	//소문내기일때 다른 프로세스 탐
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
		$delivery_point_yn = $_POST['delivery_point_yn'];
		
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
		
		//소문내기는 자동으로 당첨
		$sql = "INSERT INTO mission_review (hero_idx, hero_code, hero_old_idx, hero_table, hero_number, hero_id, hero_name, hero_new_name, hero_nick, hero_write_date";
		$sql .= ", hero_hp_01, hero_hp_02, hero_hp_03, hero_today, hero_ip, hero_03,  hero_address_01, hero_address_02, hero_address_03, hero_superpass, hero_agree, delivery_point_yn ";
		$sql .= ", lot_01)";
		$sql .= "VALUES (".$good_idx.", '".$hero_code."', '".$hero_old_idx."', '".$hero_table."',".$hero_number.", '".$hero_id."', '".$hero_name."'";
		$sql .= ",'".$hero_new_name."', '".$hero_nick."',now(), '".$hero_hp_01."', '".$hero_hp_02."', '".$hero_hp_03."', now(), '".$hero_ip."'";
		$sql .= ", '".$hero_03."', '".$hero_address_01."', '".$hero_address_02."', '".$hero_address_03."', '".$hero_superpass."', '".$hero_agree."', '".$delivery_point_yn."' ";
		$sql .= ",1)";

		$mission_review_pf = mysql_query ( $sql );
		$mission_review_idx = 0;
		
		if(!$mission_review_pf){
			logging_error($temp_nick, $board."-STEP_01_04", $full_today);
			error_historyBack("");
			exit;
		} else {
			$mission_review_idx = mysql_insert_id();
		}

		// 컨텐츠등록
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


		$sql =  " INSERT INTO board (hero_idx, hero_code, hero_table, hero_title, hero_name ";
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
		
		//SNS 등록
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
			if($post_key != "survey_idx" && strpos($post_key, "answer_") === false) { //설문조사 폼은 삭제
				$sql_one .= ", ".$post_key;
				$sql_two .= ", '".$_POST [$post_key]."'";
			}
		}

		$sql = 'INSERT INTO mission_review ('.$sql_one.',hero_write_date) VALUES ('.$sql_two.',now());';

		$mission_review_pf = mysql_query ( $sql );
		$mission_review_idx = 0;
		
		if(!$mission_review_pf){
			logging_error($temp_nick, $board."-M_MISSION_APPLICATION_04", $full_today);
			error_historyBack("");
			exit;
		} else {
			$mission_review_idx = mysql_insert_id();
		}
	}

	//포인트 부여 및 등업기능//테이블, 타입, 글번호, 리뷰번호, 제목, 최대포인트 포함여부, 날짜
	######################################################################################################################################################
	// " ' "오류 수정 160912
	if($mission_review_idx > 0) {
		$title01 = str_replace("'", "`", $out_row['hero_title']);
		$point_rs = pointAdd($board, "mission_application", 0, $idx, $good_idx, $title01, 'Y');
		
		//배송비선차감 2021-03-26
		if($delivery_point_yn == "Y") {
			deliveryPoint($_POST["hero_old_idx"], $member_rs["hero_id"], $member_rs["hero_code"], $member_rs["hero_name"], $member_rs["hero_nick"], $_DELIVERY_POINT);
		}
	
		/* 210818 필요없는 로직 속도 때문에 결과값이 늦어질수 있을거 같음
		if($point_rs!=1){
			$rollback_query = "delete from mission_review where hero_idx='".$good_idx."'";
			//echo $rollback_query;
			$pf_rollback = mysql_query($rollback_query);
			if(!$pf_rollback){
				logging_error($temp_nick, $board."-M_MISSION_APPLICATION_05", $full_today);
			}
			error_historyBack("");
			exit;
	
		}
		*/
	
		//기본 주소 변경
		######################################################################################################################################################
		if(!$member_rs["hero_address_02"] || $hero_address_save=='1'){
			$infoedit_sql = "update member set hero_address_01='".$_POST['hero_address_01']."', hero_address_02='".$_POST['hero_address_02']."', hero_address_03='".$_POST['hero_address_03']."', hero_hp='".$_POST['hero_hp_01']."-".$_POST['hero_hp_02']."-".$_POST['hero_hp_03']."' where hero_code='".$_SESSION['temp_code']."'";
			@mysql_query($infoedit_sql);
		}
		
		//설문조사 210215
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
	
		location(DOMAIN_END."m/mission_completion.php?".get("type"));
		exit;
	}
}
?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script src="/js/jquery.form.js"></script>
<? if($mission_board_type){ //소문내기 ?>
<script type="text/javascript" src="/js/mustache.min.js"></script>
<script type="text/javascript" src="/js/mustache_template2.js"></script>
<? } ?>
<!--컨텐츠 시작-->
<div class="contents_area mu_member join_wrap support_apply">
	<div class="page_title t_c">
		<? if($idx == $temp_idx) {?>
			<h2 class="fz48 fw500 main_c">이벤트 신청하기</h2>
		<? } else { ?>
			<h2 class="fz48 fw500 main_c">체험단 신청하기</h2>
		<? } ?> 		
	</div>
	<form action="zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
	<input type="file" name="thumbImage" id="write_hero_thumb" title="이미지" style="position: absolute; left: -9999em;"/>
	</form>	
	<div class="signup_wrap">
	<div id="write_mode" class="contents">    
 	<form name="form_next" action="<?=DOMAIN_END.'m/mission_application.php?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onSubmit="return false;">
    <input type="hidden" name="hero_drop" value="hero_drop||hero_address_save" />   
	<input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>">
	<input type="hidden" name="hero_old_idx" value="<?=$_GET['mission_idx'];?>">
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
		<input type="hidden" name="hero_01" value="<?=$_GET['mission_idx']?>" />
		<input type="hidden" name="hero_group" value="<?=$_GET['board']?>" />
	<? }else { ?>
		<input type="hidden" name="hero_01" id="hero_representative_blog" value="" />
	<? }?>    	
    
	<div id="board" class="stepbox">
    <?
    $number=1;
	
	if($mission_board_type == false && $out_row["hero_question_url_yn"] != "N") { //소문내기 아닐경우
		if($idx != $temp_idx) { 
	?>
		<div class="answerWrap sns_input_bx">
			<ul>
				<li>
					<span class="fz30 fw600 li_tit">URL을 입력해주세요.</span>
					<? if($out_row['hero_question_url_check'] == "1") {?>
						<span class="txt_emphasis_12">* 네이버 블로그 URL은 필수로 입력하셔야 합니다.</span>
					<? } else if($out_row['hero_question_url_check'] == "2") {?>
						<span class="txt_emphasis_12">* 인스타그램 URL은 필수로 입력하셔야 합니다.</span>
					<? } else if($out_row['hero_question_url_check'] == "3") {?>
						<span class="txt_emphasis_12">* 네이버 블로그/인스타그램 URL 중  한개의 URL은 필수로 입력하셔야 합니다.</span>
					<? } else if($out_row['hero_question_url_check'] == "4") {?>
						<span class="txt_emphasis_12">* 네이버 블로그, 인스타그램 URL은 필수로 입력하셔야 합니다.</span>
					<? } else if($out_row['hero_question_url_check'] == "5") {?>
						<span class="txt_emphasis_12">* 영상 채널(유튜브, 네이버TV, 틱톡, 기타 등) URL은 필수로 입력하셔야 합니다.</span>
					<? } else if($out_row['hero_question_url_check'] == "6") {?>
						<span class="txt_emphasis_12">* 네이버 블로그/인스타그램/영상 채널(유튜브, 네이버TV, 틱톡, 기타 등) URL 중 한개의 URL은 필수로 입력하셔야 합니다.</span>
					<? }?>
				</li>
			</ul>
			
			<ul class="sns_input">			
			<?
				$hero_question_url_list = explode("/////",$out_row['hero_question_url_list']);
				$i = 0;
				foreach($hero_question_url_list as $key => $value) {
					$blog_id = "";
					switch ($value) {
					case "블로그":
						$blog_id = "hero_blog_00";
						?>
            			<li class="answer_dl_vertical">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					&nbsp;&nbsp;https://blog.naver.com/<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=str_replace("https://blog.naver.com/", "", $member_rs["{$blog_id}"]);?>" placeholder="네이버 또는 블로그 ID 입력" style="width:51%;display:inline;">
            				</div>
            			</li>
            			<? 
					   break;
					
					case "인스타그램":
						$blog_id = "hero_blog_04";
						?>
            			<li class="answer_dl">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					&nbsp;&nbsp;https://www.instagram.com/<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=str_replace("https://www.instagram.com/", "", $member_rs["{$blog_id}"]);?>" placeholder="인스타그램 ID 입력" style="width:42%;display:inline;">
            				</div>
            			</li>
            			<? 
					   break;
					
					case "페이스북":
						$blog_id = "hero_blog_01";
						?>
            			<li class="answer_dl">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="http:// 또는 https:// 포함된 SNS URL을 입력해주세요.">
            				</div>
            			</li>
            			<? 
					   break;
					
					case "트위터":
						$blog_id = "hero_blog_02";
						?>
            			<li class="answer_dl">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="http:// 또는 https:// 포함된 SNS URL을 입력해주세요.">
            				</div>
            			</li>
            			<? 
					   break;
					
					case "카카오스토리":
						$blog_id = "hero_blog_06";
						?>
            			<li class="answer_dl">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="http:// 또는 https:// 포함된 SNS URL을 입력해주세요.">
            				</div>
            			</li>
            			<? 
					   break;
					
					case "그 외":
						$blog_id = "hero_blog_05";
						?>
            			<li class="answer_dl">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="http:// 또는 https:// 포함된 SNS URL을 입력해주세요.">
            				</div>
            			</li>
            			<? 
					   break;
					
					case "영상 채널":
						$blog_id = "hero_blog_03";
						?>
            			<dl class="answer_dl">
            				<span><?=$value == "블로그" ? "네이버 블로그":$value?> URL</span>
            				<div>
            					<input type='text' id="hero_blog_<?=$i?>" name="<?=$blog_id?>" class="hero_blog form-control" value="<?=url($member_rs["{$blog_id}"]);?>" placeholder="http:// 또는 https:// 포함된 SNS URL을 입력해주세요.">
            				</div>
            			</dl>
            			<? 
					   break;
					}
			$i++;
			} 
			?>
			<? } else { ?>
			<p class="fz26 fw500">※ 아래 사항을 입력해 주세요.</p>
			<? } ?>
		</div>
	<? } //소문내기 아닌 경우 ?> 
	<? if($survey_cnt > 0) {?>
		<ul class="sns_input_bx require_box">
			<span class="fz30 fw600 li_tit">필수 확인 사항을 체크해주세요.</span>
			<div class="answerWrap">
				<?
				$survey_num = 1;
				while($row_survey = mysql_fetch_assoc($rs_survey)){ ?>
				<input type="hidden" name="survey_idx[]" value="<?=$row_survey['hero_idx']?>">
				<div class="survey">
					<p class="title">
						<?if($row_survey["necessary"] == "Y") {?>[필수]<?}?>
						<?=$survey_num?>) <?=$row_survey["title"]?>
					</p>
					
					<div class="exBox">
						<p><?=nl2br($row_survey["cont"])?></p>
						<? if($row_survey["image_cont"]) {?>
							<p class="img"><img src="/user/survey/<?=$out_row["hero_idx"]?>/<?=$row_survey["image_cont"]?>" /></p>
						<? } ?>
					</div>
					
					<div class="answerBox">
						<? if($row_survey["questionType"] == "1") {?>
						<textarea name="answer_<?=$row_survey['hero_idx']?>[]" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>문항"<?}?>></textarea>
						<? } else if($row_survey["questionType"] == "2") {?>
							<? for($z=1; $z<=20; $z++) {?>
								<? if($row_survey["op".$z]) { 
									if($z > 1) echo "<br/>";
								?>
								<div class="input_radio"><input type="radio" name="answer_<?=$row_survey['hero_idx']?>[]" id="answer_<?=$survey_num?>_<?=$z?>" value="<?=$row_survey["op".$z]?>" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>문항"<?}?> /> <label for="answer_<?=$survey_num?>_<?=$z?>"><?=$row_survey["op".$z]?></label></div>
								<? } ?>
							<? } ?>
						<? } else if($row_survey["questionType"] == "3") {?>
							<? for($z=1; $z<=20; $z++) {?>
								<? if($row_survey["op".$z]) { 
									if($z > 1) echo "<br/>";
								?>
								<div class="input_chk"><input type="checkbox" name="answer_<?=$row_survey['hero_idx']?>[]" id="answer_<?=$survey_num?>_<?=$z?>" value="<?=$row_survey["op".$z]?>" <?if($row_survey["necessary"] == "Y") {?>title="<?=$survey_num?>문항"<?}?>/> <label for="answer_<?=$survey_num?>_<?=$z?>" class="input_chk_label"><?=$row_survey["op".$z]?></label></div>
								<? } ?>
							<? } ?>	
						<? } ?>
					</div>
				</div>
				<? 
					$survey_num++;
					} 
				?>
			</div> 
		</ul>
	    <? } ?>   
	   	
        <? if($mission_board_type){ //소문내기?>
		<div class="">
			<dl>
				<dt><p class="emphasisInfo"><span class="txt_emphasis">*</span>는 필수 입력 항목입니다!!!</p></dt>
				<dd>
					<ul>
						<li>
							<label><span class="star_icon">*</span>제목</label>
							<input type="text" name="hero_title" id="hero_title" />
						</li>
						<li>
							<label>작성자</label>
							<?=$_SESSION['temp_nick'];?>
						</li>
						<li>
							<label><span class="star_icon">*</span>대표이미지</label>
							<div id="present_image_area">
								<? if($hero_thumb){ ?>
									<img src="<?=$hero_thumb?>" style="width:200px;margin-top:10px;"><br/>
								<? }?>
							</div>
							<label for="write_hero_thumb" id="link" class="btnUpload">사진 업로드</label>
							<input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$hero_thumb?>"/>
							<span style="color:#ff0000">* 10MB 이하로 업로드해 주세요.</span>
						</li>
						<li>
							<label>
								<? if(strpos($out_row["hero_question_url_list"],"블로그") !== false) { ?>
									<span class="star_icon">*</span>
								<? } ?>
								네이버 블로그
							</label>
							<div>
								<input type="text" name="naver_url" placeholder="반드시 포스팅 URL을 입력해주세요." class="inputUrl" value=""/>
								<input type="hidden" name="naver_admin_check" id="naver_admin_check" />
								<? if($out_row["hero_ftc"] == "1") {?>
									<a href="javascript:;" onClick="fnAdminCheck('naver')" class="btnUrlCheck">공정위문구확인</a> 	
									<p class="txt_url_check" id="txt_naver_url_check"></p>
								<? } ?>
								<dl class="urlAgreeBox">
									<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
									<dd>
										<div class="input_radio"><input type="radio" name="naver_member_check" id="naver_member_check_Y" value="Y"/><label for="naver_member_check_Y">예</label></div>
										<div class="input_radio"><input type="radio" name="naver_member_check" id="naver_member_check_N" vlaue="N"/><label for="naver_member_check_N">아니오</label></div>
									</dd>
								</dl>
								<p class="fz24 txt_agree_info mgb10">
									※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
								</p>
							</div>
						</li>
						<li>
							<label>
								<? if(strpos($out_row["hero_question_url_list"],"인스타그램") !== false) { ?>
									<span class="star_icon">*</span>
								<? } ?>
								인스타그램
							</label>
							<div>
								<input type="text" name="insta_url" placeholder="반드시 포스팅 URL을 입력해주세요." class="inputUrl" value=""/>
								<input type="hidden" name="insta_admin_check" id="insta_admin_check" />
								<? if($out_row["hero_ftc"] == "1") {?>
									<a href="javascript:;" onClick="fnAdminCheck('insta')" class="btnUrlCheck">공정위문구확인</a> 	
									<p class="txt_url_check" id="txt_insta_url_check"></p>
								<? } ?>
								<dl class="urlAgreeBox">
									<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
									<dd>
										<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_Y" value="Y" /><label for="insta_member_check_Y">예</label></div>
										<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_N" vlaue="N" /><label for="insta_member_check_N">아니오</label></div>
									</dd>
								</dl>
								<p class="fz24 txt_agree_info mgb10">
									※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
								</p>
							</div>
						</li>
						<? if($_GET['board'] == 'group_04_27' || $out_row["hero_table"] == "group_04_27"){ ?>
						<li>
							<label>후기(영상)</label>
							<div class="ui_urlBox">
								<div class="ui_url">
									<input type="text" name="movie_url[]" placeholder="반드시 포스팅 URL을 입력해주세요." class="inputUrl3" value=""/>
									<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 
									<dl class="urlAgreeBox">
										<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
										<dd>
											<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_Y" value="Y" /><label for="movie_member_check1_Y">예</label></div>
											<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_N" vlaue="N" /><label for="movie_member_check1_N">아니오</label></div>
										</dd>
									</dl>
									<p class="fz24 txt_agree_info mgb10">
										※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
									</p>
								</div>
							</div>
						</li>
						<? } ?>
						<li>						
							<label>카페</label>
							<div class="ui_urlBox">
								<div class="ui_url">
									<input type="text" name="cafe_url[]" placeholder="반드시 포스팅 URL을 입력해주세요." class="inputUrl3"/>
									<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 
									<dl class="urlAgreeBox">
										<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
										<dd>
											<div class="input_radio"><input type="radio" name="cafe_member_check1" id="cafe_member_check1_Y" value="Y"/><label for="cafe_member_check1_Y">예</label></div>
											<div class="input_radio"><input type="radio" name="cafe_member_check1" id="cafe_member_check1_N" vlaue="N"/><label for="cafe_member_check1_N">아니오</label></div>
										</dd>
									</dl>
									<p class="fz24 txt_agree_info mgb10">
										※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
									</p>
								</div>
							</div>
						</li>
						<li>
							<label>기타</label>
							<div class="ui_urlBox">
								<div class="ui_url">
									<input type="text" name="etc_url[]" placeholder="반드시 포스팅 URL을 입력해주세요." class="inputUrl3"/>
									<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a> 
									<dl class="urlAgreeBox">
										<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
										<dd>
											<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_Y" value="Y" /><label for="etc_member_check1_Y">예</label></div>
											<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_N" vlaue="N"/><label for="etc_member_check1_N">아니오</label></div>
										</dd>
									</dl>
									<p class="txt_agree_info mgb10">
										※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
									</p>
								</div>
							</div>
						</li>
					</ul>
					<div class="infoBox line-none">
						<p class="fz24 fw500">
							※ AK LOVER에서 진행되는 모든 체험단은 공정거래위원회 표시광고법 지침에 따라 제품을 제공받아 후기를 작성하실 경우, 대가성 여부를 표시하는 것을 규정상 원칙으로 하고 있습니다.<Br/>
							※ 네이버 블로그, 인스타그램 URL은 1개만 등록 가능하며, 후기(영상), 카페, 기타 URL만 최대 5개까지 등록을 제공합니다.<br/>
							※ 기타란은  트위터, 카카오스토리, 페이스북 등 URL을 입력합니다.
						</p>
					</div>
				</dd>
			</dl>
		</div>
        <? } //소문내기?>
        <div class="step step03">
        <!-- (s) 배송  -->
        	<? if($out_row['hero_type'] != 8) { ?>
        	<!-- <p class="tit"><span class="star_icon">*</span> (필수) 체험단 상품을 배송 받을 주소를 입력해주세요.</p> -->
        	<? } else { ?>
        	<!-- <p class="tit"><span class="star_icon">*</span> (필수) 포인트 체험단 혜택을 수령하실 휴대폰 번호를 입력해주세요.</p> -->
        	<? }?>        	
        	<dl class="sns_input_bx address_box">
				<dt class="fz30 fw600 li_tit">받으시는 분 정보 입력</dt>
				<dd>
					<ul>
						<li>
							<label for="hero_new_name">받으시는분</label> 
							<input type="text" name="hero_new_name" id="hero_new_name" value="<?=$member_rs['hero_name']?>">
						</li>
						<li>
							<?
								$next = str_ireplace ( '-', '', $member_rs["hero_hp"]);
								$next = str_ireplace ( '~', '', $next );
								$next = str_ireplace ( '_', '', $next );
								$next = str_ireplace ( '/', '', $next );
							?>
							<label for="hero_hp_01">연락처</label> 
							<div class="f_b phone">
								<input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode: disabled;" /> - 
								<input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode: disabled;" /> - 
								<input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" style="ime-mode: disabled;" />
							</div>
						</li>
						<? if($out_row['hero_type'] != 8) { ?>
							<li>
								<label for="hero_address_01">주소</label>
								<input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_rs['hero_address_01']?>" style="width:78%;" onclick="javascript:btnAddressGet()" readonly /> <a href="javascript:btnAddressGet()" class="btn_post">우편번호</a><br />
								<input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_rs['hero_address_02']?>" style="margin:1.2rem 0 0 0;" onclick="javascript:btnAddressGet()" readonly />
								<input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_rs['hero_address_03']?>" style="margin:1.2rem 0 0 0;">
							</li>
						<? } else { ?>
							<input type="hidden" name="hero_address_01" value="<?=$member_rs['hero_address_01'];?>"> 
							<input type="hidden" name="hero_address_02" value="<?=$member_rs['hero_address_02'];?>"> 
							<input type="hidden" name="hero_address_03" value="<?=$member_rs['hero_address_03'];?>"> 
						<? }?>
					</ul>
				</dd>
			</dl>
        <!-- (e) 배송 -->	
       
		<!-- (s) 슈퍼패스 -->
		<? if($out_row['hero_superpass']=='Y'){	?>
		<ul class="sns_input_bx require_box">	
			<li>
				<dl>
					<dt class="fz30 fw600 li_tit"><span class="question_num">슈퍼패스 사용 여부</dt>
					<dd>
						<div class="superpassBox">
						<? if($member_rs["superpass_count"]==0){ ?>
							<li class="fz24 bold">사용할 수 있는 슈퍼패스가 없습니다.</li>	
						<? }else if(countSuperpass($out_row['hero_select_count'])<=$out_row['enrolled_superpass']){ ?>
							<li class="fz24 bold">본 체험단의 슈퍼패스는 선착순으로 마감되었습니다.</li>
						<? } else if($member_rs["superpass_count"] > 0){ ?> 
							<li class="point_radio">
								<div class="f_b">
									<span class="fz15 bold">슈퍼패스를 사용하시겠습니까?</span>
									<div class="input_chk"><input type="checkbox" name="hero_superpass" id="hero_superpass" value="Y" style="width:20px;"><label for="hero_superpass" class="input_chk_label">확인</label></div>
								</div>
								<span class="fz14 500">*슈퍼패스는 신청이 완료된 후에 수정할 수 없으니 신중히 선택해 주시기 바랍니다.</span>
							</li>							
						<? } ?>		
						</div>
					</dd>
				</dl>
			</li>
		</ul>
		<? } ?>

        <? if($out_row['delivery_point_yn'] == "Y"){
        	$use_point = $member_rs['total_user_point']-$member_rs['total_use_point'];
        ?>		
		<dl class="delivery">
			<dt class="fz30 fw600 li_tit">배송비 포인트 차감 여부</dt>
			<dd>		
				<ul>
					<li class="point_radio">
						<div class="">
							<span class="fz15 bold"><?=$_DELIVERY_POINT?>포인트를 차감하시겠습니까?</span>
							<div class="input_radio" style="margin-left: 1rem;"><input type="radio" name="delivery_point_yn" id="delivery_point_yn1" value='Y' style="width: 20px;"><label for="delivery_point_yn1" style="width: 20px;">예</label></div>
							<div class="input_radio" style="margin-left: 1rem;"><input type="radio" name="delivery_point_yn" id="delivery_point_yn2" value='N' style="width: 20px;" checked><label for="delivery_point_yn2" style="width: 50px;">아니오</label></div>
						</div>
						<span class="fz24 500">* <?=$_DELIVERY_POINT?>포인트 차감하지 않을 시 체험단 제품은 착불로 배송됩니다.</span>
					</li>
					<li class="desc fz26 fw500">					
						해당 항목에 ‘예’ 체크하면 체험단 신청 시 가용포인트 <?=$_DELIVERY_POINT?>포인트가 선차감 됩니다.<br/>
						체험단 당첨 시 제품은 무료로 배송됩니다.<br/> 체험단 미 당첨 시 차감 된 포인트는 환불해 드립니다.<br/>
						(가용포인트가 부족할 경우, 체크 불가)
					</li>	
				</ul>
			</dd>
		</dl>
		<? } ?>
       </div>      	
        <? if($out_row['hero_type'] != 1) { ?>
		<ul class="sns_input_bx require_box">	
			<li>
				<div class="agree">
					<div class="title">[필수] <span class="number">콘텐츠 활용 동의</span></div>
					<ul>
						<li class="agree_cont fz26 fw500">
							AK Lover 활동의 일환으로 작성한 모든 콘텐츠(저작물)와 관련된 권리(저작권, 초상권 등)를 AK Lover
							활동으로 진행한 국/내외 관련제품 및 브랜드 웹사이트, 홈쇼핑 방송, 온라인/오프라인 광고, 기타 광고, 홍보 및 마케팅 자료로 AK Lover 활동 중,
							활동이 종료된 후에도 본인이 동의 철회 의사를 밝히기 전까지 무상으로 자유롭게 이용할 권리 및 2차적 저작물 작성권을 애경산업㈜에 허락하며 이에 동의합니다.<br/>
						</li>
						<li class="agreechk">
							<div>				
								<p class="fz24 fw600">위 내용에 동의하십니까?</p>
									<p class="fz24 fw500">
									<? if($out_row['hero_type'] == 2) { ?>
										* 콘텐츠 활용 미 동의 시 소문내기 참여가 불가합니다.
									<? } else if($out_row['hero_type'] == 10) { ?>
										* 콘텐츠 활용 미 동의 시 체험단 참여가 불가합니다.
									<? } else { ?>
										* 콘텐츠 활용 미 동의 시 체험단 신청이 불가합니다.
									<? } ?>
								</p>
							</div>
							<div class="input_chk"><input type="checkbox" name="hero_agree" id="hero_agree" value='Y'> <label for="hero_agree" class="input_chk_label fz24">콘텐츠 활용 동의</label></div>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		<? } ?>  	            
       </div>    
       <div class="btn_bx">
       		<a href="javascript:;" class="btn_submit btn_color" onClick="javascript:go_submit(document.form_next)">등록하기</a>
       </div>
    </form>
	</div>
</div> 
<!--컨텐츠 종료-->
<? include_once "tail.php"; ?>

<script type="text/javascript">
<? if ( $out_row['delivery_point_yn']=='Y' ) { ?> 
var use_point		= <?=$use_point?>;
var delivery_point	= <?=$_DELIVERY_POINT?>;
<? } ?>

var clipboard_naver = new Clipboard('.btn_clip_naver');
clipboard_naver.on('success', function(e) {
	alert("네이버블로그 공정위문구가 복사 되었습니다.");
});

clipboard_naver.on('error', function(e) {
    console.log(e);
});

var clipboard_insta = new Clipboard('.btn_clip_insta');
clipboard_insta.on('success', function(e) {
	alert("인스타그램 공정위문구가 복사 되었습니다.");
});

clipboard_insta.on('error', function(e) {
    console.log(e);
});

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
				alert("네이버 블로그를 입력해주세요.");
				$("input[name='naver_url']").focus();
				return;
			}
		} else if(gubun == "insta") {
			var param = "mode=insta_url_check&insta_url="+$("input[name='insta_url']").val()+"&search_keyword=<?=$search_ftc_insta?>";
			if(!$("input[name='insta_url']").val()) {
				alert("인스타그램  URL을 입력해주세요.");
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
							$("#txt_naver_url_check").html("공정위문구가 확인되었습니다.");
						} else if(gubun == "insta") {
							$("#insta_admin_check").val("Y");
							$("#txt_insta_url_check").addClass("txt_success");
							$("#txt_insta_url_check").html("공정위문구가 확인되었습니다.");
						}
					} else {
						if(gubun == "naver") {
							var html  = "공정위 문구 미작성시 후기 등록이 불가합니다.";
							html += "<br/>반드시, 아래 문구 그대로 콘텐츠 하단에 기입 부탁드립니다.<br/>";
							html += '<span style="color:#000; line-height:24px;"><?=$out_row["hero_ftc_naver"]?> <a href="javascript:;" class="btn_copy btn_clip_naver" data-clipboard-text="<?=$out_row['hero_ftc_naver']?>">공정위문구 복사하기</a></span>';
							
							$("#naver_admin_check").val("N");
							$("#txt_naver_url_check").removeClass("txt_success");
							$("#txt_naver_url_check").html(html);
						} else if(gubun == "insta") {
							var html  = "공정위 문구 미작성시 후기 등록이 불가합니다.";
								html += "<br/>반드시, 아래 문구 그대로 콘텐츠 상단에 기입 부탁드립니다.<br/>";
								html += '<span style="color:#000; line-height:24px;"><?=$out_row["hero_ftc_insta"]?> <a href="javascript:;" class="btn_copy btn_clip_insta" data-clipboard-text="<?=$out_row['hero_ftc_insta']?>">공정위문구 복사하기</a></span>';
							
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
				alert("최대 5개까지 등록 가능합니다.");
				return;
			}
		} else if(type == "minus"){
			var ui_urlBox = $(t).parents(".ui_url");
			ui_urlBox.remove();
		}
	}
	
	//가용포인트 체크
	$("input[name=delivery_point_yn]").on('click', function(){
		if($(this).val() == "Y") {
			if( use_point < delivery_point ) {
				alert("가용포인트가 부족합니다.");
				$('input[name=delivery_point_yn]:input[value="N"]').prop("checked", true);
			}
		}
	})
	
    //대표사진 업로드
    $("#write_hero_thumb").change(function(){

        var filename = $(this).val();

        var tf_extension = extension_check(filename,"image");

        if(tf_extension==false){
            $(this).val("");
            return false;
        }

        var options=
        {
	                success: function(data){
	                    if(data=='0'){
	                        alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
	                        return false;
	                    }else{
	                        $("#present_image_area").html("<img src='"+data+"' style='margin:10px 0;'/>");
	                        data = trim(data);
	                        $("#hero_thumb").val(data);
	                    }
	                },beforeSend:function(){
	                    $('.img-loading').css('display','block');
	                }
	                ,complete:function(){
	                    $('.img-loading').css('display','none');
	             
	                },error:function(e){  
	                    alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
	                    return false;
	                } 
	        };
	        $('#write2_file_upload').ajaxForm(options).submit();
                    
    	});
    
	});

	function block_blog(){
		var selected = $('#hero_select_01').val();
		var sel_no = '';
		
		if(selected=='블로그 URL')	var sel_no = 0;
		else if(selected=='페이스북 URL') var sel_no = 1;
		else if(selected=='트위터 URL') var sel_no = 2;
		else if(selected=='미투데이 URL') var sel_no = 3;
		else if(selected=='그외 SNS URL') var sel_no = 4;
		else if(selected=='카카오스토리 URL')	var sel_no = 5;
		
		for (var j = 0; j < 6; j++) {
			if(sel_no!=j){
				$('#hero_blog_0'+j).prop('disabled','disabled').prop('name','');
			}else{
				var i = j
				$('#hero_blog_0'+j).prop('disabled','').prop('name','hero_01');
			}
		}
		$('#hero_blog_0'+i).focus();
	}

    //신청하기
    function go_submit(form) {
    	var expUrl = /^http[s]?\:\/\//i; //url 체크
        var hero_select_01 = $('#hero_select_01');
        var new_name = form.hero_new_name;
        var thumb 			= form.hero_thumb;
        var board_title     = form.hero_title;
        var hero_04			= form.hero_04;
        var address_01 = form.hero_address_01;
        var address_02 = form.hero_address_02;
        var hero_superpass	= form.hero_superpass;

        var hero_question_url_check = "<?=$out_row["hero_question_url_check"]?>"; //URL 필수 값 체크
        var hero_type = "<?=$out_row["hero_type"]?>"; //URL 필수 값 체크
        var hero_blog_00	= form.hero_blog_00;
		var hero_blog_01 	= form.hero_blog_01;
		var hero_blog_02 	= form.hero_blog_02;
		var hero_blog_03 	= form.hero_blog_03;
		var hero_blog_04	= form.hero_blog_04;
		var hero_blog_05 	= form.hero_blog_05;
		var hero_blog_06 	= form.hero_blog_06;
		
        var hp_01 = form.hero_hp_01;
        var hp_02 = form.hero_hp_02;
        var hp_03 = form.hero_hp_03;
       
        var hero_01 = form.hero_01;

		var hero_blog = "";
		var val_chk = true;

		var mission_board_type = false;
		if(hero_type == "2" || hero_type == "10") {
			mission_board_type = true;
		}
		
		//URL 필수값 체크 추가
		if(mission_board_type == false) {
			if(hero_question_url_check == "1") {
				if(!$("input[name='hero_blog_00']").val()) {
					alert("네이버 블로그 URL을 입력해 주세요.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "2") {
				if(!$("input[name='hero_blog_04']").val()) {
					alert("인스타그램 URL을 입력해 주세요.");
					$("input[nam='hero_blog_04']").focus();
					return false;
				}
			} else if(hero_question_url_check == "3") {
				if(!$("input[name='hero_blog_00']").val() && !$("input[name='hero_blog_04']").val()) {
					alert("네이버 블로그/인스타그램 URL 중  한개의 URL은 필수로 입력하셔야 합니다.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "4") {
				if(!$("input[name='hero_blog_00']").val() || !$("input[name='hero_blog_04']").val()) {
					alert("네이버 블로그, 인스타그램 URL은 필수로 입력하셔야 합니다.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			} else if(hero_question_url_check == "5") {
				if(!$("input[name='hero_blog_03']").val()) {
					alert("영상 채널 URL을 입력해 주세요.");
					$("input[nam='hero_blog_03']").focus();
					return false;
				}
			} else if(hero_question_url_check == "6") {
				if(!$("input[name='hero_blog_00']").val() && !$("input[name='hero_blog_04']").val() && !$("input[name='hero_blog_03']").val()) {
					alert("네이버 블로그/인스타그램/영상 채널 URL 중 한개의 URL은 필수로 입력하셔야 합니다.");
					$("input[name='hero_blog_00']").focus();
					return false;
				}
			}
		}

		$('.hero_blog').each(function(index) {
			blog_value = ""
;			if(this.name == "hero_blog_00") {
				blog_value = "https://blog.naver.com/" + this.value;
			} else if(this.name == "hero_blog_04") {
				blog_value = "https://www.instagram.com/" + this.value;
			} else {
    			if(!expUrl.test(this.value) && this.value) {
    				alert("SNS URL http:// 또는 https:// 필수로 입력이 필요합니다.");
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

		var surveyCheck = true;
        // $(".answer_box").each(function(index, item){
        $(".survey").each(function(index, item){ //250403 - 뮤자인 수정 YDH
			var _textarea = $(this).find("textarea");
			var _checkbox = $(this).find("input[type='checkbox']:checked");
			var _checkbox_necessary = $(this).find("input[type='checkbox']");
			var _radio = $(this).find("input[type='radio']:checked");
			var _radio_necessary = $(this).find("input[type='radio']");
			if(!_textarea.val() && _textarea.attr("title")) {
				alert("필수문항 미응답시 체험단 신청이 불가합니다.\n"+_textarea.attr("title")+"을 확인해 주세요");
				_textarea.focus();
				surveyCheck = false;
				return false;
			}

			if(_checkbox_necessary.attr("title") && !_checkbox.val()) {
				alert("필수문항 미응답시 체험단 신청이 불가합니다.\n"+_checkbox_necessary.attr("title")+"을 확인해 주세요");
				_checkbox.focus();
				surveyCheck = false;
				return false;
			}

			if(_radio_necessary.attr("title") && !_radio.val()) {
				alert("필수문항 미응답시 체험단 신청이 불가합니다.\n"+_radio_necessary.attr("title")+"을 확인해 주세요");
				_radio.focus();
				surveyCheck = false;
				return false;
			}
		})
		
		if(!surveyCheck) return;

		<? if($mission_board_type){ ?>
			if(board_title.value == "") {
				alert('제목을 입력해주세요.');
				board_title.focus();
				return false;
			}
			
	        if(thumb.value == ""){
	            alert("대표 이미지를 등록해주세요.");
	            return false;
	        }else{
	        	thumb.style.border = '';
	        }

	        <? if(strpos($out_row["hero_question_url_list"],"블로그") !== false) { ?>
			if(!$("input[name='naver_url']").val()) {
				alert("네이버 블로그 URL을 입력해 주세요.");
				$("input[name='naver_url']").focus();
				return;
			}	
			<? } ?>
			
			if($("input[name='naver_url']").val()) {
				if(!expUrl.test($("input[name='naver_url']").val())) {
					alert("네이버 블로그 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
					$("input[name='naver_url']").focus();
					return;
				}
				<? if($out_row["hero_ftc"] == "1") {?>
				if($("input[name='naver_admin_check']").val() != "Y") {
					alert("네이버 블로그 공정위 문구 확인 후 진행해 주세요.");
					return;
				}
				<? } ?>
	
				if($("input:radio[name='naver_member_check']:checked").val() != "Y") {
					alert("네이버 블로그 공정거래위원회 문구 작성에 동의해주세요.");
					return;
				}
			}
	
			<? if(strpos($out_row["hero_question_url_list"],"인스타그램") !== false) { ?>
				if(!$("input[name='insta_url']").val()) {
					alert("인스타그램  URL을 입력해 주세요.");
					$("input[name='insta_url']").focus();
					return;
				}	
			<? } ?>
	
			if($("input[name='insta_url']").val()) {
				if(!expUrl.test($("input[name='insta_url']").val())) {
					alert("인스타그램 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
					return;
				}
	
				<? if($out_row["hero_ftc"] == "1") {?>
				if($("input[name='insta_admin_check']").val() != "Y") {
					alert("인스타그램 공정위 문구 확인 후 진행해 주세요.");
					return;
				}
				<? } ?>
	
				if($("input:radio[name='insta_member_check']:checked").val() != "Y") {
					alert("인스타그램 공정거래위원회 문구 작성에 동의해주세요.");
					return;
				}
	
			}
	
			<? if($_GET ['board'] == 'group_04_27') { ?>
			var movieUrlCheck = true;
			var movieMemberCheck = true;
	       	$("input[name='movie_url[]']").each(function(i){
	           	if($(this).val()) {
	           		if(!expUrl.test($(this).val())) {
		           		alert("후기(영상) URL http:// 또는 https:// 필수로 입력이 필요합니다.");
		           		movieUrlCheck = false;
						return false;
	           		}
	
	           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
	                    alert("후기(영상) 공정거래위원회 문구 작성에 동의해주세요.")
	             	   movieMemberCheck = false;
	             	   return false;
	                }
	            }
	        })
	        if(!movieUrlCheck) return;
	        if(!movieMemberCheck) return;
	        <? } ?>
	
	        var cafeUrlCheck = true;
			var cafeMemberCheck = true;
	       	$("input[name='cafe_url[]']").each(function(i){
	           	if($(this).val()) {
	           		if(!expUrl.test($(this).val())) {
		           		alert("카페 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
		           		cafeUrlCheck = false;
						return false;
	           		}
	
	           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
	                    alert("카페 공정거래위원회 문구 작성에 동의해주세요.")
	             	   cafeMemberCheck = false;
	             	   return false;
	                }
	            }
	        })
	        if(!cafeUrlCheck) return;
	        if(!cafeMemberCheck) return;
	
	        var etcUrlCheck = true;
			var etcMemberCheck = true;
	       	$("input[name='etc_url[]']").each(function(i){
	           	if($(this).val()) {
	           		if(!expUrl.test($(this).val())) {
		           		alert("기타 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
		           		etcUrlCheck = false;
						return false;
	           		}
	
	           		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
	                    alert("기타 공정거래위원회 문구 작성에 동의해주세요.")
	             	   etcMemberCheck = false;
	             	   return false;
	                }
	            }
	        })
	        if(!etcUrlCheck) return;
	        if(!etcMemberCheck) return;

	        var url_value_check = false; //포스팅 URL 1개는 반드시 등록이 필요함
	    	$(".inputUrl").each(function(i){
	    		if($(this).val()) url_value_check = true;
	    	})
	    	
	    	if(!url_value_check) {
	    		alert("포스팅 URL은 1건 이상 등록이 필요합니다.");
	    		return;
	    	}
		<? } //소문내기 ?>

        if(new_name.value == ""){
            alert("받으시는분 이름을 입력해주세요.");
            new_name.style.border = '1px solid red';
            new_name.focus();
            return false;
        }else{
            new_name.style.border = '1px solid #e4e4e4';
        }
		
		<? if($out_row['hero_type'] != 8) { ?>
        if(address_01.value == ""){
            alert("배송지 주소 입력해주세요.");
            address_01.style.border = '1px solid red';
            address_01.focus();
            return false;
        }else{
            address_01.style.border = '1px solid #e4e4e4';
        }
        if(address_02.value == ""){
            alert("배송지 주소 입력해주세요.");
            address_02.style.border = '1px solid red';
            address_02.focus();
            return false;
        }else{
            address_02.style.border = '1px solid #e4e4e4';
        }
        <? }?>
        
        if(hp_01.value == ""){
            alert("연락처를 입력해주세요.");
            hp_01.style.border = '1px solid red';
            hp_01.focus();
            return false;
        }else{
            hp_01.style.border = '1px solid #e4e4e4';
        }
        if(hp_02.value == ""){
            alert("연락처를 입력해주세요.");
            hp_02.style.border = '1px solid red';
            hp_02.focus();
            return false;
        }else{
            hp_02.style.border = '1px solid #e4e4e4';
        }
        if(hp_03.value == ""){
            alert("연락처를 입력해주세요.");
            hp_03.style.border = '1px solid red';
            hp_03.focus();
            return false;
        }else{
            hp_03.style.border = '1px solid #e4e4e4';
        }
		
		<? if($out_row['hero_type'] == 8) { ?>
		if(!form.hero_confirm.checked){
			alert("포인트 체험단 진행 과정을 확인해야 신청이 가능합니다");
        	form.hero_confirm.focus();
            return false;				
		}
	   <? } ?>
	   
		<? if($out_row['hero_type'] != 1) { ?>
      	//개인정보 활용 동의
		if(!form.hero_agree.checked){
			alert("컨텐츠 활용에 동의해야 체험단 신청이 가능합니다");
        	form.hero_agree.focus();
            return false;				
		}
		<? } ?>

		var r = true; // 160311 추가 ajax에서 바로 return false 사용 시 기능 안됨 그래서 전역변수 추가
		if(typeof hero_superpass != "undefined" && hero_superpass.checked==true){
			
			if(confirm("슈퍼패스를 사용하시겠습니까?")){
				    var url="/board/thumbnail_02/getSuperpassData.php";  
				    var params="idx="+<?=$_GET['mission_idx']?>;  
				  
				    $.ajax({      
				        type:"POST",  
				        url:url,      
				        data:params,
						async: false,   // 160311 ajax에서 전역변수에 값을 담기위해선 async: false 필요      
				        success:function(args){   
				            if(args==0){
								if(confirm("본 체험단의 슈퍼패스는 선착순으로 마감되었습니다. 슈퍼패스 없이 체험단에 참여하시겠습니까?")){
									hero_superpass.checked=false;
									r=true;
								}else{
									hero_superpass.checked=false;
					            	r=false;
								}	
									
					        }else if(args==9)	alert("시스템 에러입니다. 다시 시도해 주세요.");
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