<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=��÷�̷�_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");


$search = "";
$search_category = "";
if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( m.hero_id like \'%'.$_GET['kewyword'].'%\' or s.hero_title like \'%'.$_GET['kewyword'].'%\')';
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
}

if($_REQUEST['category_select']) {
	$search_category = "in('".$_REQUEST['category_select']."')";
}else {
	$search_category = "in('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_23')";
}

$sql  = " SELECT r.hero_idx , r.hero_superpass, r.delivery_point_yn, r.hero_today ";
$sql .= " , g.hero_title as menu ";
$sql .= " , m.hero_nick , m.hero_id, m.hero_name, m.hero_hp ";
$sql .= " , s.hero_title as mission_title ";
$sql .= " FROM mission_review r ";
$sql .= " LEFT JOIN hero_group g ON r.hero_table = g.hero_board ";
$sql .= " LEFT JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission s ON r.hero_old_idx = s.hero_idx ";
$sql .= " WHERE r.lot_01 = 1 AND r.hero_table ".$search_category." ".$search;
$sql .= " ORDER BY hero_idx DESC ";

$list_res = sql($sql,"on");

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>NO</th>
	<th>ī�װ�</th>
	<th>ü��ܸ�</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>�̸�</th>
	<th>ȸ������ ����ó</th>
	<th>�����н� ��뿩��</th>
	<th>��ۺ� ����������</th>
	<th>��û��</th>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$hero_superpass_txt = "";
	if($list["hero_superpass"] == "Y") {
		$hero_superpass_txt = "���";
	} else {
		$hero_superpass_txt = "�̻��";
	}
	
	$delivery_point_txt = "";
	if($list["delivery_point_yn"] == "Y") {
		$delivery_point_txt = "������";
	}
?>
<tr>
	<td><?=$num?></td>
	<td><?=$list["menu"]?></td>
	<td class="title"><?=$list["mission_title"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=name_masking($list["hero_name"])?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$hero_superpass_txt?></td>
	<td><?=$delivery_point_txt?></td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? 
$num++;
} 
?>
</table>
                        	
                        
                        
                        
                        
                        