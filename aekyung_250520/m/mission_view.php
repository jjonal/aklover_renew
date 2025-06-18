<?
include_once "head.php";
#####################################################################################################################################################
$today = date( "Y-m-d", time());
if(!strcmp($_SESSION['temp_drop'], '')){
}else{
    $temp_drop = $_SESSION['temp_drop'];
    if($temp_drop<=$today){
        $sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        @sql($sql, 'on');
        $_SESSION['temp_write']=$_SESSION['temp_level'];
        $_SESSION['temp_view']=$_SESSION['temp_level'];
        $_SESSION['temp_update']=$_SESSION['temp_level'];
        $_SESSION['temp_rev']=$_SESSION['temp_level'];
        unset($_SESSION['temp_drop']);
    }
}

if(!strcmp($_SESSION['temp_level'], '')){
    $_SESSION['temp_level'] = '0';
    $_SESSION['temp_write'] = '0';
    $_SESSION['temp_view'] = '1';
    $_SESSION['temp_update'] = '0';
    $_SESSION['temp_rev'] = '0';
} else {
	$my_level = $_SESSION ['temp_level'];
	$my_write = $_SESSION ['temp_write'];
	$my_view = $_SESSION ['temp_view'];
	$my_update = $_SESSION ['temp_update'];
	$my_rev = $_SESSION ['temp_rev'];
}

$group_sql = " SELECT * FROM hero_group WHERE hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."' ";
$out_group = new_sql($group_sql,$error);
$right_list = mysql_fetch_assoc($out_group);

$sql  = " select * from mission as A, ";
$sql .= " (select count(hero_superpass) as superpass from mission_review where hero_old_idx='".$_GET ['mission_idx']."' ";
$sql .= " AND hero_table='".$_GET ['board']."' and hero_superpass ='Y') as B ";
$sql .= " where A.hero_kind != '구매체험'  AND hero_table = '".$_GET['board']."' AND hero_idx = '".$_REQUEST['mission_idx']."' ";
if($my_write < 9999) {
	$sql .= " AND A.hero_use = 1 ";
}

sql($sql, 'on');
$out_row = @mysql_fetch_assoc($out_sql);

$mission_board_type = false; //소문내기, 미션 인증하기 타입
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

$focus_group = false;
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_27" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
}

//선정자는 마감된 미션 상세 페이지 접근 권한 있음
$review_sql = " SELECT count(*) as cnt FROM mission_review WHERE hero_old_idx = '".$_GET ['mission_idx']."' AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = 1 ";
$review_res = sql($review_sql);
$review_rs = mysql_fetch_assoc($review_res);
$review_auth = false;
if($review_rs["cnt"] > 0) $review_auth = true;

//후기미작성자
if($review_auth) {
	$board_write_sql = " SELECT count(*) as cnt FROM board WHERE hero_01 = '".$_GET ['mission_idx']."' AND hero_code = '".$_SESSION["temp_code"]."' ";
	$board_write_res = sql($board_write_sql);
	$board_write_rs = mysql_fetch_assoc($board_write_res);
}

$check_day = date ( "Y-m-d", time () );
$today_04_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
$today_01_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_02'] ) );
if($review_auth == false) {
	if($focus_group){ //뷰티, 유튜버, 라이프클럽
		if ($my_write < '9999' and $today_01_02 < $check_day){
			if($out_row["hero_type"] == "7") { //자율미션
				$mission_last_day = $out_row['hero_today_04_02'];
				if($mission_last_day == "0000-00-00 00:00:00") {
					$last_day = date ( "Y-m-d", strtotime ( $out_row['hero_today_03_02'] ) );
				} else {
					$last_day = date ( "Y-m-d", strtotime ( $out_row['hero_today_04_02'] ) );
				}
			
				if ($my_write < '9999' and $last_day < $check_day){
			
					$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
					msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
					exit ();
				}
			} else if($out_row["hero_type"] == "9") { //정기미션(선택)
				$mission_last_day = $out_row['hero_today_04_02'];
				if($mission_last_day == "0000-00-00 00:00:00") {
					$last_day = date ( "Y-m-d", strtotime ( $out_row['hero_today_03_02'] ) );
				} else {
					$last_day = date ( "Y-m-d", strtotime ( $out_row['hero_today_04_02'] ) );
				}
					
				if ($my_write < '9999' and $last_day < $check_day){
						
					$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
					msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
					exit ();
				}	
			} else {
				if ($my_write < '9999' and $today_01_02 < $check_day){
					$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
					msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
					exit ();
				}
			}
			
		}
	}else{
		$mission_last_day = $out_row['hero_today_04_02'];
		if($mission_last_day == "0000-00-00 00:00:00") {
			$last_day = date ( "Y-m-d", strtotime ( $out_row['hero_today_03_02'] ) );
		} else {
			$last_day = date ( "Y-m-d", strtotime ( $out_row['hero_today_04_02'] ) );
		}
	
		if ($my_write < '9999' and $last_day < $check_day){
			$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
			//msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
			//exit ();
		}
	}
}

// 프리미엄 미션은 로그인이후 접속가능
$temp_auth_hero_code = $_SESSION["temp_code"];
if($focus_group) {
	if($_SESSION['temp_view'] != '9999' && $_SESSION['temp_view'] != '10000'){
		if($_GET['board'] == 'group_04_06'){
			if($_SESSION['temp_view'] != $right_list['hero_view']){
				if($out_row["hero_type"] == "7") { //자율체험
					if($_SESSION["before_beauty_auth"] != "Y") {
						$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
//						msg('죄송합니다. 이 미션은 뷰티클럽 기수만 참여할 수 있습니다. ', 'location.href="' . $action_href . '"' );
						msg('죄송합니다. 해당 미션은 ‘AK Lover 프리미어 뷰티클럽’ 분들에 한 해 참여 가능합니다.', 'location.href="' . $action_href . '"' );
						exit;
					}
				} else {
					$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
//					msg('죄송합니다. 이 미션은 현기수 뷰티클럽만 참여할 수 있습니다. ', 'location.href="' . $action_href . '"' );
					msg('죄송합니다. 해당 미션은 ‘AK Lover 프리미어 뷰티클럽’ 분들에 한 해 참여 가능합니다.', 'location.href="' . $action_href . '"' );
					exit;
				}
			}
		} else if($_GET ['board'] == 'group_04_27'){
			if($out_row["hero_movie_group"] == "group_04_27") {
				if($_SESSION['temp_view'] != "9995") {
					if($out_row["hero_type"] == "7") {
						if($_SESSION["before_beautymovie_auth"] != "Y") {
							$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
							msg('죄송합니다. 이 미션은 Beauty Club 영상팀 기수만 참여할 수 있습니다.', 'location.href="' . $action_href . '"' );
							exit;
						}
					} else {
						$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
						msg('죄송합니다. 이 미션은 현기수 Beauty Club 영상팀만 참여할 수 있습니다.', 'location.href="' . $action_href . '"' );
						exit;
					}
				}	
			} else if($out_row["hero_movie_group"] == "group_04_31") {
				if($_SESSION['temp_view'] != "9993") {
					if($out_row["hero_type"] == "7") {
						if($_SESSION["before_lifemovie_auth"] != "Y") {
							$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
							msg('죄송합니다. 이 미션은 Life Club 영상팀 기수만 참여할 수 있습니다.', 'location.href="' . $action_href . '"' );
							exit;
						}
					} else {
						$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
						msg('죄송합니다. 이 미션은 현기수 Life Club 영상팀만 참여할 수 있습니다.', 'location.href="' . $action_href . '"' );
						exit;
					}
				}	
			} else {
				$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
				msg('죄송합니다. 이 미션은 현기수 Life Club 영상팀만 참여할 수 있습니다.', 'location.href="' . $action_href . '"' );
				exit;
			}
		} else if($_GET ['board'] == 'group_04_28'){
			if($_SESSION['temp_view'] != $right_list['hero_view']){
				if($out_row["hero_type"] == "7") { //자율체험
					if($_SESSION["before_life_auth"] != "Y") {
						$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
//						msg('죄송합니다. 이 미션은 라이프클럽 기수만 참여할 수 있습니다. ', 'location.href="' . $action_href . '"' );
						msg('죄송합니다. 해당 미션은 ‘AK Lover 프리미어 라이프클럽’ 분들에 한 해 참여 가능합니다.', 'location.href="' . $action_href . '"' );
						exit;
					}
				} else {
					$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
//					msg('죄송합니다. 이 미션은 현기수 라이프클럽만 참여할 수 있습니다. ', 'location.href="' . $action_href . '"' );
					msg('죄송합니다. 해당 미션은 ‘AK Lover 프리미어 라이프클럽’ 분들에 한 해 참여 가능합니다.', 'location.href="' . $action_href . '"' );
					exit;
				}
			}
		}
	}
}else {
	if($_SESSION ['temp_view'] < $right_list['hero_view']) {
		error_historyBack("애경 서포터즈 회원만 상세보기가 가능합니다.");
		exit;
	}
}
?>

<!--컨텐츠 시작-->

<script src="/js/musign/sns_share.js"></script>
<script src="/m/js/musign/supporters.js"></script>
<link href="/m/css/musign/board.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/suppoters.css" rel="stylesheet" type="text/css">

<div id="support_view">     
    <div>
	<?
		$next_command = htmlspecialchars_decode($out_row['hero_command']);
		$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
		$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
		$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
		$next_command = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_command);
		$next_command = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_command);
		$next_command = preg_replace("/width: \d+px/","width:100%;",$next_command);
		$next_command = preg_replace("/height: \d+px;/","",$next_command);
		$next_command = preg_replace("/height: \d+px/","",$next_command);

		$check_day = date( "Y-m-d", time());
        //if($_SERVER['REMOTE_ADDR'] == '121.167.104.240') $check_day = date("Y-m-d", strtotime("- day", time()));
		$today_01_01 = date( "Y-m-d", strtotime($out_row['hero_today_01_01']));
		$today_01_02 = date( "Y-m-d", strtotime($out_row['hero_today_01_02']));
		
		$today_02_01 = date( "Y-m-d", strtotime($out_row['hero_today_02_01']));
		$today_02_02 = date( "Y-m-d", strtotime($out_row['hero_today_02_02']));
		
		$today_03_01 = date( "Y-m-d", strtotime($out_row['hero_today_03_01']));
		$today_03_02 = date( "Y-m-d", strtotime($out_row['hero_today_03_02']));
		
		$today_04_01 = date( "Y-m-d", strtotime($out_row['hero_today_04_01']));
		$today_04_02 = date( "Y-m-d", strtotime($out_row['hero_today_04_02']));

		if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
			$review_menu = '리뷰어 신청 : ';
			if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){
				$date_color_01 = "orange";
			}else{
				$date_color_01 = "orange";
			}
			$one_day = $out_row['hero_today_01_01'];
			$two_day = $out_row['hero_today_01_02'];
			$setup_type = '1';
		}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
			$review_menu = '리뷰어 발표 : ';
			$date_color_02 = "orange";
			$one_day = $out_row['hero_today_02_01'];
			$two_day = $out_row['hero_today_02_02'];
			$setup_type = '2';
		}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
			$review_menu = '리뷰 등록 : ';
			$date_color_03 = "orange";
			$one_day = $out_row['hero_today_03_01'];
			$two_day = $out_row['hero_today_03_02'];
			$setup_type = '3';
		}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
			$review_menu = '베스트 발표 : ';
			$date_color_04 = "orange";
			$one_day = $out_row['hero_today_04_01'];
			$two_day = $out_row['hero_today_04_02'];
			$setup_type = '4';
		}else{
			$review_menu = '참여 기간 : ';
			$one_day = $out_row['hero_today_01_01'];
			$two_day = $out_row['hero_today_04_02'];
			$setup_type = '5';
		}

		$next_help = htmlspecialchars_decode($out_row['hero_help']);
		$next_help = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_help);
		$next_help = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_help);
		$next_help = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_help);
		$next_help = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_help);
		$next_help = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_help);
		$next_help = preg_replace("/width: \d+px/","",$next_help);

		$type_check = "";
		if($_GET ['board'] == 'group_04_05' || $_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28') {
			if($out_row["hero_question_url_check"] == "1") {
				$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='네이버 블로그'>";
			} else if($out_row["hero_question_url_check"] == "2") {
				$type_check = "<img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'>";
			} else if($out_row["hero_question_url_check"] == "3") {
				$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='블로그'><img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'>";
			} else if($out_row["hero_question_url_check"] == "4") {
				$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='블로그'><img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'>";
			} else if($out_row["hero_question_url_check"] == "5") {
				$type_check =  "<img src='/m/img/musign/supporters/ic_youtube.png' alt='유튜브'>";
			} else if($out_row["hero_question_url_check"] == "6") {
				$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='블로그'><img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'><img src='/m/img/musign/supporters/ic_youtube.png' alt='유튜브'>";
			} else {
				// if($out_row["hero_type"] == "1") {
				//     $type_check = "이벤트";
				// } else if($out_row["hero_type"] == "2") {
				//     $type_check = "소문내기";
				// } else if($out_row["hero_type"] == "3") {
				//     $type_check = "설문참여";
				// } else if($out_row["hero_type"] == "5") {
				//     $type_check = "품평참여";
				// } else if($out_row["hero_type"] == "8") {
				//     $type_check = "포인트체험";
				// } else {
				//     $type_check = "체험단";
				// }
			}
		}
	?>
	<div class="mission_wrap">		
		<!-- ------------------------ 상단 데이터 출력 (s) ---------------------------------->
		<? include_once("missionInfo.php") ?>
		<!-- ------------------------ 상단 데이터 출력 (e) ---------------------------------->
		
		<!-- ------------------------ 일정 데이터 출력 (s) ---------------------------------->
		<? include_once("missionDate.php") ?>
		<!-- ------------------------ 일정 데이터 출력 (e) ---------------------------------->

		<!-- ------------------------ 상세 데이터 출력 (s) ---------------------------------->
		<? include_once("missionContent.php") ?>
		<!-- ------------------------ 상세 데이터 출력 (e) ---------------------------------->

        <!-- ------------------------ 신청자 출력 (s) ---------------------------------->
        <? if($my_level > 9998) include_once("mission_application_list.php") ?>
        <!-- ------------------------ 신청자 출력 (s) ---------------------------------->
	</div>


<div class="mission_view_btn right">
<?
$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['mission_idx'].'\'';
$view_sql = mysql_query($sql);
$data_count = mysql_num_rows($view_sql);

	if(!strcmp($setup_type, '1')){
		if(!strcmp($data_count, '0')){
			if(strcmp($_SESSION['temp_code'], '')){
				if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ 
					?>
					<? if($out_row["hero_type"] == "7") { //자율 미션 ?>
						<div class="content_btn_div">
							<a href="mission_application.php?<?=get()?>" class="content_btn">체험단 신청하기</a>
						</div>
					<? } else if($out_row["hero_type"] == "9") { //정기미션(선택)?>
						<div class="content_btn_div">
							<a href="mission_application.php?<?=get()?>" class="content_btn">체험단 신청하기</a>
						</div>
					<? } else { ?>
						<!-- 가이드 다운 버튼 (s) -->
						<div class="guide_btn_bx">
							<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
								<a href="/" class="download_btn content_btn">
									<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
									가이드라인 확인
								</a>
							<? } ?>
						</div>
						<!-- 가이드 다운 버튼 (e) -->
						<?
							$sql = 'select hero_code from board where hero_table = \'' . $_GET ['board'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $_GET ['mission_idx'] . '\'';
							$view_sql = @mysql_query ( $sql );
							$data_count = @mysql_num_rows ( $view_sql );
							if ($data_count == 0) {
						?>
						<div class="content_btn_div">
							<a href="/m/mission_write.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>&action=write" class="content_btn">콘텐츠 등록하기</a>
						</div>
						<? } else { ?>							
						<div class="content_btn_div">
							<a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="content_btn">콘텐츠 확인하기</a>
						<? } ?>
					</div>
					<? } ?>
				<? }else{
					if($out_row['hero_type'] == 2) {
				?>			
					<div class="content_btn_div">
						<a href="mission_application.php?<?=get()?>" class="content_btn">소문내기 인증하기</a>
					</div>
				<? }else if($out_row['hero_type'] == 10) { ?>
					<div class="content_btn_div">
						<a href="mission_application.php?<?=get()?>" class="content_btn">미션 인증하기</a>
					</div>
				<? }else if($out_row['hero_type'] == 1) { ?>
					<div class="content_btn_div">
						<a href="mission_application.php?<?=get()?>" class="content_btn">이벤트신청하기</a>
					</div>
				<? }else if($out_row['hero_type'] == 3) { ?>
					<div class="content_btn_div">
						<a href="mission_application.php?<?=get()?>" class="content_btn" style="visibility: hidden;">체험단 신청하기</a>
					</div>
                <? }else { ?>
					<div class="content_btn_div">
                		<a href="mission_application.php?<?=get()?>" class="content_btn">체험단 신청하기</a>
					</div>
                <? } ?>
				<?	}
					}else{
					if($out_row['hero_type'] == 2) {
				?>					
					<div class="content_btn_div">
						<a href="#" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();" class="content_btn">소문내기 인증하기</a>
					</div>
				<? }else if($out_row['hero_type'] == 10) { ?>					
					<div class="content_btn_div">
						<a href="#" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();" class="content_btn">미션 인증하기</a>
					</div>
				<? }else if($out_row['hero_type'] == 1) { ?>					
					<div class="content_btn_div">
                        <? if($my_level > 9998) {?>
                            <a class="content_btn pop_btn">신청자 확인하기</a>
                        <? } ?>
						<a href="#" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();" class="content_btn">신청하기</a>
					</div>
				<? }else if($out_row['hero_type'] == 3) { ?>
					<div class="content_btn_div">
                        <? if($my_level > 9998) {?>
                            <a class="content_btn pop_btn">신청자 확인하기</a>
                        <? } ?>
						<a href="#" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();" class="content_btn" style="visibility: hidden;">체험단 신청하기</a>
					</div>
                <? }else { ?>                	
					<div class="content_btn_div">
                        <? if($my_level > 9998) {?>
                            <a class="content_btn pop_btn">신청자 확인하기</a>
                        <? } ?>
						<a href="#" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();" class="content_btn">체험단 신청하기</a>
					</div>
                <? } ?>
	<?
			}
		}else{
			
	//    }//2리뷰어등록//1리뷰어신청자//3미션참여하기
	
	$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['mission_idx'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' order by hero_today desc';
	$out_sql_01 = @mysql_query($sql_01);
	$count_01 = @mysql_num_rows($out_sql_01);
	$list_01                             = @mysql_fetch_assoc($out_sql_01);
			if(strcmp($_SESSION['temp_id'], '')){ ?>
				<div class="content_btn_div">
                    <a class="content_btn" href="<?=DOMAIN_END?>m/mission_muDelete.php?board=<?=$_GET['board']?>&idx=<?=$out_row['hero_idx']?>">체험단 신청 취소하기</a>
				</div>
	<?
			}
		}
	}

	if(!strcmp($setup_type, '2')){ 
		if($_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28'){
	?>
			<div class="content_btn_div2">
				<a href="<?=DOMAIN_END?>m/mission_win_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn pick_support">선정자 확인하기</a>
			</div>
			<? if($my_level > 9998) {?>
				 <!-- <a href="<?=DOMAIN_END?>m/mission_application_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn">신청자 확인하기</a> -->
				 <a class="content_btn pop_btn">신청자 확인하기</a>
			<? } ?>
	<? } else { ?>
		<? if($out_row["hero_type"] == "7") {?>
			<div class="content_btn_div2">
				<a href="<?=DOMAIN_END?>m/mission_win_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn pick_support">선정자 확인하기</a>
			</div>
			<? if($my_level > 9998) {?>
				 <a class="content_btn pop_btn">신청자 확인하기</a>
			<? } ?>
		<? } else if($out_row["hero_type"] == "9") { //정기미션(선택)?>
			<div class="content_btn_div2">
				<a href="<?=DOMAIN_END?>m/mission_win_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn pick_support">선정자 확인하기</a>
			</div>
			<? if($my_level > 9998) {?>
				 <a class="content_btn pop_btn">신청자 확인하기</a>
			<? } ?>
		<? } ?>
	<? } ?>
		  <!-- <a href="javascript:pcMobile('pc','/main/index.php?<?=get("page||hero_idx||mission_idx","view=step_03&idx=".$_REQUEST['mission_idx'])?>');" class="m_content_btn">선정자 확인</a>-->
		  <!-- <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_02&idx='.$_REQUEST['mission_idx'])?>&from=m" target="_blank"><img src="img/hero1.jpg" alt="신청자 확인" width="110px"/></a>-->
	<?
	}else if(!strcmp($setup_type, '3')){
	$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and lot_01=\'1\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['mission_idx'].'\'';
	$view_sql = @mysql_query($sql);
	$data_count = @mysql_num_rows($view_sql);
		if(!strcmp($data_count, '0')){
	?>
		<!-- 가이드 다운 버튼 (s) -->
		<div class="guide_btn_bx">
			<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
				<a href="/" class="download_btn content_btn">
					<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
					가이드라인 확인
				</a>
			<? } ?>
		</div>
		<!-- 가이드 다운 버튼 (e) -->
		<div class="content_btn_div2">
            <? if($my_level > 9998) {?>
                <a class="content_btn pop_btn">신청자 확인하기</a>
            <? } ?>
			<a href="<?=DOMAIN_END?>m/mission_win_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn pick_support">선정자 확인하기</a>
			<a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="content_btn">콘텐츠 확인하기</a>
		</div>
	<?
		}else{
	$new_sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_01=\''.$_GET['mission_idx'].'\'';
	$view_new_sql = mysql_query($new_sql);
	$new_count = mysql_num_rows($view_new_sql);
		if(!strcmp($new_count, '0')){
	?>
		<!-- 가이드 다운 버튼 (s) -->
		<div class="guide_btn_bx">
			<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
				<a href="/" class="download_btn content_btn">
					<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
					가이드라인 확인
				</a>
			<? } ?>
		</div>
		<!-- 가이드 다운 버튼 (e) -->
		<div class="content_btn_div2">
            <? if($my_level > 9998) {?>
                <a class="content_btn pop_btn">신청자 확인하기</a>
            <? } ?>
			<a href="<?=DOMAIN_END?>m/mission_win_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn pick_support">선정자 확인하기</a>
		    <a href="/m/mission_write.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>&action=write" class="content_btn">콘텐츠 등록하기</a>
		</div>
	<?
		}else{
	?>
		<!-- 가이드 다운 버튼 (s) -->
		<div class="guide_btn_bx">
			<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
				<a href="/" class="download_btn content_btn">
					<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
					가이드라인 확인
				</a>
			<? } ?>
		</div>
		<!-- 가이드 다운 버튼 (e) -->
		<div class="content_btn_div2">
            <? if($my_level > 9998) {?>
                <a class="content_btn pop_btn">신청자 확인하기</a>
            <? } ?>
		   <a href="<?=DOMAIN_END?>m/mission_win_list.php?board=<?=$_GET["board"]?>&idx=<?=$_GET["mission_idx"]?>" class="content_btn pick_support">선정자 확인하기</a>
		   <a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="content_btn">콘텐츠 확인하기</a>
		</div>
	<?
		}
	}
	}else if(!strcmp($setup_type, '4')){
	?>
		<!-- 가이드 다운 버튼 (s) 241127 추가-->
		<div class="guide_btn_bx">
			<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
				<a href="/" class="download_btn content_btn">
					<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
					가이드라인 확인
				</a>
			<? } ?>
		</div>

		<!-- 가이드 다운 버튼 (e) -->
		<div class="content_btn_div2">
          <? if($my_level > 9998) {?>
              <a class="content_btn pop_btn">신청자 확인하기</a>
          <? } ?>
		  <!-- <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" target="_blank"  class="content_btn pick_support">선정자 확인하기</a> -->
		  <? if($board_write_rs["cnt"] == 0 && $today_03_02 < $check_day && $review_auth) {//후기 미작성 시 버튼 노출?>
		 	 <!-- <a href="/m/mission_write.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>&action=write" class="content_btn">후기 등록하기</a> -->
		  <? } else if($board_write_rs["cnt"] > 0) { ?>
            <a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="content_btn">콘텐츠 확인하기</a>
		  <? } ?>
		  <a href="/m/board_02.php?board=group_04_10" target="_blank" class="content_btn">우수후기 확인하기</a>
		</div>
	<?
	}else if(!strcmp($setup_type, '5')){
		if($_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_28'){
	?>
		<!-- 가이드 다운 버튼 (s) 241127 추가-->
        <!-- 가이드 다운 버튼 미노출 250106 YDH -->
		<div class="guide_btn_bx" style="display: none;">
			<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
				<a href="/" class="download_btn content_btn">
					<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
					가이드라인 확인
				</a>
			<? } ?>
		</div>
		
		<div class="content_btn_div2">
			<p class="content_btn end">체험단 신청하기 (마감)</p>
            <a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="content_btn">콘텐츠 확인하기</a>
		</div>
	<?
		} else { ?>	
			<!-- 가이드 다운 버튼 (s) 241127 추가-->
			<div class="guide_btn_bx">
				<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
					<a href="/" class="download_btn content_btn">
						<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
						가이드라인 확인
					</a>
				<? } ?>
			</div>

			<div class="guide_btn_bx single">
                <? if($my_level > 9998) {?>
                    <a class="content_btn pop_btn">신청자 확인하기</a>
                <? } ?>
				<!-- <? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
					<a href="/" class="download_btn content_btn">
						<img src="/m/img/musign/supporters/guide.png" alt="가이드라인 확인">
						가이드라인 확인하기
					</a>
				<? } ?> -->
			</div>
		<?} } ?>	

   </div>
</div> 
<!--컨텐츠 종료-->

<!-- 가이드라인 팝업 -->
<div id="guideline" class="guide_popup" style="display: none;">
    <div class="inner rel">
		<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
			<div class="scroll">
			<? $isGuide = $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3'] ?>
			<div>
				<? if( $isGuide ) { ?>
				<div class="guide_wrap">                
					<p class="fz32 bold pop_tit">가이드라인 다운로드</p>                
					<div class="pop_cont guid_dw">
						<? if( $out_row['guide_ori_file'] ) { ?>
							<a href="/freebest/auth_download.php?hero_idx=<?=$out_row["hero_idx"]?>&type=mission&column=guide1&download=<?=$out_row['guide_ori_file']?>" class="guide_btn f_c"><img src="/m/img/musign/supporters/ic_insta.png" alt="인스타그램 가이드라인"><p class="f_b fz24 bold"> 인스타그램 가이드라인 다운로드 <span class="guide_dw_img"></span></p></a>
						<? } ?>
						<? if( $out_row['guide_ori_file2'] ) { ?>
							<a href="/freebest/auth_download.php?hero_idx=<?=$out_row["hero_idx"]?>&type=mission&column=guide2&download=<?=$out_row['guide_ori_file2']?>" class="guide_btn f_c"><img src="/m/img/musign/supporters/ic_naver_blog.png" alt="네이버 블로그 가이드라인"><p class="f_b fz24 bold">  네이버 블로그 가이드라인 다운로드 <span class="guide_dw_img"></span></p></a>
						<? } ?>
						<? if( $out_row['guide_ori_file3'] ) { ?>
							<a href="/freebest/auth_download.php?hero_idx=<?=$out_row["hero_idx"]?>&type=mission&column=guide3&download=<?=$out_row['guide_ori_file3']?>" class="guide_btn f_c"><img src="/m/img/musign/supporters/ic_youtube.png" alt="숏폼 가이드라인"><p class="f_b fz24 bold">  숏폼 가이드라인 다운로드 <span class="guide_dw_img"></span></p></a>
						<? } ?>
					</div>
				</div>            
				<? } ?>
				<div class="text_wrap">                
					<p class="fz32 bold pop_tit">공정위 배너/문구 삽입</p>            
					<div class="pop_cont">
						<? if($out_row['hero_banner']){ ?>	
						<div class="naver_txt">                 
							<div class="tabBtnArea3">
								<div class="">
									<span class="fz28 bold">네이버 블로그 공정위 배너 삽입 방법</span> 
								</div>
								<div class="naver_cont">
									<ul>
										<li class="">
											<span class="fz26 bold main_c">Step.1 </span>
											<div>
												<p class="fz26 fw500">공정위 배너이미지 다운받기 버튼 클릭하기</p>
												<a href="/img/front/icon/banner_img_2.png" download class="fz12 fw600 btn_copy">공정위 배너 이미지 다운받기 <img src="/img/front/board/copy.webp" alt="배너 코드 복사하기"></a>
											</div>
										</li>
										<li class="">
											<span class="fz26 bold main_c">Step.2 </span>
											<div>
												<p class="fz26 fw500">공정위 배너 링크 복사하기 버튼 클릭하기</p>
												<a data-clipboard-text="https://www.aklover.co.kr/main/index.php" class="fz12 fw600 btn_copy btn_clip_naver">공정위 배너 링크 복사하기 <img src="/img/front/board/copy.webp" alt="배너 코드 복사하기"></a>
											</div>
										</li>
										<li class="f_s">
											<span class="fz26 bold main_c">Step.3 </span>
											<div>
												<p class="fz26 fw500">블로그 에디터에 배너 이미지를 삽입하고<br>
												복사된 링크 걸면 완료!</p>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>              
						<? } ?>  
						<? if($out_row['hero_insta']){ ?>	
						<div class="insta_txt">                        
							<div class="tabBtnArea3">
								<div class="">
									<span class="fz28 bold">인스타그램 공정위 문구 삽입</span>
								</div>
							</div>
							<div class="banner_img fz28 bold"><?=nl2br($out_row['hero_insta'])?></div>      
							<div class="banner_info">
								<ul>
									<li>- 위 문구를 텍스트 제일 상단에 작성해 주세요.</li>
								</ul>
							</div>
						</div>
						<? } ?>                  
					</div>
				</div>
			</div>
		</div>
    </div>	
</div>

<?
include_once "tail.php";
?>
<script>
	$(document).ready(function(){
		$('body').addClass('dock_page');
	})

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

	// 신청자 확인 팝업
	$(document).ready(function(){
		$('.pop_btn').click(function(){
			$(".popup").show();
		});

		$('.btn_x').click(function(){
			$(".popup").hide();
		});
	});
</script>