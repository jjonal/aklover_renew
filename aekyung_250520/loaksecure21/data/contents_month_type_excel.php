<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=�Ϲ�������_����Ÿ�Ժ�_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search_year = $_GET["search_year"];

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

sql($sql,"on");
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>�����</th>
	<th>�Ϲݹ̼�</th>
	<th>ü���</th>
	<th>�̺�Ʈ</th>
	<th>�ҹ�����</th>
	<th>��������</th>
	<th>����Ʈü��</th>
	<th>��ǰǰ��</th>
</tr>
<? 
	while($list = @mysql_fetch_assoc($out_sql)){
		$type_0 += $list['type_0'];
		$type_10 += $list['type_10'];
		$type_1 += $list['type_1'];
		$type_2 += $list['type_2'];
		$type_3 += $list['type_3'];
		$type_5 += $list['type_5'];
		$type_8 += $list['type_8'];
?>
<tr>
	<td><?=$list["year"]?>��<?=$list["month"]?>��</td>
	<td><?=$list["type_0"]?></td>
	<td><?=$list["type_10"]?></td>
	<td><?=$list["type_1"]?></td>
	<td><?=$list["type_2"]?></td>
	<td><?=$list["type_3"]?></td>
	<td><?=$list["type_5"]?></td>
	<td><?=$list["type_8"]?></td>
</tr>
<? 
	}
?>
<tr>
	<td>�հ�</td>
	<td><?=$type_0?></td>
	<td><?=$type_10?></td>
	<td><?=$type_1?></td>
	<td><?=$type_2?></td>
	<td><?=$type_3?></td>
	<td><?=$type_5?></td>
	<td><?=$type_8?></td>
</tr>
</table>