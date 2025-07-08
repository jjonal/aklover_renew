<?php
// 서포터즈 생성 및 삭제 관련.
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];

// 데이터 유효성 검사 y-m-d 형식으로 넘어올 시 y-m-d H:i:s 형식으로 변경
if (!empty($_POST["new_startDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_startDt"])) {
    $_POST["new_startDt"] = $_POST["new_startDt"]." 00:00:00";
}
if (!empty($_POST["new_endDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_endDt"])) {
    $_POST["new_endDt"] = $_POST["new_endDt"]." 23:59:59";
}

// recruit 필드가 UTF-8로 넘어오면 EUC-KR로 변환 (왜 깨져 넘어오지..?)
$recruit = iconv("UTF-8", "EUC-KR", $_POST["new_recruit"]);

$result = 0;
$data = array();
if($mode == "insert") {
    $sql  = " INSERT INTO supporters (recruit, hero_board, startDt, endDt) VALUES ";
    $sql .= " ('".$recruit."','".$_POST["new_hero_board"]."','".$_POST["new_startDt"]."','".$_POST["new_endDt"]."') ";
    $result = sql($sql,"on");
    if($result) {
        $data["result"] = 1;
    } else {
        $data["result"] = -1;
    }
} elseif ($mode == "delete") {
    $sql  = " DELETE FROM supporters WHERE idx = '".$_POST["idx"]."' ";
    $result = sql($sql,"on");

    if($result) {
        $data["result"] = 1;
    } else {
        $data["result"] = -1;
    }
} elseif ($mode == "update") {
    $result = sql($sql,"on");

    if($result) {
        $data["result"] = 1;
    } else {
        $data["result"] = -1;
    }
} else {
    $data["result"] = -2; //잘못된 요청
}
echo json_encode($data);
exit;
?>