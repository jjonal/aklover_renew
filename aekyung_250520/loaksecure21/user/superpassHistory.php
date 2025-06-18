<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["superpass_check"]) {
	$search .= " AND superpass_check = '".$_GET["superpass_check"]."' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) as cnt  ";
$total_sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$total_sql .= " WHERE 1=1 ".$search;

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

$sql  = " SELECT ";
$sql .= " m.hero_nick, m.hero_id, m.hero_name, s.panelty_check, s.login_a_month_ago_check  ";
$sql .= " , s.blog_check, s.write_check, s.superpass_check, s.hero_today  ";
$sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY s.hero_idx DESC LIMIT ".$start.",".$list_page;


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
		<th>����/������</th>
		<td>
			<input type="radio" name="superpass_check" id="superpass_check" <?=!$_GET["superpass_check"] ? "checked":""; ?> value=""><label for="superpass_check">��ü</label>
			<input type="radio" name="superpass_check" id="superpass_check_y" <?=$_GET["superpass_check"]=="Y" ? "checked":""; ?> value="Y"><label for="superpass_check_y">����</label>
			<input type="radio" name="superpass_check" id="superpass_check_n" <?=$_GET["superpass_check"]=="N" ? "checked":""; ?> value="N"><label for="superpass_check_n">������</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>

<div class="view_title_box">
	<p><label>�����н� ����</label></p>
	<p>
	1. �Ŵ� ó�� �α����� �� ���� ����</br>
	2. �α��� ������ 3���� ������ �г�Ƽ�� ����� ��</br>
	3. �α��� ������ �Ѵ� ���� �α����� ����� �־���� </br>
	4. ��α�+���� url ����</br>
	5. �Ѵ������� ����� �� �Ǵ� ��� ����</br></br>
	ex) 1�� ������ �������� ������ �����丮�� ����
	</p>
</div>

<div class="listExplainWrap mgb10">
<label>�� </label> : <strong><?=number_format($total_data)?></strong>��
</div>

<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>�̸�</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>�г�Ƽ</th>
	<th>�Ѵ� �� �α���</th>
	<th>��α�/����</th>
	<th>�ۼ���</th>
	<th>��������</th>
	<th>�α��γ�¥</th>
</tr>
</thead>
<?
if($total_data > 0) {
while($list = mysql_fetch_assoc($list_res)) {
	$superpass_txt = "";
	if($list["superpass_check"] == "Y") {
		$superpass_txt = "����";
	} else {
		$superpass_txt = "������";
	}
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["panelty_check"]?></td>
	<td><?=$list["login_a_month_ago_check"]?></td>
	<td><?=$list["blog_check"]?></td>
	<td><?=$list["write_check"]?></td>
	<td><?=$superpass_txt?></td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? 
$i--;
} 
} else {
?>
<tr>
	<td colspan="10">��ϵ� �����Ͱ� �����ϴ�.</td>
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


