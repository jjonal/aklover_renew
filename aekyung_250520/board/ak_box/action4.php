<?
if(!strcmp($_GET['action'], 'delete')){
    $msg .= '삭제';
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
    $sql = 'select * from mission where hero_idx=\''.$_GET['idx'].'\';';
    sql($sql, 'on');
    $list                             = @mysql_fetch_assoc($out_sql);
//    @unlink(USER_FILE_INC_END.$list['hero_board_one']);

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
    $sql = 'select * from board where hero_table=\''.$_GET['board'].'\' and hero_01=\''.$_GET['idx'].'\';';
    sql($sql, 'on');
    while($list                             = @mysql_fetch_assoc($out_sql)){
        $drop_action_img = $list['hero_command'];
        $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
        preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
        while(list($code_key, $code_val) = @each($code_main[1])){
            if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
                    $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
//                    @unlink($check_file);
            }else{
                continue;
            }
        }
    }

    $sql = 'DELETE FROM mission_review WHERE hero_old_idx = \''.$_GET['idx'].'\';';
    sql($sql);
    $sql = 'DELETE FROM point WHERE hero_table=\''.$_GET['board'].'\' and hero_old_idx = \''.$_GET['idx'].'\';';
    @mysql_query($sql);
    $sql = 'DELETE FROM mission WHERE hero_table=\''.$_GET['board'].'\' and hero_idx = \''.$_GET['idx'].'\';';
    @mysql_query($sql);
    $sql = 'DELETE FROM board WHERE hero_table=\''.$_GET['board'].'\' and hero_01 = \''.$_GET['idx'].'\';';
    @mysql_query($sql);
}else{
//    msg('잘못된 경로 입니다.','location.href="./out.php"');
    exit;
}
$action_href = PATH_HOME.'?'.$get_herf;
msg($msg.' 되었습니다.','location.href="'.$action_href.'"');
exit;
?>