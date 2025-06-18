<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
?>
      <div class="btngroup">
        <div class="btn_l">
<?
if(!strcmp($_GET['view'], '')){
    if($check_list['hero_write']<=$_SESSION['temp_write']){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&view=write&action=write&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
<?
    }
}
if(strcmp($_GET['view'], '')){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
<?
}
?>
        </div>
        <div class="paging">
<?
if(!strcmp($_GET['view'], '')){
            include_once BOARD_INC_END.'page.php';
}
?>
        </div>
        <div class="btn_r">
<?
if( (!strcmp($_GET['view'], 'view')) or (!strcmp($_GET['view'], 'view_new'))  or (!strcmp($_GET['view'], 'step_06')) ){
    if( ($_SESSION['temp_level']>='9999') or (!strcmp($board_list['hero_code'], $_SESSION['temp_code'])) ){
?>
<!--            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&next_board=<?=$board_list['hero_table']?>&view=write&action=update&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>-->
            <a href="<?=MAIN_HOME."?".get('view||action','view=step_04&action=update');?>"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
<?
        $sql = 'select * from review where hero_table = \''.$board_list['hero_table'].'\' and hero_old_idx=\''.$_GET['hero_idx'].'\' order by hero_today desc;';
        sql($sql, 'on');
        $review_data = @mysql_num_rows($out_sql);
//        if( ($_SESSION['temp_level']>='99') or (!strcmp($review_data, '0')) ){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&next_board=<?=$board_list['hero_table']?>&view=action_delete&action=delete&idx=<?=$_GET['hero_idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
<?
//        }
    }
}
?>
<?
if(!strcmp($_GET['action'], 'write')){
    if($check_list['hero_write']<=$_SESSION['temp_write']){//btn_write.gif
?>

            <a href="#" onclick="javascript:on_submit();"><img src="../image/bbs/btn_confrim2.gif" alt="등록" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
<?
    }
}
?>
<?
if(!strcmp($_GET['action'], 'update')){
    if( ($my_level>='9999') or (!strcmp($board_list['hero_code'], $_SESSION['temp_code'])) ){
?>

            <a href="#" onclick="javascript:on_submit();"><img src="../image/bbs/btn_confrim2.gif" alt="등록" /></a>
            <a href="<?=MAIN_HOME.'?'.get('next_board||action||view','view=view');?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
<?
    }
}
?>
        </div>
      </div>
