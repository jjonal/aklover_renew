<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$hero_code = $_POST["hero_code"];
$hero_kind = out($_POST["hero_kind"]);
$hero_endday = $_POST["hero_endday"];
$result = 0;
$data = array();
if($mode == "superpass") {
	
	$sql  = " INSERT INTO superpass (hero_code, hero_kind, hero_superpass, hero_today, hero_endday) VALUES ";
	$sql .= " ('".$hero_code."','".$hero_kind."','1','".date("Y-m-d H:i:s")."','".$hero_endday."') ";
	$result = sql($sql,"on");

	if($result) {
		$data["result"] = "1";
	} else {
		$data["result"] = "-1";
	}
} else if($mode == "delSuperpass") {
	$sql = "  DELETE FROM superpass WHERE hero_code = '".$hero_code."' AND hero_idx = '".$_POST["hero_idx"]."' ";
	$data["sql"] = $sql;
	$result = sql($sql,"on");
	
	if($result) {
		$data["result"] = "1";
	} else {
		$data["result"] = "-1";
	}
	
}
echo json_encode($data);
exit;
?>