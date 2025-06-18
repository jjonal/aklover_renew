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
$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
if(!strcmp($_GET['type'], 'drop')){
    $drop_sql = 'select * from mission_review where hero_idx =\''.$_GET['hero_idx'].'\';';//desc
    $out_drop = @mysql_query($drop_sql);
    $drop_list                             = @mysql_fetch_assoc($out_drop);
    $review_point_sql = 'DELETE FROM point WHERE hero_old_idx = \''.$drop_list['hero_old_idx'].'\' and hero_code = \''.$drop_list['hero_code'].'\';';
    @mysql_query($review_point_sql);

    $drop_mission_sql = 'DELETE FROM mission_review WHERE hero_idx = \''.$_GET['hero_idx'].'\'';
    @mysql_query($drop_mission_sql);

    $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$drop_list['hero_code'].'\';';
    $out_member_total_sql = @mysql_query($member_total_sql);
    $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
    $member_total_point = $member_total_list['member_total'];
    $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$drop_list['hero_code'].'\';'.PHP_EOL;
    @mysql_query($sql);

    $msg = '삭제 되었습니다.';
    $get_herf = get('view||type','view=view','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
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
                    <div class="article_img"> <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$out_row['hero_thumb']?>" width='126' height='126'/> </div>
                    <ul class="article_txt">
                        <li class="c_orange"><?=$out_row['hero_title']?></li>
                        <li><?=cut(str_ireplace('<br />
<br />', '', nl2br(TRIM(strip_tags(str_ireplace('&nbsp;', '', htmlspecialchars_decode($out_row['hero_command'])))))),'50');?></li><?//nl2br?><?//cut(TRIM(strip_tags(str_ireplace('&nbsp;', '', nl2br(htmlspecialchars_decode($out_row['hero_command']))))),'50');?>
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
                    <img src="../image/mission/spm_txt_reviewer.gif" alt="리뷰신청자" class="subtitle" />
                    <ul class="txt">
                        <li>리뷰어로 선정되신 분들께는 이메일과 휴대폰 문자를 통해 안내해 드립니다.</li>
                        <li>캠페인과 리뷰 등록에 대한 문의는 고객센터 1:1문의로 해주세요.</li>
                    </ul>
                <div class="spm_wrap">
<?
$check_day = date( "Y-m-d", time());
$today_01_01 = date( "Y-m-d", strtotime($out_row['hero_today_01_01']));
$today_01_02 = date( "Y-m-d", strtotime($out_row['hero_today_01_02']));

while($list_01                             = @mysql_fetch_assoc($out_sql_01)){
    $pk_m_sql = 'select * from member where hero_code = \''.$list_01['hero_code'].'\'';
    $out_pk_m_sql = mysql_query($pk_m_sql);
    $out_pk_m_row                             = @mysql_fetch_assoc($out_pk_m_sql);
    
    if($out_pk_m_row['hero_code']==$_SESSION['temp_code'] || $_SESSION['temp_level']>=99){
    
    $pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
    $out_pk_p_sql = mysql_query($pk_p_sql);
    $pk_p_row                             = @mysql_fetch_assoc($out_pk_p_sql);

if($check_day>="2013-11-21"){
    $hero_mt5_view = $list_01['hero_03'];
}else{
    $hero_mt5_view = $list_01['hero_02'];
}

$hero_mt5_view = str_replace("/////","&nbsp;&nbsp;&nbsp;",$hero_mt5_view);
?>
                    <dl>
                        <dd>
                            <ul>
                                <li class="c_orange"><img src="<?=str($pk_p_row['hero_img_new'])?>" alt="level1" /> <?=$list_01['hero_nick']?>&nbsp;&nbsp;&nbsp;
                                <span style="font-size: 12px;background-color: #ff6815;height: 21px;margin-bottom: 5px;color: white;text-align: center;padding: 3px 10px;font-weight: 800;">신청 번호 : <?=$list_01['hero_number']?></span>  
                                <?if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                    if(!strcmp($list_01['hero_code'], $_SESSION['temp_code'])){?>
                                <a href="<?=PATH_HOME.'?'.get('view','view=step_02_01&hero_idx='.$list_01['hero_idx'])?>">[수정]</a>
                                <a href="<?=PATH_HOME.'?'.get('type||hero_idx','type=drop&hero_idx='.$list_01['hero_idx'])?>">[삭제]</a>
                                <?}}?></li>
                                <li class="mt5"><?=$hero_mt5_view?></li>
                            </ul>
                        </dd>
                    </dl>
<?}}?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="spm_01"> <img src="../image/mission/spm_bg4.gif" alt="top" /> </div>
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