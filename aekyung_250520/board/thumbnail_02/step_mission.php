<?php
if(!defined('_HEROBOARD_'))exit;
/*
Ak Lover 요청
2025-02-13 musign-YDH 추가
체험단 삭제 기능 추가
*/

$idx = $_GET['idx'];
$hero_use = $_GET['hero_use'];
$page = $_GET['page'];

//hero_use == 2은 삭제로 사용 예정
$sql  = " UPDATE mission ";
$sql .= " SET hero_use = ".$hero_use;
$sql .= " WHERE hero_idx = '".$idx."'";

@mysql_query($sql);

if($hero_use == '2'){
    $msg = '삭제되었습니다.';
}else {
    $msg = '취소되었습니다.';
}

if($_GET['type'] == 'view') //뷰에서 넘어올때
    $action_href = PATH_HOME.'?'.'board='.$_GET['board'].'&page='.$_GET['page'];
else //리스트에서 넘어올때
    $action_href = PATH_HOME.'?'.'board='.$_GET['board'].'&page='.$_GET['page'].'&hero_use=2';


msg($msg,'location.href="'.$action_href.'"');
?>