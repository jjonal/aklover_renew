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
$hero_codes = $_POST['hero_codes'];

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
	
} else if($mode == "chkSuperpass") { // 슈퍼패스 일괄지급
    $success = true; // 전체 처리 성공 여부 확인용
    
    // hero_codes가 문자열로 넘어올 경우 배열로 변환
    if(!is_array($hero_codes)) {
        $hero_codes = explode(',', $hero_codes);
    }
    
    foreach($hero_codes as $code) {
        $sql  = " INSERT INTO superpass (hero_code, hero_kind, hero_superpass, hero_today, hero_endday) VALUES ";
        $sql .= " ('".trim($code)."','".$hero_kind."','1','".date("Y-m-d H:i:s")."','".$hero_endday."') ";
        
        $result = sql($sql, "on");
        
        if(!$result) {
            $success = false; // 하나라도 실패하면 false로 설정
            break; // 실패 시 즉시 중단
        }
    }
    
    // 최종 결과 설정
    $data["result"] = $success ? "1" : "-1";
}

echo json_encode($data);
exit;
?>