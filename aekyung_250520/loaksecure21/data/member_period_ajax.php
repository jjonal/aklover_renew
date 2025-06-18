<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한


$mode = $_GET["mode"];
$search_year = $_GET["search_year"];

$search_change_type = "";
if($_GET["search_change_type"] == "1") {
	$search_change_type = "out";
} else if($_GET["search_change_type"] == "2") {
	$search_change_type = "in";
}

if($mode == "member_month") {
	$sql  = " SELECT month, count(*) cnt FROM ( ";
	$sql .= " SELECT date_format(hero_oldday,'%m') month FROM member WHERE hero_use = 0 AND date_format(hero_oldday,'%Y') = '".$search_year."' ) a ";
	$sql .= " GROUP BY month ORDER BY month ASC ";
	
	$res = sql($sql,"on");
	
	$list = array();
	while($rs = mysql_fetch_assoc($res)) {
		$list[] = $rs; 
	}
} else if($mode == "withdrawal_month") {
	$sql  = " SELECT month, count(*) cnt FROM ( ";
	$sql .= " SELECT FROM_UNIXTIME(hero_out_date,'%m') month FROM member WHERE hero_use = 1 AND FROM_UNIXTIME(hero_out_date,'%Y') = '".$search_year."' ) a ";
	$sql .= " GROUP BY month ORDER BY month ASC ";
	
	$res = sql($sql,"on");
	
	$list = array();
	while($rs = mysql_fetch_assoc($res)) {
		$list[] = $rs;
	}	
} else if($mode == "change_year") {

	$sql  = " SELECT year, COUNT(*) cnt FROM ";
	$sql .= " (SELECT DATE_FORMAT(hero_today,'%Y') year FROM member_backup_history "; 
    $sql .= " WHERE (hero_code IS NOT NULL AND hero_code != '') AND hero_type='".$search_change_type."') a GROUP BY YEAR ORDER BY year ASC ";
    
    $res = sql($sql,"on");
    $list = array();
    while($rs = mysql_fetch_assoc($res)) {
    	$list[] = $rs;
    }
} else if($mode == "change_month") {
	$sql  = " SELECT month, COUNT(*) cnt FROM ";
	$sql .= " (SELECT DATE_FORMAT(hero_today,'%m') month FROM member_backup_history ";
	$sql .= " WHERE (hero_code IS NOT NULL AND hero_code != '') AND hero_type='".$search_change_type."' AND DATE_FORMAT(hero_today,'%Y') = '".$search_year."') a ";
	$sql .= " GROUP BY month ORDER BY month ASC ";
	
	$res = sql($sql,"on");
	$list = array();
	while($rs = mysql_fetch_assoc($res)) {
		$list[] = $rs;
	}
}
echo json_encode($list);
?>