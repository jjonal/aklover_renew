<?
define('_HEROBOARD_', TRUE);

include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'function.php';

if(!$_SESSION["global_code"]) {
	exit;
}

$hero_code = $_SESSION["global_code"];

$mode = $_POST["mode"];
$result = false;

$data = array();
if($mode == "reply_write") {
	$auto_sql = " SHOW TABLE STATUS LIKE 'global_reply'";
	$out_auto_sql = sql($auto_sql,"on");
	$auto_list = mysql_fetch_assoc($out_auto_sql);
	
	$next_idx = $auto_list['Auto_increment'];

	if(!$_POST['depth_idx'] && !$_POST['depth_idx_old']){ //Ã¹ ´ñ±Û
		$old_idx 			=	$next_idx;
		$top_old_idx 		=	$next_idx;
		 
		## depth
		$hero_create_depth 	=	0;
	
	
	} else if($_POST['depth_idx'] && $_POST['depth_idx_old']){
		$old_idx 			=	$_POST['depth_idx'];
		$top_old_idx 		=	$_POST['depth_idx_old'];

		$reply_depth_sql = " SELECT hero_depth FROM global_reply WHERE hero_idx='".$old_idx."' ";
		 
		$out_reply_depth = sql($reply_depth_sql);
		 
		$reply_depth_list = mysql_fetch_assoc($out_reply_depth);
		$hero_create_depth = $reply_depth_list['hero_depth']+1;
		
	} else { //error
		echo "WRONG_SETTING";
		exit;
	}
	
	$insert_sql  = " INSERT INTO global_reply (hero_idx, hero_old_idx, hero_code, hero_command, hero_depth  ";
	$insert_sql .= " , hero_depth_idx, hero_depth_idx_old, hero_today, hero_topfix ) VALUES ";
	$insert_sql .= " ('".$next_idx."','".$_POST["hero_old_idx"]."','".$hero_code."','".$_POST["command"]."','".$hero_create_depth."' ";
	$insert_sql .= "  , '".$old_idx."','".$top_old_idx."',now(),'".$_POST["hero_topFix"]."') ";
	
	$result = sql(out($insert_sql));
	$data["sql"] = $insert_sql;
	$data["result"] = $result;
		
} else if($mode == "reply_edit") {
	if(!$_POST["depth_idx"]){
		$data["result"] = $result;
		exit;
	}	
	
	$update_sql = " UPDATE global_reply SET hero_command = '".$_POST["command"]."' WHERE hero_idx = '".$_POST['depth_idx']."' ";
	$result = sql(out($update_sql),"on");
	$data["result"] = $result;
} else if($mode == "reply_drop") {
	$delete_sql = "DELETE FROM global_reply where hero_idx = '".$_POST["depth_idx"]."' ";
	$result = $result = sql($delete_sql,"on");
	$data["result"] = $result;
}

echo json_encode($data);
?>