<?php
include_once "head.php";
#####################################################################################################################################################
if($_GET['kewyword']){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

$sql = "select * from mission where hero_table='".$_REQUEST['board']."' ".$search;//hero_today_04_02 desc
if( (!strcmp($_SESSION['temp_level'], '10000')) or (!strcmp($_SESSION['temp_level'], '9999')) ){ 
	//관리자 일 경우 잘 보여 짐 
}else{
	//관리자가 아닐경우, 노출된 미션만 보여짐 
	$sql.=" and ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' and '".date("Y-m-d H:i")."' >= hero_today_05_01)) and ((hero_today_05_02 is null or hero_today_05_02 ='') or (hero_today_05_02 is not null and hero_today_05_02 != '' and '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
}

$searchType = $_GET['searchType'];
$searchText = $_GET['searchText'];
if($searchType) {
	$sql .=" and ".$searchType." like '%".$searchText."%'";
}
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);



######################################################################################################################################################



$list_page=9;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;

//http://www.aklover.co.kr/m/board_00.php?board=group_01_01
$next_path=get("page");
######################################################################################################################################################
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
//echo $group_sql;
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];

// 프리미엄 미션은 로그인이후 접속가능
if($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_08' || $_GET ['board'] == 'group_04_23'){
	if($my_view != '9999' && $my_view != '10000'){
		if($my_view < $right_list['hero_list']) {
			error_historyBack("죄송합니다. 권한이 없습니다.");
			exit;
		}else {
			//기자단
			if($_GET ['board'] == 'group_04_08'){
				if($right_list['hero_list'] == '9998') {
					if($my_view != $right_list['hero_list'] ){
						error_historyBack("죄송합니다. AKLOVER 기자단만 참여할 수 있습니다.");
						exit;
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						error_historyBack("죄송합니다. 권한이 없습니다.");
						exit;
					}
				}
				
			//휘슬클럽
			}else if($_GET ['board'] == 'group_04_23'){
				if($right_list['hero_list'] == '9997') {
					if($my_view != $right_list['hero_list']){
						error_historyBack("죄송합니다. 휘슬클럽만 참여할 수 있습니다.");
						exit;
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						error_historyBack("죄송합니다. 권한이 없습니다.");
						exit;
					}
				}
				
			//루나체험단
			}else if($_GET['board'] == 'group_04_06'){
				if($right_list['hero_list'] == '9996') {
					if($my_view != $right_list['hero_list'] &&  $_SESSION['temp_id'] != "sr1787"){
						error_historyBack("죄송합니다. 루나체험단만 참여할 수 있습니다.");
						exit;
					}
				}else {
					if($my_view < $right_list['hero_list']) {
						error_historyBack("죄송합니다. 권한이 없습니다.");
						exit;
					}
				}
			}	
		}
	}
}
######################################################################################################################################################



?>
<link href="css/general.css" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
	
    <!-- <div id="title"><p><?=$right_list['hero_title'];?></p></div>-->
     
     
     
<? include_once "boardIntroduce.php"; ?>
 	<div class="clear"></div>  

       <!-- gallery 시작 -->
    <div id="gallery">
      <ul>
<?
$main_sql = $sql. "order by CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_02 END desc,
CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_02 END desc,
CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_02 END desc,
CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_02 END desc,
CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_02 END desc
limit ".$start.",".$list_page.";";

//$main_sql = $sql.' limit '.$start.','.$list_page.';';
//echo $main_sql;
$out_main = @mysql_query($main_sql);
$i="0";
while($main_list                             = @mysql_fetch_assoc($out_main)){
    if(!strcmp($i,'0')){
        $ul_class = "gallery_left";
    }else if(!strcmp($i,'1')){
        $ul_class = "gallery_center";
    }else if(!strcmp($i,'2')){
        $ul_class = "gallery_right";
    }else if(!strcmp($i,'3')){
        $ul_class = "gallery_left1";
    }else if(!strcmp($i,'4')){
        $ul_class = "gallery_center1";
    }else if(!strcmp($i,'5')){
        $ul_class = "gallery_right1";
    }else if(!strcmp($i,'6')){
        $ul_class = "gallery_left1";
    }else if(!strcmp($i,'7')){
        $ul_class = "gallery_center1";
    }else if(!strcmp($i,'8')){
        $ul_class = "gallery_right1";
    }
	

//echo $main_list['hero_img_new'];
    
    $img_parser_url = @parse_url($main_list['hero_img_new']);
    $img_host = $img_parser_url['host'];
    $img_path = $img_parser_url['path'];
    
    if($main_list['hero_thumb']){
		$view_img = $main_list['hero_thumb'];
	}elseif(is_file($main_list['hero_img_new'])){
		$view_img = $main_list['hero_img_new'];
	}else{
		$view_img = IMAGE_END.'hero.jpg';
	}


    /*if(!strcmp($main_list['hero_thumb'],'')){
	    if(!strcmp($main_list['hero_img_new'],'')){
	        $view_img = IMAGE_END.'hero.jpg';
	    }else{
	    	$view_img = $main_list['hero_img_new'];
	    }
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list['hero_thumb'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $main_list['hero_thumb'];
    }*/

    $content = $main_list['hero_command'];
    $content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
    $content = str_replace("\r", "", $content);
    $content = str_replace("\n", "", $content);
    $content = str_replace("&#65279;", "", $content);
    $content_01 = cut($content,'50');
    if(!strcmp($content_01,"")){
        $content_01 = "&nbsp;";
    }


    $title = $main_list['hero_title'];
    $title = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($title))));
    $title = str_replace("\r", "", $title);
    $title = str_replace("\n", "", $title);
    $title = str_replace("&#65279;", "", $title);
    $title_01 = $title;//cut($title,'50');
    if(!strcmp($title_01,"")){
        $title_01 = "&nbsp;";
    }
    $check_day = date( "Y-m-d", time());
    $today_01_01 = date( "Y-m-d", strtotime($main_list['hero_today_01_01']));
    $today_01_02 = date( "Y-m-d", strtotime($main_list['hero_today_01_02']));

    $today_02_01 = date( "Y-m-d", strtotime($main_list['hero_today_02_01']));
    $today_02_02 = date( "Y-m-d", strtotime($main_list['hero_today_02_02']));

    $today_03_01 = date( "Y-m-d", strtotime($main_list['hero_today_03_01']));
    $today_03_02 = date( "Y-m-d", strtotime($main_list['hero_today_03_02']));

    $today_04_01 = date( "Y-m-d", strtotime($main_list['hero_today_04_01']));
    $today_04_02 = date( "Y-m-d", strtotime($main_list['hero_today_04_02']));
	
	$mission_complete = '';

    
	//루나, 휘슬
	if($_GET['board'] == "group_04_23" || $_GET['board'] == 'group_04_06'){
		if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
			$review_menu = "후기 등록";
			$one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
			$two_day = date( "m월d일", strtotime($main_list['hero_today_01_02']));
			$mission_complete ='';
		}else if($today_01_02<$check_day){
			$review_menu = "체험단 마감";
			$mission_complete = "<div style='width:100%;height:210px;background-color: #eeeeee;position: relative;opacity: 0.8;'><img src='/m/img/general/mission_complete.png' style='width: 85%;top: -182px;position: relative;left: 10%;max-height: 180px;'></div>";
			$one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
			$two_day = date( "m월d일", strtotime($main_list['hero_today_01_02']));
		}
	// 루나, 휘슬 아닌거
	}else {
		if($main_list['hero_type'] == 2) {
			if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
				$review_menu = "소문내기 신청";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_01_02']));
				$mission_complete ='';
			}else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
				$review_menu = "소문내기 발표";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_02_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
			}else if(($today_04_02 < $check_day)){
				$review_menu = "소문내기 마감";
				$mission_complete = "<div style='width:100%;height:210px;background-color: #eeeeee;position: relative;opacity: 0.8;'><img src='/m/img/general/mission_complete.png' style='width: 85%;top: -182px;position: relative;left: 10%;max-height: 180px;'></div>";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
			}
		}else {
			if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
				$review_menu = "체험단 신청";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_01_02']));
			}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
				$review_menu = "체험단 발표";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_02_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_02_02']));
			}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
				$review_menu = "후기 등록";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_03_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_03_02']));
			}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
				$review_menu = "우수후기 발표";
				$one_day = date( "m월d일", strtotime($main_list['hero_today_04_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
			}else if($today_04_02<$check_day){
				$review_menu = "체험단 마감";
				$mission_complete = "<div style='width:100%;height:210px;background-color: #eeeeee;position: relative;opacity: 0.8;'><img src='/m/img/general/mission_complete.png' style='width: 85%;top: -182px;position: relative;left: 10%;max-height: 180px;'></div>";    
				$one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
				$two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
			}
		}
	}
	
	
	
	
	//161125 변경
	/*if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
    	if($_GET['board'] == "group_04_23" || $_GET['board'] == 'group_04_06'){
    		$review_menu = '후기 등록';
    	}else{
    		$review_menu = '체험단 신청';
    	}
        $one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_01_02']));
    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
        $review_menu = '체험단 발표';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_02_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_02_02']));
    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
        $review_menu = '후기 등록';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_03_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_03_02']));
    }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
        $review_menu = '우수후기 발표';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_04_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
    }else{
        $review_menu = '체험단 마감';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
		$mission_complete = "<div style='width:100%;height:210px;background-color: #eeeeee;position: relative;opacity: 0.8;'><img src='/m/img/general/mission_complete.png' style='width: 85%;top: -182px;position: relative;left: 10%;max-height: 180px;'></div>";    
	} */
	
	
?>
        <li class="<?=$ul_class?>" style="height:210px;">
              <ul class="gallery_box" style="width:100%;">
                <li class="thumb" style="width:100%">
					<a href="<?=DOMAIN_END?>m/mission_view<?echo ($_REQUEST['board']=='group_04_07')? "_02" : ""; ?>.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=&mission_idx=<?=$main_list['hero_idx']?>">
						<img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" width="100%" height="100">
					</a>
				</li>
                <li class="gallery_title2" style="width:90%; padding-left:5%"><?=$title_01?></li>
				<a href="<?=DOMAIN_END?>m/mission_view.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=&mission_idx=<?=$main_list['hero_idx']?>">
					<li class="date" style="width:100%"><?=$review_menu?>
					</li>
				</a>
				<a href="<?=DOMAIN_END?>m/mission_view.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=&mission_idx=<?=$main_list['hero_idx']?>"> 
					<li class="date" style="width:100%; margin-bottom:5%"><?=$one_day?> - <?=$two_day?>
					</li>
				</a>
               </ul>
				<?=$mission_complete?>
                 <!--<span class="more"><a href="general_viewer"><img src="img/general/more.jpg" alt="더보기"/></a></span>-->
        </li>
<?
$i++;
}
?>
     </ul>
     <div class="clear"></div> 

      </div>
	       <!--<div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>-->
     <div id="page_number" style="text-align:center">
<?include_once "page.php"?>
      </div>
      <? include_once 'searchBox.php';?>
      
   


      
       <!-- gallery 종료 --> 
      
    
<!--컨텐츠 종료-->

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? } ?>
</script>
<?include_once "tail.php";?>