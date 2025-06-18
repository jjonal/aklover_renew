<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];
$result = 0;
$data = array();
if($mode == "order") {
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$sql = " UPDATE board SET hero_order  = '".$_POST["hero_order"][$i]."' WHERE hero_idx = '".$_POST["hero_idx"][$i]."' ";
		$result = sql($sql,"on");
		
		if(!$result) {
			$data["result"] = -1;
			echo json_encode($data);
			exit;
		}
	}

	$data["result"] = 1;	
	echo json_encode($data);
	exit;
} 
?>
                        	
                        