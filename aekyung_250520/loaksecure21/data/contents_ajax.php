<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_GET["mode"];
$search_year = $_GET["search_year"];

if($mode == "month") {
	$sql   = " SELECT hero_today, COUNT(*),substr(hero_today,1,4) year, substr(hero_today,5,6) month ";
	$sql  .= " , sum(ifnull(if(hero_type=0,1,0),0)) type_0 ";
	$sql  .= " , sum(ifnull(if(hero_type=1,1,0),0)) type_1 ";
	$sql  .= " , sum(ifnull(if(hero_type=2,1,0),0)) type_2 ";
	$sql  .= " , sum(ifnull(if(hero_type=3,1,0),0)) type_3 ";
	$sql  .= " , sum(ifnull(if(hero_type=5,1,0),0)) type_5 ";
	$sql  .= " , sum(ifnull(if(hero_type=8,1,0),0)) type_8 ";
	$sql  .= " , sum(ifnull(if(hero_type=10,1,0),0)) type_10 ";
	$sql  .= " FROM ";
	$sql  .= " (SELECT hero_type, DATE_FORMAT(hero_today_01_01,'%Y%m') AS hero_today FROM mission ";
	$sql  .= " WHERE hero_table = 'group_04_05' and DATE_FORMAT(hero_today_01_01,'%Y') = '".$search_year."') a GROUP BY hero_today  ";
	$sql  .= " ORDER BY a.hero_today DESC ";
	
	$res = sql($sql,"on");
	
	$list = array();
	while($rs = mysql_fetch_assoc($res)) {
		$list[] = $rs; 
	}
}
echo json_encode($list);
?>