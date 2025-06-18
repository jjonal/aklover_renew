<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
if(!defined('_HEROBOARD_'))exit;

include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'hero.php';
include_once FREEBEST_INC_END.'function.php';

$start = 1;
$ipp = 10;

$subject = $_GET["subject"];

if($subject) $search = " AND b.hero_title like '%".$subject."%' ";

if(!strcmp($_GET['pg'], '')){$pg = '1';}else{$pg = $_GET['pg'];}
$start = ($pg-1)*$ipp;

$sql = " SELECT count(*) cnt FROM mission m inner JOIN board b ON m.hero_idx = b.hero_01 WHERE m.hero_table = 'group_04_05' AND DATE_format(b.hero_today,'%Y') >= 2019 ";
$sql .= $search;
$sql .= " AND ( m.hero_keywords like '%홈즈%' ";
$sql .= " OR m.hero_keywords like '%에어후레쉬%' "; 
$sql .= " OR m.hero_keywords like '%차량용%' ";
$sql .= " OR m.hero_keywords like '%탈취탄%' ";
$sql .= " OR m.hero_keywords like '%방충선언%' )";
$sql .= " AND b.hero_use = 1";

sql($sql,"on");

$rs = mysql_fetch_array($out_sql);

$data = array();
$data["totalCount"] = $rs["cnt"];

$sql = " SELECT b.hero_idx as num, b.hero_table, b.hero_title as subject, substr(b.hero_today,1,10) as reg_date FROM mission m inner JOIN board b ON m.hero_idx = b.hero_01 WHERE  m.hero_table = 'group_04_05' AND DATE_format(b.hero_today,'%Y') >= 2019 ";
$sql .= $search;
$sql .= " AND ( m.hero_keywords like '%홈즈%' ";
$sql .= " OR m.hero_keywords like '%에어후레쉬%' ";
$sql .= " OR m.hero_keywords like '%차량용%' ";
$sql .= " OR m.hero_keywords like '%탈취탄%' ";
$sql .= " OR m.hero_keywords like '%방충선언%' )";
$sql .= " AND b.hero_use = 1 order by b.hero_today desc LIMIT ".$start.", ".$ipp;

sql($sql);

$rs_list = array();
while($list = @mysql_fetch_assoc($out_sql)){
	$list["subject"] = urlencode($list["subject"]);
	$rs_list[] = $list;
}
$data["list"] = $rs_list; 

echo urldecode(json_encode($data));
?>