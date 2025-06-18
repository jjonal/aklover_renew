<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=loyalAkLover_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

if($_GET["gubun"]) {
	if($_GET["gubun"] == "sum") {
		$search .= " AND (l.gubun is null or l.gubun = '') ";
	} else {
		$search .= " AND l.gubun = '".$_GET["gubun"]."' ";
	}
}

if($_GET["gisu_year"]) {
	$search .= " AND l.gisu_year = '".$_GET["gisu_year"]."' ";
}

if($_GET["gisu_month"]) {
	$search .= " AND l.gisu_month = '".$_GET["gisu_month"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

//리스트
$sql  = " SELECT l.hero_idx, l.gisu_year, l.gisu_month, l.hero_today, l.gubun ";
$sql .= " , m.hero_name, m.hero_nick, m.hero_id ";
$sql .= " FROM member_loyal l ";
$sql .= " LEFT JOIN member m ON l.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY l.gisu_year DESC, l.gisu_month DESC, l.hero_today DESC ";
$list_res = sql($sql,"on");

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>구분</th>
	<th>기수</th>
	<th>아이디</th>
	<th>이름</th>
	<th>닉네임</th>
	<th>등록일</th>
</tr>
<? while($list = mysql_fetch_assoc($list_res)) {
	$gubun_txt= "";
	if($list["gubun"]=="r") {
		$gubun_txt = "리뷰";
	} else if($list["gubun"]=="j") {
		$gubun_txt = "참여";
	} else {
		$gubun_txt = "통합";
	}
?>
<tr onClick="fnView('<?=$list["hero_idx"]?>')" style="cursor:pointer">
	<td><?=$gubun_txt?></td>
	<td><?=$list["gisu_year"]?>년 <?=$list["gisu_month"]?>월</td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
	}
?>
</table>