<?
define('_HEROBOARD_', TRUE);//HEROBOARD¿ÀÇÂ
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

$mode = $_POST["mode"];
$sel_hero_idx = $_POST["sel_hero_idx"]; 
$lot_01 = $_POST["lot_01"];

$sql = "";
$data = array();
if($mode=="select") {
	
	for($i=0; $i<count($sel_hero_idx); $i++) {

		if($lot_01[$sel_hero_idx[$i]] == "Y") {
			$sql = " UPDATE mission_review SET lot_01 = 1 WHERE hero_idx = '".$sel_hero_idx[$i]."' ";
		} else {
			$sql = " UPDATE mission_review SET lot_01 = 0 WHERE hero_idx = '".$sel_hero_idx[$i]."' ";
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

} 

?>
