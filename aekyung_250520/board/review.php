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
$sql = 'select * from review where hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc;';
sql($sql, 'on');
$review_data = @mysql_num_rows($out_sql);
?>
            <div class="comment_cnt">
                <strong class="c_orange">댓글 <?=$review_data?>개</strong>
            </div>
            <div class="commentbox">
<?
$check_review_sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';
$out_check_review_sql = mysql_query($check_review_sql);
$check_review_list                             = @mysql_fetch_assoc($out_check_review_sql);
$check_review_list['hero_rev'];
?>

                    <input type="hidden" id="action" name="action" value="review_write">
                    <textarea id="hero_command" name="hero_command" cols="30" rows="5" class="ment_txt" title="덧글내용"></textarea>
<?if( ($my_rev>='9999') or ($check_review_list['hero_rev']<=$my_rev) ){?>
                    <input type="image" src="../image/bbs/btn_comment.gif" onclick="hero_review('zip.php?hero_idx=<?=$out_row['hero_idx']?>', 'abcd', 'hero_command', 'review', 'action'); javascript:document.getElementById('action').value='review_write';alert('완료 되었습니다.');location.reload(); return false;" class="btn_ment" title="덧글달기">
<?
}
$review_i = $review_data-1;
while($review_row                             = @mysql_fetch_assoc($out_sql)){
    if(!strcmp($review_i, '0')){
        $last_class = ' last';
    }else{
        $last_class = '';
    }
/*
    $pk_m_sql = 'select * from member where hero_code = \''.$review_row['hero_code'].'\'';
    $out_pk_m_sql = mysql_query($pk_m_sql);
    $out_pk_m_row                             = @mysql_fetch_assoc($out_pk_m_sql);
    $pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
    $out_pk_p_sql = mysql_query($pk_p_sql);
    $pk_p_row                             = @mysql_fetch_assoc($out_pk_p_sql);
*/
$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$review_row['hero_code'].'\'';
$out_pk_sql = mysql_query($pk_sql);
$pk_row                             = @mysql_fetch_assoc($out_pk_sql);
?>
                <dl class="clearfix<?=$last_class;?>">
                    <dt><img src="<?=str($pk_row['hero_img_new'])?>" /><?=$pk_row['hero_nick']?></dt>
                    <dd >
                        <ul>
                            <li class="gray"><?=date( "Y-m-d", strtotime($review_row['hero_today']));?>
<?
if( ($my_rev>='9999') or (!strcmp($review_row['hero_code'], $_SESSION['temp_code'])) ){
?>
                                <a href="#" onclick="hero_ajax('zip.php?hero_idx=<?=$review_row['hero_idx']?>', 'hero_command', 'hero_command', 'review_edit');javascript:document.getElementById('action').value='<?=$review_row['hero_idx']?>'; return false;" class="ment_edit" id="글번호">수정</a>
                                <a href="#" onclick="hero_ajax('zip.php?hero_idx=<?=$review_row['hero_idx']?>&old_idx=<?=$out_row['hero_idx']?>', 'abcd', 'hero_command', 'review_drop'); javascript:alert('삭제 되었습니다.');location.reload(); return false;" class="ment_del">삭제</a>
<?}?>
                            </li>
                            <li id='dd'><?=nl2br($review_row['hero_command'])?></li>
                        </ul>
                    </dd>
                </dl>
<?
$review_i--;
}
?>
            </div>
            <div id="abcd"></div>
