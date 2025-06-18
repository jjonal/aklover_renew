<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if(!$_GET['board'] || !$_SESSION["global_code"]){
	error_historyBack("잘못된 접근입니다.");
	exit;
} 

$hero_code = $_SESSION["global_code"];

$result = false;

$FILE_NAME = 'hero_file';
$USER_FILE_NAME = $_FILES[$FILE_NAME]['name'];
$USER_TEMP_FILE_NAME = $_FILES[$FILE_NAME]['tmp_name'];
$userfile_count = count($USER_FILE_NAME);

if($_GET["action"] == "write") {
	if(strcmp($userfile_count,"0")){
		while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
			$FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로
			if(strcmp($FILE_LOW,"")){
				$FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;
				
				if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){//파일이 없을때
					@copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
					$upload_column .= ", ".$FILE_NAME;
					$upload_val .= ", '".$FILE_NEW_NAME."'";
	
					$upload_column .= ", hero_ori_file";
					$upload_val .= ", '".$FILE_LOW."'";
		
				}
			}
		}
	}

	$insert_sql  = " INSERT INTO global_board (hero_code, hero_table, board_code, hero_title, hero_command ";
	$insert_sql .= " , hero_today, hero_use_yn, hero_notice, hero_temp, hero_pcMobile ";
	if($userfile_count > 0) {
		$insert_sql .= $upload_column;
	}
	$insert_sql .= " ) VALUES ";
	$insert_sql .= " ('".$hero_code."','".$_POST["hero_table"]."','".$_POST["board_code"]."','".$_POST["hero_title"]."' ,'".$_POST["hero_command"]."' ";
	$insert_sql .= " ,now(),'Y','".$_POST["hero_notice"]."','".$_POST["hero_temp"]."','".$_POST["hero_pcMobile"]."' ";
	if($userfile_count > 0) {
		$insert_sql .= $upload_val;
	}
	$insert_sql .= " ) ";
	
	$result = sql($insert_sql,"on");
	
	$msg = "등록되었습니다.";
	
	if($result) {
		message($msg);
		location("globalQnaList.php?board=".$_GET["board"]);
	}
} else if($_GET["action"] == "edit") {
	if(strcmp($userfile_count,"0")){
		while(list($USER_FILE_NAME_KEY, $USER_FILE_NAME_VAL) = each($USER_FILE_NAME)){
	
			$FILE_LOW = strtolower($USER_FILE_NAME_VAL);//소문자로
	
			if(strcmp($FILE_LOW,"")){
				$FILE_NEW_NAME= Y_m_d_h_i_s.'_'.$FILE_LOW;
	
				if(strcmp(is_file(USER_FILE_INC_END.$FILE_NEW_NAME),"1")){//파일이 없을때
	
					@copy($USER_TEMP_FILE_NAME[$USER_FILE_NAME_KEY], USER_FILE_INC_END.$FILE_NEW_NAME);
					$upload_column .= ", ".$FILE_NAME." = '".$FILE_NEW_NAME."' ";
					$upload_column .= ", hero_ori_file = '".$FILE_LOW."' ";
				}
			}
		}
	}
	
	$edit_sql  = " UPDATE global_board SET ";
	$edit_sql .= " hero_title = '".$_POST["hero_title"]."' ";
	$edit_sql .= " , hero_command = '".$_POST["hero_command"]."' ";
	$edit_sql .= " , hero_notice = '".$_POST["hero_notice"]."' ";
	$edit_sql .= " , hero_temp = '".$_POST["hero_temp"]."' ";
	$edit_sql .= " , hero_pcMobile = '".$_POST["hero_pcMobile"]."' ";
	if($userfile_count > 0) {
		$edit_sql .= $upload_column;
	}
	$edit_sql .= " WHERE hero_idx = '".$_POST["hero_idx"]."' ";
	
	$result = sql($edit_sql,"on");
	
	$msg = "수정되었습니다.";
	
	if($result) {
		message($msg);
		location("globalQnaWrite.php?board=".$_GET["board"]."&hero_idx=".$_POST["hero_idx"]);
	}
} else if($_GET["action"] == "drop") {
	$drop_sql = " UPDATE global_board SET hero_use_yn = 'N' WHERE hero_idx = '".$_POST["hero_idx"]."' ";
	
	$result = sql($drop_sql,"on");
	
	$msg = "삭제되었습니다.";
	
	if($result) {
		message($msg);
		location("globalQnaList.php?board=".$_GET["board"]);
	}
}