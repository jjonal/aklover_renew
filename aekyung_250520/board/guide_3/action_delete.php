<?
######################################################################################################################################################
if(!strcmp($_GET['action'], 'delete')){
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

    // 댓글 삭제 전 데이터 저장 S musign 25.07.10 jnr
    $review_sql = "SELECT r.hero_code, r.hero_table, r.hero_command, r.hero_today 
               FROM review r 
               WHERE r.hero_old_idx = '".$_REQUEST['idx']."'";
    $review_result = @mysql_query($review_sql);
    // 댓글 데이터가 있다면 삭제 이력 테이블에 저장 (조회되는 여러value가 있을수 있기에 foreach문으로 처리)
    while($review = @mysql_fetch_assoc($review_result)) {
        $save_sql = "INSERT INTO board_del 
                 (hero_code, hero_table, hero_command, hero_today, content_type) 
                 VALUES (
                     '".addslashes($review['hero_code'])."',
                     '".addslashes($review['hero_table'])."',
                     '".addslashes($review['hero_command'])."',
                     '".$review['hero_today']."',
                     'reply'
                 )";
        @mysql_query($save_sql);
    }

    $review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($review_drop_sql);

    // 댓글 삭제 전 데이터 저장 musign 25.07.10 jnr
    // 게시글 삭제 전 데이터 저장
    $board_sql = "SELECT b.hero_code, b.hero_table, b.hero_command, b.hero_today 
              FROM board b 
              WHERE b.hero_idx = '".$_REQUEST['idx']."'";
    $board_result = @mysql_query($board_sql);
    $board = @mysql_fetch_assoc($board_result);

    if($board) {
        $save_sql = "INSERT INTO board_del 
                 (hero_code, hero_table, hero_command, hero_today, content_type) 
                 VALUES (
                     '".addslashes($board['hero_code'])."',
                     '".addslashes($board['hero_table'])."',
                     '".addslashes($board['hero_command'])."',
                     '".$board['hero_today']."',
                     'board'
                 )";
        @mysql_query($save_sql);
    }
    // 댓글 삭제 전 데이터 저장 E musign 25.07.10 jnr

    $board_select_sql = 'select * from board WHERE hero_idx=\''.$_REQUEST['idx'].'\';';
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
    @mysql_query($board_drop_sql);
    $msg = '삭제 되었습니다.';
    $get_herf = get('next_board||view||action||idx||page','','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
?>