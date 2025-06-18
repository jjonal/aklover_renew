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
    $_SESSION['temp_view'] = '0';
    $_SESSION['temp_update'] = '0';
    $_SESSION['temp_rev'] = '0';
}
######################################################################################################################################################
$board_sql = 'select * from board where hero_idx = \''.$_REQUEST['board_idx'].'\';';
sql($board_sql, 'on');
$board_list                            = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
if(!strcmp($board_list['hero_table'],'hero')){
    $group_table_name = $board_list['hero_03'];
}else{
    $group_table_name = $board_list['hero_table'];
}
$group_sql = 'select hero_title,hero_rev_point from hero_group where hero_board =\''.$group_table_name.'\';';//desc
$out_group_sql = @mysql_query($group_sql);
$group_list                             = @mysql_fetch_assoc($out_group_sql);
$group_point = $group_list['hero_rev_point'];//리뷰 획득포인트
######################################################################################################################################################
$today_total_sql = 'select hero_point from today where hero_type=\'hero_total\'';
$out_today_total_sql = @mysql_query($today_total_sql);
$today_total_list                             = @mysql_fetch_assoc($out_today_total_sql);
$point_total_point = $today_total_list['hero_point'];//당일 최대 획득포인트


$today_rev_sql = 'select hero_point from today where hero_type=\'hero_rev\'';
$out_today_rev_sql = @mysql_query($today_rev_sql);
$today_rev_list                             = @mysql_fetch_assoc($out_today_rev_sql);
$point_rev_point = $today_rev_list['hero_point'];//리뷰 당일 최대 포인트
######################################################################################################################################################
$today_user_total_sql = 'select SUM(hero_point) as today_user_total from point where date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$_SESSION['temp_code'].'\' and hero_include_maxpoint="Y";';

$out_today_user_total_sql = @mysql_query($today_user_total_sql);
$today_user_total_list                             = @mysql_fetch_assoc($out_today_user_total_sql);
$today_user_total = $today_user_total_list['today_user_total'];


$today_user_rev_sql = 'select SUM(hero_point) as today_user_rev from point where hero_type=\'review\' and date(hero_today)=\''.date( "Y-m-d", time()).'\' and hero_code=\''.$_SESSION['temp_code'].'\';';
$out_today_user_rev_sql = @mysql_query($today_user_rev_sql);
$today_user_rev_list                             = @mysql_fetch_assoc($out_today_user_rev_sql);
$today_user_rev = $today_user_rev_list['today_user_rev'];
######################################################################################################################################################
$review_total_sql = 'select * from review where hero_old_idx = \''.$_REQUEST['save_id'].'\';';
$out_review_total_sql = @mysql_query($review_total_sql);
$review_total = @mysql_num_rows($out_review_total_sql)+1;

if(!strcmp($_REQUEST['mode'],'review_write')){
######################################################################################################################################################
    $auto_sql = 'SHOW TABLE STATUS LIKE \'review\'';
    $out_auto_sql = @mysql_query($auto_sql);
    $auto_list                               = @mysql_fetch_assoc($out_auto_sql);
    $auto_idx = $auto_list['Auto_increment'];

    $sql_one_write = 'hero_idx, hero_depth_idx_old, hero_depth_idx, hero_code, hero_table, hero_old_idx, hero_name, hero_today, hero_command';
    $sql_two_write = '\''.$auto_idx.'\', \''.$auto_idx.'\', \''.$auto_idx.'\', \''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \''.$_REQUEST['board_idx'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\', \''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\'';
    $sql = 'INSERT INTO review ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
    @mysql_query($sql);

    if($point_total_point>$today_user_total){
        $sql_one_write = 'hero_review_idx, hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today, hero_include_maxpoint';
        $sql_two_write = '\''.$auto_idx.'\', \''.$_REQUEST['board_idx'].'\', \''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \''.$_POST['type'].'\', \''.$_SESSION['temp_id'].'\', \''.$group_list['hero_title'].'\', \''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\', \''.$_SESSION['temp_name'].'\', \''.$group_list['hero_rev_point'].'\', \''.Ymdhis.'\', \'Y\'';
        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        @mysql_query($sql);
    }
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
    }else{
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
######################################################################################################################################################
}else if(!strcmp($_REQUEST['mode'],'review_depth')){
######################################################################################################################################################
    $auto_sql = 'SHOW TABLE STATUS LIKE \'review\'';
    $out_auto_sql = @mysql_query($auto_sql);
    $auto_list                               = @mysql_fetch_assoc($out_auto_sql);
    $auto_idx = $auto_list['Auto_increment'];
    $review_depth_sql = 'select hero_depth from review where hero_idx=\''.$_REQUEST['save_id'].'\';';
    $out_review_depth = @mysql_query($review_depth_sql);
    $review_depth_list                             = @mysql_fetch_assoc($out_review_depth);
    $hero_create_depth = $review_depth_list['hero_depth']+1;

    $sql_one_write = 'hero_idx, hero_depth_idx_old, hero_depth, hero_depth_idx, hero_code, hero_table, hero_old_idx, hero_name, hero_today, hero_command';
    $sql_two_write = '\''.$auto_idx.'\', \''.$_REQUEST['save_id_old'].'\', \''.$hero_create_depth.'\', \''.$_REQUEST['save_id'].'\', \''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \''.$_REQUEST['board_idx'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\', \''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\'';
    $sql = 'INSERT INTO review ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
    @mysql_query($sql);

    if($point_total_point>$today_user_total){
        $sql_one_write = 'hero_review_idx, hero_old_idx, hero_code, hero_table, hero_type, hero_id, hero_top_title, hero_title, hero_name, hero_point, hero_today, hero_include_maxpoint';
        $sql_two_write = '\''.$auto_idx.'\', \''.$_REQUEST['board_idx'].'\', \''.$_SESSION['temp_code'].'\', \''.$group_table_name.'\', \''.$_POST['type'].'\', \''.$_SESSION['temp_id'].'\', \''.$group_list['hero_title'].'\', \''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\', \''.$_SESSION['temp_name'].'\', \''.$group_list['hero_rev_point'].'\', \''.Ymdhis.'\', \'Y\'';
        $sql = 'INSERT INTO point ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
        @mysql_query($sql);
    }
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
    }else{
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
######################################################################################################################################################
}else if(!strcmp($_REQUEST['type'],'review_edit')){
######################################################################################################################################################
    $sql_one_update = 'hero_command=\''.iconv('UTF-8', 'EUC-KR', $_POST['input_chat']).'\'';
    $sql = 'UPDATE review SET '.$sql_one_update.' WHERE hero_idx = \''.$_REQUEST['hero_idx'].'\';';
    @mysql_query($sql);
######################################################################################################################################################
}
if(!strcmp($_REQUEST['type'],'review_edit_action')){
######################################################################################################################################################
    $sql = 'select * from review where hero_idx = \''.$_GET['hero_idx'].'\';';
    $out_sql = @mysql_query($sql);
    $review_list                             = @mysql_fetch_assoc($out_sql);
    $out = $review_list['hero_command'];
    echo iconv('EUC-KR', 'UTF-8', $out);
######################################################################################################################################################
}else if(!strcmp($_REQUEST['type'],'review_drop')){
######################################################################################################################################################
    $check_01_sql = 'select * from review where hero_use is null and hero_depth_idx = \''.$_REQUEST['depth_idx_old'].'\';';
    $out_check_01 = @mysql_query($check_01_sql);
    $check_01_count = @mysql_num_rows($out_check_01);
    $check_02_sql = 'select * from review where hero_use is not null and hero_depth_idx = \''.$_REQUEST['depth_idx_old'].'\';';
    $out_check_02 = @mysql_query($check_02_sql);
    $check_02_count = @mysql_num_rows($out_check_02);
    if( (!strcmp($check_01_count,'1')) and (!strcmp($check_02_count,'1')) ){
        $check_01_list                             = @mysql_fetch_assoc($out_check_01);//삭제할글
        $check_02_list                             = @mysql_fetch_assoc($out_check_02);//먼저 삭제된글

        $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$check_01_list['hero_idx'].'\';';//삭제할글 포인트삭제
        $out_point = @mysql_query($point_sql);

        $update_select_sql = 'DELETE FROM review where hero_idx = \''.$check_01_list['hero_idx'].'\';';//삭제할글 삭제
        $out_update_select = @mysql_query($update_select_sql);

        $update_select_sql = 'DELETE FROM review where hero_idx = \''.$check_02_list['hero_idx'].'\';';//먼저 삭제된글 삭제
        $out_update_select = @mysql_query($update_select_sql);

        $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$check_01_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$check_01_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);

        exit;
    }
    $review_select_sql = 'select * from review where hero_depth_idx = \''.$_REQUEST['hero_idx'].'\';';
    $out_review_select = @mysql_query($review_select_sql);
    $review_select_count = @mysql_num_rows($out_review_select);
    if( (!strcmp($review_select_count,'0')) or (!strcmp($review_select_count,'1')) ){
        $review_select_sql = 'select * from review where hero_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_review_select = @mysql_query($review_select_sql);
        $review_select_list                             = @mysql_fetch_assoc($out_review_select);

        $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_point = @mysql_query($point_sql);
        $review_sql = 'DELETE FROM review WHERE hero_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_review = @mysql_query($review_sql);

        $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$review_select_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_select_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }else{
        $review_select_sql = 'select * from review where hero_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_review_select = @mysql_query($review_select_sql);
        $review_select_list                             = @mysql_fetch_assoc($out_review_select);

        $update_select_sql = 'UPDATE review SET hero_use=\'1\' where hero_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_update_select = @mysql_query($update_select_sql);

        $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_point = @mysql_query($point_sql);


        $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$review_select_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_select_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);

/*
모든 포인트 삭제
        $review_select_sql = 'select * from review where hero_depth_idx = \''.$_REQUEST['hero_idx'].'\';';
        $out_review_select = @mysql_query($review_select_sql);
        while($review_select_list                             = @mysql_fetch_assoc($out_review_select)){
            $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$review_select_list['hero_idx'].'\';';
            $out_point = @mysql_query($point_sql);
            $review_sql = 'DELETE FROM review WHERE hero_idx = \''.$review_select_list['hero_idx'].'\';';
            $out_review = @mysql_query($review_sql);

            $member_total_sql = 'select SUM(hero_point) as member_total from point where hero_code=\''.$review_select_list['hero_code'].'\';';
            $out_member_total_sql = @mysql_query($member_total_sql);
            $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
            $member_total_point = $member_total_list['member_total'];
            $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_select_list['hero_code'].'\';'.PHP_EOL;
            @mysql_query($sql);
        }
*/
    }
######################################################################################################################################################
}
?>