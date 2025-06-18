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
	    $_SESSION['temp_view'] = '0';
	    $_SESSION['temp_update'] = '0';
	    $_SESSION['temp_rev'] = '0';
	}
######################################################################################################################################################
	$board_sql = 'select * from board where hero_idx = \''.$_REQUEST['hero_idx'].'\';';
	sql($board_sql, 'on');
	$board_list                            = @mysql_fetch_assoc($out_sql);
	if(!strcmp($board_list['hero_table'],'hero')){
	    $group_table_name = $board_list['hero_03'];
	    $group_table_temp_name = "hero_03";
	}else{
	    $group_table_name = $board_list['hero_table'];
	    $group_table_temp_name = "hero_table";
	}

	$group_sql = 'select * from hero_group where hero_board =\''.$group_table_name.'\';';//desc
	$out_group_sql = @mysql_query($group_sql);
	$group_list                             = @mysql_fetch_assoc($out_group_sql);

	if($group_list['hero_view'] <= $_SESSION['temp_view']){//권한

$group_view_point = $group_list['hero_view_point'];//리뷰 획득포인트
$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$board_list['hero_code'].'\'';
$out_pk_sql = mysql_query($pk_sql);
$pk_row                             = @mysql_fetch_assoc($out_pk_sql);

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
        $sql_one_write = 'hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
        $sql_two_write = '\''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \'view\', \''.$_REQUEST['hero_idx'].'\', \''.$_SESSION['temp_id'].'\', \''.$group_list['hero_title'].'\', \''.$board_list['hero_title'].'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$group_view_point.'\', \''.Ymdhis.'\'';
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
if(strcmp($board_list['hero_table'],'hero')){
    $sql = 'select * from board where hero_table = \''.$group_table_name.'\' and hero_idx > \''.$_GET['hero_idx'].'\' order by hero_idx asc limit 0,1;';
    $out_sql = @mysql_query($sql);
    $Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Prev['hero_idx'];

    $sql = 'select * from board where hero_table = \''.$group_table_name.'\' and hero_idx < \''.$_GET['hero_idx'].'\' order by hero_idx desc limit 0,1;';
    $out_sql = @mysql_query($sql);
    $Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Next['hero_idx'];
}else{
}
$recommand_sql = 'select * from hero_recommand where hero_recommand_code = \''.$_SESSION['temp_code'].'\' and hero_board_idx = \''.$_GET['hero_idx'].'\';';
$out_recommand_sql = @mysql_query($recommand_sql);
$recommand_count = @mysql_num_rows($out_recommand_sql);

if(!strcmp($_GET['type'], 'recommand')){
    if(!strcmp($recommand_count, '0')){
        $member_sql = 'select * from member where hero_code = \''.$board_list['hero_code'].'\';';
        $out_member_sql = @mysql_query($member_sql);
        $member_list = @mysql_fetch_assoc($out_member_sql);//mysql_fetch_row
        if(strcmp($_SESSION['temp_code'], '')){
            $hero_url_value = str_ireplace('&type=recommand', '', DOMAIN.URI);
            $sql_one_write = 'hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_recommand_code, hero_recommand_id, hero_recommand_nick, hero_recommand_name, hero_today';
            $sql_two_write = '\''.$hero_url_value.'\', \''.$_REQUEST['board'].'\', \''.$_REQUEST['hero_idx'].'\', \''.$member_list['hero_code'].'\', \''.$member_list['hero_id'].'\', \''.$member_list['hero_nick'].'\', \''.$member_list['hero_name'].'\', \''.$_SESSION['temp_code'].'\', \''.$_SESSION['temp_id'].'\', \''.$_SESSION['temp_nick'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\'';
            $hero_recommand_sql = 'INSERT INTO hero_recommand ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
            @mysql_query($hero_recommand_sql);
            $temp_rec = $board_list['hero_rec']+1;
            $up_member_sql = 'UPDATE board SET hero_rec=\''.$temp_rec.'\' WHERE hero_idx = \''.$_REQUEST['hero_idx'].'\';';
            $out_member_sql = @mysql_query($up_member_sql);
        }
    }
    $msg = '추천 하였습니다.';
    $get_herf = get('type','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($board_list['hero_today'])))){
    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png'  width='14' alt='new' /> ";
}else{
    $new_img_view = "";
}
$sns_title = $board_list['hero_title'];
$link = DOMAIN.URI_PATH.'?'.get();
$sns_image= DOMAIN_END.'image/logo2.gif';

if(!strcmp($_GET['action'], 'delete')){
    $review_sql = 'select * from review WHERE hero_old_idx = \''.$_REQUEST['hero_idx'].'\';';
    $out_review = @mysql_query($review_sql);
    while($review_list                             = @mysql_fetch_assoc($out_review)){
        $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$review_list['hero_idx'].'\';';
        @mysql_query($point_sql);
        $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$review_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
    $review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_REQUEST['hero_idx'].'\';';
    @mysql_query($review_drop_sql);
    $board_select_sql = 'select * from board WHERE hero_idx=\''.$_REQUEST['hero_idx'].'\';';
    $out_board_select = @mysql_query($board_select_sql);
    $board_select_list                             = @mysql_fetch_assoc($out_board_select);
    @unlink(USER_FILE_INC_END.$board_select_list['hero_board_one']);

    $drop_action_img = $board_select_list['hero_command'];
    $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
    preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
    while(list($code_key, $code_val) = @each($code_main[1])){
        if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
            $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
            @unlink($check_file);
        }else{
            continue;
        }
    }
    $drop_point_sql = 'select * from point WHERE hero_old_idx = \''.$_REQUEST['hero_idx'].'\';';
    $out_drop_point = @mysql_query($drop_point_sql);
    while($drop_point_list                             = @mysql_fetch_assoc($out_drop_point)){
        $point_sql = 'DELETE FROM point WHERE hero_idx = \''.$drop_point_list['hero_idx'].'\';';
        @mysql_query($point_sql);
        $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$drop_point_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$drop_point_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }

    $recommand_drop_sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$_REQUEST['hero_idx'].'\';';
    @mysql_query($recommand_drop_sql);

    $board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_REQUEST['hero_idx'].'\';';
    @mysql_query($board_drop_sql);
    $msg = '삭제 되었습니다.';
    $get_herf = get('next_board||view||action||idx||page','','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
?>

<script language=javascript>

	function open0(link){
	    var link1 = encodeURIComponent(link);
	    window.open('http://www.facebook.com/sharer/sharer.php?u='+link1,'','width=520 height=400 scrollbars=yes');
	}
	function open1(sub, link){
	    var sub1 = encodeURIComponent(sub);
	    var link1 = encodeURIComponent(link);
	    window.open('http://twitter.com/home?status='+sub1+' '+link1,'','width=520 height=200 scrollbars=yes');
	}
	function open2(sub, link){
	    var sub1 = encodeURIComponent(sub);
	    var link1 = encodeURIComponent(link);
	    window.open('http://plugin.me2day.net/v1/me2post/create_post_form.nhn?body='+sub1+' '+link1,'','width=520 height=400 scrollbars=yes');
	}

</script>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>

<link href="css/review_viewer.css" rel="stylesheet" type="text/css">

<!--컨텐츠 시작-->
<!--<div id="title"><p><?=$group_list['hero_title'];?></p></div>-->
<? include_once "boardIntroduce.php"; ?>
     

<div id="list_title">
    <div id="title_left" style="float:left; width:67%; margin-left:3%;">
        <ul style="width:100%">
        <li class="new_btn" style="width:100%; margin-bottom:5px"><?=$new_img_view?><?=cut($board_list['hero_title'],48);?></li>
        <li class="date" style="width:100%">작성일: <?=date( "Y.m.d", strtotime($board_list['hero_today']));?></li>
        <li class="nickname" style="width:100%"><img src="<?=str($pk_row['hero_img_new'])?>" height="13px"/><?=$pk_row['hero_nick'];?></li>
        </ul>
    </div>   
    
    <div id="title_right" style="float:right; margin-right:3%;">
        <a href="javascript:open0('<?=$link?>');"><img src="img/review/facebook_icon.jpg" alt="페이스북" width="23px"></a>
        <a href="javascript:open1('<?=$sns_title?>','<?=$link?>');"><img src="img/review/tweeter_icon.jpg" alt="트위터" width="23px"></a>
        <a href="javascript:open2('<?=$sns_title?>','<?=$link?>');"><img src="img/review/me2_icon.jpg" width="23px" alt="미투데이"></a>
        <iframe name="face" src="https://developers.facebook.com/tools/debug/og/object?q=<?=$link?>" width="0" height="0"></iframe>
    </div>
</div>
<?
//$temp_command = str_ireplace("&lt;P&gt;&amp;nbsp;&lt;/P&gt;\r\n&lt;P&gt;&amp;nbsp;&lt;/P&gt;\r\n&lt;P&gt;&amp;nbsp;&lt;/P&gt;\r\n&lt;P&gt;&amp;nbsp;&lt;/P&gt;\r\n", '', $board_list['hero_command']);
//$temp_command = str_ireplace("&lt;P style=&quot;TEXT-ALIGN: left&quot; align=left&gt;&amp;nbsp;&lt;/P&gt;\r\n&lt;P style=&quot;TEXT-ALIGN: left&quot; align=left&gt;&amp;nbsp;&lt;/P&gt;\r\n", '', $temp_command);

//$next_command = htmlspecialchars_decode($temp_command);
$next_command = htmlspecialchars_decode($board_list['hero_command']);
$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
$next_command=preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_command);
$next_command=preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_command);
//$next_command=preg_replace("/width: \d+px/","",$next_command);
$next_command = preg_replace("/width: \d+px/","width:100%;",$next_command);
$next_command = preg_replace("/height: \d+px;/","",$next_command);
$next_command = preg_replace("/height: \d+px/","",$next_command);


$temp_hero_04 = href(nl2br($board_list['hero_04']));
$temp_hero_04 = str_ireplace('<A', '<A target="_blank"', $temp_hero_04);
?>
<div style="padding-top:5px;padding-left:5%;padding-right:5%;line-height:normal;"><?=$next_command;?></div><!--id="list_content"-->

<?
if(strcmp($Prev['hero_idx'], '')){
?>
<div id="list_previous" style="width:90%; margin:auto">
        <a href="<?=PATH_END;?>board_view_00.php?<?=get("hero_idx","hero_idx=".$Prev['hero_idx'])?>">
        <ul style="width:100%">
        <li style="width:19%; padding-left:2%">이전글&nbsp;&nbsp;<img src="img/review/arrow1.png" alt=""/></li>
        <li style="width:79%"><?=cut($Prev['hero_title'],26);?></li>
        </ul>
        </a>
</div>
<?
}
if(strcmp($Next['hero_idx'], '')){
?>
<div id="list_next" style="width:90%; margin:auto">
        <a href="<?=PATH_END;?>board_view_00.php?<?=get("hero_idx","hero_idx=".$Next['hero_idx'])?>">
        <ul style="width:100%">
        <li style="width:19%; padding-left:2%">다음글&nbsp;&nbsp;<img src="img/review/arrow2.png" alt=""/></li>
        <li style="width:79%"><?=cut($Next['hero_title'],26);?></li>
        </ul>
        </a>
</div>
<?
}
?>
<div class="clear"></div> 
     
     
<div id="list_btn" style="width:90%; margin:auto; margin-top:20px; margin-bottom:20px">
        <ul style="width:100%">
        <li style="width:40%; float:left">
            <a href="<?=DOMAIN_END."m/board_00.php?".get("hero_idx")?>"><img src="img/review/list_btn.jpg" alt="목록" width="70px"/></a></li>
        <li style="width:60%; float:right; text-align:right">
<?if( ($_SESSION['temp_level']>='9999') or (!strcmp($board_list['hero_code'],$_SESSION['temp_code'])) ){?>
            <a href="/m/write.php?board=<?=$_REQUEST['board']?>&action=write&idx=<?=$_REQUEST['hero_idx']?>"><img src="img/review/modify_btn.jpg" alt="수정" width="70px"/></a>&nbsp;
            <a href="<?=DOMAIN_END."m/board_view_00.php?".get("action","action=delete")?>"><img src="img/review/delete_btn.jpg" alt="삭제" width="70px"/></a></li>
<?}?>
  </ul>
        <div class="clear"></div>
</div>
<?
//////////////////////////////////////////////////////////////////////
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

$sql = 'select * from review where hero_old_idx=\''.$_REQUEST['hero_idx'].'\' order by hero_depth_idx_old asc,hero_depth asc,hero_today asc;';//hero_depth_idx_old desc,hero_depth asc
//echo $sql;
sql($sql, 'on');
$review_data = @mysql_num_rows($out_sql);
?>
<div id="reply" style="width:90%; margin:auto; margin-bottom:10px">
        <ul style="width:100%">
<?
$check_review_sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';
$out_check_review_sql = mysql_query($check_review_sql);
$check_review_list                             = @mysql_fetch_assoc($out_check_review_sql);
$check_review_list['hero_rev'];
?>
        <input type="hidden" id="action" name="action" value="review_write">
        <input type="hidden" id="temp_save_id" name="temp_save_id" value="<?=$board_list['hero_idx']?>">
        <input type="hidden" id="temp_save_id_old" name="temp_save_id_old" value="">

       
        
        
<?if( ($my_rev>='9999') or ($check_review_list['hero_rev']<=$my_rev) ){
if( (strcmp($_SESSION['temp_level'],'0')) and (strcmp($_SESSION['temp_level'],'')) ){
?>
        <li style="width:75%; float:left"><textarea id="hero_command" name="hero_command" cols="" rows="" class="reply_box"></textarea></li>
        <li style="float:left;width: 12%;margin: 14px 0 0 4%;">
        	<input type="button" value="댓글 입력" class="btn-warning" style="padding: 13%;"
        		onClick="hero_review_end_m('zip_new.php?board_idx=<?=$_REQUEST['hero_idx']?>', 'abcd', 'hero_command', 'review', 'action', 'temp_save_id', 'temp_save_id_old');" alt="댓글입력">
        </li>
<?
}
}
?>
        </ul>
        <div class="clear"></div> 
</div>

<script>
	$(document).ready(function(){


		$('.click_reply').click(function(){

			cancle_reply();

				
				var reply_view ='';
				var mode = $(this).prop('alt');
				var reply_area_top = $(this).parent('div').siblings('.reply_area_top');
				var temp_idx = $(this).siblings('#temp_idx').val();
				var temp_id = $(this).siblings('#temp_id').val();
				var temp_id_old = $(this).siblings('#temp_id_old').val();

				reply_view += "<div id='reply_area_02'>";
				reply_view += "		<ul>";
				reply_view += "		<input type='hidden' id='action_02' name='action' value='"+mode+"'>";
				reply_view += "		<input type='hidden' id='temp_save_id_02' name='temp_save_id' value='"+temp_id+"'>";
				reply_view += "		<input type='hidden' id='temp_save_id_old_02' name='temp_save_id_old' value='"+temp_id_old+"'>";
				reply_view += "			<li style='width:70%;'>";
				reply_view += "				<textarea id='hero_command_02' name='hero_command' cols='' rows='' class='reply_box'></textarea>";
				reply_view += "			</li>";
				reply_view += "			<li style='width:30%;'>";
				reply_view += "				<input type='button' value='댓글 입력' class='btn-warning' onclick='save_reply();' alt='댓글 입력'>";
				reply_view += "				<input type='button' value='취소' class='btn-info' onclick='cancle_reply();' alt='취소'>";
				reply_view += "			</li>";
				reply_view += "		</ul>";
				reply_view += "		<div class='clear'></div> ";
				reply_view += "</div>";

				reply_area_top.html(reply_view);

				if(mode=="review_edit"){
					hero_ajax('zip_new.php?hero_idx='+temp_id+'', 'hero_command_02', 'hero_command_02', 'review_edit_action');
				}

				/* hero_ajax('zip_new.php', 'hero_command_02', 'hero_command_02', 'review_depth'); */
				
				/* $(this).parent('.button_area').slideUp(); */
				$('#reply_area_02').slideToggle();
			
		});


		$('.delete_reply').click(function(){

			var temp_id = $(this).siblings('#temp_id').val();
			var temp_id_old = $(this).siblings('#temp_id_old').val();
			hero_ajax_m('zip_new.php?hero_idx='+temp_id+'&depth_idx_old='+temp_id_old+'', 'abcd', 'hero_command', 'review_drop');
			alert('삭제 되었습니다.');
			return false;

		});
		
	});

	function cancle_reply(){
		$('.reply_area_top').html('');
		/* $('.button_area').slideDown(); */
	}

	function save_reply(){

		hero_review_end_m('zip_new.php?board_idx=<?=$_REQUEST['hero_idx']?>', 'abcd', 'hero_command_02', 'review', 'action_02', 'temp_save_id_02', 'temp_save_id_old_02');
		
	}
	
	
</script>

<input type='hidden' id='temp_idx' value='<?=$board_list['hero_idx']?>'>

<?
$review_i = $review_data-1;
while($review_row                             = @mysql_fetch_assoc($out_sql)){
    if(!strcmp($review_i, '0')){
        $last_class = ' last';
    }else{
        $last_class = '';
    }
	$pk_sql  = "select A.hero_level,A.hero_nick,B.hero_img_new ";
	$pk_sql .= "from member as A, level as B ";
	$pk_sql .= "where B.hero_level = A.hero_level and A.hero_code = '".$review_row['hero_code']."'";
	//echo $pk_sql;
	$out_pk_sql = mysql_query($pk_sql);
	$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
	
	if(!strcmp($review_row['hero_depth'],'0')){
	$temp_check_count_i = 0;
	$check_sql = 'select * from review where hero_depth_idx_old= \''.$review_row['hero_idx'].'\'';
	$out_check_sql = mysql_query($check_sql);
	$check_count = @mysql_num_rows($out_check_sql);
	}
	$temp_check_count = $check_count - $temp_check_count_i;
?>

<div class="reply_view" style="padding: 2% 0%;margin: 2% 4%;width:92%; <?if(!strcmp($review_row['hero_depth'],"1")){echo ' margin-bottom:0px';}?>">
			<?if(strcmp($review_row['hero_use'], '1')){?>
			        <div class="nickname" style="float:left;width:24%;" >
			        	<?if($review_row['hero_depth']>=1){?>
			        		<span class="reply_arrow">
			        			<img src="img/review/reply_arrow.png" alt="" style="width:10px;"/>
			        		</span>
			        	<?}?>
			        	<img src="<?=str($pk_row['hero_img_new'])?>"  height="13px"/>
			        	<?=$pk_row['hero_nick']?>
			        	
			        </div>
				        <div style="width:75%; text-align:left;float:right;word-break: break-all;padding-left:2%;padding-right:2%;word-wrap: break-word;word-break:break-all;/* white-space: pre-wrap; white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;*/line-height: normal;"><?=htmlspecialchars($review_row['hero_command'])?><span style="color: #AAAAAA;float:right;"><?=date( "m-d", strtotime($review_row['hero_today']));?></span></div>
				        <div class="button_area" style="float:right;padding-top:2%;width: 100%;text-align:right;">
				        		<?if( (strcmp($_SESSION['temp_level'],'0')) and (strcmp($_SESSION['temp_level'],'')) ){?>
				        				
				        				<input type='hidden' id='temp_id' value='<?=$review_row['hero_idx']?>'>
										<input type='hidden' id='temp_id_old' value='<?=$review_row['hero_depth_idx_old']?>'>
				        				
				        				<input type='button' value="댓글" class="btn-warning click_reply" style="padding: 1% 3%;" alt="review_depth"/>
				        		<?}
								if( ($my_rev>='9999') or (!strcmp($review_row['hero_code'], $_SESSION['temp_code'])) ){?>
				        
				        			
				        				<input type='button' value="수정" class="btn-info click_reply" style="padding: 1% 3%;" alt="review_edit"/>
				        				
				        				<input type='button' value="삭제" class="btn-danger delete_reply" style='padding: 1% 3%;'/>
				        		
				        	<?}?>
				        	
				        </div>
			<?}else{?>
			<div class="nickname" style="width:100%;text-align:center">삭제된 글 입니다.</div>
			<?}?>
			
        	<div class="reply_area_top">
        		
        	</div>
        	<div id="abcd"></div>
        <div class="clear"></div> 
</div>
<?
	$temp_check_count_i++;
	$review_i--;
}?>

  <div class="clear"></div>   
<!--컨텐츠 종료-->
<?
include_once "tail.php";
}else{
    $msg = '권한이';
    $action_href = PATH_END.'board_00.php?'.get('hero_idx','download=ok');
    msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>