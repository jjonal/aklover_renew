<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

$mode = $_POST["mode"];

$sql = "";
$data = array();
if($mode=="select") { //우수후기 선정 변경
	
	$sel_hero_idx = $_POST["sel_hero_idx"];
	$hero_board_three = $_POST["hero_board_three"];
	
	for($i=0; $i<count($sel_hero_idx); $i++) {

		if($hero_board_three[$sel_hero_idx[$i]] == "Y") {
			$sql = " UPDATE board SET hero_board_three = 1 WHERE hero_idx = '".$sel_hero_idx[$i]."' ";
		} else {
			$sql = " UPDATE board SET hero_board_three = 0 WHERE hero_idx = '".$sel_hero_idx[$i]."' ";
		}

		$data["result"] = sql($sql,"on");
		
		if(!$data["result"]) {
			echo json_encode($data);
			mysql_close();
			exit;
		}
		
	}
	
	echo json_encode($data);
	mysql_close();
	exit;

} else if($mode=="point"){
	$mission_idx = $_POST["mission_idx"];
	$add_point = $_POST["add_point"];
	$sel_point = $_POST["sel_point"];
	$hero_top_title = "우수후기지급";
	
	$sql  = " SELECT hero_title  FROM mission WHERE hero_idx = '".$mission_idx."' ";
	sql($sql,"on");
	$rs_mission = mysql_fetch_assoc($out_sql);
	
	$mission_title = $rs_mission["hero_title"];
	
	$cnt = 0;
	foreach($sel_point as $val) {
		
		$sql = " SELECT hero_code FROM board WHERE hero_idx='{$val}' ";
		sql($sql,"on");
		$rs_board =  mysql_fetch_assoc($out_sql);
		
		$hero_code = $rs_board["hero_code"];
		
		$sql = " SELECT hero_id, hero_name, hero_nick FROM member WHERE hero_code='{$hero_code}' ";
		sql($sql,"on");
		$rs_member  = mysql_fetch_assoc($out_sql);
		
		$hero_id = $rs_member["hero_id"];
		$hero_name = $rs_member["hero_name"];
		$hero_nick = $rs_member["hero_nick"];
		
		$sql  = " INSERT INTO point (hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx, hero_review_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
		$sql .= " VALUES ";
		$sql .= " ('{$hero_code}', 'nail', 'adminGreat', '{$val}', {$mission_idx}, 0, '".$hero_id."', '".$hero_top_title."', '".addslashes($mission_title)."', '".$hero_name."', '".$hero_nick."', '{$add_point}',now(), 'N', 0, 'Y', now()) ";
				
		$data["result"] = sql($sql,"on");

		if(!$data["result"]) {
			$data["cnt"] = $cnt;
			echo json_encode($data);
			mysql_close();
			exit;
		}
		$cnt++;
	}
	$data["cnt"] = $cnt;
	
	echo json_encode($data);
	mysql_close();
	exit;
	
}

?>
