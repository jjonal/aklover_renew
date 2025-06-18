<?php
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=바이럴유형별_".date("Ymd",time()).".xls" ); 
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
	<th rowspan="2">월별</th>
	<th colspan="4">(신) 바이럴 대상자</th>
	<th rowspan="2">신규 일반회원</th>
	<th rowspan="2">신규 바이럴 대상자</th>
</tr>
<tr>
	<th>네이버 블로그</th>
	<th>인스타</th>
	<th>블로그 && 인스타</th>
	<th>블로그 or 인스타</th>
</tr>
<? 
while($list = mysql_fetch_assoc($list_res)) { ?>
<tr>
	<td>
		<? if($list["month"]) { ?>
		<?=substr($list["month"],0,4)?>년 <?=substr($list["month"],4,2)?>월
		<? } else { ?>
		소계
		<? } ?>
	</td>
	<td><?=number_format($list["naver"])?>명</td>
	<td><?=number_format($list["insta"])?>명</td>
	<td><?=number_format($list["naver_and_insta"])?>명</td>
	<td><?=number_format($list["naver_or_insta"])?>명</td>
	<td><?=number_format($list["total_cnt"])?>명</td>
	<td><?=number_format($list["viral_cnt"])?>명</td>
</tr>
<? } ?>
</table>
