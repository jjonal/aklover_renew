<?php
define('_HEROBOARD_', TRUE);
include_once                                '../../freebest/head.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

$excel_nick = iconv("utf-8", "euc-kr", "수영문문123");

$sql = "SELECT hero_code, hero_nick, hero_name, hero_id FROM member WHERE hero_nick = '".$excel_nick."' ";
sql($sql,"on");
$rs  = mysql_fetch_assoc($out_sql);

echo $sql;

print_r($rs);

$sql  = " SELECT hero_title FROM mission ";
$sql .= " WHERE hero_idx = 1338 ";
	
	
$out_sql    = mysql_query($sql);
$mission_rs = mysql_fetch_assoc($out_sql);

$sql  = "	INSERT INTO point ( ";
$sql .= "		hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx, hero_review_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, ";
$sql .= "		hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today ";
$sql .= "	) VALUES ( ";
$sql .= "		'{$rs["hero_code"]}', 'user', 'excel', 0, '1338', 0, '".$rs["hero_id"]."', '테스트', '타이틀', '".$rs["hero_name"]."', '".$rs["hero_nick"]."', '0', ";
$sql .= "		now(), 'N', 0, 'Y', now() ";
$sql .= "	) ";

$result = mysql_query($sql);

echo $result;

?>