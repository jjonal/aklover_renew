<?
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(!strcmp($_GET['action'], 'delete') && $_GET['idx']){

	$full_today		=		date("Y-m-d H:i:s");
	$today 			=		substr($full_today,0,10);
	$hero_code 		= 		$_SESSION['temp_code'];
	$id				=		$_SESSION['temp_id'];
	$name			=		$_SESSION['temp_name'];
	$nick			=		$_SESSION['temp_nick'];

	$idx			=		$_GET['idx'];
	
	if(!$hero_code || !$name){	error_historyBack("잘못된 접근입니다.");exit;}
	
	//프로세스 순서 해당 포인트 삭제 -> 해당 글 삭제
	pointDel($_GET['idx'] ,$_GET['board'],"mission_write");
	
	$recommand_drop_sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$_REQUEST['idx'].'\';';
	@mysql_query($recommand_drop_sql);
	
	$recommand_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
	@mysql_query($recommand_drop_sql);
	
	$board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_REQUEST['idx'].'\';';
	@mysql_query($board_drop_sql);
	
	$mission_url_drop_sql = " DELETE FROM mission_url WHERE board_hero_idx = '".$_REQUEST['idx']."' ";
	@mysql_query($mission_url_drop_sql);
	
	/* 160518 삭제
	 *  $deleteBoardSql = "delete from board where hero_idx='".$idx."'";
	//echo $deleteBoardSql;
	$deleteBoardRes = mysql_query($deleteBoardSql);
	if(!$deleteBoardRes){
		
		logging_error($hero_code,$board."-DEL_02_01 : ".$deleteBoardSql,$full_today);
		error_historyBack("");
		exit;
		
	}
	
	$deletePointSql = "delete from point where hero_old_idx='".$idx."' and hero_code='".$hero_code."'";
	$deletePointRes = mysql_query($deletePointSql);
	if(!$deletePointRes){
		
		logging_error($hero_code,$board."-DEL_02_02 : ".$deletePointSql,$full_today);
		error_historyBack("");
		exit;
	}
	
	
	$selectMemberSql = "select sum(hero_point) as heroSumPoint from point where hero_code='".$hero_code."'";
	//echo $selectMemberSql;
	$selectMemberRes = mysql_query($selectMemberSql);
	if(!$selectMemberRes){
		logging_error($hero_code,$board."-DEL_02_03 : ".$selectMemberSql,$full_today);
		error_historyBack("");
		exit;
	}
	
	$selectMemberRs = mysql_fetch_assoc($selectMemberRes);
	
	$updateMemberSql = "update member set hero_point='".$selectMemberRs['heroSumPoint']."' where hero_code='".$hero_code."'";
	//echo $updateMemberSql;
	$updateMemberRs = mysql_query($updateMemberSql);
	if(!$updateMemberRs){
	
		logging_error($hero_code,$board."-DEL_02_04 : ".$updateMemberSql,$full_today);
		error_historyBack("");
		exit;
	} */
	
	//일반미션, 프리미엄 미션의 경우 -> 생생후기로 이동
	if($_GET['board']=='group_04_05' || $_GET['board']=='group_04_06')	$board = "group_04_09";
	else																$board = $_GET['board']; 
		
	$get_herf = "board=".$board."&page=".$_GET['page'];
	$action_href = PATH_HOME.'?'.$get_herf;
	location($action_href);
	
	
/* 	
    $review_sql = 'select * from review WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
    $out_review = @mysql_query($review_sql);
 */    
/* 
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
*/
/*     
    $review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($review_drop_sql);
*/
/* 
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
*/
/*
    $drop_point_sql = 'select * from point WHERE hero_old_idx = \''.$_REQUEST['idx'].'\';';
    $out_drop_point = @mysql_query($drop_point_sql);
    while($drop_point_list                             = @mysql_fetch_assoc($out_drop_point)){
        $point_sql = 'DELETE FROM point WHERE hero_idx = \''.$drop_point_list['hero_idx'].'\';';
        @mysql_query($point_sql);
        $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$drop_point_list['hero_code'].'\';';
        $out_member_total_sql = @mysql_query($member_total_sql);
        $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
        $member_total_point = $member_total_list['member_total'];
        $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$drop_point_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
*/
    /* 
    $recommand_drop_sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($recommand_drop_sql);

    $board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_REQUEST['idx'].'\';';
    @mysql_query($board_drop_sql); 
    
    $msg = '삭제 되었습11니다.';
    msg($msg,'location.href="'.$action_href.'"');
    */ 
   
   
}
?>