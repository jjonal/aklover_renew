<?
if(!defined('_HEROBOARD_'))exit;

if(!$_GET['board'] || $_SESSION["global_admin_yn"] != "Y"){
	error_historyBack("잘못된 접근입니다.");
	exit;
}

$command = $_POST['command'];

$command = nl2br(htmlspecialchars($command));
$command = str_ireplace("<br />", "", $command);//글자 변경
$command = @str_ireplace('img', 'img', $command);
$check_img = @explode('&lt;img', $command);
foreach($check_img as $check_key => $check_val) {
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
foreach($command_img as $img_key => $img_val) {
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

$result = false;
$hero_code = $_SESSION["global_code"];
$board = $_GET["board"];

if(isset($_FILES['guideFile1'])) {
	if(is_uploaded_file($_FILES['guideFile1']['tmp_name'])) {

		$sourcePath = $_FILES['guideFile1']['tmp_name'];
		$filePath = $_SERVER["DOCUMENT_ROOT"]."/user/file/";

		$fileName = $_FILES['guideFile1']['name'];
		$fileNewName= date('YmdHis').sprintf('%05d',mt_rand(0,99999));


		if(@move_uploaded_file($sourcePath,($filePath.$fileNewName))) {
			$guide_ori_file1 = $fileName;
			$guide_file1 = $fileNewName;
		}
	}
}

if(isset($_FILES['guideFile2'])) {
	if(is_uploaded_file($_FILES['guideFile2']['tmp_name'])) {

		$sourcePath = $_FILES['guideFile2']['tmp_name'];
		$filePath = $_SERVER["DOCUMENT_ROOT"]."/user/file/";

		$fileName = $_FILES['guideFile2']['name'];
		$fileNewName= date('YmdHis').sprintf('%05d',mt_rand(0,99999));


		if(@move_uploaded_file($sourcePath,($filePath.$fileNewName))) {
			$guide_ori_file2 = $fileName;
			$guide_file2 = $fileNewName;
		}
	}
}

if($_GET["action"] == "write") {
	$insert_sql  = " INSERT INTO global_mission (hero_code, hero_table, hero_country, hero_title, hero_title_02 ";
	$insert_sql .= " ,hero_product, hero_required, hero_tag, hero_tag_sub, hero_guide ";
	$insert_sql .= " , hero_help, hero_media, hero_start_date, hero_end_date , hero_today ";
	$insert_sql .= " , hero_thumb, hero_command ";
	if($guide_ori_file1) {
		$insert_sql .= ",guide_ori_file1, guide_file1";
	}
	if($guide_ori_file2) {
		$insert_sql .= ",guide_ori_file2, guide_file2";
	}
	$insert_sql .= " ) VALUES ";
	$insert_sql .= " ('".$hero_code."','".$board."','".$_POST["hero_country"]."','".$_POST["hero_title"]."','".$_POST["hero_title_02"]."' ";
	$insert_sql .= " ,'".$_POST["hero_product"]."','".$_POST["hero_required"]."','".$_POST["hero_tag"]."','".$_POST["hero_tag_sub"]."','".$_POST["hero_guide"]."' ";
	$insert_sql .= " ,'".$_POST["hero_help"]."','".$_POST["hero_media"]."','".$_POST["hero_start_date"]."','".$_POST["hero_end_date"]."',now() ";
	$insert_sql .= " ,'".$_POST["hero_thumb"]."','".$command."' ";
	if($guide_ori_file1) {
		$insert_sql .= " ,'".$guide_ori_file1."', '".$guide_file1."' ";
	}
	if($guide_ori_file2) {
		$insert_sql .= " ,'".$guide_ori_file2."', '".$guide_file2."' ";
	}
	$insert_sql .= " ) ";

	$result = sql($insert_sql, "on");
	
	$msg = "등록되었습니다.";
	
	if($result) {
		message($msg);
		location(PATH_HOME."?board=".$_GET["board"]."&view=missionList");
	}
} else if($_GET["action"] == "update") {
	//$first_img
	$update_sql  = " UPDATE global_mission SET ";
	$update_sql .= " hero_country = '".$_POST["hero_country"]."' ";
	$update_sql .= " , hero_title = '".$_POST["hero_title"]."' ";
	$update_sql .= " , hero_title_02 = '".$_POST["hero_title_02"]."' ";
	$update_sql .= " , hero_product = '".$_POST["hero_product"]."' ";
	$update_sql .= " , hero_required = '".$_POST["hero_required"]."' ";
	$update_sql .= " , hero_tag = '".$_POST["hero_tag"]."' ";
	$update_sql .= " , hero_tag_sub = '".$_POST["hero_tag_sub"]."' ";
	$update_sql .= " , hero_guide = '".$_POST["hero_guide"]."' ";
	$update_sql .= " , hero_help = '".$_POST["hero_help"]."' ";
	$update_sql .= " , hero_media = '".$_POST["hero_media"]."' ";
	$update_sql .= " , hero_start_date = '".$_POST["hero_start_date"]."' ";
	$update_sql .= " , hero_end_date = '".$_POST["hero_end_date"]."' ";
	if($first_img) {
		$update_sql .= " , hero_thumb = '".$first_img."' ";
	}
	$update_sql .= " , hero_command = '".$command."' ";
	if($guide_ori_file1) {
		$update_sql .= " , guide_ori_file1 = '".$guide_ori_file1."' ";
		$update_sql .= " , guide_file1 = '".$guide_file1."' ";
	} else if($_POST["delGuideFile1"] == "Y") {
		$update_sql .= " , guide_ori_file1 = '' ";
		$update_sql .= " , guide_file1 = '' ";
	}
	if($guide_ori_file2) {
		$update_sql .= " , guide_ori_file2 = '".$guide_ori_file2."' ";
		$update_sql .= " , guide_file2 = '".$guide_file2."' ";
	} else if($_POST["delGuideFile2"] == "Y") {
		$update_sql .= " , guide_ori_file2 = '' ";
		$update_sql .= " , guide_file2 = '' ";
	}

	$update_sql .= " WHERE hero_idx = '".$_POST["hero_idx"]."' ";
	$result = sql($update_sql, "on");
	
	$msg = "수정되었습니다.";
	
	if($result) {
		message($msg);
		location(PATH_HOME."?board=".$_GET["board"]."&view=missionView&hero_idx=".$_POST["hero_idx"]);
	}
} else if($_GET["action"] == "drop") {
	$delete_sql = " UPDATE global_mission SET hero_use_yn = 'N' WHERE hero_idx = '".$_GET["hero_idx"]."' ";
	$result = sql($delete_sql, "on");
	
	$msg = "삭제했습니다.";
	
	if($result) {
		message($msg);
		location(PATH_HOME."?board=".$_GET["board"]."&view=missionList");
	}
}
?>