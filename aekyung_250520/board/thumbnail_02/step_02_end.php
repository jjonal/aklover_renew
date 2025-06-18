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
$sql = 'select * from mission where hero_notice=\'0\' and hero_table = \''.$_GET['board'].'\' and hero_idx > \''.$_GET['idx'].'\' order by hero_idx asc limit 0,1;';
sql($sql, 'on');
    $Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Prev['hero_idx'];

$sql = 'select * from mission where hero_notice=\'0\' and hero_table = \''.$_GET['board'].'\' and hero_idx < \''.$_GET['idx'].'\' order by hero_idx desc limit 0,1;';
sql($sql, 'on');
    $Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Next['hero_idx'];
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
$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc, hero_idx desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
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
        <div class="contents">
            <div class="spm_step3">
                <div class="box1">
                    <div class="article_img"> <img src="<?=$out_row['hero_img_new']?>" width='126' height='126'/> </div>
                    <ul class="article_txt">
                        <li class="c_orange"><?=$out_row['hero_title']?></li>
                        <li><?=cut(strip_tags(htmlspecialchars_decode($out_row['hero_command'],'15')));?></li>
                        <li class="mt20">
                            <img src="../image/mission/spm_date.gif" alt="" />
                            <?=date( "y년 m월 d일", strtotime($out_row['hero_today_00_01']));?> ~ <?=date( "y년 m월 d일", strtotime($out_row['hero_today_00_02']));?>
                        </li>
                        <li class="mt5">
                            <img src="../image/mission/spm_cnt.gif" alt="" />
                            <span class="c_orange bold"><?=$count_01?></span> 명
                        </li>
                    </ul>
                </div>
                <div class="box2">
                    <div class="d1"><?=date( "m.d", strtotime($out_row['hero_today_01_01']));?>~<?=date( "m.d", strtotime($out_row['hero_today_01_02']));?></div>
                    <div class="d2"><?=date( "m.d", strtotime($out_row['hero_today_02_01']));?>~<?=date( "m.d", strtotime($out_row['hero_today_02_02']));?></div>
                    <div class="d3"><?=date( "m.d", strtotime($out_row['hero_today_03_01']));?>~<?=date( "m.d", strtotime($out_row['hero_today_03_02']));?></div>
                    <div class="d4"><?=date( "m.d", strtotime($out_row['hero_today_04_01']));?>~<?=date( "m.d", strtotime($out_row['hero_today_04_02']));?></div>
                </div>
                <div class="box3">
                    <img src="../image/mission/spm_txt_reviewer.gif" alt="리뷰신청자" class="subtitle" />
                    <ul class="txt">
                        <li>리뷰어로 선정되신 분들께는 이메일과 휴대폰 문자를 통해 안내해 드립니다.</li>
                        <li>캠페인과 리뷰 등록에 대한 문의는 simba86@aekyung.kr으로 해주세요.</li>
                    </ul>
                <div class="spm_wrap">
<?
while($list_01                             = @mysql_fetch_assoc($out_sql_01)){
    $pk_m_sql = 'select * from member where hero_code = \''.$list_01['hero_code'].'\'';
    $out_pk_m_sql = mysql_query($pk_m_sql);
    $out_pk_m_row                             = @mysql_fetch_assoc($out_pk_m_sql);
    $pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
    $out_pk_p_sql = mysql_query($pk_p_sql);
    $pk_p_row                             = @mysql_fetch_assoc($out_pk_p_sql);
?>
                    <dl>
                        <dd>
                            <ul>
                                <li class="c_orange"><img src="<?=str($pk_p_row['hero_img_new'])?>" alt="level1" /> <?=$list_01['hero_nick']?></li>
                                <li class="mt5"><?=$list_01['hero_02']?></li>
                            </ul>
                        </dd>
                    </dl>
<?}?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="spm"> <img src="../image/mission/spm_bg4.gif" alt="top" /> </div>
                <div class="btngroup tr">
                    <a href="<?=PATH_HOME.'?'.get('view||idx')?>"><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
                </div>
            </div>
        </div>
    </div>
<?
}else{
        $msg = '권한';
        $action_href = PATH_HOME.'?'.get('view');
        msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>