<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head.php';
######################################################################################################################################################
include_once FREEBEST_INC_END.'function.php';
######################################################################################################################################################
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
if(!strcmp($_POST['type'],'zip')){
    if(strcmp($_POST['input_chat'],'')){
        $sql = 'select * from zipcode where dong like \'%'.$_POST['input_chat'].'%\'';
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
        while($list  = @mysql_fetch_assoc($out_sql)){ 
            $out .= '<a href="#" onclick="fnLoad_01(\''.$list['zipcode'].'\', \''.$list['sido'].'\', \''.$list['gugun'].'\', \''.$list['dong'].'\', \''.$list['bunji'].'\', \''.$list['seq'].'\')">'.$list['gugun'].' '.$list['dong'].' '.$list['bunji'].'</a><br>';//.' '.$list['seq']
        }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }
}else if(!strcmp($_POST['type'],'id')){
//    $str_len = strlen($_POST['input_chat']);
$str_len = mb_strlen($_POST['input_chat'], 'utf-8');
//    if(strcmp($_POST['input_chat'],'')){
    if( ($str_len > '3') and ($str_len < '21') ){
        $sql = 'select * from member where hero_id = \''.$_POST['input_chat'].'\'';
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
            if(!strcmp($count,'0')){
                $out = '<font color=blue>사용가능</font>';
                $out .= '<input type=hidden id="id_action" name="id_action" value="hero_ok">';
            }else{
                $out = '<font color=red>사용불가</font>';
                $out .= '<input type=hidden id="id_action" name="id_action" value="hero_down">';
            }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }else{
        $out = '<font color=red>사용불가</font>';
        $out .= '<input type=hidden id="id_action" name="id_action" value="hero_down">';
        echo iconv('EUC-KR', 'UTF-8', $out);
    }
}else if(!strcmp($_POST['type'],'nick')){
//    $str_len = strlen($_POST['input_chat']);
    $str_len = mb_strlen($_POST['input_chat'], 'utf-8');
    if( ($str_len > '1') and ($str_len < '21') ){
        $sql = 'select * from member where hero_nick = \''.$_POST['input_chat'].'\'';
        $sql = out($sql);
        sql($sql, 'end');
        $count = @mysql_num_rows($out_sql);
            if(!strcmp($count,'0')){
                $out = '<font color=blue>사용가능</font>';
                $out .= '<input type=hidden id="nick_action" name="nick_action" value="hero_ok">';
            }else{
                $out = '<font color=red>사용불가</font>';
                $out .= '<input type=hidden id="nick_action" name="nick_action" value="hero_down">';
            }
        echo iconv('EUC-KR', 'UTF-8', $out);
    }else{
        $out = '<font color=red>사용불가</font>';
        $out .= '<input type=hidden id="nick_action" name="nick_action" value="hero_down">';
        echo iconv('EUC-KR', 'UTF-8', $out);
    }
}else if(!strcmp($_POST['type'],'review')){
    if(!strcmp($_POST['mode'],'review_write')){
        $sql = 'select * from board where hero_idx = \''.$_GET['hero_old_idx'].'\';';
        sql($sql, 'on');
        $review_list                             = @mysql_fetch_assoc($out_sql);
        $idx_sql = 'SHOW TABLE STATUS LIKE \'review\'';
        $out_idx_sql = @mysql_query($idx_sql);
        $idx_list                             = @mysql_fetch_assoc($out_idx_sql);
        $good_idx = $idx_list['Auto_increment'];



        $sql_one_write = 'hero_idx, hero_code, hero_table, hero_old_idx, hero_name, hero_today, hero_command';
        $sql_two_write = '\''.$good_idx.'\', \''.$_SESSION['temp_code'].'\', \''.$review_list['hero_table'].'\', \''.$_GET['hero_old_idx'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\', \''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\'';
echo        $sql = 'INSERT INTO review ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
echo '---';
exit;

        @mysql_query($sql);
        $sql = 'UPDATE board SET hero_review_count=\''.$review_count.'\' WHERE hero_idx = \''.$_GET['hero_old_idx'].'\';';
        @mysql_query($sql);

        $sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$review_list['hero_table'].'\';';//desc
        sql($sql);
        $right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
        $temp_id = $_SESSION['temp_id'];
        $temp_code = $_SESSION['temp_code'];
        $temp_top_title = $right_list['hero_title'];
        $temp_title = $review_list['hero_title'];
        $temp_point = $right_list['hero_rev_point'];
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
            $sql = 'select * from point where hero_table=\''.$review_list['hero_table'].'\' and hero_code = \''.$temp_code.'\' and hero_type=\''.$_POST['type'].'\' and hero_old_idx=\''.$_GET['hero_old_idx'].'\' order by hero_today desc limit 0,1;';
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

                $total_today_sql = 'select * from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$temp_code.'\' and not hero_title="월출석개근";';
                $out_total_today_sql = mysql_query($total_today_sql);
                $total_today_total_point='0';
                while($total_today_today_list                             = @mysql_fetch_assoc($out_total_today_sql)){
                    $total_today_total_point = $total_today_total_point + $total_today_today_list['hero_point'];
                }
                if(!strcmp($total_today_total_point,'')){
                    $total_today_total_point = '0';
                }else{
                    $total_today_total_point = $total_today_total_point;
                }
                $total_admin_today_sql = 'select * from today where hero_type=\'hero_total\'';
                $out_total_admin_today_sql = mysql_query($total_admin_today_sql);
                $total_admin_today_today_list                             = @mysql_fetch_assoc($out_total_admin_today_sql);

                $today_sql = 'select * from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_type=\'review\' and hero_code=\''.$temp_code.'\';';
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
                $admin_today_sql = 'select * from today where hero_type=\'hero_rev\'';
                $out_admin_today_sql = mysql_query($admin_today_sql);
                $admin_today_today_list                             = @mysql_fetch_assoc($out_admin_today_sql);

                if( ($total_admin_today_today_list['hero_point']>$total_today_total_point) and ($admin_today_today_list['hero_point']>$today_total_point) ){
######################################################################################################################################################
                    $level_sql = 'select * from level where hero_level!=\'0\' and hero_point_01<=\''.$total.'\' and hero_point_02>=\''.$total.'\'';
                    $out_level = mysql_query($level_sql);
                    $level_list                             = @mysql_fetch_assoc($out_level);
                    $level_up_sql = 'select * from level_up';
                    $out_level_up = mysql_query($level_up_sql);
                    if($member_list['hero_level'] <= $level_list['hero_level']){
######################################################################################################################################################
                        $out_level_up_count = @mysql_num_rows($out_level_up);
                        if(strcmp($out_level_up_count, '0')){

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

                        }else{
                                    $level_up_ok = '0';
                        }
######################################################################################################################################################
                        $level_list['hero_level'];
                        if(!strcmp($level_up_ok, '0')){
                            $sql_one_write = 'hero_review_idx, hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                            $sql_two_write = '\''.$good_idx.'\', \''.$_GET['hero_old_idx'].'\', \''.$temp_code.'\', \''.$review_list['hero_table'].'\', \''.$_POST['type'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
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
                            $temp_level_sql = 'select * from level where hero_level=\''.$user_level_up.'\'';
                            $out_temp_level = mysql_query($temp_level_sql);
                            $temp_level_list                             = @mysql_fetch_assoc($out_temp_level);
        //                    $msg = '축하 합니다. 레벨 상승하셨습니다.\n 현재 등급은 : ['.$temp_level_list['hero_name'].']';
    //                        $msg = iconv('EUC-KR', 'UTF-8', '축하 합니다. 레벨 상승하셨습니다.');
    //                            $msg = '축하 합니다. 레벨 상승하셨습니다.';
    //                        msg($msg,'');
                            if($level_list['hero_level']>$_SESSION['temp_level']){
                                $sql = 'UPDATE member SET hero_level=\''.$user_level_up.'\', hero_write=\''.$user_write_up.'\', hero_view=\''.$user_view_up.'\', hero_update=\''.$user_update_up.'\', hero_rev=\''.$user_rev_up.'\', hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                                mysql_query($sql);
                            }else{
                                $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                                mysql_query($sql);
                            }
                            $_SESSION['temp_level'] = $user_level_up;
                            $_SESSION['temp_write'] = $user_write_up;
                            $_SESSION['temp_view'] = $user_view_up;
                            $_SESSION['temp_update'] = $user_update_up;
                            $_SESSION['temp_rev'] = $user_rev_up;
                        }else{
                            $sql_one_write = 'hero_review_idx, hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                            $sql_two_write = '\''.$good_idx.'\', \''.$_GET['hero_old_idx'].'\', \''.$temp_code.'\', \''.$review_list['hero_table'].'\', \''.$_POST['type'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                            $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                            mysql_query($sql);
                            $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                            mysql_query($sql);
                        }
                    }else{
                        $sql_one_write = 'hero_review_idx, hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                        $sql_two_write = '\''.$good_idx.'\', \''.$_GET['hero_old_idx'].'\', \''.$temp_code.'\', \''.$review_list['hero_table'].'\', \''.$_POST['type'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                        mysql_query($sql);
                        $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                        mysql_query($sql);
                    }
######################################################################################################################################################
                }else{
                    $sql_one_write = 'hero_review_idx, hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today';
                    $sql_two_write = '\''.$good_idx.'\', \''.$_GET['hero_old_idx'].'\', \''.$temp_code.'\', \''.$review_list['hero_table'].'\', \''.$_POST['type'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'(당일 포인트 초과)\', \''.$_SESSION['temp_name'].'\', \'0\', \''.Ymdhis.'\'';
        //            $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        //            mysql_query($sql);
                }
######################################################################################################################################################
            }
        }
    }else if(!strcmp($_POST['mode'],'review_depth')){
        $sql_one_update = 'hero_command=\''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\'';
echo        $sql = 'UPDATE review SET '.$sql_one_update.' WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
//        sql($sql, 'on');
        exit;
    }else{
        $sql_one_update = 'hero_command=\''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\'';
        $sql = 'UPDATE review SET '.$sql_one_update.' WHERE hero_idx = \''.$_POST['mode'].'\';';
        sql($sql, 'on');
    }
}else if(!strcmp($_POST['type'],'review_edit')){
    $sql = 'select * from review where hero_idx = \''.$_GET['hero_old_idx'].'\';';
    sql($sql, 'on');
    $review_list                             = @mysql_fetch_assoc($out_sql);
    $out = $review_list['hero_command'];
        echo iconv('EUC-KR', 'UTF-8', $out);
}else if(!strcmp($_POST['type'],'review_drop')){

    $sql = 'SELECT * FROM review WHERE hero_idx = \''.$_GET['hero_old_idx'].'\';';
    sql($sql, 'on');
    $drop_sql                             = @mysql_fetch_assoc($out_sql);
    $drop_sql = 'SELECT * FROM point WHERE hero_code=\''.$drop_sql['hero_code'].'\' and hero_table=\''.$drop_sql['hero_table'].'\' and hero_review_idx = \''.$_GET['hero_old_idx'].'\';';
    $out_drop_sql = @mysql_query($drop_sql);
    while($drop_list                             = @mysql_fetch_assoc($out_drop_sql)){
        $member_sql = 'SELECT * FROM member WHERE hero_code=\''.$drop_list['hero_code'].'\';';
        $out_member_sql = @mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member_sql);
        $last_member_point = $member_list['hero_point']-$drop_list['hero_point'];
        $sql = 'UPDATE member SET hero_point=\''.$last_member_point.'\' WHERE hero_id = \''.$drop_list['hero_id'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
    $sql = 'select * from board where hero_idx = \''.$_GET['old_idx'].'\';';
    sql($sql, 'on');
    $delete_list                             = @mysql_fetch_assoc($out_sql);
    $delete_count = $delete_list['hero_review_count']-1;
    $sql = 'UPDATE board SET hero_review_count=\''.$delete_count.'\' WHERE hero_idx = \''.$_GET['old_idx'].'\';';
    sql($sql);
    $sql = 'DELETE FROM point WHERE hero_review_idx = \''.$_GET['hero_old_idx'].'\';';
    sql($sql);
    $sql = 'DELETE FROM review WHERE hero_idx = \''.$_GET['hero_old_idx'].'\';';
    sql($sql);

}else if(!strcmp($_POST['type'],'review_depth')){

    $out = $_GET['hero_old_idx']."ddr";
//    hero_depth_idx=$_GET['hero_idx'];
    echo iconv('EUC-KR', 'UTF-8', $out);

}
?>