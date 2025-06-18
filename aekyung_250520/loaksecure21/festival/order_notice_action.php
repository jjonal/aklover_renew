<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$hero_title = $_POST["hero_title"];
$hero_content = $_POST["hero_content"];
$hero_idx = $_POST["hero_idx"];

$reslut = false;
$data = array();
if($mode == "write") {
	$sql = " INSERT INTO order_notice(hero_title, hero_content, hero_regdate) VALUES ('".$hero_title."', '".$hero_content."', now())";
	$result = sql(out($sql),"on");
	if($result) $data["result"] = 1;
} else if($mode == "edit") {
	$sql = " UPDATE order_notice SET hero_title='".$hero_title."', hero_content='".$hero_content."' where hero_idx=".$hero_idx;
	$result = sql(out($sql),"on");
	if($result) $data["result"] = 1;
} else if($mode == "del") {
	$sql = " DELETE FROM order_notice where hero_idx=".$hero_idx;
	$result = sql(out($sql),"on");
	if($result) $data["result"] = 1;
}

echo json_encode($data);
?>