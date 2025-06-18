<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["startDate"]) {
    $search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["endDate"]) {
    $search .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
    $search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM member_backup ";
$total_sql .= " WHERE hero_code != '' ".$search;

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

//����Ʈ
$sql  = " SELECT hero_today, hero_code, hero_id, hero_nick, hero_name, hero_jumin, ";
$sql .= " hero_mail, hero_hp, hero_use, hero_chk_phone, hero_chk_email ";
$sql .= " FROM member_backup ";
$sql .= " WHERE hero_code != '' ".$search;
$sql .= " ORDER BY hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="order" value="<?=$_GET["order"]?>" />
<input type="hidden" name="hero_code" value="" />
<input type="hidden" name="view" value="" />
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
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
		    	<option value="hero_name"<?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>����</option>
		    	<option value="hero_jumin"<?if(!strcmp($_REQUEST['select'], 'hero_jumin')){echo ' selected';}else{echo '';}?>>�������</option>
		    	<option value="hero_mail"<?if(!strcmp($_REQUEST['select'], 'hero_mail')){echo ' selected';}else{echo '';}?>>�̸���</option>
		    	<option value="hero_hp"<?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>����ó</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
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
	<col width="6%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="15%" />
    <col width="" />
    <col width="" />
	<col width="6%" />
    <col width="15%" />
</colgroup>
<thead>
<tr>
	<th>No</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>����</th>
	<th>�������</th>
	<th>�̸���</th>
	<th>����ó</th>
    <th>�޴���<br>���ŵ���</th>
    <th>�̸���<br>���ŵ���</th>
    <th>ȸ������</th>
    <th>�����</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {
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

    $hero_chk_phone_txt = "�̵���";
    if($list["hero_chk_phone"] == "1") $hero_chk_phone_txt = "����";
    $hero_chk_email_txt = "�̵���";
    if($list["hero_chk_email"] == "1") $hero_chk_email_txt = "����";
?>
<tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
	<td><?=$i?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_jumin"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$list["hero_hp"]?></td>
    <td><?=$hero_chk_phone_txt?></td>
    <td><?=$hero_chk_email_txt?></td>
	<td><?=$hero_use_txt?></td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? 
$i--;
}
} else { ?>
<tr>
	<td colspan="8">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<? } ?>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function() {	
	fnOrder = function(sort) {
		$("#searchForm input[name='order']").val(sort);
		$("#searchForm").attr("action","").submit();
	}
	
	fnSearch = function() {
		$("#searchForm input[name='order']").val("");
		$("#searchForm").attr("action","").submit();
	}
	
	fnView = function(hero_code) {
		$("input[name='hero_code']").val(hero_code);
		$("input[name='view']").val("dormantAcntMgrView");
		$("#searchForm").attr("action","<?=PATH_HOME?>").submit();
		
	}
})
</script>