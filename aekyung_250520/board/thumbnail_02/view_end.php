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
$cut_title_name = '26';
$_GET['board'];
$sql = 'select * from mission where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
//echo $right_list['hero_view'];
//echo $_SESSION['temp_level'];
//if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
if($right_list['hero_view'] <= $my_view){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_title = $right_list['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];

$view_sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_old_idx=\''.$temp_idx.'\' and hero_type=\''.$_GET['view'].'\' and hero_id = \''.$temp_id.'\' order by hero_today desc limit 0,1;';
$view_out_sql = mysql_query($view_sql);
$view_list                             = @mysql_fetch_assoc($view_out_sql);
$last_day = date( "Ymd", strtotime($view_list['hero_today']));
$to_day = date( "Ymd", time());
//echo $out_row['hero_code'];
//echo $temp_code;
//if(strcmp($to_day, $last_day)){
if( (strcmp($to_day, $last_day)) and (strcmp($out_row['hero_code'], $temp_code)) ){
    $sql_one_write = 'hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today';
    $sql_two_write = '\''.$_SESSION['temp_code'].'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_idx.'\', \''.$temp_id.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
    $up_sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
    sql($up_sql);
}
######################################################################################################################################################
?>
<div class="contents_area">
    <div class="page_title">
        <h2><img src="<?=str($right_list['hero_right']);?>" alt="<?=$right_list['hero_title'];?>" /></h2>
        <ul class="nav">
            <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
            <li>&gt;</li>
            <li><?=$right_list['hero_top_title']?></li>
            <li>&gt;</li>
            <li class="current"><?=$right_list['hero_title']?></li>
        </ul>
    </div>
<?if($right_list['hero_write'] <= $my_write){?>
    <div class="spm_txt">
        <dl>
            <dt style="width:100%;text-align:center"><a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&view=step_write&action=update&idx=<?=$_GET['idx']?>"><span class="bg1">수정</span></a> <a><span class="bg1">삭제</span></a></dt>
        </dl>
        <div class="clearfix"></div>
    </div>
<?}?>
    <div class="spm_txt">
        <dl>
            <dt style="width:100%;text-align:center"><?=$out_row['hero_title']?></dt>
        </dl>
        <div class="clearfix"></div>
    </div>
    <div class="contents">
        <div class="spm_img"><?=htmlspecialchars_decode($out_row['hero_command']);?></div>
        <div class="spm_txt">
            <dl>
                <dt><img src="../image/mission/spm_txt1.gif" alt="참여일정" /></dt>
                <dd>리뷰어 신청 : <?=date( "m월 d일", strtotime($out_row['hero_today_00_01']));?> ~ <?=date( "m월 d일", strtotime($out_row['hero_today_00_02']));?> 까지</dd>
            </dl> 
            <dl> 
                <dt><img src="../image/mission/spm_txt2.gif" alt="참여방법" /></dt>
                <dd>
                    <pre>
<?=$out_row['hero_help']?>
                    </pre>
                </dd>
            </dl> 
            <dl> 
                <dt><img src="../image/mission/spm_txt3.gif" alt="참여방법" /></dt>
                <dd><?=$out_row['hero_tag']?></dd>
            </dl>
            <div class="clearfix"></div>
        </div>
<!--
        <div class="spm_img">
            <img src="../image/main/banner_mainbig.jpg" alt="" width="705" height="100" />
        </div>
w705*높이 제한없슴-->
        <div class="btn_group tc mt60">
<?
$sql = 'select * from mission_review where hero_table = \''.$_GET['board'].'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_old_idx=\''.$_GET['idx'].'\'';
$view_sql = mysql_query($sql);
$data_count = mysql_num_rows($view_sql);
if(!strcmp($data_count, '0')){
?>
            <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>"><img src="../image/mission/btn_mission_join.gif" alt="미션참여하기" /></a>
<?
}else{
?>
            <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>"><img src="../image/mission/btn_mission_join.gif" alt="미션참여하기" /></a>
<?}?>
        </div>

    </div>
</div>
<?
}else{
        $msg = '권한이';
        $action_href = PATH_HOME.'?'.get('view');
        msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>