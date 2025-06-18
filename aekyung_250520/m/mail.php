<?php

include_once "head.php";
// #####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
// #####################################################################################################################################################
if($_GET['board']!='mail'){
	error_location("권한이 없습니다.","/m/main.php?board=login");
	exit;
}
if(!$_SESSION ['temp_level']) {
	error_location("권한이 없습니다.","/m/main.php?board=login");
	exit;
}
	
$error = "MAIL_01";
$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
$out_group = new_sql( $group_sql,$error,"on");
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );
if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	error_historyBack("페이지 권한이 없습니다.");
	exit;
}

##변수 설정
#####################################################################################################################################################

$title_view_all = "쪽지함입니다.";

$error = "TODAY_02";
$sql = "select count(*) from mail where hero_user like '%". $_SESSION ['temp_id']."%' or hero_user='all' order by hero_today desc";
$out_sql = new_sql( $sql, $error,"on" );
	
if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}
$total_data = mysql_result ( $out_sql,0,0 );
// #####################################################################################################################################################
$list_page = 5;
$page_per_list = 5;

if (! strcmp ( $_GET ['page'], '' )) $page = '1';
else 	$page = $_GET ['page'];

$start = ($page - 1) * $list_page;
$next_path = get ("page||hero_i_count");

?>

<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link href="css/today.css" rel="stylesheet" type="text/css">

<!--컨텐츠 시작-->
	<div id="title">
		<p><?=$right_list['hero_title'];?></p>
	</div>

	<div>
		<img src="img/shadow1.jpg" alt="" width="100%" height="2px" />
	</div>

	<div id="guide">
		<div id="guide_left" style="float: left; width: 70%">
			<ul style="width: 100%">
				<li style="width: 20%; margin-left: 5%"><img
					src="img/today/note3.png" alt="" width="42px" /></li>
				<li class="guide_text" style="width: 75%"><p><?=$title_view_all?></p></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	
	<div id="today_list">

	<?
		$error = "TODAY_03";
		$main_sql = "select A.*, B.hero_nick, C.hero_img_new from (select * from mail where hero_user like '%". $_SESSION ['temp_id']."%' or hero_user='all' limit ".$start.",".$list_page.") as A left outer join member as B on A.hero_code=B.hero_code inner join level as C on B.hero_level = C.hero_level order by A.hero_today desc" ;
		$out_main = new_sql($main_sql,$error );
		if((string)$out_main==$error){
			error_historyBack("");
			exit;  
		}
		$i = 1;
		while ( $main_list = @mysql_fetch_assoc ( $out_main ) ) {

			$title = $main_list ['hero_title'];
			$title = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $title ) ) ) );
			$title = str_replace ( "\r", "", $title );
			$title = str_replace ( "\n", "", $title );
			$title_01 = str_replace ( "&#65279;", "", $title );
			if ($title_01=='') 		$title_01 = "&nbsp;";
		
			if ($main_list ['hero_user_check']=='' or !strstr($main_list ['hero_user_check'], $_SESSION['temp_id'])) {
									$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png' alt='new' />&nbsp;";
			} else 					$new_img_view = "";
			
	
	?>
				
				<div class="tabbtn" onClick="openLayer1('<?=$page_per_list?>','./img/today/list_arrow1','<?=$i?>','_1');">
					<div class="title_left">
						<ul>
							<li class="tabbtn_top"><img src="<?=str($main_list['hero_img_new'])?>"/><?=$main_list['hero_nick']?></li>
							<li class="tabbtn_title"><?=$new_img_view?><?=$title_01?></li>
							<li class="tabbtn_date">작성일 <?=date( "Y.m.d", strtotime($board_rs['hero_today']));?></li>
						</ul>
					</div>
		
					<div class="title_right" style="float: right; margin-right: 3%;">
						<img id="img<?=$i?>" src="img/today/list_arrow1.png" alt=""	width="24" />
					</div>
				</div>
				<div class='tabcon tabcon_<?=$board_rs["hero_idx"]?> tabcon_hide'></div>
				
		
				<div id="tab<?=$i?>" class="tabcon" style="background: #fff;">
		
					<div>
						<img src="img/shadow1.jpg" alt="" width="100%" height="2px" />
					</div>
						<?
							$next_command = htmlspecialchars_decode ( $main_list ['hero_command'] );
							$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
							$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
							$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
							/* $next_command = preg_replace ( "/ width=(\"|\')?\d+(\"|\')?/", " width='100%'", $next_command ); */
							$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
							$next_command = preg_replace ( "/width: \d+px/", "", $next_command );  
							$temp_hero_04 = href ( nl2br ( $board_list ['hero_04'] ) );
							
							$temp_hero_04 = str_ireplace ( '<A', '<A target="_blank"', $temp_hero_04 );
							
						?>
						<div style="padding-top: 15px; padding-left: 5%; padding-right: 5%; line-height: 18px"><?=$next_command;?></div>
					
						<!--id="list_content"-->
						<div class="list_btn" style="width: 90%; margin: auto; margin-top: 20px; margin-bottom: 20px">
							<div class="clear"></div>
						</div>
		
		    			<div style="border-bottom: 1px solid #c8c8c8">
							<img src="img/shadow1.jpg" alt="" width="100%" height="2px" />
						</div>
						<div class="clear"></div>
				</div>
		<?
			$i++;
		}
		?>

	</div>

	<?
		if (strcmp ( $_REQUEST ['hero_i_count'], "" )) {
	?>
		<script>
			penLayer1('<?=$main_count+5?>','./img/today/list_arrow1','<?=$_REQUEST[hero_i_count]?>','_1');
		</script>
	<?
		}
	?>
     <div id="page_number">
		<?include_once "page.php"?>
		<?
			$sql = 'select * from hero_group where hero_board = \'' . $_GET ['board'] . '\'';
			sql ( $sql, 'on' );
			$check_list = @mysql_fetch_assoc ( $out_sql );
			if ($check_list ['hero_write'] <= $_SESSION ['temp_write']) {
		?>
        		<span class="gallery_btn"> 
          			<a href="<?=DOMAIN_END?>/m/write.php?board=<?=$_REQUEST['board']?>&action=write">
						<img src="img/general/write_btn.jpg" alt="글쓰기" 	width="70px">
					</a>
				</span> 
		<?
			}
		?>
      </div>


	<!--컨텐츠 종료-->
<?include_once "tail.php";?>