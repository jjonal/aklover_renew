<?php
include_once "head.php";
#####################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
if(strcmp($_REQUEST['kewyword'], '')){
    $sql_select = 'hero_title';
    $search = ' and new_board.'.$sql_select.' like \'%'.$_REQUEST['kewyword'].'%\'';
    $search_next = '&select='.$sql_select.'&kewyword='.$_REQUEST['kewyword'];
}
#####################################################################################################################################################
$power_sql = 'select * from hero_group where hero_menu=\'0\' and hero_type!=\'html\' and hero_type!=\'guide_4\' and hero_use=\'1\';';
sql($power_sql,'on');
$power_count = @mysql_num_rows($out_sql);
$i='1';
while($power_list                             = @mysql_fetch_assoc($out_sql)){
    if(!strcmp($power_count,$i)){
        $comma = '';
    }else{
        $comma = ', ';
    }
    if(!strcmp($_SESSION['temp_level'], '')){
        $my_level = '0';
    }else{
        $my_level = $_SESSION['temp_level'];
    }
//echo     $power_list['hero_title']. '========';
//echo     $power_list['hero_search'].'========';

    if($my_level>=$power_list['hero_search']){
//echo     '<font color=orange>'.$my_level.'</font>';
//        echo '승인';
        $power_search .= '\''.$power_list['hero_board'].'\''.$comma;
    }
    $i++;
//    echo '<br>';
}
$new_power_search = substr(trim($power_search), '-1');
if(!strcmp($new_power_search, ',')){
    $orange = substr(trim($power_search), '0', '-1');
}else{
    $orange = $power_search;
}
$power_search = 'new_board.hero_table in('.$orange.')';
######################################################################################################################################################
//$sql = 'select * from board where '.$power_search.$search.' and hero_use=\'1\';';
$sql = '
select new_board.* from(
    select hero_idx, hero_code, hero_table, hero_name, hero_nick, hero_today, hero_title, hero_use from board union all
    select hero_idx, hero_code, hero_table, hero_name, hero_nick, hero_today, hero_title, hero_use from mission
) as new_board where
'.$power_search.$search.' and new_board.hero_use=\'1\';';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=5;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page||select||kewyword",$search_next);
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
?>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link href="css/today.css" rel="stylesheet" type="text/css">

<!--컨텐츠 시작-->
<div id="title"><p>검색</p></div>
     
<div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>
<div id="today_list">

<!--펼침메뉴 리스트 시작-->
<?

//$sql = 'select * from board where '.$power_search.$search.' and hero_use=\'1\' order by hero_table asc, hero_today desc limit '.$start.','.$list_page.';';
$sql = '
select new_board.* from(
    select hero_idx, hero_code, hero_table,hero_command, hero_name, hero_nick, hero_today, hero_title, hero_review_count, hero_use from board union all
    select hero_idx, hero_code, hero_table,hero_command, hero_name, hero_nick, hero_today, hero_title, hero_review_count, hero_use from mission
) as new_board where
'.$power_search.$search.' and new_board.hero_use=\'1\' order by new_board.hero_table asc, new_board.hero_today desc limit '.$start.','.$list_page.';';
sql($sql);
$i=1;
while($list                             = @mysql_fetch_assoc($out_sql)){
    $info_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';
    $out_info_sql = mysql_query($info_sql);
    $info_list                             = @mysql_fetch_assoc($out_info_sql);
    $link_sql ='select * from (select *, (@rownum:=@rownum+1) as rownum from board , (select @rownum:=0) tmp where board.hero_table=\''.$list['hero_table'].'\' and board.hero_use=\'1\' order by hero_today desc) A where hero_idx=\''.$list['hero_idx'].'\'';
    $out_link_sql = mysql_query($link_sql);
    $link_list                             = @mysql_fetch_assoc($out_link_sql);
    $new_page_total = $link_list['rownum'];
    $new_page = ceil($new_page_total/8);

    $pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$list['hero_code'].'\'';
    $out_pk_sql = mysql_query($pk_sql);
    $pk_row                             = @mysql_fetch_assoc($out_pk_sql);
?>
<div id="today_list1" class="tabbtn" onClick="openLayer1('5','./img/today/list_arrow1','<?=$i?>','_1');">
       <div class="title_left" style="float:left; width:85%; margin-left:3%;">
          <ul style="width:100%">
          <li style="width:100%; margin-bottom:2px"><img src="<?=str($pk_row['hero_img_new'])?>" height="13px" />&nbsp;<?=$pk_row['hero_nick'];?></li>
          <li class="new_btn" style="width:100%; margin-bottom:1px"><font color="orange">[<?=$info_list['hero_title']?>]</font> <?=cut($list['hero_title'], $cut_title_name);?></li>       
          <li class="date" style="width:100%">작성일 <?=date( "y.m.d", strtotime($list['hero_today']));?></li>
          </ul>
       </div>
      <div class="title_right" style="float:right; margin-right:3%;">
        <img id="img<?=$i?>" src="img/today/list_arrow1.png" alt="" width="24"/>
      </div>
</div>

<div id="tab<?=$i?>" class="tabcon" style="background:#fff;">

    <!--펼침메뉴 내용 시작-->
    <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>
<?
$next_command = htmlspecialchars_decode($list['hero_command']);
$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
$next_command = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_command);
$next_command = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_command);
$next_command = preg_replace("/width: \d+px/","",$next_command);
$temp_hero_04 = href(nl2br($board_list['hero_04']));

$temp_hero_04 = str_ireplace('<A', '<A target="_blank"', $temp_hero_04);
?>
<div style="padding-top:5px;line-height:normal;"><?=$next_command;?></div><!--id="list_content"-->
    <div class="list_btn" style="width:90%; margin:auto; margin-top:20px; margin-bottom:20px">
        <ul style="width:100%">
        <li style="width:40%; float:left">
<!--<a href="review.php"><img src="img/review/list_btn.jpg" alt="목록" width="70px"/></a>-->
        </li>
        <li style="width:60%; float:right; text-align:right">
<?if( ($_SESSION['temp_level']>='9999') or (!strcmp($list['hero_code'],$_SESSION['temp_code'])) ){
if(!strcmp($list['hero_table'],'hero')){
    $new_path = "&next_board=hero";
}else{
    $new_path = "";
}
?>
<?if( ($_SESSION['temp_level']>='9999') or (!strcmp($list['hero_code'],$_SESSION['temp_code'])) ){?>
            <a href="http://www.aklover.co.kr/main/index.php?board=<?=$list['hero_table'].$new_path?>&page=<?=$page?>&idx=<?=$list['hero_idx']?>&view=write&action=update" target="_blank"><img src="img/review/modify_btn.jpg" alt="수정" width="70px"/></a>&nbsp;
            <a href="review.php"><img src="img/review/delete_btn.jpg" alt="삭제" width="70px"/></a></li>

<?}}?>
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

$old_sql = 'select * from review where hero_old_idx=\''.$list['hero_idx'].'\' order by hero_depth_idx_old asc,hero_depth asc,hero_today asc;';//hero_depth_idx_old desc,hero_depth asc
$out_old_sql = mysql_query($old_sql);
$review_data = @mysql_num_rows($out_old_sql);
?>
<div id="reply" style="width:90%; margin:auto">
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
        <li style="float:right"><input type="image" src="img/review/input_btn.jpg" onClick="javascript:hero_review_end('zip_new.php?board_idx=<?=$list['hero_idx']?>', 'abcd', 'hero_command', 'review', 'action', 'temp_save_id', 'temp_save_id_old');alert('완료 되었습니다.');location.reload();return false" alt="댓글입력" width="70px"></li>
<?
    }
}
?>
        </ul>
        <div class="clear"></div> 
</div>
<?
$review_i = $review_data-1;
while($review_row                             = @mysql_fetch_assoc($out_old_sql)){
    if(!strcmp($review_i, '0')){
        $last_class = ' last';
    }else{
        $last_class = '';
    }
$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$review_row['hero_code'].'\'';
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
<div class="reply_view" style="width:90%; margin:auto;<?if(!strcmp($review_row['hero_depth'],"1")){echo ' margin-bottom:0px';}?>">
        <ul style="width:100%">
<?if(strcmp($review_row['hero_use'], '1')){?>
        <li class="nickname" style="width:23%"><?if(!strcmp($review_row['hero_depth'],"1")){?><span class="reply_arrow"><img src="img/review/reply_arrow.png" alt="" height="13px"/></span>&nbsp;<?}?><img src="<?=str($pk_row['hero_img_new'])?>"  height="13px"/><?=$pk_row['hero_nick']?></li>
        <li style="width:43%; padding-left:2%; padding-right:2%;word-wrap: break-word;word-break:break-all;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;line-height: normal;"><?=htmlspecialchars($review_row['hero_command'])?>
        <li style="width:30%; text-align:right"><?if(!strcmp($review_row['hero_depth'], '0')){?>
        <?if( (strcmp($_SESSION['temp_level'],'0')) and (strcmp($_SESSION['temp_level'],'')) ){?>
        <a href="#" onClick="javascript:hero_ajax('zip_new.php', 'hero_command', 'hero_command', 'review_depth');document.getElementById('action').value='review_depth';document.getElementById('temp_save_id').value='<?=$review_row['hero_idx']?>'; document.getElementById('temp_save_id_old').value='<?=$review_row['hero_depth_idx_old']?>';document.getElementById('view_test').style.display='block'; document.getElementById('view_test2').style.display='none'; return false;"><img src="img/review/reply_btn.jpg" alt="댓글" width="30px"/></a>
        <?}}if( ($my_rev>='9999') or (!strcmp($review_row['hero_code'], $_SESSION['temp_code'])) ){?>
        <a href="#" onClick="javascript:hero_ajax('zip_new.php?hero_idx=<?=$review_row['hero_idx']?>', 'hero_command', 'hero_command', 'review_edit_action');document.getElementById('action').value='review_edit';document.getElementById('temp_save_id').value='<?=$review_row['hero_idx']?>';  document.getElementById('temp_save_id_old').value='<?=$review_row['hero_depth_idx_old']?>'; document.getElementById('view_test').style.display='none'; document.getElementById('view_test2').style.display='block'; return false;"><img src="img/review/modify_btn1.jpg" alt="수정" width="30px"/></a>
        <a href="#" onClick="javascript:hero_ajax('zip_new.php?hero_idx=<?=$review_row['hero_idx']?>&depth_idx_old=<?=$review_row['hero_depth_idx_old']?>', 'abcd', 'hero_command', 'review_drop');document.getElementById('action').value='review_drop';alert('삭제 되었습니다.');location.reload();return false;"><img src="img/review/delete_btn1.jpg" alt="삭제" width="30px"/></a><!--alert('삭제 되었습니다.');location.reload(); --><br/><?=date( "Y-m-d", strtotime($review_row['hero_today']));?><?}?></li>
<?}else{?>
<li class="nickname" style="width:100%;text-align:center"><?=$review_row['hero_idx']?>삭제된 글 입니다.</li>
<?}?>
        </ul>
        <div class="clear"></div> 
</div>
<?
$temp_check_count_i++;
$review_i--;
}?>
    <div style="border-bottom:1px solid #c8c8c8"><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>
    
      <div class="clear"></div>  
      <!--펼침메뉴 내용 종료-->
</div>
<?
$i++;
}?>
</div>
     <div id="page_number">
<?include_once "page.php"?>
      </div>

 
<!--컨텐츠 종료-->
<?include_once "tail.php";?>