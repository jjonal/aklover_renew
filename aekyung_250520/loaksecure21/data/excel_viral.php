<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=���̷�������_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

$startDate = substr($_GET["startDate"],0,7);
$endDate = substr($_GET["endDate"],0,7);

if($startDate && $endDate) {
	$search = " AND date_format(hero_oldday,'%Y-%m') >= '".$startDate."' AND date_format(hero_oldday,'%Y-%m') <= '".$endDate."' ";
}

$sql  = " SELECT * FROM ";
$sql .= " ( SELECT month ";
$sql .= " , count(*) as total_cnt "; 
$sql .= " , SUM(if((DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) AS viral_cnt "; 
$sql .= " , SUM(if(ifnull(length(hero_blog_00),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0 ,1,0)) AS naver "; 
$sql .= " , SUM(if(ifnull(length(hero_blog_04),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) AS insta ";
$sql .= " , SUM(if(ifnull(length(hero_blog_00),0) > 0 && ifnull(length(hero_blog_04),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) naver_and_insta "; 
$sql .= " , SUM(if((ifnull(length(hero_blog_00),0) > 0 || ifnull(length(hero_blog_04),0) > 0) && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) naver_or_insta ";
$sql .= " FROM ( ";
$sql .= " SELECT date_format(hero_oldday,'%Y%m') month, hero_jumin, hero_sex ,hero_blog_00, hero_blog_04 ";
$sql .= " FROM member WHERE hero_use = 0 ".$search;
$sql .= " ) a GROUP BY month WITH rollup ) a ORDER BY month DESC ";

$list_res = sql($sql, "on");

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th rowspan="2">����</th>
	<th colspan="4">(��) ���̷� �����</th>
	<th rowspan="2">�ű� �Ϲ�ȸ��</th>
	<th rowspan="2">�ű� ���̷� �����</th>
</tr>
<tr>
	<th>���̹� ��α�</th>
	<th>�ν�Ÿ</th>
	<th>��α� && �ν�Ÿ</th>
	<th>��α� or �ν�Ÿ</th>
</tr>
<? 
while($list = mysql_fetch_assoc($list_res)) { ?>
<tr>
	<td>
		<? if($list["month"]) { ?>
		<?=substr($list["month"],0,4)?>�� <?=substr($list["month"],4,2)?>��
		<? } else { ?>
		�Ұ�
		<? } ?>
	</td>
	<td><?=number_format($list["naver"])?>��</td>
	<td><?=number_format($list["insta"])?>��</td>
	<td><?=number_format($list["naver_and_insta"])?>��</td>
	<td><?=number_format($list["naver_or_insta"])?>��</td>
	<td><?=number_format($list["total_cnt"])?>��</td>
	<td><?=number_format($list["viral_cnt"])?>��</td>
</tr>
<? } ?>
</table>
