<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["type"]) {
	$search .= " AND p.type = '".$_GET["type"]."' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

//������ �ѹ���
$total_sql  = " SELECT count(*) as cnt FROM member_penalty p ";
$total_sql .= " LEFT JOIN member m ON p.hero_code = m.hero_code ";
$total_sql .= " WHERE p.hero_use_yn='Y' ".$search;
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){
	$page = '1';
}else{
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT p.type, p.memo, p.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_sex , m.hero_level ";
$sql .= " , m.hero_jumin, m.hero_use, m.hero_level ";
$sql .= " FROM member_penalty p ";
$sql .= " LEFT JOIN member m ON p.hero_code = m.hero_code ";
$sql .= " WHERE p.hero_use_yn='Y' ".$search;
$sql .= " ORDER BY p.hero_idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

$type_arr = array("1"=>"���߾��̵�","2"=>"���̵���� ���ؼ�","3"=>"�ı� �̵��","4"=>"�������� ���� ������","5"=>"ǳ��/���� ������","9"=>"��Ÿ");
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
		<th>�г�Ƽ Ÿ��</th>
		<td>
			<select name="type">
				<option value="">����</option>
				<option value="1" <?=$_GET["type"]=="1" ? "selected":""?>>���߾��̵�</option>
				<option value="2" <?=$_GET["type"]=="2" ? "selected":""?>>���̵���� ���ؼ�</option>
				<option value="3" <?=$_GET["type"]=="3" ? "selected":""?>>�ı� �̵��</option>
				<option value="4" <?=$_GET["type"]=="4" ? "selected":""?>>�������� ���� ������</option>
				<option value="5" <?=$_GET["type"]=="5" ? "selected":""?>>ǰ��/���� ������</option>
				<option value="9" <?=$_GET["type"]=="9" ? "selected":""?>>��Ÿ</option>
			</select>	
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
				<option value="p.memo" <?if(!strcmp($_REQUEST['select'], 'p.memo')){echo ' selected';}else{echo '';}?>>����</option>
		    	<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
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
<label>�� </label> : <strong><?=number_format($total_data)?></strong>��
</div>

<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="7%" />
	<col width="7%" />
	<col width="7%" />
	<col width="5%" />
	<col width="5%" />
	<col width="5%" />
	<col width="5%" />
	<col width="10%" />
	<col width="*" />
	<col width="15%" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>�̸�</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>����</th>
	<th>����</th>
	<th>����</th>
	<th>ȸ������</th>
	<th>�г�Ƽ Ÿ��</th>
	<th>����</th>
	<th>�����</th>
</tr>
</thead>
<?
if($total_data > 0) {
while($list = mysql_fetch_assoc($list_res)) {
	$age = "";
	if($list["hero_jumin"]) {
		$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
	}
	
	$hero_sex_txt = "";
	if($list["hero_sex"] == 1) {
		$hero_sex_txt = "��";
	} else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
		$hero_sex_txt = "��";
	}
	
	$hero_use_txt = "";
	if($list["hero_use"] == 0) {
		$hero_use_txt = "ȸ��";
	} else if($list["hero_use"] == 1) {
		$hero_use_txt = "Ż��";
	} else if($list["hero_use"] == 2) {
		$hero_use_txt = "�޸�ȸ��";
	}
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$age?></td>
	<td><?=$hero_sex_txt?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$hero_use_txt?></td>
	<td><?=$type_arr[$list["type"]]?></td>
	<td class="title"><?=$list["memo"]?></td>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
$i--;
} 
} else {
?>
<tr>
	<td colspan="11">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<?}?>
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


