<?php 
if(!defined('_HEROBOARD_'))exit;

//include_once '../combined/admin_user_manager.php';

$search = "";

if($_GET["hero_today_start"]) {
	$search .= " AND date_format(hero_regdate,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
}

if($_GET["hero_today_end"]) {
	$search .= " AND date_format(hero_regdate,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
}

if($_GET["hero_table"]){
	$search .= " AND m.hero_table = '".$_GET["hero_table"]."' ";
}

if($_GET["pointType"]){
	if($_GET["pointType"] == 'Plus') $search .=" and hero_order_point > 0 ";
	else if($_GET["pointType"] == 'Minus') $search .=" and hero_order_point < 0 ";
}

if($_GET["kewyword"]){
	$search .= " AND o.".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

// ����¡�� ���� ����Ÿ �� ����
$total_sql  = " SELECT count(*) AS cnt FROM order_main o ";
$total_sql .= " INNER JOIN mission m ON o.mission_idx = m.hero_idx  WHERE hero_process='DE' ".$search;

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=20;
$page_per_list=10;
  
if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];
	
$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT o.hero_idx, o.hero_id, o.hero_name, o.hero_nick, o.hero_order_point, o.hero_regdate ";
$sql .= " ,m.hero_title AS  mission_title ";
$sql .= " , (SELECT hero_title FROM hero_group WHERE hero_board = m.hero_table) as menu ";
$sql .= " FROM order_main o ";
$sql .= " LEFT JOIN mission m ON o.mission_idx = m.hero_idx ";
$sql .= " WHERE o.hero_process='DE' ".$search;
$sql .= " ORDER BY o.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page."";

$list_res = sql($sql);
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
		<th>��ۺ� �Ⱓ �˻�</th>
		<td>
			<input type="text" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" class="dateMode"/> ~ 
            <input type="text" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" class="dateMode"/>
		</td>
	</tr>
	<tr>
		<th>ü���</th>
		<td>
			<select name="hero_table">
				<option value="">����</option>
				<option value="group_04_05" <?=$_GET["hero_table"]=="group_04_05" ? "selected":"";?>>ü���</option>
				<option value="group_04_06" <?=$_GET["hero_table"]=="group_04_06" ? "selected":"";?>>��ƼŬ��</option>
				<option value="group_04_28" <?=$_GET["hero_table"]=="group_04_28" ? "selected":"";?>>������Ŭ��</option>
				<option value="group_04_27" <?=$_GET["hero_table"]=="group_04_27" ? "selected":"";?>>��Ʃ��</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>����/��ȯ</th>
		<td>
			<input type="radio" name="pointType"  id="pointAll" value="All" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">��ü</label> 
			<input type="radio" name="pointType"  id="pointPlus" value="Plus" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">����</label> 
			<input type="radio" name="pointType"  id="pointMinus" value="Minus" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">��ȯ</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_id" <?=$_GET['select'] == "hero_id" ? "selected" : ""?>>���̵�</option>
				<option value="hero_name" <?=$_GET['select'] == "hero_name" ? "selected" : ""?>>����</option>
				<option value="hero_nick" <?=$_GET['select'] == "hero_nick" ? "selected" : ""?>>�г���</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?=$_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>

<div class="listExplainWrap mgb10">
<label>�� </label> : <strong><?=number_format($total_data)?></strong>��</span>
</div>

<table class="t_list">
<colgroup>
	<col width="10%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="5%" />
	<col width="*" />
	<col width="5%" />
</colgroup>
<thead>
	<tr>
		<th>������</th>
		<th>�׷�</th>
		<th>���̵�</th>
		<th>����</th>
		<th>�г���</th>
		<th>����/��ȯ</th>
		<th>ü��� ��</th>
		<th>����Ʈ</th>
	</tr>
</thead>
<? 
if($total_data > 0) {
while($list = @mysql_fetch_assoc($list_res)){
	$point = $list["hero_order_point"] * -1;
?>
<tr>
	<td><?=$list['hero_regdate']?></td>
	<td><?=$list['menu']?></td>
	<td><?=$list['hero_id']?></td>
	<td><?=name_masking($list['hero_name'])?></td>
	<td><?=$list['hero_nick']?></td>
	<td><?=$list['hero_order_point'] > 0 ? "����":"��ȯ";?></td>
	<td class="title"><?=strip_tags($list["mission_title"]);?></td>
	<td><?=$point?> P</td>
</tr>
<? }
} else {?>
<tr>
	<td colspan="8">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<? } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>

<script>
$(document).ready(function(){
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}
})
</script>


    
    