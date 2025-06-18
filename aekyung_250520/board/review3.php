<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
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
######################################################################################################################################################
//$cut_title_name = '26';
//$_GET['board'];
$sql = 'select * from review where hero_old_idx=\''.$_GET['hero_idx'].'\' order by hero_depth_idx_old asc,hero_depth asc,hero_today asc;';//hero_depth_idx_old desc,hero_depth asc
sql($sql, 'on');
$review_data = @mysql_num_rows($out_sql);
?>
            <div class="comment_cnt">
                <strong class="c_orange">댓글 <?=$review_data?>개</strong>
            </div>
            <div id="abcd"></div>
            <div class="commentbox">
<?
$check_review_sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';
$out_check_review_sql = mysql_query($check_review_sql);
$check_review_list                             = @mysql_fetch_assoc($out_check_review_sql);
$check_review_list['hero_rev'];
?>

                    <input type="hidden" id="action" name="action" value="review_write">
                    <input type="hidden" id="temp_save_id" name="temp_save_id" value="<?=$board_list['hero_idx']?>">
                    <input type="hidden" id="temp_save_id_old" name="temp_save_id_old" value="">
                    <textarea id="hero_command" name="hero_command" cols="30" rows="5" class="ment_txt" title="덧글내용"></textarea>
<?if( ($my_rev>='9999') or ($check_review_list['hero_rev']<=$my_rev) ){?>
                    <input type="image" src="../image/bbs/btn_comment.gif" onclick="javascript:hero_review_end('zip_new.php?board_idx=<?=$_REQUEST['hero_idx']?>', 'abcd', 'hero_command', 'review', 'action', 'temp_save_id', 'temp_save_id_old');alert('완료 되었습니다.');location.reload();return false;" class="btn_ment" title="덧글달기"><!--alert('완료 되었습니다.');location.reload();-->
<?
}
$review_i = $review_data-1;
$p_i="0";
while($review_row                             = @mysql_fetch_assoc($out_sql)){
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
                <dl class="
<?
    if(strcmp($review_row['hero_depth'], '0')){echo "rpment ";};if( (!strcmp($review_row['hero_depth'], '1')) and (!strcmp($temp_check_count, '1')) ){echo ' last ';};?>clearfix<?if( (!strcmp($review_row['hero_depth'], '0')) and (strcmp($check_count, '1')) ){echo " rp ";};echo $last_class;?>">
                    <dt>
                    <img src="<?=str($pk_row['hero_img_new'])?>" /><?=$pk_row['hero_nick']//.$review_row['hero_idx']//.'<br>'.$review_row['hero_depth'].'-'.$review_row['hero_depth_idx'].'-'.$review_row['hero_depth_idx_old'].'<br>'.$review_row['hero_old_idx']?>
                    </dt>
                    <dd >
                        <ul>
<?
    if(strcmp($review_row['hero_use'], '1')){
?>
                            <li class="gray"><?=date( "Y-m-d", strtotime($review_row['hero_today']))?>
                                <span class="btngrp">
<?
    if(!strcmp($review_row['hero_depth'], '0')){
    if(strcmp($_SESSION['temp_level'],'0')){
?>
                                <a href="#" onclick="javascript:check_review_all(<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>);"><img src="../image/bbs/btn_mentreply.png" alt="답글달기"/></a>
<?
    }}
if( ($my_rev>='9999') or (!strcmp($review_row['hero_code'], $_SESSION['temp_code'])) ){
?>
                                <a href="#" onclick="javascript:check_review_edit(<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>);"><img src="../image/bbs/btn_mentmod.png" alt="수정"/></a>
                                <a href="#" onclick="javascript:hero_ajax('zip_new.php?hero_idx=<?=$review_row['hero_idx']?>&depth_idx_old=<?=$review_row['hero_depth_idx_old']?>', 'abcd', 'hero_command', 'review_drop');document.getElementById('action').value='review_drop';alert('삭제 되었습니다.');location.reload();return false;" class="ment_del"><img src="../image/bbs/btn_mentdel.png" alt="삭제"/></a><!--alert('삭제 되었습니다.');location.reload(); -->
<?}?>
                                </span>
                            </li>
                            <li style="word-wrap: break-word;word-break:break-all;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;line-height: normal;"><?=htmlspecialchars($review_row['hero_command'])?></li>
<?}else{?>
삭제된 글 입니다.
<?}?>
                        </ul>
                    </dd>
                </dl>
                <div  class="view_test_<?=$review_row['hero_idx']?>" id="view_test_<?=$p_i?>" style="display:none;height:60px" >
                    <div><textarea id="hero_command_<?=$review_row['hero_idx']?>" name="hero_command" cols="30" rows="5" class="ment_txt" title="덧글내용"></textarea><input type="image" src="../image/bbs/btn_comment.gif" onclick="javascript:hero_review_end('zip_new.php?board_idx=<?=$_REQUEST['hero_idx']?>', 'abcd', 'hero_command_<?=$review_row['hero_idx']?>', 'review', 'action', 'temp_save_id', 'temp_save_id_old');alert('완료 되었습니다.');location.reload();return false;" class="btn_ment" title="덧글달기"><!--alert('완료 되었습니다.');location.reload();--></div>
                </div>
<?
$temp_check_count_i++;
$review_i--;
$p_i++;
}
?>
            </div>
<script>
function check_review_all(save_id,save_id_old){
    hero_ajax4('zip_new.php', 'hero_command', 'hero_command', 'review_depth');
    document.getElementById('action').value='review_depth';
    document.getElementById('temp_save_id').value=save_id;
    document.getElementById('temp_save_id_old').value=save_id_old;
    var ddd = 'view_test_'+ save_id;
    $('[id^="view_test_"]').each(function(idx) {
        $('#view_test_' + idx).hide('fast');
    });
    $('.'+ddd).toggle();
    return false;
}
function check_review_edit(save_id,save_id_old){
hero_ajax4('zip_new.php?hero_idx='+save_id, 'hero_command_'+save_id, 'hero_command_'+save_id, 'review_edit_action');
document.getElementById('action').value='review_edit';
document.getElementById('temp_save_id').value=save_id;
document.getElementById('temp_save_id_old').value=save_id_old;
var ddd = 'view_test_'+ save_id;
$('[id^="view_test_"]').each(function(idx) {
    $('#view_test_' + idx).hide('fast');
});
$('.'+ddd).toggle();
return false;
}
</script>