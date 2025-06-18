<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$hero_idx = $_POST["hero_idx"];

$reslut = false;
$data = array();

if($mode == "checkNick") {
	$member_cnt = 0;
	
	$member_sql = " SELECT count(*) cnt FROM member WHERE hero_use = 0 AND hero_nick = '".$_POST["hero_nick"]."' ";
	$member_res = sql(out($member_sql),"on");
	$member_rs = mysql_fetch_assoc($member_res);
	
	$member_cnt = $member_rs["cnt"];
	
	$loyal_cnt = 0;
	if($member_cnt == "1") {
		
		$member_data_sql = " SELECT hero_code FROM member WHERE hero_use = 0 AND hero_nick = '".$_POST["hero_nick"]."' ";
		$member_data_res = sql(out($member_data_sql));
		$member_data_rs = mysql_fetch_assoc($member_data_res);
		
		$loyal_sql  = " SELECT count(*) cnt FROM member_loyal ";
		$loyal_sql .= "	WHERE DATE_ADD(CONCAT(gisu_year, gisu_month,'01'), INTERVAL 4 MONTH) >= date_format(NOW(),'%Y-%m-%d') ";
		$loyal_sql .= " AND hero_code = '".$member_data_rs["hero_code"]."' ";
		$loyal_res = sql($loyal_sql);
		$loyal_rs = mysql_fetch_assoc($loyal_res);
		
		$loyal_cnt = $loyal_rs["cnt"];
		
		if($loyal_cnt == 0) {
			$result = true;
			$data["result"] = 1;
		} else {
			$data["result"] = -3;
		}
	} else {
		$data["result"] = -2;
	}
	
} else if($mode == "write") {
	$member_sql = " SELECT hero_code FROM member WHERE hero_use = 0 AND hero_nick = '".$_POST["hero_nick"]."' ";
	$member_res = sql(out($member_sql),"on");
	$member_rs = mysql_fetch_assoc($member_res);
	
	if($member_rs["hero_code"]) {
		$sql  = " INSERT INTO member_loyal (hero_code, gisu_year, gisu_month, hero_today) ";
		$sql .= " VALUES ('".$member_rs["hero_code"]."','".$_POST["gisu_year"]."','".$_POST["gisu_month"]."',now())";
		
		$result = sql($sql);
		if($result) {
			$data["result"] = 1;
		} else {
			$data["result"] = -3;
		}
	} else {
		$data["result"] = -2;
	}
} else if($mode == "edit") {
	$sql  = " UPDATE member_loyal SET ";
	$sql .= " gisu_year = '".$_POST["gisu_year"]."' ";
	$sql .= " , gisu_month = '".$_POST["gisu_month"]."' ";
	$sql .= " WHERE hero_idx = '".$hero_idx."' ";
	
	$result = sql($sql, "on");
	if($result) {
		$data["result"] = 1;
	} else {
		$data["result"] = -2;
	}
	
} else if($mode == "del") {
	$sql  = " DELETE FROM member_loyal ";
	$sql .= " WHERE hero_idx = '".$hero_idx."' ";
	
	$result = sql($sql, "on");
	
	if($result) {
		$data["result"] = 1;
	} else {
		$data["result"] = -2;
	}	
}
echo json_encode($data);

?>