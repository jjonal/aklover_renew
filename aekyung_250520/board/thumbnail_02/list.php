<link rel="stylesheet" href="../css/front/supporters.css">
<?
if(!defined('_HEROBOARD_'))exit;

if($_GET ['board'] == 'group_04_27') exit;

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

$group_sql = " SELECT * FROM hero_group WHERE hero_order != '0' AND hero_use = '1' AND hero_board = '".$_GET['board']."' ";
sql($group_sql);
$right_list = @mysql_fetch_assoc($out_sql);

//검색어
if(strcmp($_POST['kewyword'], '')){
    $search = ' and ('.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\' or hero_title_02 like \'%'.$_POST['kewyword'].'%\')';
    $search_next = '&select='.$_POST['select'].'&kewyword='.stripslashes($_POST['kewyword']);
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and ('.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\' or hero_title_02 like \'%'.$_GET['kewyword'].'%\')';
    $search_next = '&select='.$_GET['select'].'&kewyword='.stripslashes($_GET['kewyword']);
}
//기간
if(strcmp($_GET['search_month'], '00') && strcmp($_GET['search_month'], '')){
    if(strcmp($_GET['search_month'], '99')){ //직접입력 아닐때
        $search .= "AND DATE_FORMAT(hero_today_04_02,'%Y-%m-%d') between DATE_SUB(DATE_FORMAT(NOW(),'%Y%m%d'), INTERVAL ".$_GET['search_month']." MONTH) and DATE_FORMAT(now(),'%Y%m%d')";
    } else { //직접입력일때
        $search .= "AND DATE_FORMAT(hero_today_04_02,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
        $search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
    }

    $search_next .= "&search_month=".$_GET['search_month'];
}

//카테고리
if(count($_GET['hero_kind']) > 0){
    $seach_kind = "";

    for ($i = 0;$i < count($_GET['hero_kind']);$i++){
        if($i == 0) $comma = '';
        else        $comma = ',';

        $seach_kind .= $comma.'\''.$_GET['hero_kind'][$i].'\'';
        $search_next .= "&hero_kind[]=".$_GET['hero_kind'][$i];
    }
    $search .= "AND hero_kind in (".$seach_kind.")";
}

$statusSearch = $_GET['statusSearch'];

$ymd = date("Y-m-d");
if($statusSearch) {
	switch ($statusSearch) {
		case "A": //신청
			$search .= " AND '".$ymd."' between hero_today_01_01 and hero_today_01_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
		case "B": //발표
			$search .= " AND '".$ymd."' between hero_today_02_01 and hero_today_02_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
		case "C": //후기
			$search .= " AND '".$ymd."' BETWEEN hero_today_03_01 and hero_today_03_02 AND hero_today_02_02 != hero_today_03_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
		case "D": //우수자
			$search .= " AND '".$ymd."' BETWEEN hero_today_04_01 and hero_today_04_02 AND hero_today_02_02 != hero_today_04_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
	}
}

if(strlen($_GET["hero_type"]) > 0) {
	$search .= " AND hero_type = '".$_GET["hero_type"]."' ";
	$search_next .= "&hero_type=".$_GET['hero_type'];
}

//2025-02-13 musign YDH 체험단 삭제 기능 추가
$hero_use = $_GET['hero_use'];

if($hero_use == '2') {
    $hero_use = '(2)';
}else {
    $hero_use = '(0,1)';
}
$search_next .= "&hero_use=".$_GET['hero_use'];

$total_sql = " SELECT count(*) cnt FROM mission WHERE hero_use in ${hero_use} AND hero_kind!='구매체험' AND hero_table='".$_GET['board']."' ".$search;
if($_SESSION['temp_level'] < "9999") { //관리자 외 노출
	$total_sql.= " AND hero_use = '1' AND ((hero_today_05_01 is null or hero_today_05_01='') OR ";
	$total_sql.= " (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
 	$total_sql.= " AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' ";
	$total_sql.= " AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
}

sql($total_sql);
$total_rs = mysql_fetch_assoc($out_sql);
$total_data = $total_rs["cnt"];

$list_page=9;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;

$noAuthPage = false;
$temp_auth_hero_code = $_SESSION["temp_code"];

//포커스 그룹 권한
if($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_27' || $_GET ['board'] == 'group_04_28') {
	if($my_view < 9999){
		if($my_view != $right_list['hero_list']) {

			if($_GET ['board'] == "group_04_27") {
				$focus_gisu_auth_sql = " SELECT count(*) as cnt FROM member_gisu WHERE hero_code = '".$_SESSION["temp_code"]."' AND (hero_board = 'group_04_27' or hero_board = 'group_04_31') ";
			} else {
				$focus_gisu_auth_sql = " SELECT count(*) as cnt FROM member_gisu WHERE hero_code = '".$_SESSION["temp_code"]."' AND hero_board = '".$_GET["board"]."' ";
			}

			sql($focus_gisu_auth_sql);
			$focus_gisu_auth_rs =  @mysql_fetch_assoc($out_sql);
			$focus_gisu_auth_cnt = $focus_gisu_auth_rs["cnt"];

			if($focus_gisu_auth_cnt == 0) { //이전 기수에 포함 안됨
				$noAuthPage = true;
			} else {
				if($_GET ['board'] == "group_04_06") {
					$_SESSION["before_beauty_auth"] = "Y";
				} else if($_GET ['board'] == "group_04_27") {

					$beautyAndLifeAuthCheckSql  = " SELECT sum(if(hero_board='group_04_27',1,0)) beauty_movie_cnt,  sum(if(hero_board='group_04_31',1,0)) life_movie_cnt ";
					$beautyAndLifeAuthCheckSql .= " FROM member_gisu WHERE hero_use = 0 AND hero_code= '".$_SESSION["temp_code"]."' GROUP BY hero_code ";
					sql($beautyAndLifeAuthCheckSql);
					$beautyAndLifeAuthCheckRs = @mysql_fetch_assoc($out_sql);

					if($beautyAndLifeAuthCheckRs["beauty_movie_cnt"] > 0) $_SESSION["before_beautymovie_auth"] = "Y";

					if($beautyAndLifeAuthCheckRs["life_movie_cnt"] > 0) $_SESSION["before_lifemovie_auth"] = "Y";
				} else if($_GET ['board'] == "group_04_28") {
					$_SESSION["before_life_auth"] = "Y";
				}
			}
		}
	}
}
?>

<div id="subpage">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
			<? if($_GET ['board'] == 'group_04_05') {?>
				<h1 class="fz68 main_c ko">베이직 뷰티&라이프 클럽</h1>
				<ul class="tab f_c black">
					<li><a href="/main/basic_aklover.php" class="fz18 fw600 f_cs mission_guide_btn">참여방법 보러가기<img src="/img/front/member/arr.webp" alt="참여방법 보러가기"></a></li>
				</ul>
			<? } else if ($_GET ['board'] == 'group_04_06') { ?>
				<h1 class="fz68 main_c ko">프리미어 뷰티 클럽</h1>
				<ul class="tab f_c black">
					<li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 f_cs mission_guide_btn">참여방법 보러가기<img src="/img/front/member/arr.webp" alt="참여방법 보러가기"></a></li>
				</ul>
			<? } else if ($_GET ['board'] == 'group_04_28') { ?>
				<h1 class="fz68 main_c ko">프리미어 라이프 클럽</h1>
				<ul class="tab f_c black">
					<li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 f_cs mission_guide_btn">참여방법 보러가기<img src="/img/front/member/arr.webp" alt="참여방법 보러가기"></a></li>
				</ul>
			<? } ?>
			</div>
			<? if($_GET ['board'] == 'group_04_05') {?>
			<p class="fz18 fw600">SNS 계정이 있다면 누구나 신청 가능한 체험단입니다. 애경의 전 제품을 경험하고 리뷰해보세요!</p>
			<? } ?>
		</div>
	</div>
<!--    <div class="sub_cont --><?// if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28' ) { ?><!--support_club--><?// } ?><!--">-->
    <div class="sub_cont <? if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28' ) { ?>support_club<? } ?>">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'search.php';?>
				<? if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28' ) { ?>
					<ul id="missionStatus" class="sub_menu">
						<li class="missionStatusSearch on">전체 <img src="/img/front/icon/bread.webp" alt="전체 목록"></li>
						<li class=""><a href="/main/index.php?board=group_04_10">우수 콘텐츠</a></li>
                        <!--관리자만 노출-->
                        <? if($my_write >= 9999 ){ ?>
                            <li><a href="index.php?board=<?=$_GET['board']?>&view=step_write&action=write" class="">체험단 등록</a></li>
                        <? } ?>
					</ul>
				<? } ?>
			</div>
			<div class="contents right rel">
			<? if($my_write >= 9999 ){ ?>
				<? if ($_GET ['board'] !== 'group_04_06' && $_GET ['board'] !== 'group_04_28' ) { //프리미어 뷰티, 라이프?>
                    <div class="btn_add">
						<!-- 250221 베이직 체험단 삭제 기능 by.musign-->
						<?if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){?>
							<? if($_GET['hero_use'] != '2'){?>
								<a href="index.php?board=<?=$_GET['board']?>&hero_use=2" class="btn_submit small btn_black">삭제된 체험단 보기</a>
							<? }else{ ?>
								<a href="index.php?board=<?=$_GET['board']?>" class="btn_submit small btn_black">체험단 목록 보기</a>
							<? } ?>
						<? } ?>
						<a href="index.php?board=<?=$_GET['board']?>&view=step_write&action=write" class="btn_submit small btn_main_c">체험단 등록</a>
					</div>
				<? } else { ?>
					<!-- 250221 프리미어 뷰티, 라이프 체험단 삭제 기능 by.musign-->
					<?if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){?>
						<div class="btn_add_premier">
							<? if($_GET['hero_use'] != '2'){?>
								<a href="index.php?board=<?=$_GET['board']?>&hero_use=2" class="btn_submit small btn_black">삭제된 체험단 보기</a>
							<? }else{ ?>
								<a href="index.php?board=<?=$_GET['board']?>" class="btn_submit small btn_black">체험단 목록 보기</a>
							<? } ?>
						</div>
					<? } ?>
				<? } ?>
			<? } ?>
			<?
				if($noAuthPage) {
					include_once("{$_SERVER[DOCUMENT_ROOT]}/include/notAuthPage.php");
					if($_GET['board'] == "group_04_27") {
						include_once("{$_SERVER[DOCUMENT_ROOT]}/include/notAuthPageYoutuber.php");
					}
				} else {
			?>
				<ul id="missionStatus" class="boardTabMenuWrap colorType">
				<? if($_GET['board'] == 'group_04_27'){ //뷰티,유튜버,라이프?>
					<li class="missionStatusSearch <?=$_GET['statusSearch']==""?"on":""?>" data-val="">전체</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"on":""?>" data-val="C">콘텐츠등록</li>
				<? } else if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28') { ?>
				<? } else { ?>
					<li class="missionStatusSearch <?=$_GET['statusSearch']==""?"on":""?>" data-val="">전체</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"on":""?>" data-val="A">체험단신청</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"on":""?>" data-val="B">선정자발표</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"on":""?>" data-val="C">콘텐츠등록</li>
					<li class="missionStatusSearch <?=$_GET['statusSearch']=="D"?"on":""?>" data-val="D">우수콘텐츠발표</li>
				<? } ?>
				</ul>
				<? if(!strcmp($total_data,"0")){?>
					<div id="blankList">검색결과가 없습니다.</div>
				<? } else { ?>
				<div class="blog_box2">
					<ul class="guerrilla_event grid_3">
					<?
					$list_sql = "SELECT * FROM mission WHERE hero_use in ${hero_use} AND  hero_kind != '구매체험' AND hero_table='".$_GET['board']."' ".$search;
					if($_SESSION['temp_level'] < 9999 ){
						$list_sql .=" AND hero_use = '1' AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
						$list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
					}
					//20241002 musign최해성 기획팀 준우주임님 요청사항 관리자일때 조건없이 전부 보였으면 좋겠음 수정완료
					if($_SESSION['temp_level'] == "9999") {
						$list_sql .= " ORDER BY hero_priority DESC ";
					}
                    //20250409 musign 윤동희 수정 체험단 신청 시작일 기준으로 정렬 board/club.php 동일 로직
                    else {
                        $list_sql .= " ORDER BY hero_priority DESC, hero_today_01_01 desc ";
                    }
//					else {
//						$list_sql .= " ORDER BY hero_priority DESC,
//								CASE WHEN (hero_today_01_01<='" . date('Y-m-d 00:00:00') . "' and hero_today_01_02>='" . date('Y-m-d 00:00:00') . "') THEN hero_today_01_01 END DESC,
//								CASE WHEN (hero_today_02_01<='" . date('Y-m-d 00:00:00') . "' and hero_today_02_02>='" . date('Y-m-d 00:00:00') . "') THEN hero_today_02_01 END DESC,
//								CASE WHEN (hero_today_03_01<='" . date('Y-m-d 00:00:00') . "' and hero_today_03_02>='" . date('Y-m-d 00:00:00') . "') THEN hero_today_03_01 END DESC,
//								CASE WHEN (hero_today_04_01<='" . date('Y-m-d 00:00:00') . "' and hero_today_04_02>='" . date('Y-m-d 00:00:00') . "') THEN hero_today_04_01 END DESC,
//								CASE WHEN (hero_today_04_02<='" . date('Y-m-d 00:00:00') . "') THEN hero_today_04_01 END desc ";
//					}
					if($_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_27" || $_GET['board'] == "group_04_28") { //뷰티,유튜버,라이프
						$list_sql .= " , hero_today_01_01 DESC ";
					} else {
						$list_sql .= " , hero_idx DESC ";
					}
					$list_sql .= " LIMIT ".$start.",".$list_page;

					sql($list_sql, 'on');
					while($list = @mysql_fetch_assoc($out_sql)){
						$img_parser_url = @parse_url($list['hero_img_new']);
						$img_host = $img_parser_url['host'];

						if(!strcmp($list['hero_img_new'],'')){
							$view_img = IMAGE_END.'hero.jpg';
						}else if(!strcmp($img_host,'')){
							$view_img = IMAGE_END.'hero.jpg';
						}else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
							$view_img = $list['hero_img_new'];
						}else if(!strcmp(eregi('naver',$img_host),'1')){
							$view_img = IMAGE_END.'hero.jpg';
						}else{
							$view_img = $list['hero_img_new'];
						}

						if($list["hero_thumb"]) $view_img = $list['hero_thumb'];

						$check_day = date( "Y-m-d", time());
						$today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
						$today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
						$today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
						$today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
						$today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
						$today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
						$today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
						$today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
						$today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
						$today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

						$status_txt = "";
						$status = "";
						$period_day = "";
						$ribbon_text = "";
						$type_check = "";

						$mission_board_type = false;
						if($list["hero_type"] == "2" || $list["hero_type"] == "10") {
							$mission_board_type = true;
						}

						if($_GET ['board'] == 'group_04_05' || $_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28') {
							if($list["hero_question_url_check"] == "1") {
								$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='네이버 블로그'>";
							} else if($list["hero_question_url_check"] == "2") {
								$type_check = "<img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
							} else if($list["hero_question_url_check"] == "3") {
								$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
							} else if($list["hero_question_url_check"] == "4") {
								$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
							} else if($list["hero_question_url_check"] == "5") {
								$type_check =  "<img src='/img/front/main/ic_youtube.webp' alt='유튜브'>";
							} else if($list["hero_question_url_check"] == "6") {
								$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'><img src='/img/front/main/ic_youtube.webp' alt='유튜브'>";
							} else {
								// if($list["hero_type"] == "1") {
								// 	$type_check = "이벤트";
								// } else if($list["hero_type"] == "2") {
								// 	$type_check = "소문내기";
								// } else if($list["hero_type"] == "3") {
								// 	$type_check = "설문참여";
								// } else if($list["hero_type"] == "5") {
								// 	$type_check = "품평참여";
								// } else if($list["hero_type"] == "8") {
								// 	$type_check = "포인트체험";
								// } else {
								// 	$type_check = "체험단";
								// }
							}
						}

						if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){

							$ribbon_text = $list['hero_kind'];
							if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
								$ribbon_text = $list['hero_kind'];
							}

							$one_day = "";
							$two_day = "";
							if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //자율미션, 정기미션(선택)
								if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
									$status_txt = "체험단 신청";
									$status = "1";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
									$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
								}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
									$status_txt = "선정자 발표";
									$status = "2";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
									$period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
								}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
									$status_txt = "콘텐츠 등록";
									$status = "3";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
									$period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
								}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
									$status_txt = "우수콘텐츠발표";
									$status = "4";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
									$period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
								}else if($today_04_02<$check_day){
									$status_txt = "체험단 마감";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									// $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
									$two_day = "";


								}else if($today_05_01>$check_day){
									$status_txt = "체험단 노출예정";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
								}
							} else {
								if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
									$status_txt = "콘텐츠 등록";
									$status = "3";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
									$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
								}else if($today_01_02<$check_day){
									$status_txt = "체험단 마감";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									// $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
									$two_day = "";
								}else if($today_05_01>$check_day){
									$status_txt = "체험단 노출예정";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
								}
							}
						} else {
							/* 2021-03-25 타입 설문조사, 제품풍평만 리본 노출 요청있었는데 검색 때문에 삭제
							if($list['hero_type'] == "3" ||  $list['hero_type'] == "5") {
								$ribbon_text = "<div class='mission_ribbon bg_hero_type_".$list['hero_type']."'>".$list['hero_kind']."</div>";
							}
							*/
							$ribbon_text = $list['hero_kind'];

							if($mission_board_type) {
								$txt1 = "";
								$txt2 = "";
								if($list["hero_type"] == "2") {
									$txt1 = "소문내기 ";
									$txt2 = "소문내기 신청";
								} else if($list["hero_type"] == "10") {
									$txt1 = "체험단";
									$txt2 = "체험단 참여";
								}

								if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
									$status_txt = $txt2;
									$status = "1";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
									$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
								}else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
									$status_txt = "당첨자 발표";
									$status = "2";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
									$period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
								}else if(($today_04_02 < $check_day)){
									$status_txt = $txt1." 마감";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
								}
							} else {
								if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
									//20180831 임시로 추가
									if($list['hero_idx'] == "1288") {
										$status_txt = "이벤트 신청";
									} else {
										$status_txt = "체험단 신청";
									}
									$status = "1";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
									$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
								}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
									$status_txt = "선정자 발표";
									$status = "2";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
									$period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
								}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
									$status_txt = "콘텐츠 등록";
									$status = "3";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
									$period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
								}else if(($today_04_01<=$check_day) and ($today_04_02>=$check_day)){
									$status_txt = "우수콘텐츠발표";
									$status = "4";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
									$period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
								}else if($today_04_02<$check_day){
									$status_txt = "체험단 마감";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									//$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
									$two_day = "";
								}else if($today_05_01>$check_day){
									$status_txt = "체험단 노출예정";
									$status = "5";
									$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
									$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
								}
							}
						}
						?>
						<li class="event_list <? if($period_day || ($period_day == 0 && strlen($period_day) > 0)) {?>cursor_cont kotext<? } ?>">
							<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx']?>" class="rel">
								<div class="event_img rel">
									<div class="status_wrap">
										<span class="status status_txt"><?=$ribbon_text?></span>
									</div>
									<img  onerror="this.src='<?=IMAGE_END?>hero.jpg'" src="<?=$view_img?>" alt="">
									<? if($list["hero_use"] == 0) { ?>
										<div class="mission_com fz17 bold">비공개</div>
									<? } ?>
									<? if($status == 5) {?>
										<div class="mission_com fz17 bold">종료된 체험단</div>
									<? } ?>
									<? if(strlen($type_check) > 0) {?>
									<span class="type_check"><?=$type_check?></span>
									<? } ?>
								</div>
								<div class="title fz18 fw600 ellipsis_100"><?=cut($list['hero_title'],"70");?></div>
								<div class="day">
									<? if($period_day) {?>
										<span class="status"><?=$status_txt?></span>
										<span class="period fz14">
											D-<?=$period_day?>
										</span>
									<? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
										<span class="status"><?=$status_txt?></span>
										<span class="period fz14">
											D-DAY
										</span>
									<? } ?>
									<? if($status == 5) {?>
										<span class="status"><?=$status_txt?></span>
										<span class="period fz14">
											END
										</span>
									<? } ?>

									<!-- [24.11.08] 체험단 마감. 마김 기한 미노출 처리 -->
									<p class="date_02 fz15 fw600 op05">
										<?=$one_day?>
										<span>-</span>
										<?=$two_day?>
									</p>
									<!-- <span class="date_02 fz15 fw600 op05"><?=$one_day?><span>-</span><?=$two_day?></span> -->
									<!-- <div class=""><?=mb_substr($list['hero_title_02'], 0, 18, 'EUC-KR');?></div> -->
								</div>

                                <!-- 250221 체험단 삭제 기능 by.musign-->
								<?if($_SERVER['REMOTE_ADDR'] == '121.167.104.240' && $_GET['hero_use'] == '2'){?>
                                    <div class="btn_wrap">
                                        <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_mission&idx=<?=$list['hero_idx']?>&page=<?=$_GET['page']?>&type=list&hero_use=0" class="btn_submit small btn_black">체험단 삭제 취소</a>
                                    </div>
								<?}?>

							</a>
						</li>
					<? } ?>
					</ul>
				</div>
			
				<? } ?>
				<div class="clearfix"></div>
				<div class="btngroup">
				<div class="paging"><?=page($total_data,$list_page,$page_per_list,$_GET[page],$next_path);?></div>
			</div>
			<? } ?>
			</div>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
	$('.missionStatusSearch').click(function(){
		$('.missionStatusSearch').removeClass('on');
		if($(this).attr('class').indexOf('on') != -1) {
			$(this).addClass('on');
		}
		$('#statusSearch').val($(this).attr('data-val'));
		$('#searchFrm').submit();
	})
})
</script>