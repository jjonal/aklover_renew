<?
if($_GET['hero_idx']){
	$hero_idx = $_GET['hero_idx'];
}
$sql = "select A.*, B.hero_name as goods_name,B.hero_serial_number,B.hero_point as goods_point,B.hero_display,C.hero_level,C.hero_hp,C.hero_mail,C.hero_address_01,C.hero_address_02,C.hero_address_03 ";
$sql .= "from order_main A inner join goods B on A.goods_idx=B.hero_idx inner join member C on A.hero_code=C.hero_code where A.hero_idx=".$hero_idx.";";
//echo $sql;
sql ( $sql );

$roll_list = @mysql_fetch_assoc ( $out_sql );
	

?>
<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_code"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<p class="tit_section">��ǰ����</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tr>
	<th>��ǰ�ڵ�</th>
	<td><?=$roll_list['hero_serial_number']?></td>
	<th>��ǰ�̸�</th>
	<td><?=$roll_list['goods_name']?></td>
</tr>
<tr>
	<th>��ǰ����Ʈ</th>
	<td><?=$roll_list['goods_point']?></td>
	<th>�Ǹſ���</th>
	<td><?=$roll_list['hero_display']?></td>
</tr>
</table>

<p class="tit_section mgt30">�ֹ��� ����</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tr>
	<th>���̵�</th>
	<td><?=$roll_list['hero_id']?></td>
	<th>�г���</th>
	<td><?=$roll_list['hero_nick']?></td>
</tr>
<tr>
	<th>�̸�</th>
	<td><?=$roll_list['hero_name']?></td>
	<th>����</th>
	<td><?=$roll_list['hero_level']?></td>
</tr>
<tr>
	<th>�޴�����ȣ</th>
	<td><?=$roll_list['hero_hp']?></td>
	<th>�̸���</th>
	<td><?=$roll_list['hero_mail']?></td>
</tr>
</table>

<p class="tit_section mgt30">��� ����</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tr>
	<th>�ֹ���ȣ</th>
	<td><?=$roll_list['hero_order_number']?></td>
	<th>�����ȣ</th>
	<td><?=$roll_list['hero_address_01']?></td>
</tr>
<tr>
	<th>�ּ�</th>
	<td colspan="3"><?=$roll_list['hero_address_02']?> ><?=$roll_list['hero_address_03']?></td>
</tr>
<tr>
	<th>��۽� �޸�</th>
	<td colspan="3"><?=$roll_list['rcv_memo']?></td>
</tr>
<tr>
	<th>�ֹ���Ȳ</th>
	<td>
		<?=$roll_list['hero_process']=="O"? "����غ�" : ""?>
		<?=$roll_list['hero_process']=="D"? "�����" : ""?>
		<?=$roll_list['hero_process']=="E"? "���ɿϷ�" : ""?>
		<?=$roll_list['hero_process']=="C"? "�ֹ����" : ""?>
	</td>
	<th>������</th>
	<td><?=$roll_list['hero_regdate']?></td>
</tr>
</table>
<div class="btnGroup">
	<div class="l"><a href="javascript:;" onclick="fnList();" class="btnList">���</a></div>
</div>
<script>
$(document).ready(function(){
	fnList = function() {
		$("#searchForm").submit();
	}	
})
</script>
