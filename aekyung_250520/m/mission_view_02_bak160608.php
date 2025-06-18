<?php
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
    }else{
    }
}
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $_SESSION['temp_level'] = '0';
    $_SESSION['temp_write'] = '0';
    $_SESSION['temp_view'] = '1';
    $_SESSION['temp_update'] = '0';
    $_SESSION['temp_rev'] = '0';
}
######################################################################################################################################################
$board_sql = 'select * from mission where hero_idx = \''.$_REQUEST['mission_idx'].'\';';
sql($board_sql, 'on');
$board_list = @mysql_fetch_assoc($out_sql);

if($_SESSION['temp_write'] < 9999 and strtotime($board_list["hero_today_04_02"]) <= mktime(0,0,0,date("m"),date("d"),date("Y"))){
	$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
	msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
	exit ();
}


if(!strcmp($board_list['hero_table'],'hero')){
    $group_table_name = $board_list['hero_03'];
    $group_table_temp_name = "hero_03";
}else{
    $group_table_name = $board_list['hero_table'];
    $group_table_temp_name = "hero_table";
}

$group_sql = 'select * from hero_group where hero_board =\''.$group_table_name.'\';';//desc
$out_group_sql = @mysql_query($group_sql);
$group_list = @mysql_fetch_assoc($out_group_sql);
if($group_list['hero_view'] <= $_SESSION['temp_view']){//권한
	// 프리미엄 미션은 로그인이후 접속가능
	if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_08') {
		if ($right_list ['hero_view'] > $_SESSION['temp_view']) {
			if (! strcmp ( $_SESSION['temp_level'], '0' )) {
				$msg = '권한이';
				$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
			} else {
				$msg = '권한이';
				$action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','');
			}
			msg( $msg . ' 없습니다.', 'location.href="' . $action_href . '"' );
			exit();
		}
	}

$group_view_point = $group_list['hero_view_point'];//리뷰 획득포인트

$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$board_list['hero_code'].'\'';

$out_pk_sql = mysql_query($pk_sql);
$pk_row = @mysql_fetch_assoc($out_pk_sql);

$today_total_sql = 'select hero_point from today where hero_type=\'hero_total\'';
$out_today_total_sql = @mysql_query($today_total_sql);
$today_total_list                             = @mysql_fetch_assoc($out_today_total_sql);
$point_total_point = $today_total_list['hero_point'];//당일 최대 획득포인트

$today_user_total_sql = 'select SUM(hero_point) as today_user_total from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$_SESSION['temp_code'].'\' and not hero_title="월출석개근";';

$out_today_user_total_sql = @mysql_query($today_user_total_sql);
$today_user_total_list                             = @mysql_fetch_assoc($out_today_user_total_sql);
$today_user_total = $today_user_total_list['today_user_total'];//당일 획득 포인트

$board_user_sql = 'select * from point where hero_table=\''.$group_table_name.'\' and hero_type=\'view\' and date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$_SESSION['temp_code'].'\';';
$out_board_user = @mysql_query($board_user_sql);
$board_user_count = @mysql_num_rows($out_board_user);

if( ($point_total_point>=$today_user_total) and (!strcmp($board_user_count,'0')) ){
    if(strcmp($group_view_point,'0')){
/////////////////////////////////////////////////////////////////////hero_mission_idx
        $sql_one_write = 'hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
        $sql_two_write = '\''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \'view\', \''.$_REQUEST['mission_idx'].'\', \''.$_REQUEST['mission_idx'].'\', \''.$_SESSION['temp_id'].'\', \''.$group_list['hero_title'].'\', \''.$board_list['hero_title'].'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$group_view_point.'\', \''.Ymdhis.'\'';
        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        @mysql_query($sql);
        $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$_SESSION['temp_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $temp_level_sql = "select * from level where hero_point_01<='".$member_total_point."' and hero_point_02>='".$member_total_point."' ";
        $out_temp_level = @mysql_query($temp_level_sql);
        $temp_level_list                             = @mysql_fetch_assoc($out_temp_level);

        if($temp_level_list['hero_level'] > $_SESSION['temp_level']){
            $sql = 'UPDATE member SET 
                    hero_level=\''.$temp_level_list['hero_level'].'\',
                    hero_write=\''.$temp_level_list['hero_level'].'\',
                    hero_view=\''.$temp_level_list['hero_level'].'\',
                    hero_update=\''.$temp_level_list['hero_level'].'\',
                    hero_rev=\''.$temp_level_list['hero_level'].'\',
                    hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
            @mysql_query($sql);
            $_SESSION['temp_level'] = $temp_level_list['hero_level'];
            $_SESSION['temp_write'] = $temp_level_list['hero_level'];
            $_SESSION['temp_view'] = $temp_level_list['hero_level'];
            $_SESSION['temp_update'] = $temp_level_list['hero_level'];
            $_SESSION['temp_rev'] = $temp_level_list['hero_level'];

            $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
            msg($msg,'');
        }else{
            $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
            @mysql_query($sql);
        }
    }
}

?>
<link href="css/general_viewer.css" rel="stylesheet" type="text/css">
<!--컨텐츠 시작-->
<div id="content">
    <div id="title"><p><?=$group_list['hero_title']?></p></div>
     
    <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>
     
    <div id="guide">
         <ul style="width:100%">
         <li style="width:13%; margin-left:5%"><img src="img/general/note1.png" alt="" width="45px"/></li>
         <li class="guide_text" style="width:82%"><p>나눔 등급부터 모든 분들이 참여할 수 있는 미션이예요.</p></li>
        </ul> 
    </div>
    <div class="clear"></div>  

 
    <div style="width:100%; text-align:center; margin-top:12px">
<!--
        <a href="https://aklover.co.kr:11486/main/index.php?board=group_04_05&view=step_02&idx=31" target="_blank"><img src="img/general/viewer_btn1.jpg" alt="리뷰어 신청자" width="80px"/></a>&nbsp;&nbsp;
        <a href="https://aklover.co.kr:11486/main/index.php?board=group_04_05&view=step_05&page=1&idx=28" target="_blank"><img src="img/general/viewer_btn2.jpg" alt="리뷰등록확인" width="80px"/></a></div>
-->
  <div id="viewer_title" style="width:93%; padding-left:7%; margin-bottom:25px;"><?=$board_list['hero_title']?>&nbsp;</div>
<?
$next_command = htmlspecialchars_decode($board_list['hero_command']);
$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
$next_command = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_command);
$next_command = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_command);
$next_command = preg_replace("/width: \d+px/","width:100%;",$next_command);
$next_command = preg_replace("/height: \d+px;/","",$next_command);
$next_command = preg_replace("/height: \d+px/","",$next_command);
?>
    <div style="padding-left:5%;padding-right:5%;word-wrap: break-word;word-break:break-all;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;"><?=$next_command;?>&nbsp;</div>

    <div class="clear"></div> 
<?
$check_day = date( "Y-m-d", time());
$today_01_01 = date( "Y-m-d", strtotime($board_list['hero_today_01_01']));
$today_01_02 = date( "Y-m-d", strtotime($board_list['hero_today_01_02']));

$today_02_01 = date( "Y-m-d", strtotime($board_list['hero_today_02_01']));
$today_02_02 = date( "Y-m-d", strtotime($board_list['hero_today_02_02']));

$today_03_01 = date( "Y-m-d", strtotime($board_list['hero_today_03_01']));
$today_03_02 = date( "Y-m-d", strtotime($board_list['hero_today_03_02']));

$today_04_01 = date( "Y-m-d", strtotime($board_list['hero_today_04_01']));
$today_04_02 = date( "Y-m-d", strtotime($board_list['hero_today_04_02']));

if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
    $review_menu = '참여 신청 : ';
    $one_day = $board_list['hero_today_01_01'];
    $two_day = $board_list['hero_today_01_02'];
    $setup_type = '1';
}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
    $review_menu = '당첨자 발표 : ';
    $one_day = $board_list['hero_today_02_01'];
    $two_day = $board_list['hero_today_02_02'];
    $setup_type = '2';
}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
    $review_menu = '후기 등록 : ';
    $one_day = $board_list['hero_today_03_01'];
    $two_day = $board_list['hero_today_03_02'];
    $setup_type = '3';
}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
    $review_menu = '베스트 발표 : ';
    $one_day = $board_list['hero_today_04_01'];
    $two_day = $board_list['hero_today_04_02'];
    $setup_type = '4';
}else{
    $review_menu = '참여 기간 : ';
    $one_day = $board_list['hero_today_01_01'];
    $two_day = $board_list['hero_today_04_02'];
    $setup_type = '5';
}

$next_help = htmlspecialchars_decode($board_list['hero_help']);
$next_help = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_help);
$next_help = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_help);
$next_help = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_help);
$next_help = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_help);
$next_help = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_help);
$next_help = preg_replace("/width: \d+px/","",$next_help);
?>


   
<div style="text-align:center; margin-bottom:20px">

<?
$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['mission_idx'].'\'';
$view_sql = mysql_query($sql);
$data_count = mysql_num_rows($view_sql);




if(!strcmp($setup_type, '1')){
    if(!strcmp($data_count, '0')){
		
		if(strcmp($_SESSION['temp_code'], '')){ 
?>
			
			<a href="mission_application.php?<?=get()?>"><img src="img/general/viewer_btn3.jpg" alt="미션참여하기" width="110px"/></a>
<?
		}else{
?>
			<a href="#" onclick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();"><img src="img/general/viewer_btn3.jpg" alt="미션참여하기" width="110px"/></a>
			<!--<a href="mission_application.php?<?=get()?>"><img src="img/general/viewer_btn3.jpg" alt="미션참여하기" width="110px"/></a>-->
<?
		}
    }else{
//    }//2리뷰어등록//1리뷰어신청자//3미션참여하기

$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['mission_idx'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' order by hero_today desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
$list_01                             = @mysql_fetch_assoc($out_sql_01);
		if(strcmp($_SESSION['temp_id'], '')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_02&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero1.jpg" alt="신청자 확인" width="110px"/></a>
      <a href="<?=DOMAIN_END.'m/mission_edit.php?'.get('hero_idx','hero_idx='.$list_01['hero_idx'])?>"><img src="img/general/modify_btn.jpg" alt="수정" width="110px"/></a>
<?
		}
    }
}




if(!strcmp($setup_type, '2')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_03&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero2.jpg" alt="당첨자 확인" width="110px"/></a>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_02&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero1.jpg" alt="신청자 확인" width="110px"/></a>
<?
}else if(!strcmp($setup_type, '3')){
$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and lot_01=\'1\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['mission_idx'].'\'';
$view_sql = @mysql_query($sql);
$data_count = @mysql_num_rows($view_sql);
    if(!strcmp($data_count, '0')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_05&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero3.jpg" alt="등록 확인" width="110px"/></a>
<?
    }else{
$new_sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_01=\''.$_GET['mission_idx'].'\'';
$view_new_sql = mysql_query($new_sql);
$new_count = mysql_num_rows($view_new_sql);
    if(!strcmp($new_count, '0')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_04&action=write&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero4.jpg" alt="리뷰 등록" width="110px"/></a>
<?
    }else{
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_05&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero3.jpg" alt="등록 확인" width="110px"/></a>
<?
    }
}
}else if(!strcmp($setup_type, '4')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_05&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero5.jpg" alt="발표 확인" width="110px"/></a>
<?
}else if(!strcmp($setup_type, '5')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_05&idx='.$_REQUEST['mission_idx'])?>" target="_blank"><img src="img/hero5.jpg" alt="발표 확인" width="110px"/></a>
<?
}
?>
   </div>

   <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>

</div> 
     
   <div class="clear"></div>
<!--컨텐츠 종료-->
<?
include_once "tail.php";

}else{
    $msg = '권한이';
    $action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','download=ok');
    msg($msg.' 없습니다.'.$_SESSION['temp_view'],'location.href="'.$action_href.'"');
    exit;
}
?>