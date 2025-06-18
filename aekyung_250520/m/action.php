<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if(!strcmp($_SESSION['temp_level'], '')){
	error_location('비정상적인 접근입니다. 로그인 후에 다시 시도해 주세요.', '/main/index.php?board=login');
	exit;
}

	$full_today = date( "Y-m-d H:i:s");
	$today = date( "Y-m-d", time());

	$my_code 		= 		$_SESSION['temp_code'];
    $my_level 		= 		$_SESSION['temp_level'];
    $my_write 		= 		$_SESSION['temp_write'];
    $my_view 		= 		$_SESSION['temp_view'];
    $my_update 		= 		$_SESSION['temp_update'];
    $my_rev 		= 		$_SESSION['temp_rev'];
    $my_id			=		$_SESSION['temp_id'];
    $my_name		=		$_SESSION['temp_name'];
    $my_nick		=		$_SESSION['temp_nick'];    
	
	$idx 			=		$_GET['idx'];
	$action			=		$_GET['action'];
	$board			=		$_GET['board'];
	$page			=		$_GET['page'];
	$next_board		=		$_GET['next_board'];
	
	$hero_table		= 		$_POST['hero_table'];
	$hero_title	 	= 		$_POST['hero_title'];
	$command 		=		$_POST['command'];
	$image_temp		= 		$_POST['image_temp'];
	
	$drop_check 	= 		explode('||', $_POST['hero_drop']);
	$point_type		=		"total";
	

//파일 업로드
######################################################################################################################################################
if(($action=='update' && is_numeric($idx)) || $action=='write'){
	
	$image_names = imageUploader($_FILES['hero_image'],false,true);
	if(substr($image_names[0],0,7)=='message'){
		$image_message = explode(":",$image_names[0][1]);
		error_historyBack($image_message[1]);
		exit; 
	}elseif($image_names[0]===0){
		error_historyBack("");
		exit;
	}
		
	$i=0;
		
	foreach ($image_names as $image_name){	
		$fileUrl = "/user/photo/".date('Y')."_".date('m')."/"; //썸네일 처리
		if(!$image_command) $image_command = "<div style='text-align:center;'>";
		if($image_name!='noFile'){
			$image_command .= "<img src='".$fileUrl.$image_name."'/><br /><br />";
		}elseif($image_temp[$i]){
			$image_tmp = str_replace("\'","'",$image_temp[$i]);
			$image_command .= $image_tmp."<br /><br />";
		}
		$i++;
	}
		
	if($image_command) $image_command .= "</div>";
	
	$hero_command = nl2br($command);
	if($image_command)	$hero_command .= "<br class='Mobile'/><br /><br />".$image_command;
	$hero_command = addslashes($hero_command);
	
	$FILE_NAME = 'hero_board_one';
	$USER_FILE_NAME = $HTTP_POST_FILES[$FILE_NAME]['name'];
	
	$USER_TEMP_FILE_NAME = $HTTP_POST_FILES[$FILE_NAME]['tmp_name'];
	
	$userfile_count = count($USER_FILE_NAME);
	while(list($drop_key, $drop_val) = each($drop_check)){
		unset($_POST[$drop_val]);
	}
}
	
if($action=='update' && is_numeric($idx) && $hero_title){

    $sql_one_update .= "hero_command = '".$hero_command."'";
	if($hero_thumb)						$sql_one_update .= ", hero_thumb = '".$hero_thumb."'";

	if(strcmp($userfile_count,"0")){
		while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
			$FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로
			if(strcmp($FILE_LOW,"")){
				$FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;
				if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){//파일이 없을때
					@copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
					$sql_one_update .= ", ".$FILE_NAME." = '".$FILE_NEW_NAME."'";
					$sql_one_update .= ", hero_board_two = '".$FILE_LOW."'";
				}
			}
		}
	}
	
	if($_POST["hero_notice_use"]) {
		$sql_one_update .= ", hero_notice_use = '".$_POST["hero_notice_use"]."' ";
	} else {
		$sql_one_update .= ", hero_notice_use = '0' ";
	}
	
	unset($_POST["hero_notice_use"]);
	
	foreach ($_POST as $post_key => $post_val) {
		$sql_one_update .= ",".$post_key."='".$post_val."'";
	}

    $error = "M_ACTION_01";
    $sql = "UPDATE board SET ".$sql_one_update." WHERE hero_idx = '".$_GET['idx']."'";

    $update_pf = new_sql($sql,$error,"on");
    
    if((string)$update_pf==$error){
    	error_historyBack("");
    	exit;
    }
    
    $get_href = get('view||action||next_board','next_board='.$_POST['hero_table'].'&view=view','');

} else if(!strcmp($action, 'write') && $hero_title){
	
	$error = "M_ACTION_02";
	$duplecateInsertCheck  = " SELECT hero_idx, hero_table FROM board WHERE hero_code='".$my_code."' AND hero_title='".$hero_title."' ";
	$duplecateInsertCheck .= " AND hero_table='".$hero_table."' AND left(hero_today,10)='".$today."'";
	
	$duplecateInsertCheck_res = new_sql($duplecateInsertCheck,$error,"on");
	if((string)$duplecateInsertCheck_res==$error){
		error_historyBack("");
		exit;
	}
	
	$check_rs = mysql_fetch_assoc($duplecateInsertCheck_res);
	
	if($check_rs['hero_idx']){
		//$href = "/m/board_view_01.php?board=".$board."&page=1&hero_idx=".$check_rs['hero_idx'];
		$href = $_SERVER['HTTP_REFERER'];
		error_location('해당 글은 이미 등록되었습니다.',$href );
		exit;
	}
	
	while(list($drop_key, $drop_val) = each($drop_check)){ //필요없는 $_POST 제거
		unset($_POST[$drop_val]);
	}
	
	$error = "M_ACTION_03";
	$idx_sql = "SHOW TABLE STATUS LIKE 'board' ";

	$out_idx_sql = new_sql($idx_sql,$error);
	if((string)$out_idx_sql==$error){
		error_historyBack("");
		exit;
	}
	
	$idx_list                             = mysql_fetch_assoc($out_idx_sql);
	
	$good_idx = $idx_list['Auto_increment'];

	## 쿼리 셋팅
	######################################################################################################################################################
	$sql_one_write .= 'hero_idx, hero_03, hero_command';
	$sql_two_write .= "'".$good_idx."', '".$board."','".$hero_command."'";
	
	if(hero_thumb){
		$sql_one_write .= ", hero_thumb";
		$sql_two_write .= ", '".$hero_thumb."'";
	}
	
	foreach ($_POST as $post_key => $post_val) {
		$sql_one_write .= ", ".$post_key;
		$sql_two_write .= ", '".$post_val."'";
	}
	
	if(strcmp($userfile_count,"0")){
	
		while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
	
			$FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로
				
			if(strcmp($FILE_LOW,"")){
				$FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;
	
				if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){//파일이 없을때
						
					@copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
					$sql_one_write .= ", ".$FILE_NAME;
					$sql_two_write .= ", '".$FILE_NEW_NAME."'";
	
					$sql_one_write .= ", hero_board_two";
					$sql_two_write .= ", '".$FILE_LOW."'";
						
				}
			}
		}
	}
	
	$error = "M_ACTION_04";
    $sql = "INSERT INTO board (".$sql_one_write.") VALUES (".$sql_two_write.");";

    $insert_pf = new_sql($sql,$error);
    if((string)$insert_pf==$error){
    	error_historyBack("글 저장에 실패 하였습니다.");
    	exit;
    }
    
    ##  포인트 및 등업체크
    ######################################################################################################################################################
    //포인트 부여 및 등업기능//테이블, write/reiew, 글 등록시 고유번호, 리뷰등록시 고유번호, 제목, 최대포인트 포함여부, 날짜
    $point_rs = pointAdd($board, $action, $good_idx, 0, 0, $hero_title, 'Y');
	
	if(substr($point_rs,0,7)=='message'){
			$point_rs = explode(":",$point_rs);
			message($point_rs[1]);
	}elseif($point_rs!=1){
	
		$rollback_query = "delete from board where hero_idx='".$idx."'";
		//echo $rollback_query;
		$pf_rollback = mysql_query($rollback_query);
		if(!$pf_rollback){
			logging_error($my_code, $idx."-M_ACTION_05 : ".$rollback_query, $full_today);
		}
		logging_error($my_code, $idx."-M_ACTION_09 : ".$point_rs, $full_today);
		error_historyBack("");
		exit;
	}
    
    ## href 셋팅
	######################################################################################################################################################
	$get_href = get('view||action||idx||page','','');
    
    
    
######################################################################################################################################################
} else if(!strcmp($_GET['action'], 'delete')){

	//$msg .= '삭제 되었습니다.';
	
    /* 160519 삭제
     * $drop_sql = 'SELECT * FROM point WHERE hero_table=\''.$board.'\' and hero_old_idx = \''.$idx.'\';';
    $out_drop_sql = new_sql($drop_sql,$error,'on');
    while($drop_list                             = @mysql_fetch_assoc($out_drop_sql)){
        $member_sql = 'SELECT * FROM member WHERE hero_code=\''.$drop_list['hero_code'].'\';';
        $out_member_sql = @mysql_query($member_sql);
        $member_list                             = @mysql_fetch_assoc($out_member_sql);
        $last_member_point = $member_list['hero_point']-$drop_list['hero_point'];
        $sql = 'UPDATE member SET hero_point=\''.$last_member_point.'\' WHERE hero_code = \''.$drop_list['hero_code'].'\';'.PHP_EOL;
        @mysql_query($sql);
    }
    $delect_sql = 'select * from board where hero_idx=\''.$idx.'\';';
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
    } */
	//프로세스 순서 해당 포인트 삭제 -> 해당 글 삭제
	pointDel($idx ,$board,"write");
	
	$sql = 'DELETE FROM hero_recommand WHERE hero_board_idx = \''.$idx.'\';'; //160519  추가
	@mysql_query($sql);
    $sql = 'DELETE FROM review WHERE hero_old_idx = \''.$idx.'\';';
    new_sql($sql,"on");
    /* $sql = 'DELETE FROM point WHERE hero_table=\''.$board.'\' and hero_old_idx = \''.$idx.'\';';
    @mysql_query($sql); */
    //$sql = 'DELETE FROM board WHERE hero_table=\''.$board.'\' and hero_idx = \''.$idx.'\';';
    $sql = 'DELETE FROM board WHERE hero_idx = \''.$idx.'\';'; //우수후기 때문에 수정
    @mysql_query($sql);
    
    //모바일 글자 깨짐 방지
    //$del_message = iconv("utf-8","euc-kr","삭제되었습니다");
    echo "<meta charset=\"EUC-KR\">";
    message("삭제되었습니다");
}else{
//    msg('잘못된 경로 입니다.','location.href="./out.php"');
    exit;
}

$links = array("group_01_01"=>"board_00.php",
				"group_01_02"=>"board_00.php",
				"group_01_03"=>"board_00.php",
				"group_01_04"=>"board_00.php",
				"group_04_11"=>"today.php",
				
				"group_02_01"=>"today.php",
				"group_02_02"=>"today.php",
				"group_03_04"=>"today.php",
				"group_03_05"=>"today.php",
				"group_02_05"=>"today.php",
				"group_02_06"=>"today.php",
		
				"group_04_01"=>"aklover.php",
				"group_04_02"=>"aklover.php",
				"group_03_01"=>"aklover.php",
				"group_05_01"=>"ranking.php",
				"group_03_03"=>"today.php",
				
				"group_04_03"=>"today.php",
				"group_04_04"=>"check.php",
				"group_02_03"=>"today.php",
				"group_04_05"=>"mission.php",
				"group_04_06"=>"mission.php",
				"group_04_07"=>"mission.php",
				"group_04_08"=>"mission.php",
				"group_04_09"=>"board_01.php",
				"group_04_10"=>"board_02.php",
				"group_04_20"=>"today.php",
				"group_04_21"=>"order.php",
				"group_04_24"=>"today.php",
				"group_04_26"=>"today.php",
				"group_04_27"=>"mission.php",
				"group_04_28"=>"mission.php",
				"group_04_29"=>"loyalAkLover.php",
		
				"cus_3"=>"customer.php"
		
		
			);
while($location = each($links)) {
	
	if($board==$location[key]){
		if($location[key] == "cus_3") {
			$action_href = "/m/".$location[value]."?board=".$board."&view_type=list&page=".$page;
		} else {
			$action_href = "/m/".$location[value]."?board=".$board."&page=".$page;
		}
		//echo $action_href;
		//exit;
		location($action_href);
		exit;
	}

}
echo "<script>location.href='/m/main.php'</script>";
exit;
?>