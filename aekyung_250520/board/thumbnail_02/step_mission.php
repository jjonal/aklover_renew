<?php
if(!defined('_HEROBOARD_'))exit;
/*
Ak Lover ��û
2025-02-13 musign-YDH �߰�
ü��� ���� ��� �߰�
*/

$idx = $_GET['idx'];
$hero_use = $_GET['hero_use'];
$page = $_GET['page'];

//hero_use == 2�� ������ ��� ����
$sql  = " UPDATE mission ";
$sql .= " SET hero_use = ".$hero_use;
$sql .= " WHERE hero_idx = '".$idx."'";

@mysql_query($sql);

if($hero_use == '2'){
    $msg = '�����Ǿ����ϴ�.';
}else {
    $msg = '��ҵǾ����ϴ�.';
}

if($_GET['type'] == 'view') //�信�� �Ѿ�ö�
    $action_href = PATH_HOME.'?'.'board='.$_GET['board'].'&page='.$_GET['page'];
else //����Ʈ���� �Ѿ�ö�
    $action_href = PATH_HOME.'?'.'board='.$_GET['board'].'&page='.$_GET['page'].'&hero_use=2';


msg($msg,'location.href="'.$action_href.'"');
?>