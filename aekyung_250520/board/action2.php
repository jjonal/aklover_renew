<?
if(!defined('_HEROBOARD_'))exit;

if(!strcmp($_SESSION['temp_level'], '') || !$_GET['action'] || !$_POST["hero_code"]){
	error_location('비정상적인 접근입니다. 로그인 후에 다시 시도해 주세요.', '/main/index.php?board=login');
	exit;
}

if(!$_GET['action'] || !$_GET['view'] || !$_GET['page']){
	error_historyBack('비정상적인 접근입니다.');
	exit;
}

## 변수설정
######################################################################################################################################################
	$today = date( "Y-m-d", time());
	$full_today = date("Y-m-d H:i:s");
	
    $my_code 		= 		$_SESSION['temp_code'];
    $my_level 		= 		$_SESSION['temp_level'];
    $my_write 		= 		$_SESSION['temp_write'];
    $my_view 		= 		$_SESSION['temp_view'];
    $my_update 		= 		$_SESSION['temp_update'];
    $my_rev 		= 		$_SESSION['temp_rev'];
    $my_id			=		$_SESSION['temp_id'];
    $my_name		=		$_SESSION['temp_name'];
    $my_nick		=		$_SESSION['temp_nick'];

	$idx 			=		$_GET['hero_idx'];
	$mission_idx    = 		$_GET['mission_idx'];
	$action			=		$_GET['action'];
	$board			=		$_GET['board'];
	$page			=		$_GET['page'];
	$next_board		=		$_GET['next_board'];
	
	$hero_title	 	= 		$_POST['hero_title'];
	$hero_table		= 		$_POST['hero_table'];
	
	$drop_check 	= 		explode('||', $_POST['hero_drop']);
    $table 			= 		'board';
	$point_type		=		"total";
	
	
	$url = array();
	$gubun = array();
	$member_check = array();
	
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

	## 본문내용 처리
	######################################################################################################################################################
	if(($action=='update' && is_numeric($idx)) || $action=='write'){
		
		if($action=='update' && $my_level<9999){
			$sql = "select count(*) as count from board where hero_idx='".$idx."' and hero_code='".$my_code."'";
			$board_res = mysql_query($sql);
			
			if(!$board_res){
				logging_error($my_nick, $board."-MISSION_ACTION_03_02", $full_today);
				error_historyBack("");
			}
			
			$list = mysql_fetch_assoc($board_res);
			
			if(!$list['count']){
				error_historyBack("잘못된 접근입니다.");
				exit;
			}
		}

	}
	
	##	업데이트
	######################################################################################################################################################
	if($action=='update' && is_numeric($idx)){
	
		//TODO 테스트 필요  2021-03-30
		$sql  = " UPDATE board SET ";
		$sql .= " hero_title = '".$_POST["hero_title"]."' ";
		$sql .= " , hero_thumb = '".$_POST["hero_thumb"]."' ";
		$sql .= " , hero_product_review = '".$_POST["hero_product_review"]."' ";
		$sql .= " , akbeauty_id = '".$_POST["akbeauty_id"]."' ";
		$sql .= " WHERE hero_idx = '".$idx."' ";
 
		$out_sql = mysql_query($sql);
		if(!$out_sql){
	
			logging_error($hero_code, $board."-MISSION_ACTION_03_05-".$sql, $full_today);
			error_historyBack("");
			exit;
	
		}
		
		$del_mission_url_sql = " DELETE FROM mission_url WHERE board_hero_idx = '".$idx."' ";
		sql($del_mission_url_sql);
		
		//SNS(수정모드) 등록
		for($i=0; $i<count($url); $i++) {
			$gubun_val = $gubun[$i];
			$url_val = $url[$i];
			$member_check_val = $member_check[$i];
			$admin_check_val = $admin_check[$i];
				
			$url_sql  = " INSERT INTO mission_url (board_hero_idx, gubun, url, member_check, admin_check) VALUES ";
			$url_sql .= " ('".$idx."','".$gubun_val."','".$url_val."','".$member_check_val."','".$admin_check_val."') ";
			sql($url_sql);
		}
	
	
		## 업데이트하면서 필요없어진 파일 삭제 기능 -> 무슨 이유에서인지 주석처리되어 있음.
			######################################################################################################################################################
			/* $drop_action_img = $list['hero_command'];
			$code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
	
			preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
			while(list($code_key, $code_val) = @each($code_main[1])){
			if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
			if(!strcmp(eregi($code_val,$command),'1')){
			continue;
			}else{
			$check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
			//                @unlink($check_file);
			}
			}else{
			continue;
			}
			} */
	
	
	
	
		## 새 글
	######################################################################################################################################################
	}elseif($action=='write'){
	
	
		## 글 등록시 중복 체크
		######################################################################################################################################################
		$duplecateInsertCheck = "select hero_idx, hero_table from board where hero_code='".$my_code."' and hero_title='".$hero_title."' and hero_table='".$hero_table."' and left(hero_today,10)='".$today."'";
		//echo $duplecateInsertCheck."<br/>";
		//exit;
		$duplecateInsertCheck_res = mysql_query($duplecateInsertCheck);
		if(!$duplecateInsertCheck_res){
	
			logging_error($my_nick, $board."-MISSION_ACTION_03_06", $full_today);
			error_historyBack("");
				
		}
	
		$check_rs = mysql_fetch_assoc($duplecateInsertCheck_res);
	
		if($check_rs['hero_idx']){
			$href = "/main/index.php?board=".$check_rs['hero_table']."&next_board=".$check_rs['hero_table']."&page=1&view=view&idx=".$check_rs['hero_idx'];
			error_location('해당 글은 이미 등록되었습니다.',$href );
			exit;
		}
	
	
		## auto increase check
		######################################################################################################################################################
		$idx_sql = "SHOW TABLE STATUS LIKE 'board'";
	
		$out_idx_sql = mysql_query($idx_sql);
		if(!$out_idx_sql){
			logging_error($my_nick, $board."-MISSION_ACTION_03_07", $full_today);
			error_historyBack("");
		}
	
		$idx_list                             = @mysql_fetch_assoc($out_idx_sql);
	
		$idx = $idx_list['Auto_increment'];
				
		$sql  = " INSERT INTO board (hero_idx, hero_code, hero_review, hero_today, hero_ip ";
		$sql .= " , hero_review_count, hero_name, hero_01, hero_notice, hero_03 ";
		$sql .= " , hero_table, hero_nick, hero_title, hero_thumb, hero_product_review ";
		$sql .= " , akbeauty_id, hero_agree ";
		if($hero_file) {
			$sql .= " , hero_board_one";
		}
		$sql .= " ) ";
		$sql .= " VALUES ('".$idx."','".$_POST["hero_code"]."','".$_POST["hero_review"]."',now(),'".$_POST["hero_ip"]."' ";
		$sql .= " ,'".$_POST["hero_review_count"]."','".$_POST["hero_name"]."','".$_POST["hero_01"]."','".$_POST["hero_notice"]."', '".$_POST["hero_03"]."' ";
		$sql .= " ,'".$_POST["hero_table"]."', '".$_POST["hero_nick"]."', '".$_POST["hero_title"]."', '".$_POST["hero_thumb"]."' , '".$_POST["hero_product_review"]."' ";
		$sql .= " ,'".$_POST["akbeauty_id"]."' ,'".$_POST["hero_agree"]."' ";
		if($hero_file) {
			$sql .= " , '".$hero_board_one."' ";
		}
		$sql .= " ) ";

		$pf = mysql_query($sql);
		if(!$pf){
			logging_error($my_nick, $board."-MISSION_ACTION_03_08", $full_today);
			error_historyBack("");
			exit;
		}

	
	
		##  포인트 및 등업체크
		######################################################################################################################################################
		//포인트 부여 및 등업기능//고유번호,테이블,날짜,total/user,글 등록시 고유번호,리뷰등록시 고유번호,제목,최대포인트 포함여부
		//$point_rs = pointInsert($board, "mission_write", $idx, 0, $hero_title, 'Y', $full_today );
		$point_rs = pointAdd($board, "mission_write", $idx, $mission_idx, 0, $hero_title, 'Y');
		if($point_rs!=1){
	
			$rollback_query = "delete from board where hero_idx='".$idx."'";
			//echo $rollback_query;
			$pf_rollback = mysql_query($rollback_query);
				if(!$pf_rollback){
					logging_error($my_nick, $board."-MISSION_ACTION_03_09", $full_today);
					}
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
 	
	
	}
	
	
	## href 셋팅
    ######################################################################################################################################################
    //전체공지사항의 경우
    /*
	if($_POST['hero_table']=='group_04_05' || $_POST['hero_table']=='group_04_06' || $_POST['hero_table']=='group_04_27' || $_POST['hero_table']=='group_04_28') 	$will_go_board = 'group_04_09';
	elseif($_POST['hero_03'])														$will_go_board = $_POST['hero_03'];
	else																			$will_go_board = $board;
	*/
	$will_go_board = $board;

//	$get_herf = "http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$will_go_board."&page=".$page."&view=view2&idx=".$idx;
    $get_herf = "http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$will_go_board."&view=step_05&page=".$page."&idx=".$_POST['hero_01'];
	
	######################################################################################################################################################
	$action_href = $get_herf;
	echo "<script>location.href='".$action_href."'</script>";
	exit;
	
?>