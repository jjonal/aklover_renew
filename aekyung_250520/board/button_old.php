<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

//if(!strcmp($_SESSION['temp_id'],'')){exit;}
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
//echo $check_list['hero_write'];
//echo $_SESSION['temp_level'];
//echo $_SESSION['temp_id'];

?>
      <div class="btngroup">
      	<div class="btn_l">
<?
//if( (!strcmp($_GET['view'], '')) and (strcmp($_SESSION['temp_id'], '')) ){
if(!strcmp($_GET['view'], '')){
//    if($check_list['hero_write'] >= $_SESSION['temp_level']){
    if( ( ($check_list['hero_write'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($check_list['hero_write'], '99')) ){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
<?
    }else{}
?>
<?}else if(strcmp($_SESSION['temp_id'], '')){?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
<?}?>
        </div>
        <div class="paging">
<?
######################################################################################################################################################
if(!strcmp($_GET['view'], '')){
    include_once BOARD_INC_END.'page.php';
}
######################################################################################################################################################
?>
        </div>
        <div class="btn_r">
<?if(!strcmp($_GET['view'], '')){?>

<?}else if( (!strcmp($_GET['action'], 'update')) and (strcmp($_SESSION['temp_id'], '')) ){

//    if( ($check_list['hero_update'] >= $_SESSION['temp_level']) or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
    if( ( ($check_list['hero_update'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($check_list['hero_update'], '99')) or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
?>
            <a href="javascript:on_submit();"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=view&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>

<?
    }else{}
}else if( (!strcmp($_GET['view'], 'delete')) and (strcmp($_SESSION['temp_id'], '')) ){
//    if( ($check_list['hero_update'] >= $_SESSION['temp_level']) or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
    if( ( ($check_list['hero_update'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($check_list['hero_update'], '99')) or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>view=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_confrim.gif" alt="확인" /></a>
<?
    }else{}
}else if( (!strcmp($_GET['view'], 'write')) and (strcmp($_SESSION['temp_id'], '')) ){
//    if($check_list['hero_write'] >= $_SESSION['temp_level']){
    if( ( ($check_list['hero_write'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($check_list['hero_write'], '99')) ){
?>
            <a href="javascript:on_submit();"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
<?
    }else{}
//}else if( (!strcmp($_GET['view'], 'view')) and (strcmp($_SESSION['temp_id'], '')) ){
}else if(!strcmp($_GET['view'], 'view')){
//    if( ($check_list['hero_update'] >= $_SESSION['temp_level']) or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
    if( ( ($check_list['hero_update'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($check_list['hero_update'], '99')) or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=update&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action&action=delete&idx=<?=$_GET['idx'];?>e&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
<?
    }else{}
}
?>
        </div>
      </div>
