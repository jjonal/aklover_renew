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
if($right_list['hero_view'] <= $my_view){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_title = $right_list['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];
######################################################################################################################################################
$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' and lot_01=\'1\' order by hero_today desc, hero_idx desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);

$content = $out_row['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = cut(str_replace("\n", "", $content),'50');
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
                    <div class="article_img"> <img src="<?=$out_row['hero_thumb']?>" width='126' height='126'/> </div>
                    <ul class="article_txt">
                        <li class="c_orange"><?=$out_row['hero_title']?></li>
                        <li><?=$content;?></li>
                        <li class="mt20">
                            <img src="../image/mission/spm_date.gif" alt="" />
                            <?=date( "y년 m월 d일", strtotime($out_row['hero_today_01_01']));?> ~ <?=date( "y년 m월 d일", strtotime($out_row['hero_today_04_02']));?>
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