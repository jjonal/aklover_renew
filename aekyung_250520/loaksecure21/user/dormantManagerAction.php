<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한


$mode = $_POST["mode"];
$hero_code = $_POST["hero_code"];
$data = array();
if($mode == "edit") { //기본정보 수정
	$hero_hp = $_POST["hero_hp_01"]."-".$_POST["hero_hp_02"]."-".$_POST["hero_hp_03"];
	$sql  = " UPDATE member_backup SET ";
	$sql .= " hero_hp = '".$hero_hp."' ";
	$sql .= " WHERE hero_use = 0 AND hero_code = '".$hero_code."' ";
	
	$result = sql($sql,"on");
	
	if(!$result) {
		$data["result"] = "-1";
	} else {
		$data["result"] = "1";
	}
}
echo json_encode($data);
exit;
?>