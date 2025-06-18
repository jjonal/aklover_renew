<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$search_year = $_GET["search_year"];
$hero_table_month = $_GET["hero_table_month"];

$hero_table_txt = "";
if($hero_table_month == "group_04_06") {
	$hero_table_txt = "뷰티클럽";
} else if($hero_table_month == "group_04_27") {
	$hero_table_txt = "Beauty/LifeClub영상팀";
} else if($hero_table_month == "group_04_28") {
	$hero_table_txt = "라이프클럽";
}

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$hero_table_txt."_콘텐츠_월별타입별_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$sql   = " SELECT hero_table, hero_today, COUNT(*),substr(hero_today,1,4) year, substr(hero_today,5,6) month ";
$sql  .= " , sum(ifnull(if(hero_type=0,1,0),0)) type_0 ";
$sql  .= " , sum(ifnull(if(hero_type=1,1,0),0)) type_1 ";
$sql  .= " , sum(ifnull(if(hero_type=2,1,0),0)) type_2 ";
$sql  .= " , sum(ifnull(if(hero_type=3,1,0),0)) type_3 ";
$sql  .= " , sum(ifnull(if(hero_type=5,1,0),0)) type_5 ";
$sql  .= " , sum(ifnull(if(hero_type=7,1,0),0)) type_7 ";
$sql  .= " , sum(ifnull(if(hero_type=8,1,0),0)) type_8 ";
$sql  .= " , sum(ifnull(if(hero_type=9,1,0),0)) type_9 ";
$sql  .= " , sum(ifnull(if(hero_type=10,1,0),0)) type_10 ";
$sql  .= " FROM ";
$sql  .= " (SELECT hero_table, hero_type, DATE_FORMAT(hero_today_01_01,'%Y%m') AS hero_today FROM mission ";
$sql  .= " WHERE hero_table = '".$hero_table_month."' and DATE_FORMAT(hero_today_01_01,'%Y') = '".$search_year."') a GROUP BY hero_today  ";
$sql  .= " ORDER BY a.hero_today DESC ";

sql($sql,"on");
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>진행월</th>
	<th>포커스그룹</th>
	<th>정기미션</th>
	<th>정기미션(선택)</th>
	<th>자율미션</th>
	<th>이벤트</th>
	<th>소문내기</th>
	<th>설문조사</th>
	<th>포인트체험</th>
	<th>제품품평</th>
</tr>
<? 
	while($list = @mysql_fetch_assoc($out_sql)){
		$type_0 += $list['type_0'];
		$type_9 += $list['type_9'];
		$type_7 += $list['type_7'];
		$type_1 += $list['type_1'];
		$type_2 += $list['type_2'];
		$type_3 += $list['type_3'];
		$type_8 += $list['type_8'];
		$type_5 += $list['type_5'];
		
		$hero_table_txt = "";
		if($list['hero_table'] == "group_04_06") {
			$hero_table_txt = "뷰티클럽";
		} else if($list['hero_table'] == "group_04_27") {
			$hero_table_txt = "Beauty/Life Club 영상팀";
		} else if($list['hero_table'] == "group_04_28") {
			$hero_table_txt = "라이프클럽";
		}
?>
<tr>
	<td><?=$list["year"]?>년<?=$list["month"]?>월</td>
	<td><?=$hero_table_txt?></td>
	<td><?=$list["type_0"]?></td>
	<td><?=$list["type_9"]?></td>
	<td><?=$list["type_7"]?></td>
	<td><?=$list["type_1"]?></td>
	<td><?=$list["type_2"]?></td>
	<td><?=$list["type_3"]?></td>
	<td><?=$list["type_8"]?></td>
	<td><?=$list["type_5"]?></td>
</tr>
<? 
	}
?>
<tr>
	<td colspan="2">합계</td>
	<td><?=$type_0?></td>
	<td><?=$type_9?></td>
	<td><?=$type_7?></td>
	<td><?=$type_1?></td>
	<td><?=$type_2?></td>
	<td><?=$type_3?></td>
	<td><?=$type_8?></td>
	<td><?=$type_5?></td>
</tr>
</table>