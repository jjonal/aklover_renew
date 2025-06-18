<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한


$search = "";

if($_GET["startDate"]) {
	$search .= " AND date_format(b.hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["endDate"]) {
	$search .= " AND date_format(b.hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$nick_sql = " SELECT hero_nick FROM member WHERE hero_code = '".$_GET["hero_code"]."' ";
sql($nick_sql,"on");
$member = @mysql_fetch_assoc($out_sql);


header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$member["hero_nick"]."_후기다운로드_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$sql  = " SELECT b.hero_title, b.hero_today, m.hero_nick, g.hero_title as hero_menu FROM board b ";
$sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN hero_group g ON b.hero_table = g.hero_board ";
$sql .= " WHERE  b.hero_table IN ('group_04_05','group_04_06','group_04_07','group_04_08','group_04_09' ";
$sql .= " ,'group_04_10','group_04_23','group_04_25','group_04_27','group_04_28') ";
$sql .= " AND b.hero_code = '".$_GET["hero_code"]."' ".$search;
$sql .= " ORDER BY b.hero_idx DESC ";

sql($sql);
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>메뉴명</th>
	<th>체험단 명</th>
	<th>닉네임</th>
	<th>등록일</th>
</tr>
<? while($list = @mysql_fetch_assoc($out_sql)){ ?>
<tr>
	<td><?=$list["hero_menu"]?></td>
	<td><?=$list["hero_title"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? } ?>
</table>