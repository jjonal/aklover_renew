<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND  date_format(hero_oldday,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

//���ŵ���
$agree_sql  = " SELECT count(*) cnt, sum(hero_chk_phone) phone , sum(hero_chk_email) email ";
$agree_sql .= " , sum(if(hero_chk_phone = 1  AND hero_chk_email = 1,1,0)) all_chk FROM member WHERE hero_use = 0 ".$search;
$list_res = sql($agree_sql, "on");

$levels = array("1"=>"�Ϲ�ȸ��","9993"=>"Life Club ������","9995"=>"Beauty Club ������","9994"=>"������Ŭ��","9996"=>"��ƼŬ��");

?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>�Ⱓ</th>
		<td>
			<input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>

<!-- 
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">�ٿ�ε�</a>
	</div>
</div>
-->

<p class="tit_section mgb10">ȸ�� ���� ��</p>
<table class="t_list">
<colgroup>
	<col width="20%" />
	<col width="20%" />
	<col width="20%" />
	<col width="20%" />
	<col width="20%" />
</colgroup>
<thead>
<tr>
	<th colspan="20">
		<? if($search) {?>
		��ȸ�Ⱓ : <?=$_GET["startDate"]?> ~ <?=$_GET["endDate"]?>
		<? } else { ?>
		�˻� �Ⱓ�� �Է��� �ּ���.
		<? } ?>
	</th>
</tr>
<tr>
	<? foreach($levels as $val) {?>
	<th><?=$val?></th>
	<? } ?>
</tr>
</thead>
<tr>
	<? foreach($levels as $key=>$val) {
		if($search) {
			$sql = " SELECT COUNT(*) cnt FROM member WHERE hero_use = 0 AND hero_level ='".$key."' ".$search;
			$res = sql($sql);
			$rs = mysql_fetch_assoc($res);
		}
	?>
	<td><?=number_format($rs["cnt"])?></td>
	<? } ?>
</tr>
</table>

<p class="tit_section mgb10 mgt30">���ŵ��� ��</p>
<table class="t_list">
<colgroup>
	<col width="25%" />
	<col width="25%" />
	<col width="25%" />
	<col width="25%" />
</colgroup>
<thead>
	<th colspan="4">
		<? if($search) {?>
		��ȸ�Ⱓ : <?=$_GET["startDate"]?> ~ <?=$_GET["endDate"]?>
		<? } else { ?>
		�˻� �Ⱓ�� �Է��� �ּ���.
		<? } ?>
	</th>
	<tr>
		<th>ȸ�� �� </th>
		<th>SMS ���ŵ���</th>
		<th>�̸��� ���ŵ���</th>
		<th>SMS + ���ŵ���</th>
	</tr>
</thead>
<? 
while($list = mysql_fetch_assoc($list_res)) { ?>
<tr>
	<td><?=number_format($list["cnt"])?></td>
	<td><?=number_format($list["phone"])?></td>
	<td><?=number_format($list["email"])?></td>
	<td><?=number_format($list["all_chk"])?></td>
</tr>
<? } ?>
</table>

<script>
$(document).ready(function(){	
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/excel_level.php").submit();
	}
})
</script>