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
	msg(' 마감된 체험단입니다.', 'location.href="' . $action_href . '"' );
	exit ();
}

$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
//echo $group_sql;
//exit;
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );

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
	if ($_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_08' || $_get['board'] == 'group_04_23' || $_get['board'] == 'group_04_27' || $_get['board'] == 'group_04_28') {
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
	<!--
    <div id="title"><p><?=$group_list['hero_title']?></p></div>
     -->

     
    <? include_once "boardIntroduce.php"; ?>
    <div class="clear"></div>  

 
    <div style="width:100%; text-align:center; margin-top:12px">
<!--
        <a href="http://www.aklover.co.kr/main/index.php?board=group_04_05&view=step_02&idx=31" target="_blank"><img src="img/general/viewer_btn1.jpg" alt="리뷰어 신청자" width="80px"/></a>&nbsp;&nbsp;
        <a href="http://www.aklover.co.kr/main/index.php?board=group_04_05&view=step_05&page=1&idx=28" target="_blank"><img src="img/general/viewer_btn2.jpg" alt="리뷰등록확인" width="80px"/></a></div>
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
	<!--
    <div style="padding-left:5%;padding-right:5%;word-wrap: break-word;word-break:break-all;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;"><?=$next_command;?>&nbsp;</div>
    <div class="clear"></div> 
    -->
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
    $review_menu = '체험단 신청 : ';
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
    $review_menu = '우수후기 발표 : ';
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
<?php 
				$command = htmlspecialchars_decode($board_list['hero_command']);
				$command = str_replace("&#160;","",$command);
				 $week = array("일", "월", "화", "수", "목", "금", "토");

				?>
				<!--div class="spm_img" style="padding:0;"><?=$command;?></div-->

				
  <style>
	.bold {font-weight:bold;}
	.bold2 {font-weight:bold;font-size:19px;}
	.fs18 {font-size:18px; }
	.fs20 {font-size:20px; }
	.center {text-align:center; }
	.fc_or {color:#f68428; }
	.pa30 {padding:30px; }
	.ml15 {margin-left:15px; }
	.ml35 {margin-left:35px; }
	.mt15 {margin-top:15px; }
	.fl {float:left; }
	.boxWrap {width:650px; padding:28px 23px; background:<?=$board_list['hero_bg']?>; color:#333; border:solid 1px #e0e0e0; font-size:15px; }
	.topWrap {height:300px; margin-bottom:25px; }
	.topWrap p {float:left; }
	.topWrap .topTit {float:left; width:350px; }
	.topWrap h1 {padding:0 50px 20px 50px; }
	.topWrap .txt {margin:0 auto; width:250px; padding:0 50px; max-height:55px; overflow:hidden; line-height:1.4em; }
	.contentWrap {width:734; border:3px solid #b5b7b5; background:#fff; }
	.contentWrap li {padding:30px; border-bottom:1px solid #e0e0e0; }
	.contentWrap li li {padding:0; border-bottom:none; }
	.contentWrap dt {font-size:20px; color:#a8a8a8; margin-bottom:30px; font-weight:bold; }
	.contentWrap dd {float:left; }
	.contentWrap li.m01 {height:170px; }
	.contentWrap li.m01 .periodTit {margin-right:5px; }
	.contentWrap li.m01 .periodTit li {width:110px;}
	.contentWrap li.m02 {height:200px; }
	.contentWrap li.m03 {height:auto; }
	.contentWrap li.m04 {height:auto; }
	.contentWrap li.m05 {height:160px; }
	.contentWrap li.m07 {height:270px; }
	.contentWrap li.m08 {min-height:300px; }
	.contentWrap li.m08 img{width:100%}
	.contentWrap li.m08 p{word-break:break-all}
	
	.boxWrap{ width:100%;}
	.boxWrap img{width:100%;}
	
	@media screen and (min-width:768px){
    	.col-sm-12-space { height:20px;float:left; }
    }
  </style>
 </head>

 <body>
	<div class="boxWrap">
		<div class="topWrap" style="height:inherit; margin-bottom:10px;">
			<p class="thumbBig" style="width:35%;"><img src="/user/upload/<?=$board_list['hero_img_old']?>" border="0" alt="제품"></p>
			<div class="topTit" style="width:65%; text-align:left; padding-left:5%;">		 
				<h1 style="padding:0; margin:0;"><img src="/image/mission/aekyungBoxTit.png" border="0" alt="나눔의 즐거움 애경박스 샘플링 미션"></h1>
				<p style="float:none; margin-bottom:5px;"><?=$board_list['hero_char']?></p>
				<p style="float:none; margin-bottom:5px;"><strong><?=$board_list['hero_title']?></strong></p>
			</div>
            <div style="clear:both;"></div>
		</div>
		<ul class="contentWrap">
        	<li class="m05" style="height:inherit;">
				<dl style="text-align:left;">
					<dt>|&nbsp;&nbsp;AK LOVER <span class="fc_or fs20">애경박스란?</span></dt>
					<dd style="width:30%"><img src="/image/mission/img_gift.jpg" border="0" alt="선물"></dd>
					<dd style="width:65%; padding-left:5%;">
                    	사랑(愛)과 존경(敬)의 마음으로 이웃과 소통하고 진정성 있는 나눔을 실천하는 애경!<br/>
                        애경의 경영 마인드처럼 애경 서포터즈 AK LOVER 분들에게도 나눔의 행복을 드리고 싶습니다.<br/>
                        애경박스를 통해 주위의 소중한 이웃, 지인, 가족들에게 사랑과 존경을 전하고 나눔의 행복을 느껴보세요.
                    </dd>
				</dl>
                <div style="clear:both;"></div>
			</li>
			
			<li class="m02" style="height:inherit;">
				<dl style="text-align:left;">
					<dt style="text-align:left; margin-bottom:10px;">|&nbsp;&nbsp;이달의 <span class="fc_or fs20">애경박스 제품</span></dt>
					<dd style="width:35%;"><img src="/user/upload/<?=$board_list['hero_img_old']?>" border="0" alt="제품"></dd>
					<dd style="width:60%; padding-left:5%; margin-top:0; height:inherit; font-size:14px;">
						<p><?=$next_help?></p>
                        <p><strong>선정인원 : 총 <?=$board_list['hero_select_count']?>명</strong></p>
                    </dd>
				</dl>
                <div style="clear:both;"></div>
			</li>
            <li class="m01" style="padding:2%; height:inherit;">
				<dl style="font-size:13px;">
					<dt style="text-align:left; margin-bottom:10px;">|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">일정 안내</span></dt>
					<dd style="width:95%; margin-left:5%;">
                    	<p style="text-align:left; margin-bottom:5px;"><strong>애경박스 신청</strong></p>
                        <p style="text-align:left; margin-bottom:5px;">- <?=date("Y.m.d",strtotime($board_list['hero_today_01_01']))?>(<?=$week[date("w",strtotime($board_list['hero_today_01_01']))]?>) ~ <?=date("Y.m.d",strtotime($board_list['hero_today_01_02']))?>(<?=$week[date("w",strtotime($board_list['hero_today_01_02']))]?>)</p>
                        <p style="text-align:left; margin-bottom:5px;"><strong>선정자 발표</strong></p>
                        <p style="text-align:left; margin-bottom:5px;">- <?=date("Y.m.d",strtotime($board_list['hero_today_02_01']))?>(<?=$week[date("w",strtotime($board_list['hero_today_02_01']))]?>)</p>
                        <p style="text-align:left; margin-bottom:5px;"><strong>후기 등록</strong></p>
                        <p style="text-align:left; margin-bottom:5px;">- <?=date("Y.m.d",strtotime($board_list['hero_today_03_01']))?>(<?=$week[date("w",strtotime($board_list['hero_today_03_01']))]?>) ~ <?=date("Y.m.d",strtotime($board_list['hero_today_03_02']))?>(<?=$week[date("w",strtotime($board_list['hero_today_03_02']))]?>)</p>
                        <p style="text-align:left; margin-bottom:5px;"><strong>우수후기 발표</strong></p>
                        <p style="text-align:left; margin-bottom:5px;">- <?=date("Y.m.d",strtotime($board_list['hero_today_04_01']))?>(<?=$week[date("w",strtotime($board_list['hero_today_04_01']))]?>)</p>
					</dd>
				</dl>
                <div style="clear:both;"></div>
			</li>
            <li class="m06" style="height:inherit;">
				<dl>
					<dt style="text-align:left;">|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">참여 방법</span></dt>
					<dd style="float:none; text-align:center; "><img src="/image/mission/img_mission.jpg" border="0" alt="참여방법"></dd>
				</dl>
                 <div style="clear:both;"></div>
			</li>
            <li class="m07" style="height:inherit;">
				<dl>
					<dt style="text-align:left;">|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">공지사항</span></dt>
					<dd style="text-align:left; font-size:13px;">
                    	<p style="margin-bottom:5px;"><strong style="color:#f68428;">01</strong> <span class="bold">애경박스 신청시 참여 이유와 나눔 계획</span>을 적어주세요.</p>
                        <p style="margin-bottom:5px;"><strong style="color:#f68428;">02</strong> <span class="bold">블로그 포스팅 1건, 개인 SNS 또는 커뮤니티 1건 총 2건에 후기를 등록</span>하여야 합니다.</p>
                        <p style="margin-bottom:5px;"><strong style="color:#f68428;">03</strong> <span class="bold">나눔 인증샷은 3건이상 </span>올리셔야 합니다.</p>
                        <p style="margin-bottom:5px;"><strong style="color:#f68428;">04</strong> 제공받은 제품 중 본품은 신청자 본인이 사용하며 <span class="bold">체험분은 100% 나눔</span>해주셔야 합니다.</p>
                        <p style="margin-bottom:5px;"><strong style="color:#f68428;">05</strong> <span class="bold">후기 미등록 시 100포인트 차감</span>되며 3달간 체험단 선정에서 제외됩니다.</p>
                        <p style="margin-bottom:5px;"><strong style="color:#f68428;">06</strong> <span class="bold">애경박스 제품 발송 비용은 애경에서 지원</span>합니다.</p>
					</dd>
				</dl>
                 <div style="clear:both;"></div>
				<!--p class="fc_or fl mt15 bold" style="font-size:13px; ">* 샘플은 단상자에 담겨진 제품으로 발송 될 예정이오니 참고 바랍니다.</p-->
			</li>
            <li class="m08" style="height:inherit;">
            	<dl>
                	<dt style="text-align:left;">|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">배너삽입</span></dt>
					<dd style="text-align:left; font-size:13px;">
                    	<?=$board_list['hero_banner']?>
                        <p><?=htmlspecialchars(trim($board_list['hero_banner']))?></p>
                        <p><span class="bold">위 배너 코드를 복사하여 컨텐츠 하단에 붙여넣기 해주세요.</span></p>   
					</dd>
                </dl>
            </li>
            
            <li class="m04" style="height:inherit;">
				<dl>
					<dt style="text-align:left;">|&nbsp;&nbsp;애경박스 나눔후기 <span class="fc_or fs20">좋은 예</span></dt>
					<dd style="float:none; text-align:center; ">
                    <?
    	                $hero_media = preg_replace("/width: \d+px/","width:100%;",$board_list['hero_media']);
						echo $hero_media;
					?>
					</dd>
				</dl>
                <div style="clear:both;"></div>
			</li> 	
            
			<li class="m03" style="height:inherit;">
				<dl>
					<dt style="text-align:left;">|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">제품 안내</span></dt>
					<dd style="float:none; ">
                    <? 
						$command = preg_replace("/width: \d+px/","width:100%;",$command);
						$command = preg_replace("/ height: (\"|\')?\d+px;(\"|\')?/","",$command);
						echo $command;
					?>
					</dd>
				</dl>
			</li>
            
			
            </ul>
		</div>	

<div style="clear:both;"></div>
<div class="share_area">
<?php
// 카카오톡 공유하기는 체험단 신청기간에만 노출
$now			= strtotime(date('Y-m-d'));
$application_01 = strtotime(substr($board_list['hero_today_01_01'], 0, 10));
$application_02 = strtotime(substr($board_list['hero_today_01_02'], 0, 10));
if( $_GET['board'] != "group_04_23" && $_GET['board'] != "group_04_08" && $_GET['board'] != "group_04_25" && $_GET['board'] != "group_04_06" && $_GET['board'] != "group_04_27" && $_GET['board'] != "group_04_28") {
	if( ($application_01 <= $now) && ($now <= $application_02) ) {
	?>
		<a href="javascript:KakaoDirect('<?=str_replace("'", "\'", $board_list['hero_title'])?>', '<?=str_replace("'", "\'", $title_02)?>', 'http://<?=$_SERVER["HTTP_HOST"].$img_new?>', 'http://<?=$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']?>');" class="sns_share_btn">
			<img src="/m/img/ico_kakao.png" width="190px"/>
		</a>
	<?php
	}
}
?>
</div>
<div class="mission_view_btn">
	

<?
$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['mission_idx'].'\'';
$view_sql = mysql_query($sql);
$data_count = mysql_num_rows($view_sql);




if(!strcmp($setup_type, '1')){
    if(!strcmp($data_count, '0')){
		
		if(strcmp($_SESSION['temp_code'], '')){ 
?>
			
			<a href="mission_application.php?<?=get()?>" class="m_content_btn">체험단 신청하기</a>
<?
		}else{
?>
			<a href="#" onClick="Javascript:alert('로그인을 하셔야 참여가능합니다');downMenu();" class="m_content_btn">체험단 신청하기</a>
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
      <a href="<?=DOMAIN_END.'m/mission_edit.php?'.get('hero_idx','hero_idx='.$list_01['hero_idx'])?>"class="m_content_btn">수정</a>
<?
		}
    }
}




if(!strcmp($setup_type, '2')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_03&idx='.$_REQUEST['mission_idx'])?>" target="_blank" class="m_content_btn">선정자 확인</a>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_02&idx='.$_REQUEST['mission_idx'])?>" target="_blank" class="m_content_btn">신청자 확인</a>
<?
}else if(!strcmp($setup_type, '3')){
$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and lot_01=\'1\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['mission_idx'].'\'';
$view_sql = @mysql_query($sql);
$data_count = @mysql_num_rows($view_sql);
    if(!strcmp($data_count, '0')){
?>
      <a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="m_content_btn">후기 확인하기</a>
<?
    }else{
$new_sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_01=\''.$_GET['mission_idx'].'\'';
$view_new_sql = mysql_query($new_sql);
$new_count = mysql_num_rows($view_new_sql);
    if(!strcmp($new_count, '0')){
?>
      <a href="/m/mission_write.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>&action=write" class="m_content_btn">후기 등록하기</a>
<?
    }else{
?>
      <a href="/m/board_01.php?board=<?=$_GET['board']?>&idx=<?=$_REQUEST['mission_idx']?>" class="m_content_btn">후기 확인하기</a>
<?
    }
}
}else if(!strcmp($setup_type, '4')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_05&idx='.$_REQUEST['mission_idx'])?>" target="_blank" class="m_content_btn">우수후기 확인</a>
<?
}else if(!strcmp($setup_type, '5')){
?>
      <a href="<?=DOMAIN_END.'main/index.php?'.get('page||hero_idx||mission_idx','view=step_05&idx='.$_REQUEST['mission_idx'])?>" target="_blank" class="m_content_btn">우수후기 확인</a>
<?
}
?>
	<a href="/m/mission.php?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>" class="mission">목록</a>
   </div>

   <!--<div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>-->
	
</div> 
     
   <div class="clear"></div>
   
<!--컨텐츠 종료-->
<?
include_once "btnTop.php";
include_once "tail.php";

}else{
    $msg = '권한이';
    $action_href = PATH_END.'mission.php?'.get('hero_idx||mission_idx','download=ok');
    msg($msg.' 없습니다.'.$_SESSION['temp_view'],'location.href="'.$action_href.'"');
    exit;
}
?>