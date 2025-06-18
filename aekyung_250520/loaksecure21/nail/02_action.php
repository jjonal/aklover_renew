<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$result = 0;
if($mode == "gisu") {
	
	$hero_board = $_POST["hero_board"];
	
	$sql = " UPDATE mission_gisu SET ";
	if($hero_board == "group_04_06") {
		$sql .= " hero_beauty_gisu = '".$_POST["gisu"]."' ";
	} else if($hero_board == "group_04_28") {
		$sql .= " hero_life_gisu = '".$_POST["gisu"]."' ";
	} else if($hero_board == "group_04_27") {
		$sql .= " hero_moviebeauty_gisu = '".$_POST["gisu"]."' ";
	} else if($hero_board == "group_04_31") {
		$sql .= " hero_movielife_gisu = '".$_POST["gisu"]."' ";
	}
	
	$result = sql($sql,"on");
	$data["success"] = $result;
	
	echo json_encode($data);	
	
} 
?>
                        	
                        