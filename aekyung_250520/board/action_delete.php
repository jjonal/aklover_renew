<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_GET['action'], 'delete')){
    if(!strcmp($_GET['next_board'],"hero")){
        $hero_table = 'hero';
    }else{
        $hero_table = $_REQUEST['board'];
    }
    
    $msg .= '삭제 되었습니다.';
    $get_herf = get('view||action||idx||page','','');
	/*
    $drop_sql = 'SELECT * FROM point WHERE hero_table=\''.$hero_table.'\' and hero_old_idx = \''.$_GET['idx'].'\';';
    $out_drop_sql = @mysql_query($drop_sql);
    while($drop_list                             = @mysql_fetch_assoc($out_drop_sql)){
        $member_sql = 'SELECT * FROM member WHERE hero_code=\''.$drop_list['hero_code'].'\';';
        $out_member_sql = @mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member_sql);
        $last_member_point = $member_list['hero_point']-$drop_list['hero_point'];
        $sql = 'UPDATE member SET hero_point=\''.$last_member_point.'\' WHERE hero_code = \''.$drop_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
	*/
    $delect_sql = 'select * from board where hero_idx=\''.$_GET['idx'].'\';';
    $out_delect_sql = @mysql_query($delect_sql);
    $delect_list = @mysql_fetch_assoc($out_delect_sql);
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
	//프로세스 순서 해당 포인트 삭제 -> 해당 글 삭제
	pointDel($_GET['idx'],$hero_table,"mission_write");
	
	//echo "pointDel";
	//exit();
	
    $sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_GET['idx'].'\';';
    sql($sql);
    $sql = 'DELETE FROM board WHERE hero_table=\''.$hero_table.'\' and hero_idx = \''.$_GET['idx'].'\';';
    @mysql_query($sql);

    echo "<script>window.history.back();</script>";
}
?>