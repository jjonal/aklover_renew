<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_SESSION['temp_id'],'')){echo '<script>location.href="'.PATH_HOME.'?board=login"</script>';exit;}
######################################################################################################################################################
if(!strcmp($_GET['type'], 'write')){
    $temp_id = $_SESSION['temp_id'];

    $sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_id = \''.$temp_id.'\' order by hero_today desc limit 0,1;';
    sql($sql, 'on');
    $today_list                             = @mysql_fetch_assoc($out_sql);
    $last_day = date( "Ymd", strtotime($today_list['hero_today']));
    $to_day = date( "Ymd", time());
    if(!strcmp($to_day, $last_day)){
        $msg = '�̹� �⼮';
        $action_href = PATH_HOME.'?'.get('type');
        msg($msg.' �ϼ̽��ϴ�.','location.href="'.$action_href.'"');
        exit;
    }else{
        $sql = 'select * from hero_group where hero_board=\''.$_GET['board'].'\'';
        sql($sql, 'on');
        $point_list                             = @mysql_fetch_assoc($out_sql);
        $temp_title = $point_list['hero_title'];
        $temp_point = $point_list['hero_today_point'];

        $sql_one_write = 'hero_code, hero_table, hero_id, hero_title, hero_name, hero_point, hero_today';
        $sql_two_write = '\''.$_SESSION['temp_code'].'\', \''.$_GET['board'].'\', \''.$temp_id.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        sql($sql);
        $msg = '�⼮ �Ϸ�';
        $action_href = PATH_HOME.'?'.get('type');
        msg($msg.' �Ǿ����ϴ�.','location.href="'.$action_href.'"');
        exit;
    }
}
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>
        <style>
            .ym_btn{ position:relative; width:100%; height:10px;}
            .btn1{position:absolute; top:-20px; right:130px;}
            .btn2{position:absolute; top:-20px;; right:0;}
            .yearmonth{position:absolute; top:-28px; right:25px; font-size:25px; font-weight:bold;}
            .cal_group{border-top:2px solid #ffd97f; height:45px; padding-top:15px; }
            .cal_info{border-bottom:2px solid #ffd97f; height:25px; padding:5px auto; text-align:center; margin-top:15px;}
            .cal_info li{float:left; display:inline-block; width:110px; margin-left:45px;}
            .cal_info li img{vertical-align:middle; margin-top:-1px;}
            .cal_info .brown{margin:0 5px; display:inline-block; color:#a16309; }

            .calendar {width:100%;}
            .calendar tr.we1 td{background:#fff0cc;}
            .calendar tr.we2 td{background:#ffe199;}
            .calendar tr.we3 td{background:#ffd166;}
            .calendar tr.we4 td{background:#ffc233;}
            .calendar tr.we5 td{background:#ffb300;}
            .calendar tr.we6 td{background:#f6ae00;}
            .calendar td{height:94px;border-right:2px solid #fff;border-bottom:2px solid #fff; position:relative; text-align:center;}
            .calendar tr td.today{ background:url(../image/guide/bg_today.gif);}
            .calendar span{position:absolute;color:#636363; display:inline-block; right:10px; top:10px; font-size:13px;}
            .calendar span.c_blue{color:#00c6f7;}
            .calendar span.c_red{ color:#ff0000;}
        </style>

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
$dayspacer = @date("w",mktime(0,0,0,$m_day,1,$y_day));//������
$lastday = @date("t",mktime(0,0,0,$m_day,1,$y_day));//��������
?>
            <img src="../image/guide/guide4_1.gif" alt="AK Lover ����Ʈ���޹��"  />
            <div class="ym_btn"> <a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$new_y_day.'&m_day='.$new_m_day)?>"><img src="../image/guide/guide4_5.gif" class="btn1" /></a>
                <span class="yearmonth"><?=$y_day.'.'.$m_day?></span>
                <a href="<?=$PHP_SELF.'?'.get('y_day||m_day','y_day='.$next_y_day.'&m_day='.$next_m_day)?>"><img src="../image/guide/guide4_6.gif" class="btn2" /></a>
            </div>
            <div class="cal_group">
                <img src="../image/guide/guide4_3.gif" alt="�⼮���� 50����Ʈ �ູ�� ����������." class="fl" />
                <a href="<?=PATH_HOME.'?'.get('','type=write');?>"><img src="../image/guide/guide4_2.gif" alt="�����⼮üũ �ٷ��ϱ�" class="fr" /></a>
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
    echo '<td></td>'.PHP_EOL;
        }else{
    echo '<td></td>'.PHP_EOL;
        }
    }
    $dd = '1';

//echo $today;
//echo $y_day.$m_day;
//mktime(��, ��, ��, ��, ��, ��)
//key_exists
//array_key_exists


    $start_day = date('Y-m-d', mktime(0, 0, 0, $m_day, 1, $y_day));
    $end_day = date('Y-m-d', mktime(0, 0, 0, $m_day, $lastday, $y_day));
    $sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_id = \''.$temp_id.'\';';
    sql($sql, 'on');
    $old_count = @mysql_num_rows($out_sql);

    $sql = 'select * from point where hero_table=\''.$_GET['board'].'\' and hero_id = \''.$temp_id.'\';';
    sql($sql, 'on');
    $old_count = @mysql_num_rows($out_sql);
    $old_list                             = @mysql_fetch_assoc($out_sql);

    $sql = 'select date(hero_today) as lee from point where hero_table=\''.$_GET['board'].'\' and hero_id = \''.$temp_id.'\' and hero_today >= \''.$start_day.'\' and hero_today <= \''.$end_day.'\' order by hero_today asc;';
    sql($sql, 'on');
    while($today_old_list                             = @mysql_fetch_assoc($out_sql)){
        $all_day[] = $today_old_list['lee'];
    }

//array_values
//array_search
//$kk = array_key_exists($input,$all_day);//������ 1


    for ($day_i = 1; $day_i <= $lastday; $day_i++){
        $str_date = @date("d",mktime(0,0,0,$m_day,$day_i,$y_day));
        $check_date = @date("Y-m-d",mktime(0,0,0,$m_day,$day_i,$y_day));
        $check_ok = @in_array($check_date,$all_day);//������ 1
        if(!strcmp($check_ok,'1')){
            $img_open = '<img src="../image/guide/check.png" alt="�⼮" />';
        }else{
            $img_open = '';
        }
        if ($check_date == $today){
            if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0){
                echo '<tr class="we'.$dd.'"><td>'.$img_open.'<span class=""><font color=green><b>����'.$str_date.'</b></font></span></td>'.PHP_EOL;
            }else{
                echo '<td>'.$img_open.'<span class=""><font color=green><b>����'.$str_date.'</b></font></span></td>'.PHP_EOL;
            }
        }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 0){
            echo '<tr class="we'.$dd.'"><td>'.$img_open.'<span class="c_red">'.$str_date.'</span></td>'.PHP_EOL;
        }else if (@date("w",mktime(0,0,0,$m_day,$day_i,$y_day)) == 6){
            echo '<td>'.$img_open.'<span class="c_blue">'.$str_date.'</span></td>'.PHP_EOL;
        }else{
            echo '<td>'.$img_open.'<span class="">'.$str_date.'</span></td>'.PHP_EOL;
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
                  <li><img src="../image/guide/g4_1.gif" alt="ȸ����" /><span class="brown"><?=$_SESSION['temp_name']?></span>��</li>
                  <li><img src="../image/guide/g4_2.gif" alt="�� �⼮�ϼ�" /><span class="brown"><?=$old_count?></span>��</li>
                  <li><img src="../image/guide/g4_3.gif" alt="�����⼮�ϼ�" /><span class="brown"><?=$old_count?></span>��</li>
                  <li><img src="../image/guide/g4_4.gif" alt="ȹ������Ʈ" /><span class="brown"><?=$old_count?></span>P</li>
              </ul>
            </div>
        </div>
    </div>
