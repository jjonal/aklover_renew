<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["url"]) {
	$search .= " AND ".$_GET["hero_blog"]." like '%".$_GET["url"]."%' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." = '".$_GET["kewyword"]."' ";
}

//������ �ѹ���
$total_sql = " SELECT count(*) as cnt FROM member WHERE hero_use=0 ".$search;
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

$sql  = " SELECT hero_name, hero_hp , hero_id, hero_nick, hero_blog_00 ";
$sql .= " , hero_blog_01, hero_blog_02, hero_blog_03 ";
$sql .= " , hero_blog_04, hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08  ";
$sql .= " FROM member where hero_use=0 ".$search;
$sql .= " ORDER BY hero_oldday DESC LIMIT ".$start.",".$list_page;

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
		<th>SNS URL</th>
		<td>
			<select name="hero_blog">
				<option value="hero_blog_00" <?=$_GET["hero_blog"]=="hero_blog_00" ? "selected":""?>>���̹� ��α�</option>
				<option value="hero_blog_04" <?=$_GET["hero_blog"]=="hero_blog_04" ? "selected":""?>>�ν�Ÿ�׷�</option>
				<option value="hero_blog_05" <?=$_GET["hero_blog"]=="hero_blog_05" ? "selected":""?>>�� �� SNS URL</option>
				<option value="hero_blog_03" <?=$_GET["hero_blog"]=="hero_blog_03" ? "selected":""?>>��Ʃ��</option>
				<option value="hero_blog_06" <?=$_GET["hero_blog"]=="hero_blog_06" ? "selected":""?>>���̹�TV</option>
				<option value="hero_blog_07" <?=$_GET["hero_blog"]=="hero_blog_07" ? "selected":""?>>ƽ��</option>
				<option value="hero_blog_08" <?=$_GET["hero_blog"]=="hero_blog_08" ? "selected":""?>>��Ÿ(����)</option>
			</select>
			<input type="text" name="url" value="<?=$_REQUEST["url"];?>" class="kewyword">		
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
		    	<option value="hero_hp" <?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>�޴�����ȣ</option>
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
	<col width="5%" />
	<col width="5%" />
	<col width="5%" />
	<col width="8%" />
	<col width="11%" />
	<col width="11%" />
	<col width="11%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>�̸�</th>
	<th>���̵�</th>
	<th>�г���</th>
	<th>�޴�����ȣ</th>
	<th>���̹� ��α�</th>
	<th>�ν�Ÿ�׷�</th>
	<th>�� �� SNS �ּ�</th>
	<th>��Ʃ��</th>
	<th>���̹�TV</th>
	<th>ƽ��</th>
	<th>��Ÿ(����)</th>
</tr>
</thead>
<?
if($total_data > 0) {
while($list = mysql_fetch_assoc($list_res)) {?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td class="title"><?=$list["hero_blog_00"]?></td>
	<td class="title"><?=$list["hero_blog_04"]?></td>
	<td class="title"><?=$list["hero_blog_05"]?></td>
	<td class="title"><?=$list["hero_blog_03"]?></td>
	<td class="title"><?=$list["hero_blog_06"]?></td>
	<td class="title"><?=$list["hero_blog_07"]?></td>
	<td class="title"><?=$list["hero_blog_08"]?></td>
</tr>
<? 
$i--;
} 
} else {
?>
<tr>
	<td colspan="12">��ϵ� �����Ͱ� �����ϴ�.</td>
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


