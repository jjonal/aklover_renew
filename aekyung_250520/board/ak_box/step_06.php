<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$today = date( "Y-m-d", time());
if(!strcmp($_SESSION['temp_drop'], '')){
}else{
    $temp_drop = $_SESSION['temp_drop'];
    if($temp_drop<=$today){
        $sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        @sql($sql, 'on');
        $_SESSION['temp_write']=$_SESSION['temp_level'];
        $_SESSION['temp_view']=$_SESSION['temp_level'];
        $_SESSION['temp_update']=$_SESSION['temp_level'];
        $_SESSION['temp_rev']=$_SESSION['temp_level'];
        unset($_SESSION['temp_drop']);
    }else{
    }
}
######################################################################################################################################################
if(!strcmp($_SESSION['temp_level'], '')){
    $_SESSION['temp_level'] = '0';
    $_SESSION['temp_write'] = '0';
    $_SESSION['temp_view'] = '1';
    $_SESSION['temp_update'] = '0';
    $_SESSION['temp_rev'] = '0';
}
######################################################################################################################################################
$board_sql = 'select * from board where hero_idx = \''.$_REQUEST['hero_idx'].'\';';
sql($board_sql, 'on');
$board_list                            = @mysql_fetch_assoc($out_sql);
if(!strcmp($board_list['hero_table'],'hero')){
    $group_table_name = $board_list['hero_03'];
    $group_table_temp_name = "hero_03";
}else{
    $group_table_name = $board_list['hero_table'];
    $group_table_temp_name = "hero_table";
}

$group_sql = 'select * from hero_group where hero_board =\''.$group_table_name.'\';';//desc
$out_group_sql = @mysql_query($group_sql);
$group_list                             = @mysql_fetch_assoc($out_group_sql);

//20140513 비로그인시 볼수 있도록
//if($group_list['hero_view'] <= $_SESSION['temp_view']){//권한

$group_view_point = $group_list['hero_view_point'];//리뷰 획득포인트
$pk_sql = 'select a.hero_level,a.hero_nick,a.hero_idx,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$board_list['hero_code'].'\'';
$out_pk_sql = mysql_query($pk_sql);
$pk_row                             = @mysql_fetch_assoc($out_pk_sql);

$today_total_sql = 'select hero_point from today where hero_type=\'hero_total\'';
$out_today_total_sql = @mysql_query($today_total_sql);
$today_total_list                             = @mysql_fetch_assoc($out_today_total_sql);
$point_total_point = $today_total_list['hero_point'];//당일 최대 획득포인트

$today_user_total_sql = 'select SUM(hero_point) as today_user_total from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$_SESSION['temp_code'].'\ and not hero_title="월출석개근";';
$out_today_user_total_sql = @mysql_query($today_user_total_sql);
$today_user_total_list                             = @mysql_fetch_assoc($out_today_user_total_sql);
$today_user_total = $today_user_total_list['today_user_total'];//당일 획득 포인트

$board_user_sql = 'select * from point where hero_table=\''.$group_table_name.'\' and hero_type=\'view\' and date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$_SESSION['temp_code'].'\';';
$out_board_user = @mysql_query($board_user_sql);
$board_user_count = @mysql_num_rows($out_board_user);

if( ($point_total_point>=$today_user_total) and (!strcmp($board_user_count,'0')) and $group_list['hero_view'] <= $_SESSION['temp_view']){
    if(strcmp($group_view_point,'0')){
        $sql_one_write = 'hero_code, hero_table, hero_type, hero_old_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
        $sql_two_write = '\''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \'view\', \''.$_REQUEST['hero_idx'].'\', \''.$_SESSION['temp_id'].'\', \''.$group_list['hero_title'].'\', \''.$board_list['hero_title'].'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$group_view_point.'\', \''.Ymdhis.'\'';
        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        @mysql_query($sql);
        $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$_SESSION['temp_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];

        $temp_level_sql = "select * from level where hero_point_01<='".$member_total_point."' and hero_point_02>='".$member_total_point."' ";
        $out_temp_level = @mysql_query($temp_level_sql);
        $temp_level_list                             = @mysql_fetch_assoc($out_temp_level);
        if($temp_level_list['hero_level'] > $_SESSION['temp_level']){
            $sql = 'UPDATE member SET 
                    hero_level=\''.$temp_level_list['hero_level'].'\',
                    hero_write=\''.$temp_level_list['hero_level'].'\',
                    hero_view=\''.$temp_level_list['hero_level'].'\',
                    hero_update=\''.$temp_level_list['hero_level'].'\',
                    hero_rev=\''.$temp_level_list['hero_level'].'\',
                    hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
            @mysql_query($sql);
            $_SESSION['temp_level'] = $temp_level_list['hero_level'];
            $_SESSION['temp_write'] = $temp_level_list['hero_level'];
            $_SESSION['temp_view'] = $temp_level_list['hero_level'];
            $_SESSION['temp_update'] = $temp_level_list['hero_level'];
            $_SESSION['temp_rev'] = $temp_level_list['hero_level'];

            $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
            msg($msg,'');
        }else{
            $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
            @mysql_query($sql);
        }
    }
}
if(strcmp($board_list['hero_table'],'hero')){
    $sql = 'select * from board where hero_table = \''.$group_table_name.'\' and hero_idx > \''.$_GET['hero_idx'].'\' order by hero_idx asc limit 0,1;';
    $out_sql = @mysql_query($sql);
    $Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Prev['hero_idx'];

    $sql = 'select * from board where hero_table = \''.$group_table_name.'\' and hero_idx < \''.$_GET['hero_idx'].'\' order by hero_idx desc limit 0,1;';
    $out_sql = @mysql_query($sql);
    $Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Next['hero_idx'];
}else{
}

$recommand_sql = 'select * from hero_recommand where hero_recommand_code = \''.$_SESSION['temp_code'].'\' and hero_board_idx = \''.$_GET['hero_idx'].'\';';
$out_recommand_sql = @mysql_query($recommand_sql);
$recommand_count = @mysql_num_rows($out_recommand_sql);

if(!strcmp($_GET['type'], 'recommand')){
    if(!strcmp($recommand_count, '0')){
        $member_sql = 'select * from member where hero_code = \''.$board_list['hero_code'].'\';';
        $out_member_sql = @mysql_query($member_sql);
        $member_list = @mysql_fetch_assoc($out_member_sql);//mysql_fetch_row
        if(strcmp($_SESSION['temp_code'], '')){
            $hero_url_value = str_ireplace('&type=recommand', '', DOMAIN.URI);
            $sql_one_write = 'hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_recommand_code, hero_recommand_id, hero_recommand_nick, hero_recommand_name, hero_today';
            $sql_two_write = '\''.$hero_url_value.'\', \''.$_REQUEST['board'].'\', \''.$_REQUEST['hero_idx'].'\', \''.$member_list['hero_code'].'\', \''.$member_list['hero_id'].'\', \''.$member_list['hero_nick'].'\', \''.$member_list['hero_name'].'\', \''.$_SESSION['temp_code'].'\', \''.$_SESSION['temp_id'].'\', \''.$_SESSION['temp_nick'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\'';
            $hero_recommand_sql = 'INSERT INTO hero_recommand ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
            @mysql_query($hero_recommand_sql);
            $temp_rec = $board_list['hero_rec']+1;
            $up_member_sql = 'UPDATE board SET hero_rec=\''.$temp_rec.'\' WHERE hero_idx = \''.$_REQUEST['hero_idx'].'\';';
            $out_member_sql = @mysql_query($up_member_sql);
        }
    }
    $msg = '추천 하였습니다.';
    $get_herf = get('type','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
?>
<script>
	$(document).ready(function(){
			$(".regist").cluetip({width:'350px',activation: 'click',dropShadow: false, sticky: true, ajaxCache: false, arrows: true, closePosition: 'title', arrows: true,closeText: '<span id="close_info">X</span>'});
	});
</script>
    <div class="contents_area">
        <div class="page_title">
            <h2><img src="<?=str($group_list['hero_right']);?>" alt="<?=$group_list['hero_title'];?>" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li><?=$group_list['hero_top_title']?></li>
                <li>&gt;</li>
                <li class="current"><?=$group_list['hero_title']?></li>
            </ul>
        </div>
        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
                <colgroup>
                    <col width="90px" />
                    <col width="400px" />
                    <col width="100px" />
                    <col width="105px" />
                </colgroup>
                <tr class="bbshead">
                    <th><img src="../image/bbs/tit_subject.gif" alt="제목" /></th>
                    <td colspan="3">
<?
if(!strcmp($board_list['hero_table'],'hero')){
?>
                        <img src="../image/bbs/icon_notice.gif" alt="공지" />
<?
}
?>
                        <?=cut($board_list['hero_title'],48);?>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_writer.gif" alt="작성자" /></th>
                    <td>
						<?

							info_mem($pk_row['hero_nick'],$pk_row['hero_idx'],$pk_row['hero_img_new']);

						?>
					</td>
                    <th><img src="../image/bbs/tit_date.gif" alt="날짜" /></th>
                    <td><?=date( "y-m-d H:i", strtotime($board_list['hero_today']));?></td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_cc.gif" alt="추천" /></th>
                    <td><?=number_format($board_list['hero_rec'])?></td>
                    <td colspan="2" style="text-align:right;">
<?
if(strcmp($_SESSION['temp_code'], '')){
if(!strcmp($recommand_count, '0')){
?>
                        <a href="<?=PATH_HOME.'?'.get('type','type=recommand');?>"><img src="http://aklover.co.kr/image/best_bt.png" alt="추천"></a>
<?}}?>
                        <a href="javascript:open0('<?=$link?>');"><img src="../image/ico_fc.jpg" alt="페이스북공유"></a>
                        <a href="javascript:open1('<?=$sns_title?>','<?=$link?>');"><img src="../image/ico_tw.jpg" alt="트위터공유"></a>
                        <a href="javascript:open2('<?=$sns_title?>','<?=$link?>');"><img src="../image/ico_me.jpg" alt="미투데이공유"></a>
                    </td>
                </tr>
                <tr>
<?
$temp_command = htmlspecialchars_decode($board_list['hero_command']);
$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $temp_command);
$temp_hero_04 = href(nl2br($board_list['hero_04']));
$temp_hero_04 = str_ireplace('<A', '<A target="_blank"', $temp_hero_04);
?>
                    <td colspan="4" valign="top" width="705px"  class="bbs_view" style="padding:25px;line-height:normal;word-break:break-all;"><?=$next_command;?></td><!--677-->
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_url.gif" style="vertical-align:middle;"></th>
                    <td colspan="3" style="padding:10px">
                        <?=$temp_hero_04;?>
                    </td>
                </tr>
<?if(strcmp($board_list['hero_board_two'], '')){?>
                <tr>
                    <th><center>파일</center></th>
                    <td colspan="3"><a href="http://aklover.co.kr/freebest/download.php?hero=<?=$board_list['hero_board_one']?>&download=<?=$board_list['hero_board_two']?>" ><?=$board_list['hero_board_two'];?></td><!--677-->
                </tr>
<?
}
if(strcmp($Prev['hero_idx'], '')){
?>
                <tr>
                    <th><img src="../image/bbs/tit_prev.gif" alt="이전글" /></th>
                    <td colspan="3">
                    <a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=step_06&hero_idx=<?=$Prev['hero_idx'];?>&idx=<?=$Prev['hero_01'];?>"><?=cut($Prev['hero_title'],26);?></a></td>
                </tr>
<?
}
if(strcmp($Next['hero_idx'], '')){
?>
                <tr class="last">
                    <th><img src="../image/bbs/tit_next.gif" alt="다음글" /></th>
                    <td colspan="3">
<a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=step_06&hero_idx=<?=$Next['hero_idx'];?>&idx=<?=$Next['hero_01'];?>"><?=cut($Next['hero_title'],26);?></a></td>
                </tr>
<?
}
?>
            </table>
<?
    include_once BOARD_INC_END.'button4.php';
$check_review_sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';
$out_check_review_sql = mysql_query($check_review_sql);
$check_review_list                             = @mysql_fetch_assoc($out_check_review_sql);
$check_review_list['hero_rev'];
    include_once BOARD_INC_END.'review3.php';
?>
        </div>
    </div>
<?
//20140513 비로그인시 볼수 있도록
//}else{
//    if(!strcmp($group_list['hero_level'], '0')){
//        $msg = '권한이';
//        $action_href = PATH_HOME.'?board=login';
//    }else{
//        $msg = '권한이';
//        $action_href = PATH_HOME.'?'.get('view');
//    }
//    msg($msg.' 없습니다.','location.href="'.$action_href.'"');
//    exit;
//}
?>