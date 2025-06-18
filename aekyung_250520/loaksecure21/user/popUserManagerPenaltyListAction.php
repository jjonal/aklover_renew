<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$hero_code = $_POST["hero_code"];
$memo = out($_POST["memo"]);
$type = $_POST["type"];
$result = 0;
$data = array();
$data["mode"] = $mode;
if($mode == "penalty") {
	
	$sql  = " INSERT INTO member_penalty (hero_code, type, memo, hero_use_yn, hero_today) VALUES  ";
	$sql .= " ('".$hero_code."','".$type."','".$memo."','Y',now()) ";
	$result = sql($sql,"on");

	if($result) {
		$data["result"] = "1";
	} else {
		$data["result"] = "-1";
	}
} else if($mode == "delPenalty") {
	$sql = "  UPDATE member_penalty SET hero_use_yn = 'N' WHERE hero_idx = '".$_POST["hero_idx"]."' ";
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