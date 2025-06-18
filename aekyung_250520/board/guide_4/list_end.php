<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$temp_id = $_SESSION['temp_id'];
$temp_code = $_SESSION['temp_code'];
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
//if(!strcmp($_SESSION['temp_id'],'')){echo '<script>location.href="'.PATH_HOME.'?board=login"</script>';exit;}
######################################################################################################################################################
$sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\'';
sql($sql, 'on');
$point_list                             = @mysql_fetch_assoc($out_sql);
//권한
if(!strcmp($my_level,'0')){msg('권한이 없습티다.','location.href="'.PATH_HOME.'?board=login"');exit;}
if($point_list['hero_write'] <= $my_level){
$temp_top_title = $point_list['hero_title'];
$temp_title = $point_list['hero_title'];
$temp_point = $point_list['hero_write_point'];
if(!strcmp($temp_point, '')){
    $temp_point = '0';
}else{
    $temp_point = $temp_point;
}
$sql = 'select * from member where hero_code=\''.$temp_code.'\'';
$member = mysql_query($sql);
$member_list                             = @mysql_fetch_assoc($member);
$total_point = $member_list['hero_point'];
$total = $total_point+$temp_point;
$old_sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_id=\''.$temp_id.'\';';
$out_old_sql = mysql_query($old_sql);
$old_count = @mysql_num_rows($out_old_sql);
while($old_list                             = @mysql_fetch_assoc($out_old_sql)){
    $old_point .= $old_list['hero_point'];
}
if(!strcmp($old_point,'')){
    $old_point = '0';
}else{
    $old_point = $old_point;
}
if(!strcmp($_GET['type'], 'write')){
    $sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_code = \''.$temp_code.'\' order by hero_today desc limit 0,1;';
    sql($sql, 'on');
    $today_list                             = @mysql_fetch_assoc($out_sql);
    $last_day = date( "Ymd", strtotime($today_list['hero_today']));
    $to_day = date( "Ymd", time());
    if(!strcmp($to_day, $last_day)){
        $msg = '이미 출석';
        $action_href = PATH_HOME.'?'.get('type');
        msg($msg.' 하셨습니다.','location.href="'.$action_href.'"');
        exit;
    }else{
        $today_sql = 'select * from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$temp_code.'\' and not hero_title="월출석개근";';
        $out_today_sql = mysql_query($today_sql);
        while($today_today_list                             = @mysql_fetch_assoc($out_today_sql)){
            $today_total_point = $today_total_point + $today_today_list['hero_point'];
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
                        $check_point_sql = 'select * from point where hero_table=\''.$level_up_list['hero_table'].'\' and hero_type=\''.$level_up_list['hero_type'].'\' and hero_code=\''.$_SESSION['temp_code'].'\';';
                        $out_check_point_sql = mysql_query($check_point_sql);
                        $out_check_point_count = @mysql_num_rows($out_check_point_sql);
                        if($level_up_list['hero_number'] <= $out_check_point_count){
                            $level_up_ok = $level_up_ok+'0';
                        }else{
                            $level_up_ok = $level_up_ok+'1';
                        }
                    }
                }
                if(!strcmp($level_up_ok, '0')){
                    $sql_one_write = 'hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                    $sql_two_write = '\''.$temp_code.'\', \''.$_GET['board'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    $user_level_up = $my_level+1;
                    $user_write_up = $my_write+1;
                    $user_view_up = $my_view+1;
                    $user_update_up = $my_update+1;
                    $user_rev_up = $my_rev+1;
                    $_SESSION['temp_level'] = $user_level_up;
                    $_SESSION['temp_write'] = $user_write_up;
                    $_SESSION['temp_view'] = $user_view_up;
                    $_SESSION['temp_update'] = $user_update_up;
                    $_SESSION['temp_rev'] = $user_rev_up;
                    $sql = 'UPDATE member SET hero_level=\''.$user_level_up.'\', hero_write=\''.$user_write_up.'\', hero_view=\''.$user_view_up.'\', hero_update=\''.$user_update_up.'\', hero_rev=\''.$user_rev_up.'\', hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                    mysql_query($sql);
                    $temp_level_sql = 'select * from level where hero_level=\''.$user_level_up.'\'';
                    $out_temp_level = mysql_query($temp_level_sql);
                    $temp_level_list                             = @mysql_fetch_assoc($out_temp_level);
//                    $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
                    $msg = '축하 합니다. 레벨 상승하셨습니다.';
                }else{
                    $sql_one_write = 'hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                    $sql_two_write = '\''.$temp_code.'\', \''.$_GET['board'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                    mysql_query($sql);
                    $msg = '출석 완료 되었습니다.';
                }
            }else{
                $sql_one_write = 'hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                $sql_two_write = '\''.$temp_code.'\', \''.$_GET['board'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                mysql_query($sql);
                $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                mysql_query($sql);
                $msg = '출석 완료 되었습니다.';
            }
            $action_href = PATH_HOME.'?'.get('type');
            msg($msg,'location.href="'.$action_href.'"');
######################################################################################################################################################
        }else{
            $sql_one_write = 'hero_code, hero_table, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
            $sql_two_write = '\''.$temp_code.'\', \''.$_GET['board'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'(당일 포인트 초과)\', \''.$_SESSION['temp_name'].'\', \'0\', \''.Ymdhis.'\'';
//            $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
//            mysql_query($sql);
            $msg = '당일 획득 포인트를 초과 하였습니다.';
            $action_href = PATH_HOME.'?'.get('type');
            msg($msg,'location.href="'.$action_href.'"');
        }
######################################################################################################################################################
        exit;
    }
}
######################################################################################################################################################
?>
    <div class="contents_area">
        <div class="page_title">
            <h2><img src="<?=str($point_list['hero_right']);?>" alt="<?=$point_list['hero_title'];?>" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li><?=$point_list['hero_top_title']?></li>
                <li>&gt;</li>
                <li class="current"><?=$point_list['hero_title']?></li>
            </ul>
        </div>
        <div class="contents">
<?
if(!$_GET['m_day']){
    $y_day = date(Y);
    $m_day = date(m);
}else{
    $y_day = $_GET['y_day'];
    $m_day = $_GET['m_day'];
}
if(!strcmp($m_day,'1')){
    $new_y_day = $y_day-1;
    $new_m_day = '12';

    $next_y_day = $y_day;
    $next_m_day = $m_day+1;
}else if(!strcmp($m_day,'12')){
    $new_y_day = $y_day;
    $new_m_day = $m_day-1;

    $next_y_day = $y_day+1;
    $next_m_day = '1';
}else{
    $new_y_day = $y_day;
    $new_m_day = $m_day-1;

    $next_y_day = $y_day;
    $next_m_day = $m_day+1;
}

$today = date('Y-m-d', time());
$dayspacer = @date("w",mktime(0,0,0,$m_day,1,$y_day));//시작일
$lastday = @date("t",mktime(0,0,0,$m_day,1,$y_day));//마지막일
?>
            <img src="../image/guide/guide4_1.gif" alt="AK Lover 포인트지급방법"  />
            <div class="ym_btn"> <a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$new_y_day.'&m_day='.$new_m_day)?>"><img src="../image/guide/guide4_5.gif" class="btn1" /></a>
                <span class="yearmonth"><?=$y_day.'.'.$m_day?></span>
                <a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$next_y_day.'&m_day='.$next_m_day)?>"><img src="../image/guide/guide4_6.gif" class="btn2" /></a>
            </div>
            <div class="cal_group">
                <img src="../image/guide/guide4_3.gif" alt="출석으로 50포인트 행복을 느껴보세요." class="fl" />
                <a href="<?=PATH_HOME.'?'.get('','type=write');?>"><img src="../image/guide/guide4_2.gif" alt="오늘출석체크 바로하기" class="fr" /></a>
            </div>
            <table border="0" cellpadding="0" cellspacing="0" class="calendar">
                <colgroup>
                    <col width="98px">
                    <col width="98px">
                    <col width="98px">
                    <col width="98px">
                    <col width="98px">
                    <col width="98px">
                    <col width="*">
                </colgroup>
<?
    for ($null_i = 0; $null_i < $dayspacer; $null_i++){
        if ($null_i == '0'){
    echo '<tr class="we1">'.PHP_EOL;
    echo '<td><div></div></td>'.PHP_EOL;
        }else{
    echo '<td><div></div></td>'.PHP_EOL;
        }
    }
    $dd = '1';
    $start_day = date('Y-m-d', mktime(0, 0, 0, $m_day, 1, $y_day));
//    $end_day = date('Y-m-d', mktime(0, 0, 0, $m_day, $lastday+1, $y_day));
    $end_day = date('Y-m-d', mktime(0, 0, 0, $m_day, $lastday, $y_day));
    $sql = 'select date(hero_today) as lee from point where hero_table=\''.$_GET['board'].'\' and hero_id=\''.$temp_id.'\' and date(hero_today) >= \''.$start_day.'\' and date(hero_today) <=\''.$end_day.'\' order by hero_today asc;';
    sql($sql, 'on');
    while($today_old_list                             = @mysql_fetch_assoc($out_sql)){
        $all_day[] = $today_old_list['lee'];
    }
    for ($day_i = 1; $day_i <= $lastday; $day_i++){
        $str_date = @date("d",mktime(0,0,0,$m_day,$day_i,$y_day));
        $check_date = @date("Y-m-d",mktime(0,0,0,$m_day,$day_i,$y_day));
        $check_ok = @in_array($check_date,$all_day);//있으면 1
        if(!strcmp($check_ok,'1')){
            $img_open = '<img src="../image/guide/check.png" alt="출석" />';
        }else{
            $img_open = '';
        }
        if ($check_date == $today){
            if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0){
                echo '<tr class="we'.$dd.'"><td><div>'.$img_open.'<span class=""><font color=green><b>오늘'.$str_date.'</b></font></span></div></td>'.PHP_EOL;
            }else{
                echo '<td><div>'.$img_open.'<span class=""><font color=green><b>오늘'.$str_date.'</b></font></span></div></td>'.PHP_EOL;
            }
        }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0){
            echo '<tr class="we'.$dd.'"><td><div>'.$img_open.'<span class="c_red">'.$str_date.'</span></div></td>'.PHP_EOL;
        }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 6){
            echo '<td><div>'.$img_open.'<span class="c_blue">'.$str_date.'</span></div></td>'.PHP_EOL;
        }else{
            echo '<td><div>'.$img_open.'<span class="">'.$str_date.'</span></div></td>'.PHP_EOL;
        }
        if( (!(($null_i+$day_i)%7)) or ($str_date == $lastday) ){
//        if(!(($null_i+$day_i)%7)){
        echo "</tr>".PHP_EOL;
        $dd++;
        }
    }
?>
            </table>
            <div class="cal_info">
                <ul>
                  <li><img src="../image/guide/g4_1.gif" alt="회원님" /><span class="brown"><?=$_SESSION['temp_name']?></span>님</li>
                  <li><img src="../image/guide/g4_2.gif" alt="총 출석일수" /><span class="brown"><?=$old_count?></span>일</li>
<!--                  <li><img src="../image/guide/g4_3.gif" alt="연속출석일수" /><span class="brown"><?=$old_count?></span>일</li>-->
                  <li><img src="../image/guide/g4_4.gif" alt="획등포인트" /><span class="brown"><?=$old_point?></span>P</li>
              </ul>
            </div>
        </div>
    </div>
<?
}else{
    msg('권한이 없습티다.','location.href="'.PATH_HOME.'?board=login"');exit;
}
?>