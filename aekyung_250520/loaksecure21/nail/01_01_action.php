<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$success_num = 0;
$fail_num = 0;
if($mode == "winning") {
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$sql = " UPDATE mission_review SET lot_01 = 1 WHERE hero_idx = '".$_POST["hero_idx"][$i]."' ";

		$result = sql($sql,"on");
		if($result) {
			$success_num++;
		} else {
			$fail_num++;
		}
	}

	$data["total"] = count($_POST["hero_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;
	
	echo json_encode($data);	
} else if($mode == "winningCancel") {
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$sql = " UPDATE mission_review SET lot_01 = 0 WHERE hero_idx = '".$_POST["hero_idx"][$i]."' ";
	
		$result = sql($sql,"on");
		if($result) {
			$success_num++;
		} else {
			$fail_num++;
		}
	}
	
	$data["total"] = count($_POST["hero_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;
	
	echo json_encode($data);
} else if($mode == "delivery") {
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$sql = " SELECT hero_code, hero_id, hero_name, hero_nick, hero_old_idx FROM mission_review WHERE hero_idx = '".$_POST["hero_idx"][$i]."' AND delivery_point_yn = 'Y'";
		$result_res = sql($sql,"on");
		$list = mysql_fetch_assoc($result_res);

		if($list['hero_code']) {
			$result = deliveryPoint($list["hero_old_idx"], $list['hero_id'], $list['hero_code'], $list['hero_name'], $list['hero_nick'], $_DELIVERY_POINT);
				
			if($result) {
				$success_num++;
			} else {
				$fail_num++;
			}
		} else {
			$fail_num++;
		}
	}

	$data["total"] = count($_POST["hero_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;

	echo json_encode($data);
} else if($mode == "deliveryCancel") {
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$sql = " SELECT hero_code, hero_id, hero_name, hero_nick, hero_old_idx FROM mission_review WHERE hero_idx = '".$_POST["hero_idx"][$i]."' AND delivery_point_yn = 'Y'";
		$result_res = sql($sql,"on");
		$list = mysql_fetch_assoc($result_res);
		
		$cancel_check_sql  = " SELECT sum(hero_order_point) AS sum_hero_order_point FROM order_main WHERE hero_process = 'DE' ";
		$cancel_check_sql .= " AND mission_idx = '".$list["hero_old_idx"]."' AND hero_code = '".$list['hero_code']."' ";
		$cancel_res = sql($cancel_check_sql);
		$cancel_list = mysql_fetch_assoc($cancel_res);
		
		if($list['hero_code'] && $cancel_list["sum_hero_order_point"] == $_DELIVERY_POINT) {
			$result = deliveryPoint($list["hero_old_idx"], $list['hero_id'], $list['hero_code'], $list['hero_name'], $list['hero_nick'], -$_DELIVERY_POINT);
			
			if($result) {
				$success_num++;
			} else {
				$fail_num++;
			}
		} else {
			$fail_num++;
		}
	}
	
	$data["total"] = count($_POST["hero_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;
	
	echo json_encode($data);
}

?>
                        	
                        