<?
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=����Ʈ�̷�Ȯ��_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

if($_SESSION["temp_level"] < 9999) exit; //��������

$search = "";
$search_order = "";

if($_GET["hero_today_start"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
	$search_order .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
}

if($_GET["hero_today_end"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
	$search_order .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
}

if($_GET["pointType"]){
	if($_GET["pointType"] == 'Plus') {
		$search .=" AND hero_point > 0 ";
		$search_order .=" AND hero_point < 0 ";
	}
	else if($_GET["pointType"] == 'Minus') {
		$search .=" AND hero_point < 0 ";
		$search_order .=" AND hero_point > 0 ";
	}
}

if($_GET["pointLimit"] == "Y") {
	$search .= " AND hero_include_maxpoint = 'Y' ";
	$search_order .= " AND hero_include_maxpoint = '".$_GET["pointLimit"]."' ";
}

if($_GET["kewyword"]){
	if($_GET["select"] == "hero_title" || $_GET["select"] == "hero_top_title") {
		$search .= " AND ".$_GET["select"]."  like '%".$_GET["kewyword"]."%' ";
	} else {
		$search .= " AND ".$_GET["select"]." ='".$_GET["kewyword"]."' ";
	}
	
	if($_GET["select"] == "hero_title" || $_GET["select"] == "hero_top_title") {
		$search_order .= "";
		if($_GET["select"] == "hero_title") {
			$search_order .= " AND ".$_GET["select"]."  like '%".$_GET["kewyword"]."%' ";
		}
	} else {
		$search_order .= " AND ".$_GET["select"]." ='".$_GET["kewyword"]."' ";
	}
}

$sql = " SELECT * FROM  (";
$sql .= " SELECT hero_type, hero_id, hero_top_title, hero_title ";
$sql .= " , hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, edit_hero_code ";
$sql .= " FROM point p ";
$sql .= " WHERE 1=1 ".$search." ";
$sql .= " UNION ALL ";
$sql .= " SELECT hero_type, hero_id, hero_top_title,  hero_title, hero_name ";
$sql .= " , hero_nick, hero_point*-1 as hero_point, hero_today, hero_include_maxpoint, hero_code FROM ( ";
$sql .= " SELECT  '' hero_type, hero_id, '' hero_top_title ";
$sql .= " , case when hero_process = 'DE' then '��۷�' when hero_process = 'M' then '����Ʈ�Ҹ�' when hero_process = 'O' then '��ǰ����' ELSE hero_process end AS hero_title ";
$sql .= " , hero_name , hero_nick, hero_order_point as hero_point, hero_regdate as hero_today, 'N' hero_include_maxpoint ";
$sql .= " , hero_code ";
$sql .= "  FROM order_main WHERE hero_process != 'C') a WHERE 1=1 ".$search_order;
$sql .= " ) a ";
$sql .= " ORDER BY hero_today DESC ";

$list_res = sql($sql,"on");
?>
<style>
table tr td,table tr td{border:1px solid #000;}
</style>
<table>
<tr>
	<th>������</th>
	<th>���̵�</th>
	<th>�̸�</th>
	<th>�г���</th>
	<th>����Ʈ ���� ����</th>
	<th>ȹ��/����</th>
	<th>����Ʈ ȹ�� �޴�</th>
	<th>����</th>
	<th>����Ʈ</th>
</tr>
<? while($list = mysql_fetch_assoc($list_res)) {	
		$hero_include_maxpoint_txt = "���Ѿ���";
		if($list["hero_include_maxpoint"] == "Y") $hero_include_maxpoint_txt = "����";
		$point_gubun_txt = "";
		if($list['hero_point']  > 0) {
			$point_gubun_txt = "ȹ��";
		} else if($list['hero_point']  < 0) {
			$point_gubun_txt = "����";
		}
?>
<tr>
	<td><?=$list['hero_today']?></td>
	<td><?=$list['hero_id']?></td>
	<td><?=name_masking($list['hero_name'])?></td>
	<td><?=$list['hero_nick']?></td>
	<td><?=$hero_include_maxpoint_txt?></td>
	<td><?=$point_gubun_txt?></td>
	<td><?=$list["hero_top_title"]?></td>
	<td class="title"><?=pointHistoryContent($list['hero_today'], $list['hero_old_idx'], $list['hero_mission_idx'], $list['hero_review_idx'], $list['hero_id'], $list['hero_top_title'], $list['hero_title'], $list['hero_point'], $list['edit_hero_code']);?></td>
	<td><?=$list["hero_point"]?></td>
</tr>
<? } ?>
</table>