<?php
// �������� ���� �� ���� ����.
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$mode = $_POST["mode"];

// ������ ��ȿ�� �˻� y-m-d �������� �Ѿ�� �� y-m-d H:i:s �������� ����
if (!empty($_POST["new_startDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_startDt"])) {
    $_POST["new_startDt"] = $_POST["new_startDt"]." 00:00:00";
}
if (!empty($_POST["new_endDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_endDt"])) {
    $_POST["new_endDt"] = $_POST["new_endDt"]." 23:59:59";
}

// recruit �ʵ尡 UTF-8�� �Ѿ���� EUC-KR�� ��ȯ (�� ���� �Ѿ����..?)
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
    $data["result"] = -2; //�߸��� ��û
}
echo json_encode($data);
exit;
?>