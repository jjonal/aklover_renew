<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//echo $_SESSION['temp_level'];
$today = date( "Y-m-d", time());
if(!strcmp($_SESSION['temp_drop'], '')){
}else{
    $temp_drop = $_SESSION['temp_drop'];
    if($temp_drop<=$today){
        $sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        mysql_query($sql);
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
if(!strcmp($_GET['next_board'],"hero")){
    $hero_table = 'hero';
}else{
    $hero_table = $_GET['board'];
}

$sql = 'select A.*,B.hero_nick as nick from mail A inner join member B on A.hero_user=B.hero_id where A.hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
//if(strcmp(eregi($_SESSION['temp_id'],$out_row['hero_user_check']),'1')){
//    if(!strcmp($out_row['hero_user_check'],'')){
//        $new_hero_user_check = $_SESSION['temp_id'];
//    }else{
//        $new_hero_user_check = $out_row['hero_user_check'].'||'.$_SESSION['temp_id'];
//    }
//    $sql = 'UPDATE mail SET hero_user_check=\''.$new_hero_user_check.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
//   mysql_query($sql);
//}
//    $temp_hit = $out_row['hero_hit']+1;
$sql = 'select * from mail where hero_notice=\'0\' and hero_idx > \''.$_GET['idx'].'\' order by hero_idx asc limit 0,1;';
sql($sql, 'on');
    $Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Prev['hero_idx'];

$sql = 'select * from mail where hero_notice=\'0\' and hero_idx < \''.$_GET['idx'].'\' order by hero_idx desc limit 0,1;';
sql($sql, 'on');
    $Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Next['hero_idx'];
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
//권한
//if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
if($right_list['hero_view'] <= $my_view){
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
$temp_top_title = $right_list['hero_title'];
$temp_title = $out_row['hero_title'];
$temp_point = $right_list['hero_view_point'];
$temp_idx = $_GET['idx'];
######################################################################################################################################################
if(!strcmp($temp_point, '')){
    $temp_point = '0';
}else{
    $temp_point = $temp_point;
}
if( (!strcmp($my_level, '0')) or (!strcmp($temp_point, '0')) ){
    //포인트는 없다
}else{
    $sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_code = \''.$temp_code.'\' and hero_type=\''.$_GET['view'].'\' and hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc limit 0,1;';
    sql($sql, 'on');
    $today_list                             = @mysql_fetch_assoc($out_sql);
    $last_day = date( "Ymd", strtotime($today_list['hero_today']));
    $to_day = date( "Ymd", time());
    if(!strcmp($to_day, $last_day)){
    }else{
        $member_sql = 'select * from member where hero_code=\''.$temp_code.'\'';
        $out_member = mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member);
        $total_point = $member_list['hero_point'];
        $total = $total_point+$temp_point;

        $today_sql = 'select * from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$temp_code.'\' and not hero_title="월출석개근";';
        $out_today_sql = mysql_query($today_sql);
        $today_total_point='0';
        while($today_today_list                             = @mysql_fetch_assoc($out_today_sql)){
            $today_total_point = $today_total_point + $today_today_list['hero_point'];
        }
        if(!strcmp($today_total_point,'')){
            $today_total_point = '0';
        }else{
            $today_total_point = $today_total_point;
        }
        $admin_today_sql = 'select * from today where hero_type=\'hero_total\'';
        $out_admin_today_sql = mysql_query($admin_today_sql);
        $admin_today_today_list                             = @mysql_fetch_assoc($out_admin_today_sql);
        if($admin_today_today_list['hero_point']>$today_total_point){
######################################################################################################################################################
            $level_sql = 'select * from level where hero_level!=\'0\' and hero_point_01<=\''.$total_point.'\' and hero_point_02>=\''.$total_point.'\'';
            $out_level = mysql_query($level_sql);
            $level_list                             = @mysql_fetch_assoc($out_level);
            $level_up_sql = 'select * from level_up';
            $out_level_up = mysql_query($level_up_sql);
            if($member_list['hero_level'] <= $level_list['hero_level']){
                while($level_up_list                             = @mysql_fetch_assoc($out_level_up)){
                    if(!strcmp($member_list['hero_level'], $level_up_list['hero_level'])){
                        $check_point_sql = 'select * from point where hero_table=\''.$level_up_list['hero_table'].'\' and hero_type=\''.$level_up_list['hero_type'].'\' and hero_code=\''.$temp_code.'\';';
                        $out_check_point_sql = mysql_query($check_point_sql);
                        $out_check_point_count = @mysql_num_rows($out_check_point_sql);
                        if($level_up_list['hero_number'] <= $out_check_point_count){
                            $level_up_ok = $level_up_ok+'0';
                        }else{
                            $level_up_ok = $level_up_ok+'1';
                        }
                    }else{
                        $level_up_ok = '0';
                    }
                }
                if(!strcmp($level_up_ok, '0')){
                    $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                    $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    if(!strcmp($_SESSION['temp_drop'], '')){
                        $user_level_up = $level_list['hero_level'];
                        $user_write_up = $level_list['hero_level'];
                        $user_view_up = $level_list['hero_level'];
                        $user_update_up = $level_list['hero_level'];
                        $user_rev_up = $level_list['hero_level'];
                    }else{
                        $user_level_up = $level_list['hero_level'];
                        $user_write_up = $my_write;
                        $user_view_up = $my_view;
                        $user_update_up = $my_update;
                        $user_rev_up = $my_rev;
                    }
                    $sql = 'UPDATE mail SET hero_hit=\''.$temp_hit.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
                    mysql_query($sql);
                    $temp_level_sql = 'select * from level where hero_level=\''.$user_level_up.'\'';
                    $out_temp_level = mysql_query($temp_level_sql);
                    $temp_level_list                             = @mysql_fetch_assoc($out_temp_level);
//                    $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
                    if($level_list['hero_level']>$_SESSION['temp_level']){
                        $msg = '축하 합니다. 레벨 상승하셨습니다.';
                        $sql = 'UPDATE member SET hero_level=\''.$user_level_up.'\', hero_write=\''.$user_write_up.'\', hero_view=\''.$user_view_up.'\', hero_update=\''.$user_update_up.'\', hero_rev=\''.$user_rev_up.'\', hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                        mysql_query($sql);
                        msg($msg,'');
                    }
                    $_SESSION['temp_level'] = $user_level_up;
                    $_SESSION['temp_write'] = $user_write_up;
                    $_SESSION['temp_view'] = $user_view_up;
                    $_SESSION['temp_update'] = $user_update_up;
                    $_SESSION['temp_rev'] = $user_rev_up;

                }else{
                    $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                    $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                    mysql_query($sql);
                    $sql = 'UPDATE mail SET hero_hit=\''.$temp_hit.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
                    mysql_query($sql);
                }
            }else{
                $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                mysql_query($sql);
                $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                mysql_query($sql);
                $sql = 'UPDATE mail SET hero_hit=\''.$temp_hit.'\' WHERE hero_idx = \''.$_GET['idx'].'\';'.PHP_EOL;
                mysql_query($sql);
            }
######################################################################################################################################################
        }else{
            $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
            $sql_two_write = '\''.$_GET['idx'].'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['view'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'(당일 포인트 초과)\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \'0\', \''.Ymdhis.'\'';
//            $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
//            mysql_query($sql);
        }
######################################################################################################################################################
    }
}
$hit_sql = 'select * from mail where hero_idx=\''.$_GET['idx'].'\';';
$out_hit_sql = mysql_query($hit_sql);
$hit_row = @mysql_fetch_assoc($out_hit_sql);//mysql_fetch_row
?>

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
                    <td colspan="3"><!--<?=$out_row['hero_title']?>-->
                        <?=cut($out_row['hero_title'],48);?>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_receiver.gif" alt="받는사람" /></th>
                    <td><?=$out_row['nick'];?></td>
                    <th><img src="../image/bbs/tit_date.gif" alt="날짜" /></th>
                    <td><?=date( "y-m-d H:i", strtotime($out_row['hero_today']));?></td>
                </tr>
                <tr>
                    <td colspan="4" valign="top" width="705px"  class="bbs_view" style="padding:10px;line-height:14px; word-break:break-word;word-wrap:break-word;">
<pre>
<?=$out_row['hero_command'];?>
</pre>
                    </td><!--677-->
                </tr>
<?if(strcmp($out_row['out_row'], '')){?>
                <tr class="last">
                    <th><center>파일</center></th>
                    <td colspan="3"><a href="<?=FREEBEST_END?>download.php?hero=<?=$out_row['hero_board_one']?>&download=<?=$out_row['hero_board_two']?>" ><?=$out_row['hero_board_two'];?></td><!--677-->
                </tr>
<?}?>
            </table>
<?
    include_once BOARD_INC_END.'button.php';
$check_review_sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\';';
$out_check_review_sql = mysql_query($check_review_sql);
$check_review_list                             = @mysql_fetch_assoc($out_check_review_sql);
$check_review_list['hero_rev'];
if($check_review_list['hero_rev']<=$my_rev){
//    include_once BOARD_INC_END.'review2.php';
}
?>
        </div>
    </div>
<?
}else{
    if(!strcmp($my_level, '0')){
        $msg = '권한이';
        $action_href = PATH_HOME.'?board=login';
    }else{
        $msg = '권한이';
        $action_href = PATH_HOME.'?'.get('view');
    }
    msg($msg.' 없습니다.','location.href="'.$action_href.'"');
    exit;
}
?>