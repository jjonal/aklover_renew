<?php
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

$hero_old_idx = $_GET["hero_old_idx"];

$sql = " SELECT hero_title FROM point WHERE hero_old_idx = '".$hero_old_idx."' AND hero_type='mission_excel' LIMIT 1 ";
sql($sql,'on');
$row = @mysql_fetch_array($out_sql);
$hero_title = $row["hero_title"];

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=".$hero_title."_체험단일괄포인트지급_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

//(s) 리스트 sql
$sql = " SELECT hero_code, hero_id, hero_nick, hero_name, hero_point FROM point WHERE hero_old_idx = '".$hero_old_idx."' AND hero_type='mission_excel' ORDER BY hero_idx ASC ";
//(e) 리스트 sql
sql($sql);

?>
<strong><?=date("Y-m-d")?></strong>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
	<tr>
		<th>번호</th>
		<th>고유번호</th>
		<th>아이디</th>
		<th>닉네임</th>
		<th>이름</th>
		<th>포인트</th>
	</tr>
	<? 
	$no = 1;
	if($hero_title) {
		while($list = @mysql_fetch_array($out_sql)){ ?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="center"><?=$list["hero_code"]?></td>
			<td align="center"><?=$list["hero_id"]?></td>
			<td align="center"><?=$list["hero_nick"]?></td>
			<td align="center"><?=$list["hero_name"]?></td>
			<td align="center"><?=$list["hero_point"]?></td>
		</tr>
	<? 
			$no++;
			} 
	} else {
	?>
	<tr>
		<td colspan="6" align="center">등록된 데이터가 없습니다.</td>
	</tr>
	<? } ?>
</table>
