<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=�Ϲ�������_����_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND ( (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
	$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
	$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
}

if($_GET["kewyword"]) {
	$search .= " AND m.hero_title LIKE '%".$_GET["kewyword"]."%' ";
}
$sql  = " SELECT m.hero_idx, m.hero_title, m.hero_today_01_01, m.hero_today_04_02 ";
$sql .= " , sum(ifnull(if(u.gubun='naver',1,0),0)) naver_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='insta',1,0),0)) insta_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='youtube',1,0),0)) youtube_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='cafe',1,0),0)) cafe_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='etc',1,0),0)) etc_cnt ";
$sql .= " FROM mission m LEFT JOIN (SELECT hero_idx, hero_01 FROM board WHERE hero_table = 'group_04_05') AS b ON m.hero_idx = b.hero_01 ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_table = 'group_04_05' ".$search;
$sql .= " GROUP BY m.hero_idx ";
$sql .= " ORDER BY m.hero_idx DESC ";

sql($sql,"on");
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>No</th>
	<th>�Ⱓ</th>
	<th>ü��� ��</th>
	<th>���̹� ��α�</th>
	<th>�ν�Ÿ�׷�</th>
	<th>��Ʃ��</th>
	<th>ī��</th>
	<th>��Ÿ</th>
</tr>
<? 
	while($list = @mysql_fetch_assoc($out_sql)){
		$tot_naver_cnt += $list['naver_cnt'];
		$tot_insta_cnt += $list['insta_cnt'];
		$tot_youtube_cnt += $list['youtube_cnt'];
		$tot_cafe_cnt += $list['cafe_cnt'];
		$tot_etc_cnt += $list['etc_cnt'];
?>
<tr>
	<td><?=$i?></td>
	<td><?=substr($list['hero_today_01_01'],0,10);?> ~ <?=substr($list['hero_today_04_02'],0,10);?></td>
	<td class="title"><?=$list['hero_title'];?></td>
	<td><?=number_format($list['naver_cnt'])?></td>
	<td><?=number_format($list['insta_cnt'])?></td>
	<td><?=number_format($list['youtube_cnt'])?></td>
	<td><?=number_format($list['cafe_cnt'])?></td>
	<td><?=number_format($list['etc_cnt'])?></td>
</tr>
<? 
	}
?>
<tr>
	<td colspan="3">�հ�</td>
	<td><?=number_format($tot_naver_cnt)?></td>
	<td><?=number_format($tot_insta_cnt)?></td>
	<td><?=number_format($tot_youtube_cnt)?></td>
	<td><?=number_format($tot_cafe_cnt)?></td>
	<td><?=number_format($tot_etc_cnt)?></td>
</tr>
</table>