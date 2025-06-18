<?php
include_once "head.php";

$my_view = $_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];

$group_sql = " SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."' ";
sql($group_sql);
$right_list = @mysql_fetch_assoc($out_sql);

if($_GET['kewyword']){
    $search = ' and ('.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\' or hero_title_02 like \'%'.$_GET['kewyword'].'%\')';
    $search_next = '&select='.$_GET['select'].'&kewyword='.stripslashes($_GET['kewyword']);
}
//기간
if(strcmp($_GET['search_month'], '00') && strcmp($_GET['search_month'], '')){
    if(strcmp($_GET['search_month'], '99')){ //직접입력 아닐때
        $search .= "AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_SUB(DATE_FORMAT(NOW(),'%Y%m%d'), INTERVAL ".$_GET['search_month']." MONTH) and DATE_FORMAT(now(),'%Y%m%d')";
    } else { //직접입력일때
        $search .= "AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
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
    $search .= " AND hero_kind in (".$seach_kind.")";
}

$searchType = $_GET['searchType'];
$searchText = $_GET['searchText'];
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

$total_sql = " SELECT count(*) cnt FROM mission WHERE hero_kind!='구매체험' AND hero_table='".$_REQUEST['board']."' ".$search;

if($_SESSION['temp_level'] < "9999") { //관리자 노출
	$total_sql.= " AND hero_use = 1 AND  ((hero_today_05_01 is null or hero_today_05_01='') OR ";
	$total_sql.= " (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
	$total_sql.= " AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' ";
	$total_sql.= " AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
}

if($searchType) {
	$sql .=" and ".$searchType." like '%".$searchText."%' ";
}

sql($total_sql);
$total_rs = mysql_fetch_assoc($out_sql);
$total_data = $total_rs["cnt"];

$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
//$next_path=get("page");
$next_path="board=".$_GET['board'].$search_next;

$noAuthPage = false;
$temp_auth_hero_code = $_SESSION["temp_code"];

//포커스 그룹 권한
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
<link href="/m/css/musign/board.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/suppoters.css" rel="stylesheet" type="text/css">


<? if($noAuthPage) {
	include_once("{$_SERVER[DOCUMENT_ROOT]}/m/notAuthPage.php");
	if($_GET['board'] == "group_04_27") {
		include_once("{$_SERVER[DOCUMENT_ROOT]}/m/notAuthPageYoutuber.php");
	}
} else { ?>
<div id="subpage" class="support">
	<div class="sub_wrap">
		<div class="sub_title">			
			<div class="">
				<? if($_GET ['board'] == 'group_04_05') {?>
					<h1 class="fz72 main_c fw500">베이직 뷰티&라이프 클럽</h1> 
				<? } else if ($_GET ['board'] == 'group_04_06') { ?>
					<h1 class="fz72 main_c fw500">프리미어 뷰티 클럽</h1> 
				<? } else if ($_GET ['board'] == 'group_04_28') { ?>	
					<h1 class="fz72 main_c fw500">프리미어 라이프 클럽</h1> 		
				<? } ?>
				<p class="fz28 fw600 desc">SNS 계정이 있다면 누구나 신청 가능한 체험단입니다.<br /> 애경의 전 제품을 경험하고 리뷰해보세요! </p>                   
			</div>
			<ul class="tab f_cs">                              
				<li><a href="/m/beauty_life_aklover.php" class="fz12 fw500 on mission_guide_btn">참여방법 보러가기<img src="/img/front/main/right_wh.webp" alt="바로가기"></a></li>
			</ul>
		</div>
		<div class="left">    
			<? if($_GET ['board'] == 'group_04_05') {?>                
        	<? include_once 'searchBox.php';?>
			<? } ?>
		</div>
	</div>
	<div id="gallery">
		<div class="boardTabMenuWrap">
        	<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ //뷰티,유튜버,라이프 ?>
            	<span class="missionStatusSearch <?=$_GET['statusSearch']==""?"active":""?>" data-val="">전체</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"active":""?>" data-val="C">콘텐츠등록</span>
            <? }else { ?>
            	<span class="missionStatusSearch <?=$_GET['statusSearch']==""?"active":""?>" data-val="">전체</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"active":""?>" data-val="A">체험단신청</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"active":""?>" data-val="B">선정자발표</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"active":""?>" data-val="C">콘텐츠등록</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="D"?"active":""?>" data-val="D">우수자발표</span>
            <? } ?>
        </div>
		<!-- 리스트 s -->
		<div class="blog_box2">
			<ul class="guerrilla_event grid_3">
				<?
				$list_sql = "SELECT * FROM mission WHERE hero_kind != '구매체험' AND hero_table='".$_GET['board']."' ".$search;
				if($_SESSION['temp_level'] < 9999 ){
					$list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
					$list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
				}
				$list_sql .=" ORDER BY hero_priority DESC,
							CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
							CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
							CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
							CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
							CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";

				if($_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_27" || $_GET['board'] == "group_04_28") { //뷰티,유튜버,라이프
					$list_sql .= " , hero_today_01_01 DESC ";
				} else {
					$list_sql .= " , hero_idx DESC ";
				}
				$list_sql .= " LIMIT ".$start.",".$list_page;
				sql($list_sql, 'on');
				if($total_data > 0) {
				while($list = @mysql_fetch_assoc($out_sql)){
				$ul_class = "";
				if($i%2 == 0) {
					$ul_class = "class='left'";
				}
				
				$img_parser_url = @parse_url($list['hero_img_new']);
				$img_host = $img_parser_url['host'];
				$img_path = $img_parser_url['path'];
				
				if($list['hero_thumb']){
					$view_img = $list['hero_thumb'];
				}elseif(is_file($list['hero_img_new'])){
					$view_img = $list['hero_img_new'];
				}else{
					$view_img = IMAGE_END.'hero.jpg';
				}
			
				$title = $list['hero_title'];
				$title = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($title))));
				$title = str_replace("\r", "", $title);
				$title = str_replace("\n", "", $title);
				$title = str_replace("&#65279;", "", $title);
				$title_01 = cut($title,'35');
				if(!strcmp($title_01,"")){
					$title_01 = "&nbsp;";
				}
				
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
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='네이버 블로그'>";
					} else if($list["hero_question_url_check"] == "2") {
						$type_check = "<img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'>";
					} else if($list["hero_question_url_check"] == "3") {
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='블로그'><img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'>";
					} else if($list["hero_question_url_check"] == "4") {
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='블로그'><img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'>";
					} else if($list["hero_question_url_check"] == "5") {
						$type_check =  "<img src='/m/img/musign/supporters/ic_youtube.png' alt='유튜브'>";
					} else if($list["hero_question_url_check"] == "6") {
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='블로그'><img src='/m/img/musign/supporters/ic_insta.png' alt='인스타그램'><img src='/m/img/musign/supporters/ic_youtube.png' alt='유튜브'>";
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
					
					if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //자율미션, 정기미션(선택)
						if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
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
							$status_txt = "콘텐츠등록";
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
						if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
							$status_txt = "콘텐츠등록";
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
					}else {
						if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
							//20180831 임시로 수정
							if($list['hero_idx'] == "1288") {
								$status_txt = "이벤트 신청";
							} else {
								$status_txt = "체험단 신청";
							}
							$status = "1";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
							$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
						}else if(($today_02_01<=$check_day) and ($today_02_02>=$check_day)){
							$status_txt = "선정자 발표";
							$status = "2";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
							$period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
						}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
							$status_txt = "콘텐츠등록";
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
					}
				}	
			?>
				<li class="event_list">
					<a href="/m/mission_view<?echo ($_REQUEST['board']=='group_04_07')? "_02" : ""; ?>.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=&mission_idx=<?=$list['hero_idx']?>" class="rel">
						<div class="event_img rel">
							<div class="status_wrap">
								<span class="status status_txt"><?=$ribbon_text?></span>
							</div>
							<img class="mission_image" onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>">
							<? if($list['hero_use'] == 0) {?>
							<div class="mission_com fz26 bold">비공개</div>
							<? } ?>
							<? if($status == 5) {?>
								<div class="mission_com fz26 bold">종료된 체험단</div>
							<? } ?>
							<? if(strlen($type_check) > 0) {?>
								<span class="type_check"><?=$type_check?></span>
							<? } ?>
						</div>	
						<div class="title fz28 fw600 ellipsis_100"><?=$title_01?></div>
						<div class="day">
							<?  if($period_day) {?>	
								<span class="status"><?=$status_txt?></span>							
								<span class="period fz24">
									D-<?=$period_day?>
								</span>
							<? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
								<span class="status"><?=$status_txt?></span>
								<span class="period fz24">
									D-DAY
								</span>
							<? } ?>
							<? if($status == 5) {?>
								<span class="status"><?=$status_txt?></span>
								<span class="period fz24">
									END
								</span>
							<? } ?>
							<!-- <span class="date_02 fz24 fw600 op05"><?=$one_day?>-<?=$two_day?></span> -->
							<!-- <div class=""><?=mb_substr($list['hero_title_02'], 0, 18, 'EUC-KR');?></div> -->
							<p class="date_02 fz15 fw600 op05">
								<?=$one_day?>
								<span>-</span>
								<?=$two_day?>
							</p>
						</div>
					</a>
				</li>
			<?
			$i++;
			}
			?>
		</ul>
	</div>
	<!-- 리스트 e -->
    <?
		}else {
	?>
 		<div id="blankList">
        	검색결과가 없습니다.
        </div>
	<? 
		} 
		?>
     </ul>
	 </div>
	<div id="page_number" class="paging">
	<?include_once "page.php"?>
	</div>
        <!-- gallery 종료 --> 
   <? } ?>
      
    
<!--컨텐츠 종료-->

<script>
$(document).ready(function(){
	$('.missionStatusSearch').click(function(){
		$('.missionStatusSearch').removeClass('on');
		if($(this).attr('class').indexOf('on') != -1) {
			$(this).addClass('on');
		}
		$('#statusSearch').val($(this).attr('data-val'));
		$('#frm').submit();
	})
})
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? } ?>
</script>
<?include_once "tail.php";?>