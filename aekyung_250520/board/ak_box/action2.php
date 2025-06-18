<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
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
$hero_table = 'mission';
$command = $_POST['command'];
$command = nl2br(htmlspecialchars($command));
$command = str_ireplace("<br />", "", $command);//글자 변경
$command = @str_ireplace('img', 'img', $command);
$check_img = @explode('&lt;img', $command);
while(list($check_key, $check_val) = @each($check_img)){
    if(!strcmp($check_key, '0')){
        continue;
    }
    $check_one = @explode('&gt;', $check_val);
    $check_two = $check_one['0'];
    $check_end = '&lt;img'.$check_two.'&gt;';
    if(!strcmp(eregi('naver',$check_end),'1')){
        $command = @str_ireplace($check_end, '', $command);
        $msg = '네이버 이미지는 삭제 되었습니다.';
    }else{
        continue;
    }
}
$command_img = @explode('src=\&quot;', $command);
while(list($img_key, $img_val) = @each($command_img)){
    if(!strcmp($img_key, '0')){
        continue;
    }
    $img_one = @explode('\&quot;', $img_val);

    $img_two = @explode('/', $img_one['0']);
    $img_count = @sizeof($img_two)-1;

    $last_img = $img_two[$img_count];

    $temp_file = USER_PHOTO_INC_END.$last_img;
    if(!strcmp($img_key, '1')){
        $first_img = @str_ireplace("temp_".$_SESSION['temp_id']."_", '', $img_one[0]);
        $next_img = @str_ireplace("temp_".$_SESSION['temp_id']."_", '', $last_img);
    }else{
        $next_img = @str_ireplace("temp_".$_SESSION['temp_id']."_", '', $last_img);
    }
    $hero_file = USER_PHOTO_INC_END.$next_img;
    @rename($temp_file, $hero_file);
}
$command = str_ireplace("temp_".$_SESSION['temp_id']."_", '', $command);//str_ireplace 대소문자 구분없이 //preg_replace()
$command = str_ireplace('&lt;a', '&lt;a target=\&quot;_BLANK\&quot;', $command);//대소문자 구분안하고 바꿀때 str_replace
$command = str_ireplace('onclick', 'on_click', $command);
######################################################################################################################################################
$drop_check = explode('||', $_POST['hero_drop']);
while(list($drop_key, $drop_val) = each($drop_check)){
    unset($_POST[$drop_val]);
}
$post_count = sizeof($_POST);
$post_i='1';

$sql = 'select * from '.$hero_table.' where hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
$list                             = @mysql_fetch_assoc($out_sql);
if(!strcmp($first_img, '')){
    $sql_one_update = '';
    $sql_one_write = '';
    $sql_two_write = '';
}else{
    $sql_one_update = 'hero_img_new = \''.$first_img.'\', ';
    $sql_one_write = 'hero_img_new, ';
    $sql_two_write = '\''.$first_img.'\', ';
}
$sql_one_update = $sql_one_update.'hero_command = \''.$command.'\', ';
$sql_one_write = $sql_one_write.'hero_command, ';
$sql_two_write = $sql_two_write.'\''.$command.'\', ';

if($_POST["hero_thumb"] && $_POST["hero_thumb"]!=$list["hero_thumb"]){
	$dest_file = $_SERVER["DOCUMENT_ROOT"].$_POST["hero_thumb"];

	$thumb_path = substr($_POST["hero_thumb"],0,strripos($_POST["hero_thumb"],"/")+1);
	$temp_file = "thum_".substr($_POST["hero_thumb"],strripos($_POST["hero_thumb"],"/")+1);
	$thumb_file = $_SERVER["DOCUMENT_ROOT"].$thumb_path.$temp_file;

	$im = thumbnail($dest_file, 289, 225);
	imagejpeg($im, $thumb_file,100);
	imagedestroy($im);

	$_POST["hero_thumb"] = $thumb_path.$temp_file;
}

while(list($post_key, $post_val) = each($_POST)){
    if(!strcmp($post_i, $post_count)){
        $comma = '';
    }else{
        $comma = ', ';
    }
    $sql_one_update .= $post_key.' = \''.$_POST[$post_key].'\''.$comma;
    $sql_one_write .= $post_key.$comma;
    $sql_two_write .= '\''.$post_val.'\''.$comma;
    $post_i++;
}
$FILE_NAME = 'hero_board_one';
$USER_FILE_NAME = $HTTP_POST_FILES[$FILE_NAME]['name'];
$USER_TEMP_FILE_NAME = $HTTP_POST_FILES[$FILE_NAME]['tmp_name'];
$userfile_count = count($USER_FILE_NAME);
if(strcmp($userfile_count,"0")){
    while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
        $FILE_UP = strtoupper($USER_FILE_NAME_VAL);//대문자
        $FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로
        if(strcmp($FILE_LOW,"")){
            $FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;
            if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){//파일이 없을때
                if(!strcmp($_GET['action'], 'update')){
//                    @unlink(USER_FILE_INC_END.$list['hero_board_one']);
                }
                @copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
                $sql_one_update .= ', '.$FILE_NAME.' = \''.$FILE_NEW_NAME.'\'';
                $sql_one_write .= ', '.$FILE_NAME;
                $sql_two_write .= ', \''.$FILE_NEW_NAME.'\'';

                $sql_one_update .= ', hero_board_two = \''.$FILE_LOW.'\'';
                $sql_one_write .= ', hero_board_two';
                $sql_two_write .= ', \''.$FILE_LOW.'\'';
            }else{
            }
        }
    }
}
if(!strcmp($_GET['action'], 'update')){
    $msg .= '수정 되었습니다.';
    $sql = 'UPDATE '.$hero_table.' SET '.$sql_one_update.' WHERE hero_idx = \''.$_GET['idx'].'\';';
    @mysql_query($sql);
    $get_herf = get('view||action','view=view','');
}else if(!strcmp($_GET['action'], 'write')){
######################################################################################################################################################
    $msg .= '입력 되었습니다.';
    $get_herf = get('view||action||idx||page','','');
    $idx_sql = 'SHOW TABLE STATUS LIKE \''.$hero_table.'\'';
    $out_idx_sql = @mysql_query($idx_sql);
    $idx_list                             = @mysql_fetch_assoc($out_idx_sql);
    $good_idx = $idx_list['Auto_increment'];
    $sql_one_write .= ', hero_idx';
    $sql_two_write .= ', \''.$good_idx.'\'';
    $sql = 'INSERT INTO '.$hero_table.' ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
    foreach (glob(USER_PHOTO_INC_END."temp_".$_SESSION['temp_id']."_*.*") as $filename) {
//        @unlink($filename);
    }
    @mysql_query($sql);
######################################################################################################################################################
    $sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
    sql($sql);
    $right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
    $temp_id = $_SESSION['temp_id'];
    $temp_code = $_SESSION['temp_code'];
    $temp_top_title = $right_list['hero_title'];
    $temp_title = $_POST['hero_title'];
    $temp_point = $right_list['hero_write_point'];
    $temp_idx = $_GET['idx'];
    if(!strcmp($temp_point, '')){
        $temp_point = '0';
    }else{
        $temp_point = $temp_point;
    }
######################################################################################################################################################
    if( (!strcmp($my_level, '0')) or (!strcmp($temp_point, '0')) ){
        //포인트는 없다
    }else{
        $member_sql = 'select * from member where hero_code=\''.$temp_code.'\'';
        $out_member = mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member);
        $total_point = $member_list['hero_point'];
        $total = $total_point+$temp_point;

        $today_sql = 'select * from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$temp_code.'\';';
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
            $level_sql = 'select * from level where hero_level!=\'0\' and hero_point_01<=\''.$total.'\' and hero_point_02>=\''.$total.'\'';
            $out_level = mysql_query($level_sql);
            $level_list                             = @mysql_fetch_assoc($out_level);
            $level_up_sql = 'select * from level_up where hero_number!=\'0\'';
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
                if(!strcmp($level_up_ok, '0')){
                    $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                    $sql_two_write = '\''.$good_idx.'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['action'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
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
                    if($level_list['hero_level']>$member_list['hero_level']){
                        $msg = '축하 합니다. 레벨 상승하셨습니다.';
                        $sql = 'UPDATE member SET hero_level=\''.$user_level_up.'\', hero_write=\''.$user_write_up.'\', hero_view=\''.$user_view_up.'\', hero_update=\''.$user_update_up.'\', hero_rev=\''.$user_rev_up.'\', hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                        mysql_query($sql);
//                        msg($msg,'');
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
                    $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                    $sql_two_write = '\''.$good_idx.'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['action'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                    $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                    mysql_query($sql);
                    $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                    mysql_query($sql);
                }
            }else{
                $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
                $sql_two_write = '\''.$good_idx.'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['action'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \''.$temp_point.'\', \''.Ymdhis.'\'';
                $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
                mysql_query($sql);
                $sql = 'UPDATE member SET hero_point=\''.$total.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
                mysql_query($sql);
            }
######################################################################################################################################################
        }else{
            $sql_one_write = 'hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today';
            $sql_two_write = '\''.$good_idx.'\', \''.$temp_code.'\', \''.$_GET['board'].'\', \''.$_GET['action'].'\', \''.$temp_id.'\', \''.$temp_top_title.'\', \''.$temp_title.'(당일 포인트 초과)\', \''.$_SESSION['temp_name'].'\', \''.$_SESSION['temp_nick'].'\', \'0\', \''.Ymdhis.'\'';
//            $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
//            mysql_query($sql);
        }
    }
######################################################################################################################################################
}else if(!strcmp($_GET['action'], 'delete')){
    $msg .= '삭제 되었습니다.';
    $get_herf = get('view||action||idx||page','','');
    $drop_sql = 'SELECT * FROM point WHERE hero_table=\''.$_GET['board'].'\' and hero_old_idx = \''.$_GET['idx'].'\';';

    $out_drop_sql = @mysql_query($drop_sql);
    while($drop_list                             = @mysql_fetch_assoc($out_drop_sql)){
        $member_sql = 'SELECT * FROM member WHERE hero_code=\''.$drop_list['hero_code'].'\';';
        $out_member_sql = @mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member_sql);
        $last_member_point = $member_list['hero_point']-$drop_list['hero_point'];
        $sql = 'UPDATE member SET hero_point=\''.$last_member_point.'\' WHERE hero_code = \''.$drop_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
    $delect_sql = 'select * from board where hero_idx=\''.$_GET['idx'].'\';';
    $out_delect_sql = @mysql_query($delect_sql);
    $delect_list                             = @mysql_fetch_assoc($out_delect_sql);
//    @unlink(USER_FILE_INC_END.$delect_list['hero_board_one']);

    $drop_action_img = $list['hero_command'];
    $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
    preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
    while(list($code_key, $code_val) = @each($code_main[1])){
        if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
                $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
//                @unlink($check_file);
        }else{
            continue;
        }
    }
    $sql = 'DELETE FROM mission_review WHERE hero_old_idx = \''.$_GET['idx'].'\';';
    sql($sql);
    $sql = 'DELETE FROM point WHERE hero_table=\''.$_GET['board'].'\' and hero_old_idx = \''.$_GET['idx'].'\';';
    @mysql_query($sql);
    $sql = 'DELETE FROM '.$hero_table.' WHERE hero_table=\''.$_GET['board'].'\' and hero_idx = \''.$_GET['idx'].'\';';
    @mysql_query($sql);

}else{
//    msg('잘못된 경로 입니다.','location.href="./out.php"');
    exit;
}
if(!strcmp($_GET['action'], 'update')){
    $drop_action_img = $list['hero_command'];
    $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";

    preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
    while(list($code_key, $code_val) = @each($code_main[1])){
        if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
            if(!strcmp(eregi($code_val,$command),'1')){
                continue;
            }else{
                $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
//                @unlink($check_file);
            }
        }else{
            continue;
        }
    }
}

$action_href = PATH_HOME.'?'.$get_herf;
msg($msg,'location.href="'.$action_href.'"');
exit;
?>