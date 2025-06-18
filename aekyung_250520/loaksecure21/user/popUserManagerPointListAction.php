<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$hero_code = $_POST["hero_code"];
$hero_title = out($_POST["hero_title"]);
$hero_point = $_POST["hero_point"];
$result = 0;
$data = array();
$data["mode"] = $mode;
if($mode == "point") {
	
	$sql  = " SELECT hero_idx, hero_code, hero_id, hero_name, hero_nick, hero_level, hero_point FROM member ";
	$sql .= " WHERE hero_use=0 AND hero_code = '".$hero_code."' ";
	$res = sql($sql,"on");
	$rs = mysql_fetch_assoc($res);
	
	$result = adminPoint($rs['hero_code'], $_POST["board"], 'user', 0, 0, 0, $rs['hero_id'], $hero_title, $rs['hero_name'], $rs['hero_nick'], $hero_point, 'N', "");

	if($result) {
		$data["result"] = "-1";
	} else {
		$data["result"] = "1";
	}
}
echo json_encode($data);
exit;
?>