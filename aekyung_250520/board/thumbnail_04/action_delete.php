<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_GET['action'], 'delete')){

	/* 
    $review_sql = 'select * from review WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
    $out_review = @mysql_query($review_sql);
    while($review_list                             = @mysql_fetch_assoc($out_review)){
        $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$review_list['hero_idx'].'\';';
        @mysql_query($point_sql);
        $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$review_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
    $review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($review_drop_sql);
     */
	
/*     $board_select_sql = 'select * from board WHERE hero_idx=\''.$_REQUEST['idx'].'\';';
    $out_board_select = @mysql_query($board_select_sql);
    $board_select_list                             = @mysql_fetch_assoc($out_board_select);
//    @unlink(USER_FILE_INC_END.$board_select_list['hero_board_one']);

    $drop_action_img = $board_select_list['hero_command'];
    $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
    preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
    while(list($code_key, $code_val) = @each($code_main[1])){
        if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
            $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
//            @unlink($check_file);
        }else{
            continue;
        }
    }
    $recommand_drop_sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($recommand_drop_sql);

    $board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($board_drop_sql); */
    
    //프로세스 순서 해당 포인트 삭제 -> 해당 글 삭제
    pointDel($_REQUEST['idx'] ,$_GET['board'],"mission_write");
    
    $board_sql = "select hero_table, hero_01_bak from board order by hero_idx desc limit 1";
    $board_res = sql($board_sql);
    $board_rs = mysql_fetch_assoc($board_res);
    $board_table = $board_rs['hero_table'];
    $hero_01_bak = $board_rs['hero_01_bak'];
    
    if($board_table == 'group_04_22') {
        $mission_after_sql = "select hero_old_idx from mission_after where hero_idx=".$hero_01_bak;
        $mission_after_res = sql($mission_after_sql);
        $mission_after_rs = mysql_fetch_assoc($mission_after_res);
        $mission_after_old_idx = $mission_after_rs['hero_old_idx'];
        
        $hero_old_idx_value = str_replace($_REQUEST['idx'].",", "", $mission_after_old_idx);
        $mission_after_update = "update mission_after set hero_old_idx ='".$hero_old_idx_value."' where hero_idx=".$hero_01_bak;
        $pf = mysql_query($mission_after_update);
    }
    
    
    $recommand_drop_sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($recommand_drop_sql);
    
    $board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($board_drop_sql);
    
    $mission_url_drop_sql = " DELETE FROM mission_url WHERE board_hero_idx = '".$_REQUEST['idx']."' ";
    @mysql_query($mission_url_drop_sql);
    
    $msg = '삭제 되었습니다.';
    $get_herf = get('next_board||view||action||idx||page','','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
?>