<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
echo $my_level;
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
?>
      <div class="btngroup">
        <div class="btn_l">
<?
if(!strcmp($_GET['view'], '')){
    if($check_list['hero_write']<=$my_level){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=write&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
<?
    }
}
if(strcmp($_GET['view'], '')){
?>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
<?
}
?>
        </div>
        <div class="paging">
<?
if(!strcmp($_GET['view'], '')){
            include_once BOARD_INC_END.'page.php';
}
echo '<br>';
echo $check_list['hero_write'];

?>
        </div>
        <div class="btn_r">

<?
if(!strcmp($_GET['view'], 'view')){
    if( ($my_level>='99') or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
        $sql = 'select * from review where hero_code = \''.$out_row['hero_code'].'\' and hero_table = \''.$_GET['board'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
        sql($sql, 'on');
        $review_data = @mysql_num_rows($out_sql);
        if( ($my_level>='100') or (!strcmp($review_data, '0')) ){
?>

            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=write&action=update&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action&action=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
<?
        }
    }
}
?>
<?
if(!strcmp($_GET['action'], 'write')){
    if($check_list['hero_write']<=$my_level){
?>

            <a href="javascript:on_submit();"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
<?
    }
}
?>
<?
if(!strcmp($_GET['action'], 'update')){
    if( ($my_level>='99') or (!strcmp($out_row['hero_code'], $_SESSION['temp_code'])) ){
        $sql = 'select * from review where hero_code = \''.$out_row['hero_code'].'\' and hero_table = \''.$_GET['board'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
        sql($sql, 'on');
        $review_data = @mysql_num_rows($out_sql);
        if( ($my_level>='100') or (!strcmp($review_data, '0')) ){
?>

            <a href="javascript:on_submit();"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
<?
        }
    }
}
?>
<!--
            <a href="javascript:on_submit();"><img src="../image/bbs/btn_edit.gif" alt="수정" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=view&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>view=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_confrim.gif" alt="확인" /></a>
            <a href="javascript:on_submit();"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_cancle.gif" alt="취소" /></a>

            <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board'];?>&view=action&action=delete&idx=<?=$_GET['idx'];?>&page=<?=$_GET['page'];?>"><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
-->
        </div>
      </div>
