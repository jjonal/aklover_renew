<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=ȸ��������_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND  date_format(hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}
$sql  = " SELECT * FROM (SELECT hero_level, COUNT(*) cnt FROM member ";
$sql .= " WHERE hero_use = 0 ".$search;
$sql .= " GROUP BY hero_level with rollup) a ORDER BY hero_level DESC ";
$list_res = sql($sql, "on");

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>Level</th>
	<th>ȸ�� ��</th>
</tr>
<? 
while($list = mysql_fetch_assoc($list_res)) { ?>
<tr>
	<td>
		<? if(strlen($list["hero_level"]) > 0) { ?>
			<?=$list["hero_level"]?>
		<? } else { ?>
			�Ұ�
		<? } ?>
	</td>
	<td><?=number_format($list["cnt"])?></td>
</tr>
<? } ?>
</table>
