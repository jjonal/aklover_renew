<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=�޸�_�Ϲ�ȸ����ȯ_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";
if($_GET["startDate"]) {
	$search .= " AND date_format(h.hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["endDate"]) {
	$search .= " AND date_format(h.hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if($_GET["hero_type"]) {
	$search .= " AND h.hero_type = '".$_GET["hero_type"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  m.".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$sql  = " SELECT h.hero_type, h.hero_today, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp, m.hero_use FROM member_backup_history h ";
$sql .= " LEFT JOIN member m ON h.hero_code = m.hero_code ";
$sql .= " WHERE h.hero_code != '' ".$search;
$sql .= " ORDER BY h.idx DESC ";
sql($sql,"on");

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
	<tr>
		<th>��ȣ</th>
		<th>�޸�/�Ϲ�ȸ�� ��ȯ</th>
		<th>���̵�</th>
		<th>�г���</th>
		<th>����</th>
		<th>����ó</th>
		<th>ȸ������</th>
		<th>�����</th>
	</tr>
	<? 
	$no = 1;
	while($list = @mysql_fetch_array($out_sql)){
		$hero_type_txt = "";
		if($list["hero_type"] == "out") {
			$hero_type_txt = "�޸�ȸ�� ��ȯ";
		} else if($list["hero_type"] == "in") {
			$hero_type_txt = "�Ϲ�ȸ�� ��ȯ";
		}
		
		$hero_use_txt = "";
		if($list["hero_use"] == "0") {
			$hero_use_txt = "����";
		} else if($list["hero_use"] == "1") {
			$hero_use_txt = "Ż��";
		} else if($list["hero_use"] == "2") {
			$hero_use_txt = "�޸�";
		}
	?>
	<tr>
		<td><?=$no?></td>
		<td><?=$hero_type_txt?></td>
		<td><?=$list["hero_id"]?></td>
		<td><?=$list["hero_nick"]?></td>
		<td><?=$list["hero_name"]?></td>
		<td><?=$list["hero_hp"]?></td>
		<td><?=$hero_use_txt?></td>
		<td><?=$list["hero_today"]?></td>
	</tr>
	<? 
		$no++;
	}
	?>
</table>
