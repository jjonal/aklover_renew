<?php
if(!defined('_HEROBOARD_'))exit;
/*
2024-10-23 Ak Lover ��û
ü��� ��û ��ұ�� �߰�
*/

$board = $_GET['board'];
$idx = $_GET['idx'];

//������ �������� ���� ��������
if($_GET['hero_code'] == ''){ //����
    $hero_code = $_SESSION['temp_code'];
}else { //������
    $hero_code = $_GET['hero_code'];
}

//��ۺ����� �ٽ� ����
$delivery_sql   = "SELECT a.delivery_point_yn, b.hero_id, b.hero_code, b.hero_name, b.hero_nick ";
$delivery_sql .= " FROM mission_review a, member b ";
$delivery_sql .= " WHERE a.hero_code = b.hero_code ";
$delivery_sql .= " AND a.hero_table = '".$board."' AND a.hero_code='".$hero_code."' AND a.hero_old_idx='".$idx."' ";

$delivery_res = sql($delivery_sql);
$delivery_rs = mysql_fetch_assoc($delivery_res);

if($delivery_rs['delivery_point_yn'] == 'Y'){
    deliveryPoint($idx, $delivery_rs["hero_id"], $delivery_rs["hero_code"], $delivery_rs["hero_name"], $delivery_rs["hero_nick"], $_DELIVERY_POINT*-1);
}

//���� �α� ���̺� ������ �μ�Ʈ
$sql = "INSERT INTO mission_review_delete_log ";
$sql .= " SELECT a.*, NOW() ";
$sql .= " FROM mission_review a ";
$sql .= " WHERE hero_table = '".$board."' AND hero_code='".$hero_code."' AND hero_old_idx='".$idx."' ";
@mysql_query($sql);

//ü��� ��û ����
$sql = "DELETE FROM mission_review WHERE hero_table = '".$board."' AND hero_code='".$hero_code."' AND hero_old_idx='".$idx."'";
@mysql_query($sql);

$action_href = PATH_HOME.'?'.'board='.$_GET['board'].'&view=view&idx='.$_GET['idx'];

$msg = "��û�� ��ҵǾ����ϴ�.";
msg($msg,'location.href="'.$action_href.'"');
?>