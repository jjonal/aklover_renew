<?php
include_once "head.php";
#####################################################################################################################################################



$sql = "select * from mission where hero_table='".$_REQUEST['board']."' ";//hero_today_04_02 desc
if( (!strcmp($_SESSION['temp_level'], '10000')) or (!strcmp($_SESSION['temp_level'], '9999')) ){ 
	//관리자 일 경우 잘 보여 짐 
}else{
	//관리자가 아닐경우, 노출된 미션만 보여짐 
	$sql.=" and ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' and '".date("Y-m-d H:i")."' >= hero_today_05_01)) and ((hero_today_05_02 is null or hero_today_05_02 ='') or (hero_today_05_02 is not null and hero_today_05_02 != '' and '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
}
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);



######################################################################################################################################################



$list_page=6;
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
######################################################################################################################################################

if (! strcmp ( $_REQUEST ['board'], "group_04_05" )) {
	$title_view_all = "회원이면 누구나 참여할 수 있는 체험이에요";
} else if (! strcmp ( $_REQUEST ['board'], "group_04_06" )) {
	$title_view_all = "지원으로 선발된 회원만 참여할 수 있는 체험이에요";
} else if (! strcmp ( $_REQUEST ['board'], "group_04_07" )) {
	$title_view_all = "애경 제품으로 구성된 테마박스를 지원해 드려요";
} else if (! strcmp ( $_REQUEST ['board'], "group_04_08" )) {
	$title_view_all = "AKLOVER 기자단을 위한 공간이에요";
} else if (! strcmp ( $_REQUEST ['board'], "group_04_23" )) {
	$title_view_all = "지원으로 선발된 회원만 참여할 수 있는 체험이에요";
}


?>
<link href="css/general.css" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
     <div id="title"><p><?=$right_list['hero_title'];?></p></div>
     
     <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>
     
<div id="guide">
         <ul style="width:100%">
         <li style="width:13%; margin-left:5%"><img src="img/general/note1.png" alt="" width="45px"/></li>
         <li class="guide_text" style="width:82%"><p><?=$title_view_all?></p></li>
        </ul> 
</div>
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

    if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
    	if($_GET['board'] == "group_04_23"){
    		$review_menu = '리뷰 등록';
    	}else{
    		$review_menu = '미션 신청';
    	}
        $one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_01_02']));
    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
        $review_menu = '미션 발표';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_02_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_02_02']));
    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
        $review_menu = '리뷰 등록';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_03_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_03_02']));
    }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
        $review_menu = '베스트 발표';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_04_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
    }else{
        $review_menu = '미션 마감';
        $one_day = date( "m월d일", strtotime($main_list['hero_today_01_01']));
        $two_day = date( "m월d일", strtotime($main_list['hero_today_04_02']));
		$mission_complete = "<div style='width:100%;height:210px;background-color: #eeeeee;position: relative;opacity: 0.8;'><img src='/m/img/general/mission_complete.png' style='width: 85%;top: -182px;position: relative;left: 10%;max-height: 180px;'></div>";    
	}
	
	
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

      
       <!-- gallery 종료 --> 
      
    
<!--컨텐츠 종료-->

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? } ?>
</script>
<?include_once "tail.php";?>