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
//�Ⱓ
if(strcmp($_GET['search_month'], '00') && strcmp($_GET['search_month'], '')){
    if(strcmp($_GET['search_month'], '99')){ //�����Է� �ƴҶ�
        $search .= "AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_SUB(DATE_FORMAT(NOW(),'%Y%m%d'), INTERVAL ".$_GET['search_month']." MONTH) and DATE_FORMAT(now(),'%Y%m%d')";
    } else { //�����Է��϶�
        $search .= "AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
        $search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
    }

    $search_next .= "&search_month=".$_GET['search_month'];
}

//ī�װ�
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
		case "A": //��û
			$search .= " AND '".$ymd."' between hero_today_01_01 and hero_today_01_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
		case "B": //��ǥ
			$search .= " AND '".$ymd."' between hero_today_02_01 and hero_today_02_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
		case "C": //�ı�
			$search .= " AND '".$ymd."' BETWEEN hero_today_03_01 and hero_today_03_02 AND hero_today_02_02 != hero_today_03_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";
			break;
		case "D": //�����
			$search .= " AND '".$ymd."' BETWEEN hero_today_04_01 and hero_today_04_02 AND hero_today_02_02 != hero_today_04_02 ";
			$search_next .= "&statusSearch='".$_GET['statusSearch']."'";	
			break;
	}
}

if(strlen($_GET["hero_type"]) > 0) {
	$search .= " AND hero_type = '".$_GET["hero_type"]."' ";
	$search_next .= "&hero_type=".$_GET['hero_type'];
}

$total_sql = " SELECT count(*) cnt FROM mission WHERE hero_kind!='����ü��' AND hero_table='".$_REQUEST['board']."' ".$search;

if($_SESSION['temp_level'] < "9999") { //������ ����
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

//��Ŀ�� �׷� ����
$noAuthPage = false;
$temp_auth_hero_code = $_SESSION["temp_code"];

//��Ŀ�� �׷� ����
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
			if($focus_gisu_auth_cnt == 0) { //���� ����� ���� �ȵ�
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
					<h1 class="fz72 main_c fw500">������ ��Ƽ&������ Ŭ��</h1> 
				<? } else if ($_GET ['board'] == 'group_04_06') { ?>
					<h1 class="fz72 main_c fw500">�����̾� ��Ƽ Ŭ��</h1> 
				<? } else if ($_GET ['board'] == 'group_04_28') { ?>	
					<h1 class="fz72 main_c fw500">�����̾� ������ Ŭ��</h1> 		
				<? } ?>
				<p class="fz28 fw600 desc">SNS ������ �ִٸ� ������ ��û ������ ü����Դϴ�.<br /> �ְ��� �� ��ǰ�� �����ϰ� �����غ�����! </p>                   
			</div>
			<ul class="tab f_cs">                              
				<li><a href="/m/beauty_life_aklover.php" class="fz12 fw500 on mission_guide_btn">������� ��������<img src="/img/front/main/right_wh.webp" alt="�ٷΰ���"></a></li>
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
        	<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ //��Ƽ,��Ʃ��,������ ?>
            	<span class="missionStatusSearch <?=$_GET['statusSearch']==""?"active":""?>" data-val="">��ü</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"active":""?>" data-val="C">���������</span>
            <? }else { ?>
            	<span class="missionStatusSearch <?=$_GET['statusSearch']==""?"active":""?>" data-val="">��ü</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"active":""?>" data-val="A">ü��ܽ�û</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"active":""?>" data-val="B">�����ڹ�ǥ</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"active":""?>" data-val="C">���������</span>
                <span class="missionStatusSearch <?=$_GET['statusSearch']=="D"?"active":""?>" data-val="D">����ڹ�ǥ</span>
            <? } ?>
        </div>
		<!-- ����Ʈ s -->
		<div class="blog_box2">
			<ul class="guerrilla_event grid_3">
				<?
				$list_sql = "SELECT * FROM mission WHERE hero_kind != '����ü��' AND hero_table='".$_GET['board']."' ".$search;
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

				if($_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_27" || $_GET['board'] == "group_04_28") { //��Ƽ,��Ʃ��,������
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
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='���̹� ��α�'>";
					} else if($list["hero_question_url_check"] == "2") {
						$type_check = "<img src='/m/img/musign/supporters/ic_insta.png' alt='�ν�Ÿ�׷�'>";
					} else if($list["hero_question_url_check"] == "3") {
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='��α�'><img src='/m/img/musign/supporters/ic_insta.png' alt='�ν�Ÿ�׷�'>";
					} else if($list["hero_question_url_check"] == "4") {
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='��α�'><img src='/m/img/musign/supporters/ic_insta.png' alt='�ν�Ÿ�׷�'>";
					} else if($list["hero_question_url_check"] == "5") {
						$type_check =  "<img src='/m/img/musign/supporters/ic_youtube.png' alt='��Ʃ��'>";
					} else if($list["hero_question_url_check"] == "6") {
						$type_check = "<img src='/m/img/musign/supporters/ic_naver_blog.png' alt='��α�'><img src='/m/img/musign/supporters/ic_insta.png' alt='�ν�Ÿ�׷�'><img src='/m/img/musign/supporters/ic_youtube.png' alt='��Ʃ��'>";
					} else {
						// if($list["hero_type"] == "1") {
						// 	$type_check = "�̺�Ʈ";
						// } else if($list["hero_type"] == "2") {
						// 	$type_check = "�ҹ�����";
						// } else if($list["hero_type"] == "3") {
						// 	$type_check = "��������";
						// } else if($list["hero_type"] == "5") {
						// 	$type_check = "ǰ������";
						// } else if($list["hero_type"] == "8") {
						// 	$type_check = "����Ʈü��";
						// } else {
						// 	$type_check = "ü���";
						// }
					}
				}
				
				if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){
					
					$ribbon_text = $list['hero_kind'];
					if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
						$ribbon_text = $list['hero_kind'];
					}
					
					if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //�����̼�, ����̼�(����)
						if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
							$status_txt = "ü��� ��û";
							$status = "1";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
							$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
						}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
							$status_txt = "������ ��ǥ";
							$status = "2";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
							$period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
						}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
							$status_txt = "���������";
							$status = "3";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
							$period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
						}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
							$status_txt = "�����������ǥ";
							$status = "4";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
							$period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
						}else if($today_04_02<$check_day){
							$status_txt = "ü��� ����";
							$status = "5";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							// $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
							$two_day = "";
						}else if($today_05_01>$check_day){
							$status_txt = "ü��� ���⿹��";
							$status = "5";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
						}
					} else {
						if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
							$status_txt = "���������";
							$status = "3";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
							$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
						}else if($today_01_02<$check_day){
							$status_txt = "ü��� ����";
							$status = "5";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							// $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
							$two_day = "";
						}else if($today_05_01>$check_day){
							$status_txt = "ü��� ���⿹��";
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
							$txt1 = "�ҹ����� ";
							$txt2 = "�ҹ����� ��û";
						} else if($list["hero_type"] == "10") {
							$txt1 = "ü���";
							$txt2 = "ü��� ����";
						}
						
						if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
							$status_txt = $txt2;
							$status = "1";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
							$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
						}else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
							$status_txt = "��÷�� ��ǥ";
							$status = "2";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
							$period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
						}else if(($today_04_02 < $check_day)){
							$status_txt = $txt1." ����";
							$status = "5";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
						}
					}else {
						if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
							//20180831 �ӽ÷� ����
							if($list['hero_idx'] == "1288") {
								$status_txt = "�̺�Ʈ ��û";
							} else {
								$status_txt = "ü��� ��û";
							}
							$status = "1";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
							$period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
						}else if(($today_02_01<=$check_day) and ($today_02_02>=$check_day)){
							$status_txt = "������ ��ǥ";
							$status = "2";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
							$period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
						}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
							$status_txt = "���������";
							$status = "3";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
							$period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
						}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
							$status_txt = "�����������ǥ";
							$status = "4";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
							$two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
							$period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
						}else if($today_04_02<$check_day){
							$status_txt = "ü��� ����";
							$status = "5";
							$one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
							// $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
							$two_day = "";
						}else if($today_05_01>$check_day){
							$status_txt = "ü��� ���⿹��";
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
							<div class="mission_com fz26 bold">�����</div>
							<? } ?>
							<? if($status == 5) {?>
								<div class="mission_com fz26 bold">����� ü���</div>
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
	<!-- ����Ʈ e -->
    <?
		}else {
	?>
 		<div id="blankList">
        	�˻������ �����ϴ�.
        </div>
	<? 
		} 
		?>
     </ul>
	 </div>
	<div id="page_number" class="paging">
	<?include_once "page.php"?>
	</div>
        <!-- gallery ���� --> 
   <? } ?>
      
    
<!--������ ����-->

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